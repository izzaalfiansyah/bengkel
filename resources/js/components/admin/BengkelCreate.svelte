<script>
	import { onMount } from 'svelte';
	import { url, read, http, modal } from '../../app';
	import { link, navigate } from 'svelte-navigator';
	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';

	// data
	let nama;
	let jam_buka;
	let jam_tutup;
	let alamat;
	let lokasi;
	let whatsapp;
	let foto;

	// function
	let data = () => {
		return {
			nama: nama,
			jam_buka: jam_buka,
			jam_tutup: jam_tutup,
			alamat: alamat,
			lokasi: lokasi,
			whatsapp: whatsapp,
			foto: foto
		};
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/bengkel', data()).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				navigate('/admin/bengkel.html');
			}
		})
	}

	let genereateMap = () => {
		var map;
		if (!map) {
			setTimeout(() => {
				map = L.map('map').setView([-8.17, 113.69], 11);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
				var marker
				map.on('click', (e) => {
					marker ? map.removeLayer(marker) : null;
					lokasi = e.latlng.lat + ',' + e.latlng.lng;
					marker = L.marker(e.latlng).addTo(map);
				})
			}, 400);
		}
	}
</script>

<main>
	<Header>Bengkel</Header>
	<form on:submit={store}>
		<Card title="Tambah Bengkel">
			<label for="">Nama</label>
			<input type="text" placeholder="Masukkan Nama" bind:value={nama} required="true" maxlength="50" class="form-control">

			<div class="row">
				<div class="col-6">
					<label for="">Jam Buka</label>
					<input type="time" placeholder="Pilih Jam Buka" bind:value={jam_buka} required="true" class="form-control">
				</div>
				<div class="col-6">
					<label for="">Jam Tutup</label>
					<input type="time" placeholder="Pilih Jam Tutup" bind:value={jam_tutup} required="true" class="form-control">
				</div>
			</div>

			<label for="">Alamat</label>
			<textarea rows="3" class="form-control" bind:value={alamat} placeholder="Masukkan Alamat" />

			<div class="row">
				<div class="col-6">
					<label for="">Lokasi</label>
				</div>
				<div class="col-6" align="right">
					<a href="#0" data-bs-toggle="modal" data-bs-target="#pilih-lokasi" on:click={genereateMap}>Pilih Lokasi</a>
				</div>
			</div>
			<input type="text" placeholder="Masukkan Lokasi (Google Maps)" bind:value={lokasi} class="form-control">

			<label for="">Nomor Whatsapp</label>
			<input type="text" placeholder="Masukkan Nomor Whatsapp" bind:value={whatsapp} required="true" maxlength="50" class="form-control">

			<label for="">Foto</label>
			<input type="file" title="Pilih Foto" required="true" accept="image/*" class="form-control" on:change="{(e) => {
				read(e.target.files[0], (result) => (foto = result));
			}}">

			<div class="mb-3 p-2 rounded shadow" align="center">
				<img src={foto} alt="" style="width: 150px; height: 150px; object-fit: cover;">
			</div>

			<div slot="footer">
				<a href="/admin/bengkel.html" use:link class="btn btn-default">Batal</a>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Card>
	</form>

	<Modal id="pilih-lokasi" title="Pilih Lokasi" size="lg">
		<div id="map" style="height: 400px;"></div>

		<div slot="footer">
			<button class="btn btn-primary" type="button" on:click="{modal.close}">Selesai</button>
		</div>
	</Modal>
</main>