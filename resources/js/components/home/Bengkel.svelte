<script>
	import { onMount } from 'svelte';
	import { http, asset, url, modal } from '../../app';
	import Section from './Section.svelte';
	import Card from '../Card.svelte';
	import Table from '../Table.svelte';
	import Modal from '../Modal.svelte';

	// data
	let data = [];
	let map;
	let nama;
	let marker;

	// function
	let get = () => {
		http.get('api/bengkel').then(res => {
			data = res.data;
		});
	}

	let generateMap = () => {
		if (map) { map.remove() }
		setTimeout(() => {
			map = L.map('map').setView(marker ? marker : [-8.17, 113.69], 11);
			L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
			L.marker(marker).bindPopup(nama).openPopup().addTo(map);
		}, 400);
	}

	onMount(() => get());
</script>

<main>
	<Section title="Bengkel">
		{#each data as item}
			<div class="shadow-sm mb-4 p-2 bg-white">
				<div class="row">
					<div class="col-md-4 p-1" align="center">
						<img src="{ asset('asset/bengkel/' + item.foto) }" alt="" style="width: 100%; height: 225px; object-fit: cover;" class="rounded">
					</div>
					<div class="col-md-8">
						<div class="text-center">
							<strong style="font-size: 22px;">{item.nama}</strong>
						</div>
						<hr>
						<div>
							<Table mode="borderless">
								<tr>
									<td style="width: 40%">Alamat</td>
									<td>:</td>
									<td>{item.alamat}</td>
								</tr>
								<tr>
									<td style="width: 40%">Waktu Operasi</td>
									<td>:</td>
									<td>{item.jam_buka} - {item.jam_tutup}</td>
								</tr>
							</Table>
						</div>
						<hr>
						<div>
							<a class="btn btn-success" href="https://api.whatsapp.com/send?phone={item.whatsapp[0] == '0' ? '62' + item.whatsapp.slice(1) : item.whatsapp}&text={encodeURIComponent('Halo ' + item.nama + '! Saya mengetahui usaha bengkel anda dari situs ' + url())}" target="_blank">
								<i class="material-icons">chat</i> Whatsapp
							</a>
							{#if item.lokasi}
								<button class="btn btn-danger" on:click="{() => {
									nama = item.nama;
									marker = [
										item.lat,
										item.lng
									];
									modal.open('#show-map');
									generateMap();
								}}">
									<i class="material-icons">map</i> Lokasi
								</button>
							{/if}
						</div>
					</div>
				</div>
			</div>
		{/each}
	</Section>

	<Modal size="lg" id="show-map" title="Lokasi">
		<div id="map" style="height: 400px"></div>

		<div slot="footer">
			<button class="btn btn-default" on:click={modal.close} type="button">Tutup</button>
		</div>
	</Modal>
</main>