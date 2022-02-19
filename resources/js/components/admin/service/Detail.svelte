<script>
	import { onMount } from 'svelte';
	import { navigate } from 'svelte-navigator';
	import { http, userID, modal, blank, url } from '$app';
	import TransaksiDetail from '$component/admin/transaksi/Detail.svelte';
	import Header from '$component/admin/Header.svelte';
	import Card from '$component/Card.svelte';
	import Table from '$component/Table.svelte';
	import Modal from '$component/Modal.svelte';

	export let id;

	// data
	let kendaraan_pelanggan = [];
	let data_pelanggan = [];
	let data_teknisi = [];
	let filter = {
		id_pelanggan: ''
	}
	let request = {
		keluhan: '',
		perintah_kerja: '',
		total_harga: 0,
		total_bayar: 0,
		status: '0',
		id_user: userID(),
		id_transaksi: '',
		id_kendaraan_pelanggan: '',
		id_teknisi: '',
		status_pengerjaan: ''
	}
	let status = '';

	// function
	let get = () => {
		http.get('api/service/' + id).then(res => {
			request = res.data;
			if (request.status == '0') {
				status = 'Estimasi'
			} else if (request.status == '1') {
				status = 'Invoice'
			} else {
				status = 'Work-Order'
			}
			filter.id_pelanggan = res.data.pelanggan.id;
		})
	}

	let getKendaraan = () => {
		http.get(`api/pelanggan/kendaraan?id_pelanggan=${filter.id_pelanggan}`).then(res => { kendaraan_pelanggan = res.data });
	}

	let getPelanggan = () => {
		getKendaraan();
		http.get('api/pelanggan').then(res => { data_pelanggan = res.data });
	}

	let getTeknisi = () => {
		http.get('api/teknisi').then(res => { data_teknisi = res.data });
	}

	let update = (e) => {
		e.preventDefault();
		http.put('api/service/' + id, request).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success');
			}
		})
	}

	let destroyService = (e) => {
		e.preventDefault();
		http.delete('api/service/' + id).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				navigate('/admin/service.html');
			}
		})
	}

	onMount(async () => {
		await getTeknisi();
		await getPelanggan();
		await get();
	})
</script>

<main>
	<Header>Service</Header>
	<Card title="Detail Service">
		<Table head="{['Kode', 'Status', 'Opsi']}">
			<tr>
				<td>{request.kode}</td>
				<td>{status}</td>
				<td>
					{#if !request.transaksi}
						<button class="btn btn-success btn-sm" on:click="{() => navigate('/admin/service/' + id + '/transaksi.html')}">Buat Transaksi</button>
					{/if}
					<button class="btn btn-sm btn-primary" type="button" on:click="{() => blank(url('print/service/' + id))}">Print</button>
					<button class="btn btn-danger btn-sm" type="button" on:click="{() => modal.open('#destroyService')}">
						<i class="material-icons">delete</i>
					</button>
				</td>
			</tr>
		</Table>
	</Card>
	<form on:submit={update}>
		<Card>
			<div class="row">
				<div class="col-md-6">
					<label for="">Pelanggan</label>
					<select bind:value={filter.id_pelanggan} disabled="true" class="form-control" on:change={getKendaraan} on:blur={() => {}}>
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

			{#if request.status != '0'}
				<label for="">Perintah Kerja</label>
				<small>Boleh tidak diisi (optional)</small>
				<textarea bind:value={request.perintah_kerja} rows="5" class="form-control" placeholder="Masukkan Perintah Kerja"></textarea>
			{/if}

			{#if request.status == '2'}
				<label for="">Teknisi</label>
				<select required={true} class="form-control" bind:value={request.id_teknisi}>
					<option value="">- Pilih Teknisi -</option>
					{#each data_teknisi as item}
						<option value={item.id}>{item.nama}</option>
					{/each}
				</select>
				
				<label for="">Status Pengerjaan</label>
				<select required={true} class="form-control" bind:value={request.status_pengerjaan}>
					<option value="">- Pilih Status -</option>
					<option value="0">Belum</option>
					<option value="1">Proses</option>
					<option value="2">Selesai</option>
				</select>
			{/if}

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click="{() => navigate('/admin/' + status.toLowerCase() + '.html')}">Kembali</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</Card>
	</form>

	<form on:submit={destroyService}>
		<Modal id="destroyService" title="Hapus Service">
			<p>anda yakin menghapus service?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click="{modal.close}">Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
	{#if request.id_transaksi}
		<Header>Transaksi</Header>
		<TransaksiDetail id={request.id_transaksi} id_service={id} />
	{/if}
</main>