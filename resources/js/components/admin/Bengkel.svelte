<script>
	import { link } from 'svelte-navigator';
	import { onMount } from 'svelte';
	import { url, http, modal, user as getUser } from '$app';

	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';
	import DataTable from '../DataTable.svelte';

	// data
	let user = {};

	let data = []
	let limit = 5;
	let search = '';
	let record = 0;
	let recordTotal = 0;
	let page = 1;
	let pageTotal = 0;
	let id;
	let nama;

	// function
	let get = () => {
		http.get('api/bengkel?limit=' + limit + '&search=' + search + '&page=' + page).then(res => {
			data = res.data;
			record = res.data.length;
			recordTotal = res.recordTotal;
			pageTotal = res.pageTotal;
		});
	}

	let destroy = (e) => {
		e.preventDefault();
		http.delete('api/bengkel/' + id).then(res => {
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
		await getUser().then(res => { user = res.data });
	})
</script>

<main>
	<Header>Bengkel</Header>
	<Card title="Data Bengkel">
		<div slot="action">
			{#if user.level == '1'}
				<a class="btn btn-primary" href="/admin/bengkel/create.html" use:link>
					<i class="material-icons">add</i>
					Tambah
				</a>
			{/if}
		</div>

		<DataTable
			head="{['No', 'Nama', 'Jam Buka', 'Jam Tutup', 'Whatsapp', 'Opsi']}"
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
						<td>{item.jam_buka}</td>
						<td>{item.jam_tutup}</td>
						<td>{item.whatsapp}</td>
						<td style="min-width: 100px;" class="text-center">
							{#if user.level == '1'}
								<a href="/admin/bengkel/{item.id}/edit.html" use:link class="btn btn-sm btn-primary">
									<i class="material-icons">search</i>
								</a>
								<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
									id = item.id;
									nama = item.nama;
									modal.open('#destroy');
								}}">
									<i class="material-icons">delete</i>
								</button>
							{:else if user.level == '2' && item.id == user.id_bengkel}
								<a href="/admin/bengkel/{item.id}/edit.html" use:link class="btn btn-sm btn-primary">
									<i class="material-icons">search</i>
								</a>
								<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
									id = item.id;
									nama = item.nama;
									modal.open('#destroy');
								}}">
									<i class="material-icons">delete</i>
								</button>
							{:else}
								-
							{/if}
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
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Bengkel">
			<p>Anda yakin menghapus bengkel <strong>{nama}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
</main>