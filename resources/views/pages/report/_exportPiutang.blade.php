<style>
body {
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}
</style>
@if(request()->get('exportTo') == "pdf")
<h2 style="margin-bottom: 0; text-align: center;">Laporan Piutang</h2>
<p style="margin: 0 0 20px; text-align: center;">Update pada : {{ date('d/m/Y H:i:s') }}</p>
@endif

<table 
    <?php if(request()->get('exportTo') == "pdf") : ?>
        border="1" 
    <?php endif; ?>
    width="100%" 
    style="border-collapse: collapse;">

    @if(request()->get('exportTo') == "excel")
    <tr><td colspan="6" align="center"><b>Laporan Piutang</b></td></tr>
    <tr><td colspan="6" align="center">Update pada : {{ date('d/m/Y H:i:s') }}</td></tr>
    <tr></tr>
    @endif

    <tr>
        <th width="10px">NO</th>
        <th>NAMA PELANGGAN</th>
        @for($i = (date('W') - 3); $i <= date('W'); $i++)
        <th align="right">Minggu-{{ $i }}</th>
        @endfor
    </tr>
    
    <?php $num = 1; ?>
    @foreach($customers as $item)
    <tr>
        <td class="text-center">{{ $num }}.</td>
        <td>{{ $item['name'] }}</td>
        <td align="right">
            <span style="color:<?= $item['minggu-1'] <= 0 ? 'green' : 'red' ?>">
                Rp{{ number_format(str_replace('-', '', $item['minggu-1']), 0, ',', '.') }},-
            </span>
        </td>
        <td align="right">
            <span style="color:<?= $item['minggu-2'] <= 0 ? 'green' : 'red' ?>">
                Rp{{ number_format(str_replace('-', '', $item['minggu-2']), 0, ',', '.') }},-
            </span>
        </td>
        <td align="right">
            <span style="color:<?= $item['minggu-3'] <= 0 ? 'green' : 'red' ?>">
                Rp{{ number_format(str_replace('-', '', $item['minggu-3']), 0, ',', '.') }},-
            </span>
        </td>
        <td align="right">
            <span style="color:<?= $item['minggu-4'] <= 0 ? 'green' : 'red' ?>">
                Rp{{ number_format(str_replace('-', '', $item['minggu-4']), 0, ',', '.') }},-
            </span>
        </td>
    </tr>
    <?php $num++; ?>
    @endforeach
</table>