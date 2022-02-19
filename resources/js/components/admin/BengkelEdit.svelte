<script>
	import { onMount } from 'svelte';
	import { read, http, modal, url, asset } from '../../app';
	import { link, navigate } from 'svelte-navigator';
	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';

	export let id;

	// data
	let nama;
	let jam_buka;
	let jam_tutup;
	let alamat;
	let lokasi;
	let latlng;
	let whatsapp;
	let foto;
	let fotoSrc;

	// function
	let get = () => {
		http.get('api/bengkel/' + id).then(res => {
			nama = res.data.nama;
			jam_buka = res.data.jam_buka;
			jam_tutup = res.data.jam_tutup;
			alamat = res.data.alamat;
			lokasi = res.data.lokasi;
			if (res.data.lokasi) {
				latlng = [
					res.data.lat,
					res.data.lng
				];
			}
			whatsapp = res.data.whatsapp;
			fotoSrc = asset('asset/bengkel/' + res.data.foto);
		});
	}

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

	let update = (e) => {
		e.preventDefault();
		http.put('api/bengkel/' + id, data()).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
			}
		})
	}

	let genereateMap = () => {
		var map;
		if (!map) {
			setTimeout(() => {
				map = L.map('map').setView([-8.17, 113.69], 11);
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
				if (latlng) { L.marker(latlng).addTo(map) };
				var marker
				map.on('click', (e) => {
					marker ? map.removeLayer(marker) : null;
					lokasi = e.latlng.lat + ',' + e.latlng.lng;
					marker = L.marker(e.latlng).addTo(map);
				})
			}, 400);
		}
	}

	onMount(async () => {
		await get();
	});
</script>

<main>
	<Header>Bengkel</Header>
	<form on:submit={update}>
		<Card title="Edit Bengkel">
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
			<input type="file" title="Pilih Foto" accept="image/*" class="form-control" on:change="{(e) => {
				read(e.target.files[0], (result) => {fotoSrc = result; foto = result});
			}}">

			<div class="mb-3 p-2 rounded shadow" align="center">
				<img src={fotoSrc} alt="" style="width: 150px; height: 150px; object-fit: cover;">
			</div>

			<div slot="footer">
				<a href="/admin/bengkel.html" use:link class="btn btn-default">Kembali</a>
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