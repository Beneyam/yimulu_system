<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Message;
use Illuminate\Support\Carbon;
use Exception;
//use App\Smpp\smpp;

class SendMessages extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'send:message';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Send  Messages';

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }
  var $socket = 0;
  var $seq = 0;
  var $debug = 0;
  var $data_coding = 0;
  var $timeout = 2;

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    //

    for ($i = 1; $i <= 10; $i++) {
      $messages   =  Message::where('created_at', '>', Carbon::now()->subMinutes(60))
        ->where('status', 0)
        ->orderByDesc('id')
        ->get();
      //Log::info('Trying to send ' . $messages->count()." messages\n");
      $this->debug = 0;

      // $host,$port,$system_id,$password
      $this->open("10.190.10.16", 8313, "012844", "nage#654");

      foreach ($messages as $message) {
        try {
          $src  = "7173"; // or text 
          $dst  = $message->receiver;
          $msg = $message->msg;
          //  Log::info(iconv_get_encoding('all'));
          sleep(1);

          //To send unicode 
          $utf = true;
          $msg = iconv('Windows-1256', 'UTF-16BE', $msg);
          $status = $this->send_long($src, $dst, $msg, $utf);
          if ($status) {
            Log::info('SMS sent to ' . $message->receiver . "\n");
            $message->status = 1;
            $message->save();
          } else {
            Log::error('SMS sending failed! message_id:' . $message->id . "\n");
          }
        } catch (Exception $e) {
          Log::error('exception occured \n' . $e);
        }
      }
      $this->close();
      sleep(4);
    }
  }

  //////////////////////////////////////////////////
  function send_pdu($id, $data)
  {

    // increment sequence
    $this->seq += 1;
    // PDU = PDU_header + PDU_content
    $pdu = pack('NNNN', strlen($data) + 16, $id, 0, $this->seq) . $data;
    // send PDU
    fputs($this->socket, $pdu);

    // Get response length
    $data = fread($this->socket, 4);
    if ($data == false) die("\nSend PDU: Connection closed!");
    $tmp = unpack('Nlength', $data);
    $command_length = $tmp['length'];
    if ($command_length < 12) return;

    // Get response 
    $data = fread($this->socket, $command_length - 4);
    $pdu = unpack('Nid/Nstatus/Nseq', $data);
    if ($this->debug) print "\n< R PDU (id,status,seq): " . join(" ", $pdu);

    return $pdu;
  }


  //////////////////////////////////////////////////
  function open($host, $port, $system_id, $password)
  {

    // Open the socket
    $this->socket = fsockopen($host, $port, $errno, $errstr, $this->timeout);
    if ($this->socket === false)
      die("$errstr ($errno)<br />");
    if (function_exists('stream_set_timeout'))
      stream_set_timeout($this->socket, $this->timeout); // function exists for php4.3+
    if ($this->debug) print "\n> Connected";


    // Send Bind operation
    $data  = sprintf("%s\0%s\0", $system_id, $password); // system_id, password 
    $data .= sprintf("%s\0%c", "", 0x34);  // system_type, interface_version
    $data .= sprintf("%c%c%s\0", 5, 0, ""); // addr_ton, addr_npi, address_range 

    $ret = $this->send_pdu(2, $data);
    if ($this->debug) print "\n> Bind done!";

    return ($ret['status'] == 0);
  }


  //////////////////////////////////////////////////
  function submit_sm($source_addr, $destintation_addr, $short_message, $optional = '')
  {

    $data  = sprintf("%s\0", ""); // service_type
    $data .= sprintf("%c%c%s\0", 5, 0, $source_addr); // source_addr_ton, source_addr_npi, source_addr
    $data .= sprintf("%c%c%s\0", 1, 1, $destintation_addr); // dest_addr_ton, dest_addr_npi, destintation_addr
    $data .= sprintf("%c%c%c", 0, 0, 0); // esm_class, protocol_id, priority_flag
    $data .= sprintf("%s\0%s\0", "", ""); // schedule_delivery_time, validity_period
    $data .= sprintf("%c%c", 0, 0); // registered_delivery, replace_if_present_flag
    $data .= sprintf("%c%c", $this->data_coding, 0); // data_coding, sm_default_msg_id
    $data .= sprintf("%c%s", strlen($short_message), $short_message); // sm_length, short_message
    $data .= $optional;

    $ret = $this->send_pdu(4, $data);
    return ($ret['status'] == 0);
  }


  //////////////////////////////////////////////////
  function close()
  {

    $ret = $this->send_pdu(6, "");
    fclose($this->socket);
    return 0;
  }


  //////////////////////////////////////////////////
  function send_long($source_addr, $destintation_addr, $short_message, $utf = 0, $flash = 0)
  {

    if ($utf)
      $this->data_coding = 0x08;

    if ($flash)
      $this->data_coding = $this->data_coding | 0x10;


    $size = strlen($short_message);
    if ($utf) $size += 20;

    if ($size < 160) { // Only one part :)
      $this->submit_sm($source_addr, $destintation_addr, $short_message);
    } else { // Multipart
      $sar_msg_ref_num =  rand(1, 255);
      $sar_total_segments = ceil(strlen($short_message) / 130);

      for ($sar_segment_seqnum = 1; $sar_segment_seqnum <= $sar_total_segments; $sar_segment_seqnum++) {
        $part = substr($short_message, 0, 130);
        $short_message = substr($short_message, 130);

        $optional  = pack('nnn', 0x020C, 2, $sar_msg_ref_num);
        $optional .= pack('nnc', 0x020E, 1, $sar_total_segments);
        $optional .= pack('nnc', 0x020F, 1, $sar_segment_seqnum);

        if ($this->submit_sm($source_addr, $destintation_addr, $part, $optional) === false)
          return false;
      }
    }


    return 0;
  }
}
