<body>
	
	<div style="padding: 20px 30px; ">
		<div class="d-flex" style="align-items: center">
			<div style="width: 20%;">
				<img src="{{ asset('/logo.png') }}" alt="" style="width: 100%;">
			</div>
			<div style="width: 50%;">
				<br><br>
				{{ env('APP_NAME') }} <br><br>
				{{ env('APP_ADDRESS') }} <br><br>
				Telp : {{ env('APP_PHONE') }}
			</div>
			<div style="width: 30%;">
				<br><br>
				<div style="border: 1px solid black; padding: 30px 0;" align="center">
					INVOICE
				</div>
			</div>
		</div>
		
		<hr>

		<div class="d-flex">
			<div style="width: 50%">
				<table style="width: 100%;">
					<tr>
						<td>No. Invoice</td>
						<td>:</td>
						<td>{{ str_replace('PS', 'FS', $data->kode) }}</td>
					</tr>
					<tr>
						<td>No. Polisi</td>
						<td>:</td>
						<td>{{ $data->kendaraan->nomor_plat }}</td>
					</tr>
					<tr>
						<td>Merk/Brand</td>
						<td>:</td>
						<td>{{ $data->kendaraan->merek }}/{{ $data->kendaraan->brand }}</td>
					</tr>
					<tr>
						<td>No. Mesin</td>
						<td>:</td>
						<td>{{ $data->kendaraan->nomor_mesin }}</td>
					</tr>
					<tr>
						<td>No. Rangka</td>
						<td>:</td>
						<td>{{ $data->kendaraan->nomor_rangka }}</td>
					</tr>
				</table>
			</div>
			<div style="width: 50%">
				<table style="width: 100%">
					<tr>
						<td>Tanggal Jatuh Tempo</td>
						<td>:</td>
						<td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
					</tr>
					<tr>
						<td>Tanggal Service</td>
						<td>:</td>
						<td>{{ date('d-m-Y', strtotime($data->updated_at)) }}</td>
					</tr>
					<tr>
						<td>Nama Pelanggan</td>
						<td>:</td>
						<td>{{ $data->pelanggan->nama }}</td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td>{{ $data->pelanggan->alamat }}</td>
					</tr>
					<tr>
						<td>Kontak</td>
						<td>:</td>
						<td>{{ $data->pelanggan->whatsapp }}</td>
					</tr>
				</table>
			</div>
		</div>
		<hr>
		<b>PART</b>
		<table class="table">
			<tr>
				<th style="min-width: 250px;" align="left">Deskripsi</th>
				<th>Qty</th>
				<th align="right">Harga</th>
				<th>Disc</th>
				<th align="right">Jumlah</th>
			</tr>
			@forelse($data->transaksi->produk as $item)
				@php $total_produk += $item['produk']->harga_jual * $item['qty'] @endphp
				@php $jumlah_produk += 1 @endphp
				<tr>
					<td style="min-width: 250px;">{{ $item['produk']->nama }}</td>
					<td align="center">{{ $item['qty'] }} PCS</td>
					<td align="right">IDR {{ number_format($item['produk']->harga_jual, 0, ',', '.') }}</td>
					<td align="center">0</td>
					<td align="right">IDR {{ number_format($item['produk']->harga_jual * $item['qty'], 0, ',', '.') }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="5" align="center">data kosong</td>
				</tr>
			@endforelse
			<tr>
				<th colspan="4" align="right">Total</th>
				<th align="right">IDR {{ number_format($total_produk, 0, ',', '.') }}</th>
			</tr>
		</table>
		<br>
		<b>JASA</b>
		<table class="table">
			<tr>
				<th style="min-width: 250px;" align="left">Deskripsi</th>
				<th>Qty</th>
				<th align="right">Harga</th>
				<th>Disc</th>
				<th align="right">Jumlah</th>
			</tr>
			@forelse($data->transaksi->jasa as $item)
				@php $total_jasa += $item['jasa']->harga @endphp
				@php $jumlah_jasa += 1 @endphp
				<tr>
					<td style="min-width: 250px;">{{ $item['jasa']->nama }}</td>
					<td align="center">1</td>
					<td align="right">IDR {{ number_format($item['jasa']->harga, 0, ',', '.') }}</td>
					<td align="center">0</td>
					<td align="right">IDR {{ number_format($item['jasa']->harga, 0, ',', '.') }}</td>
				</tr>
			@empty
				<tr>
					<td colspan="5" align="center">data kosong</td>
				</tr>
			@endforelse
			<tr>
				<th colspan="4" align="right">Total</th>
				<th align="right">IDR {{ number_format($total_jasa, 0, ',', '.') }}</th>
			</tr>
		</table>
		<div align="right">
			<br>
			<div style="width: 45%;">
				<table style="width: 100%">
					<tr>
						<td>Jumlah Part & Jasa</td>
						<td>:</td>
						<td align="right">{{ $jumlah_jasa + $jumlah_produk }}</td>
					</tr>
					<tr>
						<td>PPN</td>
						<td>:</td>
						<td align="right">0</td>
					</tr>
					<tr>
						<td>Tanggal Pembayaran</td>
						<td>:</td>
						<td align="right">{{ date('d-m-Y', strtotime($data->updated_at)) }}</td>
					</tr>
					<tr>
						<td>Total</td>
						<td>:</td>
						<td align="right">IDR {{ number_format($total_produk + $total_jasa) }}</td>
					</tr>
				</table>
			</div>
		</div>
		Transfer Melalui Rek. BCA: {{ env('APP_REK') }}
		<hr>
		<div class="d-flex">
			<div style="width: 50%" align="center">
				Kasir
				<br><br><br>
				( {{ $data->user->nama }} )
			</div>
			<div style="width: 50%" align="center">
				Pelanggan
				<br><br><br>
				( {{ $data->pelanggan ? $data->pelanggan->nama : '-' }} )
			</div>
		</div>
	</div>
</body>