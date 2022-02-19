<script>
	import { onMount } from 'svelte';
	import { navigate } from 'svelte-navigator';
	import { http, modal, asset, read } from '../../app';

	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';
	import DataTable from '../DataTable.svelte';

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
	let request = {
		kode: '',
		id: ''
	}

	// function
	let get = () => {
		http.get(`api/transaksi?limit=${filter.limit}&page=${filter.page}&search=${filter.search}&id_user=${filter.id_user}`).then(res => { 
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
		http.delete('api/transaksi/' + request.id).then(res => {
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
		await get();
		await getUser();
	})
</script>

<main>
	<Header>Transaksi Produk & Jasa</Header>
	<Card title="Data Transaksi">
		<div slot="action">
			<button class="btn btn-primary" type="button" on:click="{() => { navigate('/admin/transaksi/add.html') }}">
				<i class="material-icons">add</i>
				Tambah
			</button>
		</div>

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
			head="{['Kode', 'Pelanggan', 'Harga', 'Kembalian', 'Status', 'Keterangan', 'Penulis', 'Opsi']}"
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
						<td style="min-width: 150px">{item.kode}</td>
						<td>{item.pelanggan ? item.pelanggan.nama : '-'}</td>
						<td style="min-width: 200px">
							Grand Total: <span class="text-primary">IDR {parseInt(item.grand_total).toLocaleString('id-ID')}</span><br>
							Pembayaran: <span class="text-success">IDR {parseInt(item.total_bayar).toLocaleString('id-ID')}</span>
						</td>
						<td style="min-width: 100px">IDR {(parseInt(item.total_bayar) - parseInt(item.grand_total)).toLocaleString('id-ID')}</td>
						<td align="center">
							{#if (parseInt(item.total_bayar) - parseInt(item.grand_total)) >= 0}
								<small class="bg-success text-white rounded p-1 px-2">Lunas</small>
							{:else}
								<small class="bg-danger text-white rounded p-1 px-2">Piutang</small>
							{/if}
						</td>
						<td align="center" style="min-width: 130px;">
							{#if item.keterangan == '1'}
								<span class="text-success">Selesai</span>
							{:else}
								<span class="text-warning">Belum Selesai</span>
							{/if}
						</td>
						<td>{item.user.username}</td>
						<td style="min-width: 100px" class="text-center">
							<button type="button" class="btn btn-sm btn-primary" on:click="{() => { navigate('/admin/transaksi/' + item.id + '/detail.html') }}">
								<i class="material-icons">search</i>
							</button>
							<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
								request.id = item.id;
								request.kode = item.kode;
								modal.open('#destroy');
							}}">
								<i class="material-icons">delete</i>
							</button>
						</td>
					</tr>
				{/each}
			{:else}
				<tr>
					<td colspan="8" align="center">data tidak tersedia</td>
				</tr>
			{/if}
		</DataTable>
	</Card>
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Transaksi">
			<p>Anda yakin menghapus transaksi <strong>{request.kode}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
</main>