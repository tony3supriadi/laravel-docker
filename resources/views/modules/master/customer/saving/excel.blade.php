<table class="table datatable no-ordering">
        <thead>
            <tr>
                <th width="10px" class="text-center no-sort">#</th>
                <th width="10%">TANGGAL</th>
                <th width="18%">PELANGGAN</th>
                <th>DESKRIPSI</th>
                <th width="8%" class="text-center">STATUS</th>
                <th width="12%" class="text-right">NOMINAL</th>
                <th width="12%" class="text-right">SALDO</th>
            </tr>
        </thead>
        <tbody>
            <?php $num = 1; ?>
            @foreach($savings as $item)
                <tr>
                    <td>#</td>
                    <td>{{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    <td>
                        <a href="{{ url('/pelanggan/'.encrypt($item->customer_id).'/tabungan') }}">
                            {{ $item->name }}
                        </a>
                    </td>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">
                        <span class="badge {{ $item->status == 'Kredit' ? 'badge-success' : 'badge-secondary' }} rounded-pill">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td class="text-right">
                    {{ $item->status == 'Debit' ? '-' : '' }}{{ number_format($item->nominal, 0, ',', '.') }}
                    </td>
                    <td class="text-right">
                        {{ number_format($item->saldo, 0, ',', '.') }}
                    </td>
                </tr>
                <?php $num++; ?>
            @endforeach
        </tbody>
    </table>