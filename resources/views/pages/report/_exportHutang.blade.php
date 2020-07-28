<style>
body {
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}
</style>
@if(request()->get('exportTo') == "pdf")
<h2 style="margin-bottom: 0; text-align: center;">Laporan Hutang</h2>
<p style="margin: 0 0 20px; text-align: center;">{{ date('d/m/Y H:i:s') }}</p>
@endif

<table 
    <?php if(request()->get('exportTo') == "pdf") : ?>
        border="1" 
    <?php endif; ?>
    width="100%" 
    style="border-collapse: collapse;">

    @if(request()->get('exportTo') == "excel")
    <tr><td colspan="4" align="center"><b>Laporan Hutang</b></td></tr>
    <tr><td colspan="4" align="center">{{ date('d/m/Y H:i:s') }}</td></tr>
    <tr></tr>
    @endif

    <tr>
        <th width="10px">NO</th>
        <th>NAMA PERUSAHAAN</th>
        <th width="20%" align="right">JUMLAH HUTANG</th>
        <th width="40%">TERBILANG</th>
    </tr>
    
    <?php $num = 1; ?>
    <?php $total = 0; ?>
    @foreach($suppliers as $item)
    <?php $total += $item['jumlah_hutang']; ?>
    <tr>
        <td class="text-center">{{ $num }}.</td>
        <td>{{ $item['supplier_name'] }}</td>
        <td align="right">Rp{{ number_format($item['jumlah_hutang'], 0, ',', '.') }},-</td>
        <td>{{ terbilang($item['jumlah_hutang']) }}</td>
    </tr>
    <?php $num++; ?>
    @endforeach
    <tr>
        <th colspan="2" align="right">TOTAL HUTANG :</th>
        <th align="right">Rp{{ number_format($total, 0, ',', '.') }}</th>
        <th align="left">{{ terbilang($total) }}</th>
    </tr>
</table>