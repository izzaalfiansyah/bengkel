<body style="padding: 20px 30px;">
	<div align="center">
		<h2>{{ env('APP_NAME') }}</h2>
	</div>
	<hr>
	<div style="display: flex;">
		<div style="width: 50%">
			<table>
				<tr>
					<td>Nama Pelanggan</td>
					<td>:</td>
					<td>{{ $data->pelanggan ? $data->pelanggan->nama : '-' }}</td>
				</tr>
				<tr>
					<td>Penulis</td>
					<td>:</td>
					<td>{{ $data->user->nama }}</td>
				</tr>
				<tr>
					<td>Status</td>
					<td>:</td>
					<td>{{ $data->total_bayar > $data->total_harga ? 'Lunas' : 'Piutang' }}</td>
				</tr>
			</table>
		</div>
		<div style="width: 50%">
			<table>
				<tr>
					<td>Kode</td>
					<td>:</td>
					<td>{{ $data->kode }}</td>
				</tr>
				<tr>
					<td>Total</td>
					<td>:</td>
					<td>IDR {{ number_format($data->total_harga, 0, '.', '.') }}</td>
				</tr>
				<tr>
					<td>Bayar</td>
					<td>:</td>
					<td>IDR {{ number_format($data->total_bayar, 0, '.', '.') }}</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td>:</td>
					<td><?= date('d-m-Y', strtotime($data->created_at)) ?></td>
				</tr>
			</table>
		</div>
	</div>
	<hr>
	<style>
		.table td, .table th {
			padding: 6px;
		}
		.table th {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}
	</style>
	Uraian Part:
	<table class="table" style="width: 100%; border-collapse: collapse;">
		<thead>
			<tr>
				<th>No</th>
				<th align="left">Part</th>
				<th align="right">Qty</th>
				<th align="right">Harga</th>
				<th align="right">Jumlah</th>
			</tr>
		</thead>
		<tbody>
			@php $total_produk = 0 @endphp
			@forelse($data->produk as $produk)
				@php $total_produk += $produk['qty'] * $produk['produk']->harga_jual @endphp
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $produk['produk']->nama }}</td>
					<td align="right">{{ $produk['qty'] }}</td>
					<td align="right">IDR {{ number_format($produk['produk']->harga_jual, 0, '.', '.') }}</td>
					<td align="right">IDR {{ number_format($produk['qty'] * $produk['produk']->harga_jual, 0, '.', '.') }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="5" align="center">data kosong</td>
				</tr>
			@endforelse
			<tr>
				<th colspan="4" align="center">Total</th>
				<th align="right">IDR {{ number_format($total_produk, 0, '.', '.') }}</th>
			</tr>
		</tbody>
	</table>
	<br>
	Uraian Jasa:
	<table class="table" style="width: 100%; border-collapse: collapse;">
		<thead>
			<tr>
				<th>No</th>
				<th align="left">Jasa</th>
				<th align="right">Qty</th>
				<th align="right">Harga</th>
				<th align="right">Jumlah</th>
			</tr>
		</thead>
		<tbody>
			@php $total_jasa = 0 @endphp
			@forelse($data->jasa as $jasa)
				@php $total_jasa += $jasa['jasa']->harga @endphp
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $jasa['jasa']->nama }}</td>
					<td align="right">1</td>
					<td align="right">IDR {{ number_format($jasa['jasa']->harga, 0, '.', '.') }}</td>
					<td align="right">IDR {{ number_format($jasa['jasa']->harga, 0, '.', '.') }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="5" align="center">data kosong</td>
				</tr>
			@endforelse
			<tr>
				<th colspan="4" align="center">Total</th>
				<th align="right">IDR {{ number_format($total_jasa, 0, '.', '.') }}</th>
			</tr>
		</tbody>
	</table>
	<br>
	<div align="right">
		<b>Grand Total: IDR {{ number_format($total_produk + $total_jasa, 0, '.', '.') }}</b>
	</div>
	<br><br><br><br><br><br>
	<div align="right">
		<div style="width: 30%;" align="center">
			<u><b>{{ $data->user->nama }}</b></u>
			<br>
			<b>PENULIS</b>
		</div>
	</div>
	<script>
		window.print();
		setTimeout(() => {
			window.close();
		}, 4000);
	</script>
</body>