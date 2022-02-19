<script>
	import { onMount } from 'svelte';
	import { navigate, link } from 'svelte-navigator';
	import { http, modal } from '$app';

	import Header from './Header.svelte';
	import Card from '$component/Card.svelte';
	import Modal from '$component/Modal.svelte';
	import DataTable from '$component/DataTable.svelte';

	// data
	let data = [];
	let data_user = [];
	let datatable = {
		record: 0,
		recordTotal: 0,
		pageTotal: 0
	}
	let filter = {
		id_user: '',
		limit: 5,
		page: 1,
		search: ''
	}
	let request = {}

	// function
	let get = () => {
		request = {}
		http.get(`api/service/work-order?limit=${filter.limit}&page=${filter.page}&search=${filter.search}&id_user=${filter.id_user}`).then(res => { 
			data = res.data;
			datatable = {
				record: data.length,
				recordTotal: res.recordTotal,
				pageTotal: res.pageTotal
			}
		});
	}

	let destroy = (e) => {
		e.preventDefault();
		http.delete('api/service/' + request.id).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	let getUser = () => {
		http.get('api/user').then(res => { data_user = res.data });
	}

	onMount(async () => {
		await get()
		await getUser()
	})
</script>

<main>
	<Header>Work Order</Header>
	<Card title="Data Work Order">
		<div class="row justify-content-end">
			<div class="col-md-4">
				<select bind:value={filter.id_user} on:blur="{() => {}}" on:change={get} class="form-control">
					<option value="">- Semua User -</option>
					{#each data_user as item}
						<option value={item.id}>{item.username}</option>
					{/each}
				</select>
			</div>
		</div>

		<DataTable
			head="{['Tanggal', 'Kode', 'Kendaraan (Merk/Brand)', 'Transaksi', 'Status Pengerjaan', 'Opsi']}"
			bind:limit={filter.limit}
			bind:search={filter.search}
			bind:record={datatable.record}
			bind:recordTotal={datatable.recordTotal}
			bind:page={filter.page}
			bind:pageTotal={datatable.pageTotal}
			action={get}
		>
			{#if data.length}
				{#each data as item, i}
					<tr>
						<td style="min-width: 150px">{item.created_at.slice(0, 10)}</td>
						<td style="min-width: 150px">{item.kode}</td>
						<td>{item.kendaraan.merek}/{item.kendaraan.brand} {item.kendaraan.warna} {item.kendaraan.tahun}</td>
						<td>
							{#if item.transaksi}
								<a href="/admin/transaksi/{item.transaksi.id}/detail.html" use:link>{item.transaksi.kode}</a>
							{:else}
								<a href="/admin/service/{item.id}/transaksi.html" class="btn btn-primary btn-sm" use:link>
									<i class="material-icons">add</i>
									Buat
								</a>
							{/if}
						</td>
                        <td>
                            {#if item.status_pengerjaan == '0'}
								<span class="badge bg-danger">Belum</span>
                            {:else if item.status_pengerjaan == '1'}
                                <span class="badge bg-primary">Proses</span>
                            {:else}
                                <span class="badge bg-success">Selesai</span>
                            {/if}
                        </td>
						<td style="min-width: 200px" class="text-center">
							<button type="button" class="btn btn-sm btn-primary" on:click="{() => { navigate('/admin/service/' + item.id + '/detail.html') }}">
								<i class="material-icons">search</i>
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
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Work Order">
			<p>Anda yakin menghapus work order <strong>{request.kode}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
</main>