<script>
	import { onMount } from 'svelte';
	import { http, modal, userID } from '../../app';

	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';
	import DataTable from '../DataTable.svelte';

	// data
	let data = []
	let limit = 5;
	let search = '';
	let record = 0;
	let recordTotal = 0;
	let page = 1;
	let pageTotal = 0;
	let id;
	let deskripsi;
	let jumlah;
	let tipe;

	// function
	let nullable = () => {
		deskripsi = '';
		jumlah = '';
		tipe = '';
	}

	let request = () => {
		return {
			deskripsi: deskripsi,
			jumlah: jumlah,
			tipe: tipe,
			id_user: userID()
		}
	}

	let get = () => {
		nullable();
		http.get('api/kas?limit=' + limit + '&search=' + search + '&page=' + page).then(res => {
			data = res.data;
			record = res.data.length;
			recordTotal = res.recordTotal;
			pageTotal = res.pageTotal;
		});
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/kas', request()).then(res => {
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
		http.put('api/kas/' + id, request()).then(res => {
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
		http.delete('api/kas/' + id).then(res => {
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
	})
</script>

<main>
	<Header>Kas</Header>
	<Card title="Data Kas">
		<div slot="action">
			<button class="btn btn-primary" type="button" on:click="{() => { modal.open('#store'); nullable() }}">
				<i class="material-icons">add</i>
				Tambah
			</button>
		</div>

		<DataTable
			head="{['No', 'Deskripsi', 'Jumlah', 'Tanggal', 'Status', 'Penulis', 'Opsi']}"
			bind:limit={limit}
			bind:search={search}
			bind:record={record}
			bind:recordTotal={recordTotal}
			bind:page={page}
			bind:pageTotal={pageTotal}
			action={get}
		>
			{#if data.length}
				{#each data as item, i}
					<tr>
						<td>{(page * limit - limit) + parseInt(i) + 1}</td>
						<td style="min-width: 300px">{item.deskripsi}</td>
						<td style="min-width: 150px">IDR {parseInt(item.jumlah).toLocaleString('id-ID')}</td>
						<td style="min-width: 100px">{item.created_at.slice(0, 10)}</td>
						<td>
							{#if item.tipe == '1'}
								<small class="text-white bg-success rounded py-1 px-2">Masuk</small>
							{:else}
								<small class="text-white bg-danger rounded py-1 px-2">Keluar</small>
							{/if}
						</td>
						<td>{item.user.nama}</td>
						<td style="min-width: 100px" class="text-center">
							<button type="button" class="btn btn-sm btn-primary" on:click="{() => {
								id = item.id;
								deskripsi = item.deskripsi;
								jumlah = item.jumlah;
								tipe = item.tipe;
								modal.open('#update');
							}}">
								<i class="material-icons">edit</i>
							</button>
							<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
								id = item.id;
								deskripsi = item.deskripsi;
								modal.open('#destroy');
							}}">
								<i class="material-icons">delete</i>
							</button>
						</td>
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
		<Modal id="store" title="Tambah Kas">
			<label for="">Deskripsi</label>
			<textarea rows="3" class="form-control" placeholder="Masukkan Deskripsi" required="true" bind:value={deskripsi} />

			<label for="">Jumlah</label>
			<input type="number" class="form-control" placeholder="Masukkan Jumlah" required="true" bind:value={jumlah} min="0">

			<label for="">Status</label>
			<select bind:value={tipe} class="form-control" required="true">
				<option value="">- Pilih Status -</option>
				<option value="1">Pemasukan</option>
				<option value="0">Pengeluaran</option>
			</select>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={update}>
		<Modal id="update" title="Edit Kas">
			<label for="">Deskripsi</label>
			<textarea rows="3" class="form-control" placeholder="Masukkan Deskripsi" required="true" bind:value={deskripsi} />

			<label for="">Jumlah</label>
			<input type="number" class="form-control" placeholder="Masukkan Jumlah" required="true" bind:value={jumlah} min="0">

			<label for="">Status</label>
			<select bind:value={tipe} class="form-control" required="true">
				<option value="">- Pilih Status -</option>
				<option value="1">Pemasukan</option>
				<option value="0">Pengeluaran</option>
			</select>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Kas">
			<p>Anda yakin menghapus kas <strong>{deskripsi}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
</main>