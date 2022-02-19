<script>
	import { onMount } from 'svelte';
	import { http } from '$app';

	import Header from '$component/admin/Header.svelte';
	import Card from '$component/Card.svelte';
	import DataTable from '$component/DataTable.svelte';

	const date = new Date();

	// data
	let data = [];
	let filter = {
		limit: 0,
		page: 0,
		search: '',
		tahun: date.getFullYear()
	}
	let datatable = {
		record: 0,
		recordTotal: 0,
		pageTotal: 0
	}

	let get = () => {
		http.get('api/transaksi/jasa?tahun=' + filter.tahun + '&limit=' + filter.limit + '&page=' + filter.page + '&search=' + filter.search).then(res => {
			data = res.data;
			datatable = {
				record: res.data.length,
				recordTotal: res.recordTotal,
				pageTotal: res.pageTotal
			}
		});
	}

	onMount(async() => {
		await get();
	})
</script>

<main>
	<Card title="Laporan Pemakaian Jasa">
		<div slot="action">
			<a href="/excel/jasa" class="btn btn-success" target="_blank">Export</a>
		</div>
		<DataTable 
			head="{['No', 'Jasa', 'Terpakai', 'Profit']}"
			bind:limit={filter.limit}
			bind:search={filter.search}
			bind:page={filter.page}
			bind:record={datatable.record}
			bind:recordTotal={datatable.recordTotal}
			bind:pageTotal={datatable.pageTotal}
			action={get}
		>
			{#if data.length}
				{#each data as item, i}
					<tr>
						<td>{i + 1}</td>
						<td>{item.nama}</td>
						<td>{item.terpakai}</td>
						<td style="min-width: 150px" class="text-success">IDR {item.penghasilan.toLocaleString('id-ID')}</td>
					</tr>
				{/each}
			{:else}
				<tr>
					<td colspan="6" align="center">data tidak tersedia</td>
				</tr>
			{/if}
		</DataTable>
	</Card>
</main>