<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarif Gerbang Sistem Tertutup</title>
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
        <p style="font-weight: bold;">TARIF GERBANG SISTEM TERTUTUP</p>
    </center>
    <p>
        Ruas : {{ $gerbang->ruas_nama }}<br>
        Gerbang : {{ $gerbang->gerbang_nama }}<br>
        Revisi Tarif : {{ $dasar_tarif->mulai_berlaku }}<br>
        Metoda Bayar : Tunai/Umum
    </p>
    <span id="tableLength"></span>
    <br>
    <span id="pageHeight"></span>
    <br>
    <table border="1" style="border-collapse: collapse">
        <tr style="font-weight: bold !important">
            <td rowspan="2">Asal Gerbang</td>
            <td rowspan="2">
                Denda
            </td>

            @php
            $cleanedString = trim($data[0]->tarif_inv, "[]");
            $arrayValue = explode(',', $cleanedString);
            $arrayValue = array_map('trim', $arrayValue);
            $arrayValue = array_filter($arrayValue, function($value) {
            return $value !== '00000';
            });
            @endphp

            @foreach ($arrayValue as $item)
            <td colspan="5">
                <center>
                    {{ $item }}
                </center>
            </td>
            @endforeach

            <td colspan="5" class="no-page-break">
                <center>
                    Total

                </center>
            </td>
        </tr>
        <tr style="font-weight: bold !important">
            @foreach ($arrayValue as $item)
            <td >
                <center>1</center>
            </td>
            <td >
                <center>2</center>
            </td>
            <td >
                <center>3</center>
            </td>
            <td >
                <center>4</center>
            </td>
            <td >
                <center>5</center>
            </td>
            @endforeach

            <td >
                <center>1</center>
            </td>
            <td >
                <center>2</center>
            </td>
            <td >
                <center>3</center>
            </td>
            <td >
                <center>4</center>
            </td>
            <td >
                <center>5</center>
            </td>
        </tr>
        @php $counter = 0; @endphp
        @foreach ($data as $item2)
            @if ($counter % 25 == 0 && $counter != 0)
                <tr class="page-break"></tr>
            @endif
            <tr class="no-page-break">
                <td>{{ $item2->asalGerbang }}</td>
                <td>
                    <center>
                        @if ($item2->jenis == '2' || $item2->jenis == '3')
                        Ya
                        @else
                        Tidak
                        @endif
                    </center>
                </td>
                @foreach ($arrayValue as $key => $value)
                <td>{{ number_format(json_decode($item2->gol1_d)[$key] ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format(json_decode($item2->gol2_d)[$key] ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format(json_decode($item2->gol3_d)[$key] ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format(json_decode($item2->gol4_d)[$key] ?? 0, 0, ',', '.') }}</td>
                <td>{{ number_format(json_decode($item2->gol5_d)[$key] ?? 0, 0, ',', '.') }}</td>
                @endforeach

                <td>{{ number_format($item2->gol1, 0, ',', '.') }}</td>
                <td>{{ number_format($item2->gol2, 0, ',', '.') }}</td>
                <td>{{ number_format($item2->gol3, 0, ',', '.') }}</td>
                <td>{{ number_format($item2->gol4, 0, ',', '.') }}</td>
                <td>{{ number_format($item2->gol5, 0, ',', '.') }}</td>
            </tr>
            {{-- <tr class="no-page-break"></tr> --}}
            @php $counter++; @endphp
        @endforeach
    </table>
</body>
<script>
     window.onload = function() {
            calculateTableLength();
            calculatePageHeight();

            window.addEventListener('resize', function() {
                calculateTableLength();
                calculatePageHeight();
            });
        }

        function calculateTableLength() {
            var table = document.querySelector('table');
            var tableLength = table.clientHeight;
            document.getElementById('tableLength').innerText = "Table Length: " + tableLength + "px";
        }

        function calculatePageHeight() {
            var pageHeight = window.innerHeight;
            document.getElementById('pageHeight').innerText = "Page Height: " + pageHeight + "px";
        }
</script>

</html>
