<table border="1">
    <tr>
        <th>No</th>
        <th>Bulan</th>
        <th>Tahun</th>
        <th>Pendapatan</th>
        <th>Pengeluaran</th>
        <th>Profit</th>
    </tr>
    @foreach ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->bulan }}</td>
            <td>{{ $item->tahun }}</td>
            <td style="min-width: 150px" class="text-success">IDR {{ number_format($item->pendapatan, 0, ',', '.') }}</td>
            <td style="min-width: 150px" class="text-success">IDR {{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
            <td style="min-width: 150px" class="text-success">IDR {{ number_format($item->pendapatan - $item->pengeluaran, 0, ',', '.') }}</td>
        </tr>
    @endforeach
</table>