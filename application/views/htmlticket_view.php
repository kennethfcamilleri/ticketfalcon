<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/pdf.css">

<table class="tg" style="undefined;table-layout: fixed; width: 600px">
<colgroup>
<col style="width: 400px">
<col style="width: 200px">
</colgroup>
  <tr>
    <th class="tg-qcjy" colspan="2">E-Ticket<br></th>
  </tr>
  <tr>
    <td class="tg-lt3p" colspan="2"><?php echo $ticket_line['event_title']; ?></td>
  </tr>
  <tr>
    <td class="tg-yw4l">Event Date: <?php echo date('l jS \of F Y h:i A',strtotime($ticket_line['event_date'])); ?></td>
    <td class="tg-urt8">ADMIT ONE</td>
  </tr>
  <tr>
    <td class="tg-yw4l">Ticket Type: <?php echo $ticket_line['ticket_type']; ?></td>
    <td class="tg-s6z2" rowspan="3"><img src="https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=<?php echo $ticket_line['ticket_code'];?>&choe=UTF-8" alt="" title="" style="width:100px;height:100px" /></td>

  </tr>
  <tr>
    <td class="tg-yw4l">Ticket Price: €<?php echo $ticket_line['ticket_price']; ?></td>
  </tr>
  <tr>
    <td class="tg-yw4l">Ticket Code: <?php echo $ticket_line['ticket_code']; ?></td>
  </tr>
</table>
