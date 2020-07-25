<table class="table datatable no-ordering">
    <thead>
        <tr>
            <th width="10px" class="text-center no-sort">#</th>
            <th width="10%">KODE</th>
            <th>PRODUK</th>
            <th width="10%">QTY</th>
            <th width="10%" class="text-right">OMSET</th>
            <th width="10%" class="text-right">PROFIT</th>
            <th width="15%">WAKTU</th>
        </tr>
    </thead>
    <tbody>
        <?php $num = 1; ?>
        <?php $qty = 0; ?>
        <?php $omset = 0; ?>
        <?php $profit = 0; ?>
        @foreach($reports as $item)

        <?php $qty = $qty + $item->qty; ?>
        <?php $omset = $omset + $item->omset; ?>
        <?php $profit = $profit + $item->profit; ?>
        <tr>
            <td class="text-center">{{ $num }}.</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->qty }}</td>
            <td class="text-right">{{ $item->omset }}</td>
            <td class="text-right">{{ $item->profit }}</td>
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-y H:i:s') }}</td>
        </tr>
        <?php $num++; ?>
        @endforeach
        <tr>
            <td align="right" colspan="3">Total :</td>
            <td>{{ $qty }}</td>
            <td>{{ $omset }}</td>
            <td>{{ $profit }}</td>
            <td></td>
        </tr>
    </tbody>
</table>
