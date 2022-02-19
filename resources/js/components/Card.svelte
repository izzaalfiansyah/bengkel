<script>
	export let title;
	let slot;
</script>

<div class="card {$$props.shadow ? 'shadow-sm' : ''}">
	{#if title}
		<div class="card-header">
			<div class="row">
				<div class="col-6">
					<div class="card-title">{title}</div>
				</div>
				<div class="col-6" align="right">
					<slot name="action" />
				</div>
			</div>
		</div>
	{/if}
	<div class="card-body">
		<slot/>
	</div>
	{#if $$slots.footer}
		<div class="card-footer">
			<slot name="footer" />
		</div>
	{/if}
</div>