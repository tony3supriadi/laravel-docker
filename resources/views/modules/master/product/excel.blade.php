<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>KODE PRODUK</th>
            <th>NAMA PRODUK</th>
            <th>KATEGORI</th>
            <th>HARGA BELI</th>
            <th>HARGA JUAL</th>
            <th>STOK</th>
            <th>STOK MINIMUM</th>
            <th>SATUAN</th>
            <th>DESKRIPSI</th>
        </tr>
    </thead>
    <tbody>
        <?php $num = 1; ?>
        @foreach($products as $item) 
        <tr>
            <td>{{ $num }}</td>
            <td>{{ $item->code }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->category_name }}</td>
            <td>{{ $item->purchase_price }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->stock }}</td>
            <td>{{ $item->stockmin }}</td>
            <td>{{ $item->symbol }}</td>
            <td>{{ $item->description }}</td>
        </tr>
        <?php $num++; ?>
        @endforeach
    </tbody>
</table>