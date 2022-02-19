<script>
	import { onMount } from 'svelte';
	import { http, modal } from '../../app';

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
	let nama;
	let kontak;
	let alamat;

	// function
	let nullable = () => {
		id = '';
		nama = '';
		kontak = '';
		alamat = '';
	}

	let request = () => {
		return {
			nama: nama,
			kontak: kontak,
			alamat: alamat
		}
	}

	let get = () => {
		nullable();
		http.get('api/supplier?limit=' + limit + '&search=' + search + '&page=' + page).then(res => {
			data = res.data;
			record = res.data.length;
			recordTotal = res.recordTotal;
			pageTotal = res.pageTotal;
		});
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/supplier', request()).then(res => {
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
		http.put('api/supplier/' + id, request()).then(res => {
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
		http.delete('api/supplier/' + id).then(res => {
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
	<Header>Supplier</Header>
	<Card title="Data Supplier">
		<div slot="action">
			<button class="btn btn-primary" type="button" on:click="{() => { modal.open('#store'); nullable() }}">
				<i class="material-icons">add</i>
				Tambah
			</button>
		</div>

		<DataTable
			head="{['No', 'Nama', 'Kontak', 'Alamat', 'Opsi']}"
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
						<td>{item.nama}</td>
						<td>{item.kontak}</td>
						<td>{item.alamat}</td>
						<td style="min-width: 100px" class="text-center">
							<button type="button" class="btn btn-sm btn-primary" on:click="{() => {
								id = item.id;
								nama = item.nama;
								kontak = item.kontak;
								alamat = item.alamat;
								modal.open('#update');
							}}">
								<i class="material-icons">edit</i>
							</button>
							<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
								id = item.id;
								nama = item.nama;
								modal.open('#destroy');
							}}">
								<i class="material-icons">delete</i>
							</button>
						</td>
					</tr>
				{/each}
			{:else}
				<tr>
					<td colspan="5" align="center">data tidak tersedia</td>
				</tr>
			{/if}
		</DataTable>
	</Card>
	<form on:submit={store}>
		<Modal id="store" title="Tambah Supplier">
			<label for="">Nama</label>
			<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={nama} maxlength="50">

			<label for="">Kontak</label>
			<input type="text" class="form-control" placeholder="Masukkan Kontak" required="true" bind:value={kontak} maxlength="50">

			<label for="">Alamat</label>
			<textarea bind:value={alamat} rows="3" class="form-control" placeholder="Masukkan Alamat"/>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={update}>
		<Modal id="update" title="Edit Supplier">
			<label for="">Nama</label>
			<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={nama} maxlength="50">

			<label for="">Kontak</label>
			<input type="text" class="form-control" placeholder="Masukkan Kontak" required="true" bind:value={kontak} maxlength="50">

			<label for="">Alamat</label>
			<textarea bind:value={alamat} rows="3" class="form-control" placeholder="Masukkan Alamat"/>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Supplier">
			<p>Anda yakin menghapus supplier <strong>{nama}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
</main>