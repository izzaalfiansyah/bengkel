<script>
	import { onMount } from 'svelte';
	import { http, modal } from '../../app';

	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';
	import DataTable from '../DataTable.svelte';

	const date = new Date();

	// data
	let data = [];
	let data_pelanggan = [];
	let limit = 5;
	let search = '';
	let record = 0;
	let recordTotal = 0;
	let page = 1;
	let pageTotal = 0;
	let id;
	let request = {
		merek: '',
		brand: '',
		tahun: date.getFullYear(),
		warna: '',
		nomor_plat: '',
		nomor_rangka: '',
		nomor_mesin: '',
		id_pelanggan: '',
		deskripsi: '',
		service: ''
	}

	// function
	let nullable = () => {
		id = '';
		request = {
			merek: '',
			brand: '',
			tahun: date.getFullYear(),
			warna: '',
			nomor_plat: '',
			nomor_rangka: '',
			nomor_mesin: '',
			id_pelanggan: '',
			deskripsi: '',
			service: ''
		}
	}

	let get = () => {
		nullable();
		http.get('api/pelanggan/kendaraan?limit=' + limit + '&search=' + search + '&page=' + page).then(res => {
			data = res.data;
			record = res.data.length;
			recordTotal = res.recordTotal;
			pageTotal = res.pageTotal;
		});
	}

	let getPelanggan = () => {
		http.get('api/pelanggan').then(res => { data_pelanggan = res.data });
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/pelanggan/kendaraan', request).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	let update = (e) => {
		e.preventDefault();
		http.put('api/pelanggan/kendaraan/' + id, request).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	let destroy = (e) => {
		e.preventDefault();
		http.delete('api/pelanggan/kendaraan/' + id).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	onMount(async () => {
		await get();
		await getPelanggan();
	})
</script>

<main>
	<Header>Kendaraan</Header>
	<Card title="Data Kendaraan">
		<div slot="action">
			<button class="btn btn-primary" type="button" on:click="{() => { modal.open('#store'); nullable() }}">
				<i class="material-icons">add</i>
				Tambah
			</button>
		</div>

		<DataTable
			head="{['No', 'Merk/Brand', 'Tahun', 'Warna', 'Pemilik', 'Jenis Service', 'Opsi']}"
			bind:limit={limit}
			bind:search={search}
			bind:record={record}
			bind:recordTotal={recordTotal}
			bind:page={page}
			bind:pageTotal={pageTotal}
			action={get}
			mode="striped"
		>
			{#if data.length}
				{#each data as item, i}
					<tr>
						<td rowspan="2">{(page * limit - limit) + parseInt(i) + 1}</td>
						<td style="min-width: 150px">
							<strong>{item.merek}/{item.brand}</strong>
							<br>
							<small>{item.nomor_plat}</small>
						</td>
						<td>{item.tahun}</td>
						<td>{item.warna}</td>
						<td>{item.pelanggan.nama}</td>
						<td>{item.service}</td>
						<td style="min-width: 100px" class="text-center">
							<button type="button" class="btn btn-sm btn-primary" on:click="{() => {
								id = item.id;
								request = {
									merek: item.merek,
									brand: item.brand,
									tahun: item.tahun,
									warna: item.warna,
									nomor_plat: item.nomor_plat,
									nomor_mesin: item.nomor_mesin,
									nomor_rangka: item.nomor_rangka,
									id_pelanggan: item.id_pelanggan,
									deskripsi: item.deskripsi,
									service: item.service
								}
								modal.open('#update');
							}}">
								<i class="material-icons">edit</i>
							</button>
							<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
								id = item.id;
								request.merek = item.merek;
								request.nomor_plat = item.nomor_plat;
								modal.open('#destroy');
							}}">
								<i class="material-icons">delete</i>
							</button>
						</td>
					</tr>
					<tr>
						<td>Deskripsi :</td>
						<td colspan="3">{item.deskripsi}</td>
						<td></td>
					</tr>
				{/each}
			{:else}
				<tr>
					<td colspan="7" align="center">data tidak tersedia</td>
				</tr>
			{/if}
		</DataTable>
	</Card>
	<form on:submit={store}>
		<Modal size="lg" id="store" title="Tambah Kendaraan">
			<div class="row">
				<div class="col-md-6">
					<label for="">Merk</label>
					<input type="text" class="form-control" placeholder="Masukkan Nama Merk" required="true" bind:value={request.merek} maxlength="50">

					<label for="">Brand</label>
					<input type="text" class="form-control" placeholder="Masukkan Nama Brand" required="true" bind:value={request.brand} maxlength="50">

					<label for="">Nomor Polisi</label>
					<input type="text" class="form-control" placeholder="Masukkan Nomor Polisi" required="true" bind:value={request.nomor_plat} maxlength="50">

					<label for="">Nomor Mesin</label>
					<small>Boleh tidak diisi (optional)</small>
					<input type="text" class="form-control" placeholder="Masukkan Nomor Mesin" bind:value={request.nomor_mesin} maxlength="50">

					<label for="">Nomor Rangka</label>
					<small>Boleh tidak diisi (optional)</small>
					<input type="text" class="form-control" placeholder="Masukkan Nomor Rangka" bind:value={request.nomor_rangka} maxlength="50">
				</div>
				<div class="col-md-6">
					<label for="">Tahun</label>
					<input type="number" min="1970" max={date.getFullYear()} class="form-control" placeholder="Masukkan Tahun" required="true" bind:value={request.tahun}>

					<label for="">Warna</label>
					<input type="text" class="form-control" placeholder="Masukkan Warna" required="true" bind:value={request.warna} maxlength="50">
					
					<label for="">Jenis Service</label>
					<input type="text" class="form-control" placeholder="Masukkan Jenis Service" required="true" bind:value={request.service} maxlength="50">

					<label for="">Pemilik</label>
					<select bind:value={request.id_pelanggan} required="true" class="form-control">
						<option value="">- Pilih Pemilik -</option>
						{#each data_pelanggan as item}
							<option value={item.id}>{item.nama}</option>
						{/each}
					</select>

					<label for="">Deskripsi</label>
					<textarea bind:value={request.deskripsi} rows="3" class="form-control" placeholder="Masukkan Deskripsi"/>
				</div>
			</div>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={update}>
		<Modal size="lg" id="update" title="Edit Kendaraan">
			<div class="row">
				<div class="col-md-6">
					<label for="">Merk</label>
					<input type="text" class="form-control" placeholder="Masukkan Nama Merk" required="true" bind:value={request.merek} maxlength="50">

					<label for="">Brand</label>
					<input type="text" class="form-control" placeholder="Masukkan Nama Brand" required="true" bind:value={request.brand} maxlength="50">

					<label for="">Nomor Polisi</label>
					<input type="text" class="form-control" placeholder="Masukkan Nomor Polisi" required="true" bind:value={request.nomor_plat} maxlength="50">

					<label for="">Nomor Mesin</label>
					<small>Boleh tidak diisi (optional)</small>
					<input type="text" class="form-control" placeholder="Masukkan Nomor Mesin" bind:value={request.nomor_mesin} maxlength="50">

					<label for="">Nomor Rangka</label>
					<small>Boleh tidak diisi (optional)</small>
					<input type="text" class="form-control" placeholder="Masukkan Nomor Rangka" bind:value={request.nomor_rangka} maxlength="50">
				</div>
				<div class="col-md-6">
					<label for="">Tahun</label>
					<input type="number" min="1970" max={date.getFullYear()} class="form-control" placeholder="Masukkan Tahun" required="true" bind:value={request.tahun}>

					<label for="">Warna</label>
					<input type="text" class="form-control" placeholder="Masukkan Warna" required="true" bind:value={request.warna} maxlength="50">
					
					<label for="">Jenis Service</label>
					<input type="text" class="form-control" placeholder="Masukkan Jenis Service" required="true" bind:value={request.service} maxlength="50">

					<label for="">Pemilik</label>
					<select bind:value={request.id_pelanggan} required="true" class="form-control">
						<option value="">- Pilih Pemilik -</option>
						{#each data_pelanggan as item}
							<option value={item.id}>{item.nama}</option>
						{/each}
					</select>

					<label for="">Deskripsi</label>
					<textarea bind:value={request.deskripsi} rows="3" class="form-control" placeholder="Masukkan Deskripsi"/>
				</div>
			</div>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Kendaraan">
			<p>Anda yakin menghapus kendaraan <strong>{request.merek} <small>({request.nomor_plat})</small></strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
</main>