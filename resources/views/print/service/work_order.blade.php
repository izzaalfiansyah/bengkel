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
					WORK ORDER
				</div>
			</div>
		</div>
		
		<hr>

		<div class="d-flex">
			<div style="width: 33.333%">
				No. : {{ $data->kode }}
			</div>
			<div style="width: 33.333%" align="center">
				Tanggal : {{ date('d-m-Y', strtotime($data->created_at)) }}
			</div>
			<div style="width: 33.333%" align="right">
				Tanggal Selesai : {{ date('d-m-Y', strtotime($data->updated_at)) }}
			</div>
		</div>
		<hr>

		<div class="d-flex">
			<div style="width: 50%">
				<table style="width: 100%;">
					<tr>
						<td>No. Service</td>
						<td>:</td>
						<td>{{ $data->kode }}</td>
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
						<td>Tahun/Warna</td>
						<td>:</td>
						<td>{{ $data->kendaraan->tahun }}/{{ $data->kendaraan->warna }}</td>
					</tr>
					<tr>
						<td>No. Rangka</td>
						<td>:</td>
						<td>{{ $data->kendaraan->nomor_rangka }}</td>
					</tr>
					<tr>
						<td>No. Mesin</td>
						<td>:</td>
						<td>{{ $data->kendaraan->nomor_mesin }}</td>
					</tr>
				</table>
			</div>
			<div style="width: 50%">
				<table style="width: 100%">
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
					<tr>
						<td>Teknisi</td>
						<td>:</td>
						<td>{{ $data->teknisi->nama }}</td>
					</tr>
					<tr>
						<td>Kontak Teknisi</td>
						<td>:</td>
						<td>{{ $data->teknisi->telepon }}</td>
					</tr>
				</table>
			</div>
		</div>
		<hr>

		<div class="d-flex">
			<div style="width: 50%;">
				<div style="padding: 5px">
					Keluhan : 
					<div style="border: 1px solid black; min-height: 60px; padding: 3px;">
						<code>{{ $data->keluhan }}</code>
					</div>
				</div>
			</div>
			<div style="width: 50%;">
				<div style="padding: 5px">
					Perintah Kerja : 
					<div style="border: 1px solid black; min-height: 60px; padding: 3px;">
						<code>{{ $data->perintah_kerja }}</code>
					</div>
				</div>
			</div>
		</div>
		<hr>

		<b>BOOKING PART</b>
		<table class="table">
			<tr>
				<th align="center">No</th>
				<th style="min-width: 250px;" align="left">Deskripsi</th>
				<th>Qty</th>
			</tr>
			@forelse($data->transaksi->produk as $item)
				@php $total_produk += $item['produk']->harga_jual * $item['qty'] @endphp
				<tr>
					<td align="center">{{ $loop->iteration }}</td>
					<td style="min-width: 250px;">{{ $item['produk']->nama }}</td>
					<td align="center">{{ $item['qty'] }} PCS</td>
				</tr>
			@empty
				<tr>
					<td colspan="3" align="center">data kosong</td>
				</tr>
			@endforelse
		</table>
		<br>
		<b>URAIAN JASA</b>
		<table class="table">
			<tr>
				<th align="center">No</th>
				<th style="min-width: 250px;" align="left">Deskripsi</th>
				<th>Qty</th>
			</tr>
			@forelse($data->transaksi->jasa as $item)
				@php $total_jasa += $item['jasa']->harga @endphp
				<tr>
					<td align="center">{{ $loop->iteration }}</td>
					<td style="min-width: 250px;">{{ $item['jasa']->nama }}</td>
					<td align="center">1</td>
				</tr>
			@empty
				<tr>
					<td colspan="3" align="center">data kosong</td>
				</tr>
			@endforelse
		</table>
		<br>
		Dengan ini kami memberikan kuasa kepada {{ env('APP_NICK') }} untuk mengerjakan segala pekerjaan yang tertulis pada Perintah Kerja dan memberikan izin untuk memeriksa kendaraan tersebut di luar area.
		<hr>
		<div class="d-flex">
			<div style="width: 50%" align="center">
				Service Advisor
				<br><br><br>
				( {{ $data->user->nama }} )
			</div>
			<div style="width: 50%" align="center">
				Pelanggan
				<br><br><br>
				( {{ $data->pelanggan ? $data->pelanggan->nama : '-' }} )
			</div>
		</div>
		<br>
	</div>
</body>