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
    <table class="bordered-table" id="print_table_div">
        {!! $table !!}
    </table>
    
</body>
</html>