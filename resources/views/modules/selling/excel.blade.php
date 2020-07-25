<table class="table datatable no-ordering">
    <thead>
        <tr>
            <th width="10px" class="text-center no-sort">#</th>
            <th width="10%">INVOICE</th>
            <th>PELANGGAN</th>
            <th width="18%" class="text-right">TOTAL PEMBAYARAN</th>
            <th width="12%" class="text-center">STATUS</th>
            <th width="18%">TANGGAL BELANJA</th>
        </tr>
    </thead>
    <tbody>
        <?php $num = 1; ?>
        <?php $total = 0; ?>
        @foreach($sales as $item)
        <?php $total = $total + $item->price_total; ?>
        <tr>
            <td class="text-center">
                {{ $num }}
            </td>
            <td>INV{{ substr($item->invoice, 0, 8) }}</td>
            <td>{{ $item->customer_name }}</td>
            <td class="text-right">{{ $item->price_total }}</td>
            <td class="text-center">
                <span class="badge badge-pill {{ (($item->status == 'Lunas') ? 'badge-success' : (($item->status == 'Piutang') ? 'badge-danger text-white' : 'badge-secondary')) }}">
                    {{ $item->status }}
                </span>
            </td>
            <td>{{ Carbon\Carbon::parse($item->created_at)->format('d-m-y H:i:s') }}</td>
        </tr>
        <?php $num++; ?>
        @endforeach
        <tr>
            <td colspan="3" align="right">TOTAL :</td>
            <td>{{ $total }}</td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>