<script>
	import { onMount } from 'svelte';
	import { http } from '$app';

	import Header from '$component/admin/Header.svelte';
	import Card from '$component/Card.svelte';
	import Table from '$component/Table.svelte';

	const date = new Date();

	// data
	let data = [];
	let filter = {
		tahun: date.getFullYear()
	}

	let get = () => {
		http.get('api/kas/report?tahun=' + filter.tahun).then(res => {
			data = res.data;
		});
	}

	onMount(async() => {
		await get();
	})
</script>

<main>
	<Header>Laporan Kas</Header>
	<Card title="Laporan Arus Kas">
		<div slot="action">
			<a href="/excel/kas" class="btn btn-success" target="_blank">Export</a>
		</div>
		<div class="row align-items-center">
			<div class="col-md-2">
				Filter Tahun :
			</div>
			<div class="col-md-4">
				<input type="number" class="form-control" bind:value={filter.tahun} min="1945" on:input={get} placeholder="Masukkan Tahun">
			</div>
		</div>
		<Table head="{['No', 'Bulan', 'Tahun', 'Pendapatan', 'Pengeluaran', 'Profit']}">
			{#if data.length}
				{#each data as item, i}
					<tr>
						<td>{i + 1}</td>
						<td>{item.bulan}</td>
						<td>{item.tahun}</td>
						<td style="min-width: 150px" class="text-success">IDR {item.pendapatan.toLocaleString('id-ID')}</td>
						<td style="min-width: 150px" class="text-danger">IDR {item.pengeluaran.toLocaleString('id-ID')}</td>
						<td style="min-width: 150px" class="text-primary">IDR {(item.pendapatan - item.pengeluaran).toLocaleString('id-ID')}</td>
					</tr>
				{/each}
			{:else}
				<tr>
					<td colspan="6" align="center">data tidak tersedia</td>
				</tr>
			{/if}
		</Table>
	</Card>
</main>