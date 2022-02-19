<table border="1">
    <tr>
        <th>No</th>
        <th>Nama Produk</th>
        <th>Terjual</th>
        <th>Penghasilan</th>
        <th>Pengeluaran</th>
        <th>Profit</th>
    </tr>
    @foreach ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->terjual }}</td>
            <td style="min-width: 150px" class="text-success">IDR {{ number_format($item->penghasilan, 0, ',', '.') }}</td>
            <td style="min-width: 150px" class="text-success">IDR {{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
            <td style="min-width: 150px" class="text-success">IDR {{ number_format($item->penghasilan - $item->pengeluaran, 0, ',', '.') }}</td>
        </tr>
    @endforeach
</table>