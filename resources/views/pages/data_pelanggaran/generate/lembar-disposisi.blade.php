<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .table-disposisi {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body style="font-size:14px;font-weight: bold">
    <table style="float: right">
        <tr>
            <td>Klarifikasi: Biasa / Sangat Rahasia</td>
        </tr>
        <tr>
            <td>Derajat: Biasa / Segera / Kilat</td>
        </tr>
    </table>
    <table style="text-align: center">
        <tr>
            <td>DIVISI PROFESI DAN PENGAMANAN POLRI</td>
        </tr>
        <tr>
            <td>BIRO PENGAMANAN INTERNAL</td>
        </tr>
        <tr>
            <td>
                <hr>
            </td>
        </tr>
    </table>

    <table style="width: 100%;text-align: center">
        <tr>
            <td><u>LEMBAR DISPOSISI</u></td>
        </tr>
    </table>
    <table style="width: 100%; margin-top:20px">
        <tr>
            <td style="width: 100px">Nomor Agenda :</td>
            <td style="width: 200px">{{ $nomor_agenda }}</td>
            <td>Diterima tanggal :</td>
            <td>Jam :</td>
        </tr>
    </table>
    <br>
    <table class="table-disposisi" style="width: 100%">
        <tr class="table-disposisi">
            <td class="table-disposisi" colspan="4" width="100">
                Catatan Kaurtu
            </td>
            <td rowspan="2" class="table-disposisi">Isi Disposisi</td>
        </tr>
        <tr class="table-disposisi">
            <td class="table-disposisi" colspan="4">
                Yth. : Karopaminal / Sespropaminal
            </td>
        </tr>
        <tr>
            <td colspan="3">
                Surat Dari : {{ $surat_dati }}
            </td>
            <td class="table-disposisi" width="100">Binpam</td>
            <td rowspan="11" class="table-disposisi"> </td>
        </tr>
        <tr>
            <td colspan="3">

            </td>
            <td class="table-disposisi">Litpers</td>
        </tr>
        <tr>
            <td colspan="3">
                Nomor Surat {{ $nomor_surat }}
            </td>
            <td class="table-disposisi">Prodok</td>
        </tr>
        <tr>
            <td colspan="3">

            </td>
            <td class="table-disposisi">Kaden "A"</td>
        </tr>
        <tr>
            <td colspan="3">
                Tanggal : {{ $tanggal }}
            </td>
            <td class="table-disposisi">Kaden "B"</td>
        </tr>
        <tr>
            <td colspan="3">

            </td>
            <td class="table-disposisi">Kaden "C"</td>
        </tr>
        <tr>
            <td colspan="3">
                Perihal {{ $perihal }}
            </td>
            <td class="table-disposisi">Urtu</td>
        </tr>
        <tr>
            <td colspan="3">

            </td>
            <td class="table-disposisi">Sub Bensat</td>
        </tr>
        <tr>
            <td colspan="3" class="table-disposisi">
                Diteruskan
            </td>
            <td class="table-disposisi" rowspan="2">Lain - Lain</td>
        </tr>
        <tr>
            <td class="table-disposisi" width="60">
                Kepada
            </td>
            <td class="table-disposisi" width="60">
                Kepada
            </td>
            <td class="table-disposisi" width="60">
                Kepada
            </td>
        </tr>
        <tr>
            <td class="table-disposisi" height="90">

            </td>
            <td class="table-disposisi" width="90">

            </td>
            <td class="table-disposisi" width="90">

            </td>
            <td class="table-disposisi" width="90">

            </td>
        </tr>
    </table>
    <p>* Lampiran / Tanpa Lampiran <br>
        <u>Catatan</u>
    </p>


</body>

</html>
