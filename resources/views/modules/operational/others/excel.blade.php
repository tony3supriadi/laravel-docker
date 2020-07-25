
<table class="table datatable no-ordering">
    <thead>
        <tr>
            <th width="10px">#</th>
            <th>DESKRIPSI</th>
            <th width="20%" class="text-right">NOMINAL</th>
            <th width="15%" class="text-center">TANGGAL</th>
        </tr>
    </thead>
    <tbody>
        <?php $num = 1; ?>
        @foreach($operationals as $item) 
        <tr>
            <td>{{ $num }}.</td>
            <td>{{ $item->description ? $item->description : '-' }}</td>
            <td class="text-right">Rp{{ number_format($item->nominal, 0, ',', '.') }},-</td>
            <td class="text-center">{{ Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>
        </tr>
        <?php $num++; ?>
        @endforeach
    </tbody>
</table>
