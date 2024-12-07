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
                <th>Sl. No</th>
                <th>Order Id</th>
                <th>Unique Id</th>
                <th>Date</th>
                <th>Worker Name</th>
                <th>Karet</th>
                <th>Issue</th>
               
                <th>Gram received</th>
                <th>Diamond </th>
                <th>Diamond Piece</th>
                <th>Color Stone</th>
                <th>Color Stone Piece</th>
                <th>AD</th>
                <th>AD Piece</th>
                <th>Enamel WT</th>
                <th>Dust</th>
            </tr>
        </thead>
        <tbody>
            @php
                $j = 1;
            @endphp
            @foreach($data as $i)
                <tr>
                    <td>{{$j}}</td>
                    <td>{{$i->order_id}}</td>
                   <td>{{get_order_qid($i->order_id)}}</td>
                   <td>{{$i->update_date}}</td>
                   <td>{{get_worker_name($i->worker_id)}}</td>
                   <td>{{get_karet_name($i->order_id)}}</td>
                   <td>{{$i->gram_issue}}</td>
                    
                    <td>{{$i->se_reciv}}</td>
                    <td>{{$i->kd}}</td>
                    <td>{{$i->pd}}</td>
                    <td>{{$i->kc}}</td>
                    <td>{{$i->pc}}</td>
                    <td>{{$i->ka}}</td>
                    <td>{{$i->pa}}</td>
                    <td>{{$i->gew}}</td>
                    <td>{{$i->se_dust}}</td>
                    @php
                        $j++;
                    @endphp
                </tr>
            @endforeach
        </tbody>
    </table>
    
    
</body>
</html>