<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .bordered-table {
            border-collapse: collapse;
            width: 100%;
        }
        .bordered-table th, .bordered-table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .bordered-table th {
            background-color: #ddd;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>Sl.no</th>
                <th>Name</th>
                <th>Making Charges</th>
                <th>Addional Charges</th>
                <th>Gold Charges</th>
                <th>Diamond Charges</th>
                <th>Payment</th>
                <th>Payment</th>
                <th>Pure Metal Pending</th>
            </tr>
        </thead>
        <tbody>
            @php
                $j = 1;
            @endphp
            @foreach($data as $row)
            @php
                $is_order_avail = DB::table('orders')->where('client_name',$row->id)->count();
                $count_paymment = count_customer_payment($row->id);
                $qq = DB::table('orders')->where('client_name',$row->id)->where('is_order',1)->where('status',1);
                $totalmakingcharges = $qq->sum('making_charges');
                $addional_charges_total = $qq->sum('addional_charges_total');
                $gold_charges_total = $qq->sum('gold_charges_total');
                $diamond_charges_total = $qq->sum('diamond_charges_total');
                $bal = 0;
                $bal = $bal+($totalmakingcharges+$addional_charges_total+$gold_charges_total+$diamond_charges_total)-$count_paymment;
            @endphp
                <tr>
                    <td>{{ $j }}</td>
                    <td>{{ $row->nickname }}</td>
                    <td>{{ $totalmakingcharges }}</td>
                    <td>{{ $addional_charges_total }}</td>
                    <td>{{ $gold_charges_total }}</td>
                    <td>{{ $diamond_charges_total }}</td>
                    <td>{{ $count_paymment }}</td>
                    <td>{{ $bal }}</td>
                    <td>{{ get_customer_gold_painding($row->id) }}</td>
                    @php
                        $j++;
                    @endphp
                </tr>
            @endforeach
        </tbody>
    </table>
    
    
</body>
</html>