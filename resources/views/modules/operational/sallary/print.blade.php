<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaji Karyawan</title>
</head>
<body>
    <?php 
    $months = [
        [ 'id' => 1, 'name' => "Januari" ],
        [ 'id' => 2, 'name'  => "Februari" ],
        [ 'id' => 3, 'name'  => "Maret" ],
        [ 'id' => 4, 'name'  => "April" ],
        [ 'id' => 5, 'name'  => "Mei" ],
        [ 'id' => 6, 'name'  => "Juni" ],
        [ 'id' => 7, 'name'  => "Juli" ],
        [ 'id' => 8, 'name'  => "Agustus" ],
        [ 'id' => 9, 'name'  => "September" ],
        [ 'id' => 10, 'name'  => "Oktober" ],
        [ 'id' => 11, 'name'  => "November" ],
        [ 'id' => 12, 'name'  => "Desember" ],
    ]; 
    $month = array_filter($months, function($var) {
        return ($var['id'] == (isset($_GET['m']) ? $_GET['m'] : date('m')));
    })[(isset($_GET['m']) ? ($_GET['m'] - 1) : (date('m') - 1))];
    ?>

    <h3 style="margin:0;padding:0;text-align:center">LAPORAN GAJI BULANAN</h3>
    <p style="margin:0 0 20px; text-align:center">BULAN : {{ strtoupper($month['name']) }} {{ isset($_GET['y']) ? $_GET['y'] : date('Y') }}</p>
    <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
            <tr>
                <th align="center" width="5%">NO.</th>
                <th align="center">NAMA KARYAWAN</th>
                <th align="center" width="15%">GAJI POKOK</th>
                <th align="center" width="15%">GAJI TAMABAHAN</th>
                <th align="center" width="15%">TOTAL</th>
                <th align="center" width="10%">TANDA TANGAN</th>
            </tr>
        </thead>
        @if(count($results))
        <tbody>
            <?php 
            $num = 1;
            $salarySUM = 0;
            $salaryExSUM = 0;
            $salaryTotSUM = 0;
            ?>
            @foreach($results as $item)
            <tr>
                <td>{{ $num }}.</td>
                <td>{{ $item->name }}</td>
                <td align="right">{{ number_format($item->salary, 0, ',', '.') }}</td>
                <td align="right">{{ number_format($item->salary_extra, 0, ',', '.') }}</td>
                <td align="right">{{ number_format($item->salary_total, 0, ',', '.') }}</td>
                <td></td>
            </tr>
            <?php
            $num++;
            $salarySUM = $salarySUM + $item->salary;
            $salaryExSUM = $salaryExSUM + $item->salary_extra;
            $salaryTotSUM = $salaryTotSUM + $item->salary_total;
            ?>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2" align="right">TOTAL :</th>
                <th align="right">{{ number_format($salarySUM, 0, ',', '.') }}</th>
                <th align="right">{{ number_format($salaryExSUM, 0, ',', '.') }}</th>
                <th align="right">{{ number_format($salaryTotSUM, 0, ',', '.') }}</th>
                <th></th>
            </tr>
        </tfoot>
        @else
        <tbody>
            <tr>
                <td colspan="6" align="center">
                    KARYAWAN PENERIMA GAJI BULAN {{ strtoupper($month['name']) }} {{ isset($_GET['y']) ? $_GET['y'] : date('Y') }} BELUM DITAMBAHKAN.
                </td>
            </tr>
        </tbody>
        @endif
    </table>
</body>
</html>