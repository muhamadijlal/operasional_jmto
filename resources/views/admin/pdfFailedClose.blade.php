<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Failed Import - Tarif Gerbang Sistem Tertutup</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family:'Open Sans';
            font-size: 8pt;
      
        }
        td,
        th {
            border: 1px solid black;
            padding: 3px;
            text-align: center;
        }

        .no-page-break {
            page-break-inside: avoid !important;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <center>
        <p style="font-weight: bold;">LIST FAILED IMPORT - TARIF GERBANG SISTEM TERTUTUP</p>
    </center>
    <table border="1" style="border-collapse: collapse">
        <tr style="font-weight: bold !important">
            <th>No</th>
            <th>Gerbang</th>
        </tr>
        @foreach($failed as $index => $item)
            <tr>
                <td>
                    <center>{{ $index+1 }}</center>
                </td>
                <td>
                    <center>{{ $item }}</center>
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
