<script>
	import Table from './Table.svelte';
	import Pagination from './Pagination.svelte';

	export let limit = 10;
	export let search = '';
	export let page = 1;
	export let pageTotal = 0;
	export let record = 0;
	export let recordTotal = 0;
	export let head = [];
	export let action;
</script>

<div>
	<div class="row">
		<div class="mb-1 col-md-2">
			<select class="form-control" bind:value={limit} on:blur="{() => {}}" on:change="{() => {
				page = 1;
				action();
			}}">
				<option value="5">5</option>
				<option value="10">10</option>
				<option value="20">20</option>
				<option value="50">50</option>
				<option value="100">100</option>
			</select>
		</div>
		<div class="mb-1 col-md-6"></div>
		<div class="mb-1 col-md-4">
			<input type="text" class="form-control" placeholder="Cari" bind:value={search} on:input="{() => {
				page = 1;
				action();
			}}">
		</div>
	</div>
	<Table head={head} {...$$props}>
		<slot/>
	</Table>
	<div class="row">
		<div class="col-md-6">
			Menampilkan {record} dari {recordTotal} data
		</div>
		<div class="col-md-6" align="right">
			<Pagination bind:now={page} bind:total={pageTotal} action={action} />
		</div>
	</div>
</div>