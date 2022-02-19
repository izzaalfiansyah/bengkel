<script>
	import { onMount } from 'svelte';
	import { navigate } from 'svelte-navigator';
	import { http, userID } from '$app';
	import Header from '$component/admin/Header.svelte';
	import Card from '$component/Card.svelte';

	// data
	let kendaraan_pelanggan = [];
	let data_pelanggan = [];
	let filter = {
		id_pelanggan: ''
	}
	let auto_pelanggan;
	let request = {
		keluhan: '',
		perintah_kerja: '',
		total_harga: 0,
		total_bayar: 0,
		status: '0',
		id_user: userID(),
		id_transaksi: '',
		id_kendaraan_pelanggan: ''
	}

	// function
	let getKendaraan = () => {
		http.get(`api/pelanggan/kendaraan?id_pelanggan=${filter.id_pelanggan}`).then(res => { kendaraan_pelanggan = res.data });
	}

	let getPelanggan = () => {
		http.get('api/pelanggan').then(res => { data_pelanggan = res.data });
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/service', request).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success');
				navigate('/admin/estimasi.html');
			}
		})
	}

	onMount(async () => {
		await getKendaraan();
		await getPelanggan();
	})
</script>

<main>
	<Header>Tambah Service</Header>
	<form on:submit={store}>
		<Card>
			<div class="row">
				<div class="col-md-6">
					<label for="">Pelanggan</label>
					<small>Filter untuk data kendaraan</small>
					<select bind:value={filter.id_pelanggan} class="form-control" required="true" on:change={getKendaraan} on:blur={() => {}}>
						<option value="">- Pilih Pelanggan -</option>
						{#each data_pelanggan as item}
							<option value={item.id}>{item.nama}</option>
						{/each}
					</select>
				</div>
				<div class="col-md-6">
					<label for="">Kendaraan</label>
					<select bind:value={request.id_kendaraan_pelanggan} class="form-control" required="true">
						<option value="">- Pilih Kendaraan -</option>
						{#each kendaraan_pelanggan as item}
							<option value={item.id}>{item.merek}/{item.brand} {item.warna} {item.tahun} ({item.nomor_plat})</option>
						{/each}
					</select>
				</div>
			</div>

			<label for="">Keluhan</label>
			<textarea bind:value={request.keluhan} rows="5" class="form-control" placeholder="Masukkan Keluhan" required="true"></textarea>

			<!-- <label for="">Perintah Kerja</label>
			<small>Boleh tidak diisi (optional)</small>
			<textarea bind:value={request.perintah_kerja} rows="5" class="form-control" placeholder="Masukkan Perintah Kerja"></textarea> -->

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click="{() => navigate('/admin/estimasi.html')}">Batal</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</Card>
	</form>
</main>