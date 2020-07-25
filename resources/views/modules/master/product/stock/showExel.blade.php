<table class="table table-hover datatable no-ordering">
    <thead>
        <tr>
            <th width="5px">#</th>
            <th width="12%">TANGGAL</th>
            <th>Deskripsi</th>
            <th width="10%" class="text-right">Status</th>
            <th width="15%" class="text-right">Nominal</th>
            <th width="15%" class="text-right">Saldo</th>
        </tr>
    </thead>
    <tbody>
        <?php $num = 1; ?>
        @foreach($products as $item)
        <tr>
            <td>{{ $num }}</td>
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('d.m.Y') }}</td>
            <td>{{ $item->description }}</td>
            <td class="text-right">{{ $item->stock_status }}</td>
            <td class="text-right">
                @if($item->stock_status == "Masuk")
                <span class="text-green">+</span>
                @elseif($item->stock_status == "Keluar" || $item->stock_status == "Transfer")
                <span class="text-red">-</span>
                @else
                @endif
                {{ $item->stock_nominal }}
            </td>
            <td class="text-right">{{ $item->stock_saldo }}</td>
        </tr>
        <?php $num++; ?>
        @endforeach
    </tbody>
</table>