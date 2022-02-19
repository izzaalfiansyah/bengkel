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
	let request = {};

	// function
	let nullable = () => {
		request = {}
	}

	let get = () => {
		nullable();
		http.get('api/teknisi?limit=' + limit + '&search=' + search + '&page=' + page).then(res => {
			data = res.data;
			record = res.data.length;
			recordTotal = res.recordTotal;
			pageTotal = res.pageTotal;
		});
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/teknisi', request).then(res => {
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
		http.put('api/teknisi/' + id, request).then(res => {
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
		http.delete('api/teknisi/' + id).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	let sendWhatsapp = (e) => {
		e.preventDefault();
		http.post('api/whatsapp/send', {
			message: whatsapp_message,
			to: whatsapp
		}).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success', true);
				modal.close();
			}
		})
	}

	onMount(async () => {
		await get();
	})
</script>

<main>
	<Header>Teknisi</Header>
	<Card title="Data Teknisi">
		<div slot="action">
			<button class="btn btn-primary" type="button" on:click="{() => { modal.open('#store'); nullable() }}">
				<i class="material-icons">add</i>
				Tambah
			</button>
		</div>

		<DataTable
			head="{['No', 'Nama', 'Alamat', 'Kontak', 'Email', 'Opsi']}"
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
						<td>{item.alamat}</td>
						<td>{item.telepon}</td>
						<td>{item.email}</td>
						<td style="min-width: 100px" class="text-center">
							<button type="button" class="btn btn-sm btn-primary" on:click="{() => {
								request = item;
								modal.open('#update');
							}}">
								<i class="material-icons">edit</i>
							</button>
							<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
								request = item;
								modal.open('#destroy');
							}}">
								<i class="material-icons">delete</i>
							</button>
						</td>
					</tr>
				{/each}
			{:else}
				<tr>
					<td colspan="6" align="center">data tidak tersedia</td>
				</tr>
			{/if}
		</DataTable>
	</Card>
	<form on:submit={store}>
		<Modal id="store" title="Tambah Teknisi">
			<label for="">Nama</label>
			<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={request.nama} maxlength="50">

			<label for="">Nomor Telepon</label>
			<input type="text" class="form-control" placeholder="Masukkan Nomor Telepon" required="true" bind:value={request.telepon} maxlength="30">
			
			<label for="">Email</label>
			<input type="email" class="form-control" placeholder="Masukkan Email" bind:value={request.email}>

			<label for="">Alamat</label>
			<textarea bind:value={request.alamat} rows="3" class="form-control" placeholder="Masukkan Alamat"/>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={update}>
		<Modal id="update" title="Edit Teknisi">
			<label for="">Nama</label>
			<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={request.nama} maxlength="50">

			<label for="">Nomor Telepon</label>
			<input type="text" class="form-control" placeholder="Masukkan Nomor Telepon" required="true" bind:value={request.telepon} maxlength="30">
			
			<label for="">Email</label>
			<input type="email" class="form-control" placeholder="Masukkan Email" bind:value={request.email}>

			<label for="">Alamat</label>
			<textarea bind:value={request.alamat} rows="3" class="form-control" placeholder="Masukkan Alamat"/>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Teknisi">
			<p>Anda yakin menghapus teknisi <strong>{request.nama}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
</main>