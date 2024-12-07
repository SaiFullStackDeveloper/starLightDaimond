<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Details Table</title>
<style>
  .table-ui {
    border-collapse: collapse;
    width: 100%;
  }

  .table-ui, .table-ui td, .table-ui th {
    border: 1px solid black;
  }
    
  .table-ui td, .table-ui th {
    text-align: center;
    padding: 8px;
  }

  /* Additional styles for nested tables */
  .nested-table {
    width: 100%;
    border-collapse: collapse;
  }

  .nested-table td {
    border: 1px solid #000;
  }

</style>
</head>
<body>

<table class="table-ui">
<tr style="background:#006CFF;color: #fff">
    <td colspan="4"><h3>Starlight Diamonds</h3></td>
 </tr>
 <tr style="background:#000;color: #fff">
    <td colspan="4">Order Details</td>
 </tr>
<tr>
    <td>ORDER NO</td>
    <td colspan="3">{{$order_data->ofnumber}}</td>
 </tr>
 <tr>
    <td>CLIENT</td>
    <td colspan="3">{{$customer_name->customer_name}}</td>
 </tr>
 <tr>
    <td>PRODUCT</td>
    <td colspan="3">{{ $products }}</td>
 </tr>
 <tr>
    <td>GOLD</td>
    <td colspan="3">
        <table class="nested-table">
            <tr>
                <!-- <td>GMs</td> -->
                <td>GOLD G/W</td>
                <td>GOLD N/W</td>
                <td>KARAT</td>
                <td>COLOUR</td>
            </tr>
            <tr>
                <!-- <td>{{count_gem_recive_polish('fp_reciv',$order_data->id,4)}}</td> -->
                <td>{{$gold_gw}}</td>
                <td>{{$gold_nw}}</td>
                <td>{{get_karat_name($order_data->filling_carret)}}</td>
                <td>{{$color}}</td>
            </tr>
        </table>
    </td>
 </tr>
 <tr>
    <td></td>
    <td>Karat</td>
    <td>Piece</td>
    <td>Gram</td>
 </tr>
 <tr>
    <td>DIAMOND</td>
    <td>{{$setting->kd}}</td>
    <td>{{$setting->pd}}</td>
    <td>{{$setting->pd}}</td>
 </tr>
 <tr>
    <td>CS</td>
    <td>{{$setting->kc}}</td>
    <td>{{$setting->pc}}</td>
    <td>{{$setting->pc}}</td>
 </tr>
 <tr>
    <td>AD</td>
    <td>{{$setting->ka}}</td>
    <td>{{$setting->pa}}</td>
    <td>{{$setting->pa}}</td>
 </tr>
 <tr>
    <td>ENAMEL</td>
    <td></td>
    <td></td>
    <td>{{$setting->gew}}</td>
 </tr>
</table>

</body>
</html>
