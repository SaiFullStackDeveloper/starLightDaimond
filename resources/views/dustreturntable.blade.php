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
                <th>Date</th>
                <th>Worker Name</th>
                <th>Dust Return</th>
            </tr>
        </thead>
        <tbody>
            @php
                $j = 1;
            @endphp
            @foreach($data as $row)
                <tr>
                    <td>{{ $j }}</td>
                    <td>{{$row->date}}</td>
                    <td>{{$row->name}}</td>
                    <td>{{$row->return_dust}}</td>
                    @php
                        $j++;
                    @endphp
                </tr>
            @endforeach
        </tbody>
    </table>
    
    
</body>
</html>