<script>
	import { onMount } from 'svelte';
	import { http } from '$app';

	import Header from '$component/admin/Header.svelte';
	import Card from '$component/Card.svelte';
	import DataTable from '$component/DataTable.svelte';
	import Produk from './Produk.svelte';
	import Jasa from './Jasa.svelte';
</script>

<main>
	<Header>Laporan Penjualan & Service</Header>
	<Produk/>
	<Jasa/>
</main>