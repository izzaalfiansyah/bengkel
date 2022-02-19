<script>
	export let head;
</script>

<div class="table-responsive">
	<table class="table table-{$$props.mode ? $$props.mode : 'hover'}" {...$$props}>
		{#if head}
			<thead>
				<tr>
					{#each head as item}
						<th key={item}>{item}</th>
					{/each}
				</tr>
			</thead>
		{/if}
		<tbody>
			<slot/>
		</tbody>
	</table>
</div>