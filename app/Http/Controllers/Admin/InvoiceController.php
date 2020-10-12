<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\StatController;
use Illuminate\Http\Request;
use Elibyy\TCPDF\TCPDF;
use TCPDF_FONTS;

class InvoiceController extends Controller
{

    //Page header
    public function createInvoice($user, $agent, $from_date,$to_date)
    {
        
    
        $fontname = TCPDF_FONTS::addTTFfont(asset('/dist/font/nyala.ttf'), 'TrueTypeUnicode', '', 96);
       dd(asset('/dist/font/nyala.ttf'));
        $data=StatController::getAgentSoldCardsInvoice($agent->id,$from_date,$to_date);
        $html = "<table>
      <tbody>
        <tr>
          <th width='5%'>No</th>
          <th width='37%'>Item Description</th>
          <th width='8%'>Unit</th>
          <th width='7%>Qty.</th>
          <th width='13%' rowspan='1' colspan='2'>Unit Price</th>
          <th width='16%' rowspan='1' colspan='2'>Total Price</th>
          <th width='16%'>Remark</th>
        </tr>
        ";
        $i=1;
        $total_total=0;
        $total_quantity=0;
        foreach($data as $row){
            $html.="<tr>td>".$i."</td>";
            $html.="<td>".$row->face_value." Birr</td>";
            $html.="<td>Pcs</td>";
            $html.="<td>".$row->quantity."</td>";
            $html.="<td>".$row->face_value."</td>";
            $html.="<td>".number_format($row->face_value*$row->quantity)."</td>";
            $html.="<td></td></tr>";
            $total_quantity+=$row->quantity;
            $total_total+=$row->face_value*$row->quantity;

        $i++;
        }
        $html.="<tr><td colspan='3'>Total</td>";
        $html.="<td>".number_format($total_quantity)."</td>";
        $html.="<td>".number_format($total_total)."</td></tr>";
        $html .= "</tbody></table>
      <style>
      table{
        border-collapse:collapse;
      }
      th,td{
        border:1px solid #888;

      }
      </style>";

        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->setHeaderCallback(function($pdf){
            // Logo
            $image_file = 'images/logo2.jpg';
            $this->Image($image_file, 30, 10, 30, 30, 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
            // Set font
            $fontname = TCPDF_FONTS::addTTFfont(asset('/dist/font/nyala.ttf'), 'TrueTypeUnicode', '', 96);
            $this->SetFont($fontname, 'B', 16);
            // Title
            $this->Cell(20, 0, '  ', 0, 0, 'R');
            $this->Cell(110, 6, 'ናሬድ ጠቅላላ ንግድ ኃላ.የተ.የግ.ማህበር', 0, 1, 'L');
            $this->Cell(72, 0, '  ', 0, 0, 'R');
            $this->Cell(110, 6, 'Nared General Trading PLC.', 0, 1, 'L');
    
            $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
    
            //$this->Line(70,23, 180, 23, $style);
    
            $this->SetFont($fontname, 'B', 12);
            $this->Cell(68, 0, '  ', 0, 0, 'R');
    
            $this->Cell(110, 5, 'የመድኃኒትና የህክምና መገልገያዎች ጅምላ አከፋፋይ', 0, 1, 'L');
            $this->Cell(72, 0, '  ', 0, 0, 'R');
    
            $this->Cell(110, 5, 'Nared Electronic yimulu_salesdistribution System', 0, 1, 'L');
            //  $this->writeHTML($htmlh, true, false, true, false, '');
            //$this->Line(70,35, 180, 35, $style);
            $this->Ln(5);
           
        });
    
        // Page footer
        $pdf->setFooterCallback(function($pdf){
            // Position at 15 mm from bottom
            $this->SetY(-15);
            //$this->WriteHTMLCell(0,0,'','',"<hr>",'1');
    
            // Set font
            $fontname = TCPDF_FONTS::addTTFfont(asset('/dist/font/nyala.ttf'), 'TrueTypeUnicode', '', 96);
      
            $this->SetFont($fontname, '', 8);
            $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
    
            $this->Line(20, 280, 180, 280, $style);
    
            // Page number
            $this->Cell(0, 5, 'Tel. 0911-22 21 64 Mobile 011-278 34 50 Website: www.Naredpharma.com', 0, 1, 'C');
            $this->Cell(0, 5, 'አዲስ አበባ ኢትዮጵያ/Addis Ababa, Ethiopia.', 0, 1, 'C');
            $this->Cell(0, 5, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 1, 'C');
        });
        // set document information
        $pdf->SetCreator("Nared EVD system");
        $pdf->SetAuthor('Nared');
        $pdf->SetTitle('Cash Invoice');
        $pdf->SetSubject('Invoice List');
        $pdf->SetKeywords('Invoice, EVD');
        $pdf->SetFont($fontname, '', 14, '', false);
        //$fontname = $pdf->addTTFfont(‘fonts/nyala.ttf’, ‘TrueTypeUnicode’, “, 32);

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 70, 10);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        // ---------------------------------------------------------

        // set font
        //$pdf->SetFont('times', 'BI', 12);

        // add a page
        $pdf->AddPage();
        $pdf->SetFont($fontname, '', 12, '', false);
        $pdf->Cell(156, 4, 'No ' . sprintf("%05d", $GLOBALS['id']), 0, 1, 'R');
        //$this->Cell(170,4,' ',0,0,'R');
        $pdf->Ln(1);
        $pdf->Cell(150, 4, 'Date ', 0, 0, 'R');

        $pdf->SetFont($fontname, 'U', 12, '', false);
        $pdf->Cell(20, 4, date("d/m/Y"), 0, 1, 'L');
        $pdf->Ln();
        $pdf->Cell(150, 4, 'For ' . $agent->name, 0, 1, 'L');
        /*if ($tender_id != "") {
            $this->Cell(150, 4, 'Tender Number:' . $tender_id, 0, 1, 'L');
        }*/
        $pdf->SetFont($fontname, '', 30, '', false);
    
        $pdf->Ln(10);

        $pdf->SetFont($fontname, '', 12, '', false);
        //    $pdf->WriteHTMLCell(190,200,5,'',$html,0);
        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Cell(40, 5, 'Total Amount In words ', 0, 0, 'L');
        $pdf->SetFont($fontname, 'U', 12, '', false);
        if ($total_total - floor($total_total) > 0) {
            $pdf->Cell(150, 5, N2W::n2w(floor($total_total)) . " Birr and " . N2W::n2w(floor(($total_total - floor($total_total)) * 100)) . " Cents only", 0, 1, 'L');
        } else {
            $pdf->Cell(150, 5, N2W::n2w(floor($total_total)) . " Birr only", 0, 1, 'L');
        }

        $pdf->Ln(10);

        $pdf->SetFont($fontname, '', 12, '', false);

        $pdf->Cell(25, 5, 'Prepared By ', 0, 0, 'L');
        $pdf->SetFont($fontname, 'U', 12, '', false);
        $pdf->Cell(150, 5, $user->name, 0, 1, 'L');
        $pdf->SetFont($fontname, '', 12, '', false);

        $pdf->Cell(0, 5, 'Approved By _________________________', 0, 1, 'L');
        $pdf->Cell(0, 5, 'Signature ____________________________', 0, 1, 'L');
        $pdf->Cell(0, 5, 'Date ____________________________', 0, 1, 'L');


        // set some text to print
        $pdf->Output($agent->name . "-" . $GLOBALS['id'] . '.pdf', 'I');
        // $pdf;
    }
}
