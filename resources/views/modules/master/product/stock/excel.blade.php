<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>KODE PRODUK</th>
            <th>NAMA PRODUK</th>
            <th>STOK SAAT INI</th>
        </tr>
    </thead>
    <tbody>
        <?php $num = 1; ?>
        @foreach($products as $item) 
        <tr>
            <td>{{ $num }}</td>
            <td>{{ $item->product_code }}</td>
            <td>{{ $item->product_name }}</td>
            <td @if($item->stock_saldo < $item->product_stockmin) style="color:red" @endif>
                {{ $item->stock_saldo }}
            </td>
        </tr>
        <?php $num++; ?>
        @endforeach
    </tbody>
</table>