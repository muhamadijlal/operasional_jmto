
<style>
    p,table{
        font-size: 11px !important;
    }
    
</style>

    <center>
            <p style="font-weight: bold !important">TARIF GERBANG SISTEM TERTUTUP</p>
    </center>

    <p>
        Cabang : {{ $gerbang->ruas_nama }}
        <br>
        Gerbang : {{ $gerbang->gerbang_nama }}
        <br>
        Revisi Tarif :{{ $dasar_tarif->mulai_berlaku}}
        <br>
        Metoda Bayar : Tunai/Umum
    </p>
    <table border="1" style="border-collapse: collapse" >
        <tr style="font-weight: bold !important" >
            <td rowspan="2" >Asal Gerbang</td>
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

            <td colspan="5">
                <center>
                    Total

                </center>
            </td>          
        </tr>
        <tr style="font-weight: bold !important">
            @foreach ($arrayValue as $item)
            <td style="min-width: 15px "> <center>1</center></td>
            <td style="min-width: 15px "> <center>2</center></td>
            <td style="min-width: 15px "> <center>3</center></td>
            <td style="min-width: 15px "> <center>4</center></td>
            <td style="min-width: 15px "> <center>5</center></td>
            @endforeach

            <td style="min-width: 15px "> <center>1</center></td>
            <td style="min-width: 15px "> <center>2</center></td>
            <td style="min-width: 15px "> <center>3</center></td>
            <td style="min-width: 15px "> <center>4</center></td>
            <td style="min-width: 15px "> <center>5</center></td>

        </tr>
        @foreach ($data as $item2)
            <tr>
                <td>{{ $item2->asalGerbang }}</td>
                <td>
                    <center>
                    @if ($item2->jenis == 'ags' || $item2->jenis ==  'khl')
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
            <tr>

            </tr>
        @endforeach

        
    </table>


