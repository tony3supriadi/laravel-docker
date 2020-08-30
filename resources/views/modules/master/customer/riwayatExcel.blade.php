<div class="card card-body d-flex justify-content-between">
                <span>SALDO TABUNGAN :</span>
                <h3>{{ number_format($customer->saldo_tabungan, 0, ',', '.') }}</h3>
            </div>

            <table class="table datatable no-ordering">
                <thead>
                    <tr>
                        <th width="5px">#</th>
                        <th width="12%">KODE #REF</th>
                        <th width="10%">TANGGAL</th>
                        <th>DESKRIPSI</th>
                        <th width="5%" class="text-center">STATUS</th>
                        <th width="15%" class="text-right">NOMINAL</th>
                        <th width="15%" class="text-right">SALDO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($savings as $item)
                    <tr>
                        <td>#</td>
                        <td>{{ $item->code }}</td>
                        <td>{{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-center">
                            <span class="badge {{ $item->status == 'Kredit' ? 'badge-success' : 'badge-secondary' }} rounded-pill">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td class="text-right">{{ $item->status == 'Debit' ? '-' : '' }}{{ number_format($item->nominal, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($item->saldo, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>