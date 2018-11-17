<?php 
   date_default_timezone_set('Europe/Istanbul');
   /* server timezone */
   define('CONST_SERVER_TIMEZONE', 'UTC');
   
   /* server dateformat */
   define('CONST_SERVER_DATEFORMAT', 'YmdHis');
   
   function now($str_user_timezone,
       $str_server_timezone = CONST_SERVER_TIMEZONE,
       $str_server_dateformat = CONST_SERVER_DATEFORMAT) {
   
     // set timezone to user timezone
       date_default_timezone_set($str_user_timezone);
   
       $date = new DateTime('now');
       $date->setTimezone(new DateTimeZone($str_server_timezone));
       $str_server_now = $date->format($str_server_dateformat);
   
     // return timezone to server default
       date_default_timezone_set($str_server_timezone);
   
       return $str_server_now;
   }
   
   if ($_GET["ea"] || $_GET["ee"] || $_GET["ek"] || $_GET["iea"] || $_GET["iee"] || $_GET["iek"]){
       $arr = array(
           'ea' => $_GET["ea"],
           'ee' => $_GET["ee"],
           'ek' => $_GET["ek"],
           'iea' => $_GET["iea"],
           'iee' => $_GET["iee"],
           'iek' => $_GET["iek"]
       );
   
       $dt = new DateTime();
       $updatetime = $dt->format('Y-m-d H:i:s');
   
       $jarr = array('result' => $arr, 'last_update' => $updatetime);
       $jstr = json_encode($jarr);
   
       $f = 'log.json';
       $fp = fopen($f, 'w');
       fwrite($fp, $jstr);
       fclose($fp);
       exit();
   }
   
   $page = $_SERVER['PHP_SELF'];
   $sec = "3";
   ?>
<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
      <title>Fatura Gösterim</title>
      <style>
         .invoice-box {
         max-width: 800px;
         margin: auto;
         padding: 30px;
         border: 1px solid #eee;
         box-shadow: 0 0 10px rgba(0, 0, 0, .15);
         font-size: 16px;
         line-height: 24px;
         font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
         color: #555;
         }
         .invoice-box table {
         width: 100%;
         line-height: inherit;
         text-align: left;
         }
         .invoice-box table td {
         padding: 5px;
         vertical-align: top;
         }
         .invoice-box table tr td:nth-child(2) {
         text-align: right;
         }
         .invoice-box table tr.top table td {
         padding-bottom: 20px;
         }
         .invoice-box table tr.top table td.title {
         font-size: 45px;
         line-height: 45px;
         color: #333;
         }
         .invoice-box table tr.information table td {
         padding-bottom: 40px;
         }
         .invoice-box table tr.heading td {
         background: #eee;
         border-bottom: 1px solid #ddd;
         font-weight: bold;
         }
         .invoice-box table tr.details td {
         padding-bottom: 20px;
         }
         .invoice-box table tr.item td{
         border-bottom: 1px solid #eee;
         }
         .invoice-box table tr.item.last td {
         border-bottom: none;
         }
         .invoice-box table tr.total td:nth-child(2) {
         border-top: 2px solid #eee;
         font-weight: bold;
         }
         @media only screen and (max-width: 600px) {
         .invoice-box table tr.top table td {
         width: 100%;
         display: block;
         text-align: center;
         }
         .invoice-box table tr.information table td {
         width: 100%;
         display: block;
         text-align: center;
         }
         }
         /* RTL */
         .rtl {
         direction: rtl;
         font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
         }
         .rtl table {
         text-align: right;
         }
         .rtl table tr td:nth-child(2) {
         text-align: left;
         }
      </style>
   </head>
   <body>
      <div class="invoice-box">
         <table cellpadding="0" cellspacing="0">
            <tr class="top">
               <td colspan="2">
                  <table>
                     <tr>
                        <td class="title">
                          <img src="./e-billing.png" style="width:100%; max-width:300px;">   
                        </td>
                        <td>
                           Last Update: <?php echo date("H:i:s d.m.Y") ?><br>
                           Due: February 1, 2018
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr class="information">
               <td colspan="2">
                  <table>
                     <tr>
                        <td>
                           Gazi Üniversitesi<br>
                           Teknoloji Fakültesi<br>
                           06500 Teknikokullar<br>
                           ANKARA
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <?php 
               $json = file_get_contents('./log.json');
               $obj = json_decode($json, true);
               $obj = $obj['result'];
                              
               $birim_fiyat = 0.219634;
               $total_kullanim = ($obj['ea'] - $obj['iea']);
               
                $ilk_aktif_index = $obj['iea'];
                $son_aktif_index = $obj['ea'];

                $total_tutar = ($birim_fiyat*$total_kullanim);
                $ilk_kapasitif_index = $obj['iek'];
                $son_kapasitif_index = $obj['ek'];
                $ilk_enduktif_index = $obj['iee'];
                $son_enduktif_index = $obj['ee'];
               ?>
            <tr class="heading">
               <td>
                  Meter Reading Information
               </td>
               <td>
                  #
               </td>
            </tr>
            <tr class="item">
               <td>
                  Last read index
               </td>
               <td>
                  <?php echo $ilk_aktif_index ?>
               </td>
            </tr>
            <tr class="item">
               <td>
                  Current index
               </td>
               <td>
                  <?php echo $son_aktif_index ?>
               </td>
            </tr>
            <tr class="item">
               <td>
                  Capacitive last read index
               </td>
               <td>
                  <?php echo $ilk_kapasitif_index ?>
               </td>
            </tr>
            <tr class="item">
               <td>
                  Capacitive current index
               </td>
               <td>
                  <?php echo $son_kapasitif_index ?>
               </td>
            </tr>
            <tr class="item">
               <td>
                  Inductive last read index
               </td>
               <td>
                  <?php echo $ilk_enduktif_index ?>
               </td>
            </tr>
            <tr class="item last">
               <td>
                  Inductive current index
               </td>
               <td>
                  <?php echo $son_enduktif_index ?>
               </td>
            </tr>
            <tr class="total">
               <td></td>
               <td>
                  Total Consumption: <?php echo $total_kullanim ?> kWh
               </td>
            </tr>
            <tr class="heading">
               <td>
                  Pricing
               </td>
               <td>
                  #
               </td>
            </tr>
            <tr class="details">
               <td>
                  Unit price
               </td>
               <td>
                  <?php echo $birim_fiyat ?> &euro;
               </td>
            </tr>
            <tr class="details">
               <td>
                  Consumption cost
               </td>
               <td>
                  <?php echo $total_tutar ?> &euro;
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>