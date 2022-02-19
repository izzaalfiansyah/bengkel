<table border="1">
    <tr>
        <th>No</th>
        <th>Nama Jasa</th>
        <th>Terpakai</th>
        <th>Profit</th>
    </tr>
    @foreach ($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->terpakai }}</td>
            <td style="min-width: 150px" class="text-success">IDR {{ number_format($item->penghasilan, 0, ',', '.') }}</td>
        </tr>
    @endforeach
</table>