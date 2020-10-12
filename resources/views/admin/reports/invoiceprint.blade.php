<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Invoice</title>
    <style>
      @font-face {
  font-family: SourceSansPro;
  src: url(SourceSansPro-Regular.ttf);
}

.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #0087C3;
  text-decoration: none;
}

body {
  position: relative;
  width: 19cm;  
  height: 28cm; 
  margin: 0 auto; 
  color: #555555;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: SourceSansPro;
}

header {
  padding: 10px 0;
  margin-bottom: 20px;
  border-bottom: 1px solid #AAAAAA;
}

#logo {
  float: left;
  margin-top: 8px;
}

#logo img {
  height: 70px;
}

#company {
  float: right;
  text-align: right;
}


#details {
  margin-bottom: 50px;
}

#client {
  padding-left: 6px;
  border-left: 6px solid #0087C3;
  float: left;
}

#client .to {
  color: #777777;
}

h2.name {
  font-size: 1.4em;
  font-weight: normal;
  margin: 0;
}

#invoice {
 
}

#invoice h1 {
  color: #0087C3;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}

#invoice .date {
  font-size: 1.1em;
  color: #777777;
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table th,
table td {
  padding: 20px;
  background: #EEEEEE;
  text-align: center;
  border-bottom: 1px solid #FFFFFF;
}

table th {
  white-space: nowrap;        
  font-weight: normal;
}

table td {
  text-align: right;
}

table td h3{
  color: #57B223;
  font-size: 1.2em;
  font-weight: normal;
  margin: 0 0 0.2em 0;
}

table .no {
  color: #FFFFFF;
  font-size: 1.6em;
  background: #57B223;
}

table .desc {
  text-align: left;
}

table .unit {
  background: #DDDDDD;
}

table .qty {
}

table .total {
  background: #57B223;
  color: #FFFFFF;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table tbody tr:last-child td {
  border: none;
}

table tfoot td {
  padding: 10px 20px;
  background: #FFFFFF;
  border-bottom: none;
  font-size: 1.2em;
  white-space: nowrap; 
  border-top: 1px solid #AAAAAA; 
}

table tfoot tr:first-child td {
  border-top: none; 
}

table tfoot tr:last-child td {
  color: #57B223;
  font-size: 1.4em;
  border-top: 1px solid #57B223; 

}

table tfoot tr td:first-child {
  border: none;
}

#thanks{
  font-size: 2em;
  margin-bottom: 50px;
}

#notices{
  padding-left: 6px;
  border-left: 6px solid #0087C3;  
}

#notices .notice {
  font-size: 1.2em;
}

footer {
  color: #777777;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #AAAAAA;
  padding: 8px 0;
  text-align: center;
}

    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="{{asset('dist/img/naredevd.png')}}">
      </div>
      <div style="float: right">
        <h2 class="name">Nared General Trading</h2>
        <div>Somalia Street, Addis Ababa</div>
        <div>(251) 11-278-3450</div>
        <div><a href="mailto:info@naredgroup.com">info@naredgroup.com</a></div>
      </div>
      </div>
    </header>
    <main>
      <div id="details" class="clearfix">
        <div id="client">
          <div class="to">INVOICE TO:</div>
          <h2 class="name">{{$to_name}}</h2>
          <div class="address">{{$to_phone}}</div>
         </div>
        <div id="invoice" style="float: right">
          <h1>INVOICE {{str_pad($id, 5, '0', STR_PAD_LEFT)}}</h1>
          <h2 class="name">Prep By: {{$staff_name}}</h1>
          <div class="date">Date of Invoice: {{$date}}</div>
         </div>
      </div>
      <table border="0" cellspacing="0" cellpadding="0">
        <thead>
          <tr>
            <th class="no">#</th>
            <th class="desc">Date</th>
            <th class="unit">Amount</th>
            <th class="qty">Commission</th>
            <th class="total">Receivable</th>
          </tr>
        </thead>
        <tbody>
          @php
            $i=0;
            $total_amount=0;
            $total_receivable=0;
          @endphp
          @foreach($invoices as $invoice)
          @php
            $i++;
            $total_amount+=$invoice->amount;
            $receivable=(100-$invoice->commission)*0.01*$invoice->amount;
            $total_receivable+=$receivable;
          @endphp
          <tr>
            <td class="no">01</td>
            <td class="desc"><h3>{{$invoice->date}}</h3></td>
            <td class="unit">{{number_format($invoice->amount)}}</td>
            <td class="qty">{{$invoice->commission}}</td>
            <td class="total">{{number_format($receivable)}}</td>
          </tr>
         @endforeach
        </tbody>
        <tfoot>
          <tr>
            <td colspan="2">Total</td>
            <td>{{$total_amount}}</td>
            <td></td>
            <td>{{$total_receivable}}</td>
          </tr>
         
        </tfoot>
      </table>
      <div id="thanks">Thank you!</div>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">These are to be collected</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>