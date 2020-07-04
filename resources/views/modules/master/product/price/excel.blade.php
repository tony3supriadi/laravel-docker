<table>
    <thead>
        <tr>
            <th>NO</th>
            <th>KODE PRODUK</th>
            <th>NAMA PRODUK</th>
            <th>GRUP PELANGGAN</th>
            <th>HARGA JUAL</th>
            <th>DESKRIPSI</th>
        </tr>
    </thead>
    <tbody>
        <?php $num = 1; ?>
        @foreach($products as $item) 
        <tr>
            <td>{{ $num }}</td>
            <td>{{ $item->product_code }}</td>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->group_name }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->description }}</td>
        </tr>
        <?php $num++; ?>
        @endforeach
    </tbody>
</table>