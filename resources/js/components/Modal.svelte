<script>
	import { modal } from '../app';
</script>

<div class="modal fade" id={$$props.id} style="z-index: 10000;">
	<div class="modal-dialog modal-{$$props.size}">
		<div class="modal-content">
			{#if $$props.title}
				<div class="modal-header">
					<div class="modal-title">{$$props.title}</div>
					<button class="close btn-close" type="button" on:click="{modal.close}"></button>
				</div>
			{/if}

			<div class="modal-body">
				<slot/>
			</div>

			{#if $$slots.footer}
				<div class="modal-footer">
					<slot name="footer"/>
				</div>
			{/if}
		</div>
	</div>
</div>