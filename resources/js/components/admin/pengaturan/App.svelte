<script>
	import { http } from '$app';
	import { onMount } from 'svelte';
	import Card from '$component/Card.svelte';

	// data
	let request = {
		number: '',
		key: '',
		pesan: {
			ultah: '',
			service: ''
		},
		ppn: '',
		pph: ''
	};

	// function
	let get = () => {
		http.get('api/setting').then(res => {
			request = {
				number: res.data.number,
				key: res.data.key,
				pesan: {
					ultah: res.data.pesan.ultah,
					service: res.data.pesan.service
				},
				ppn: res.data.ppn,
				pph: res.data.pph
			};			
		})
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/setting', request).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success');
				get();
			}
		})
	}

	let numberOnly = (data) => {
		const value = data.toString().replace(/[^,\d]/gi, '');
		return value;
	}

	onMount(async () => {
		await get();
	})
</script>

<main>
	<form on:submit={store}>
		<Card>
			<div class="card-title">Transaksi</div>
			<hr>

			<label for="">PPN</label>
			<small>(dalam bentuk persentase)</small>
			<input type="number" class="form-control" required="true" bind:value={request.ppn} max="100" min="0" placeholder="Masukkan PPN">
			
			<!-- <label for="">PPH</label>
			<small>(dalam bentuk persentasi)</small>
			<input type="number" class="form-control" required="true" bind:value={request.pph} max="100" min="0" placeholder="Masukkan PPH"> -->

			<br>

			<div class="card-title">Whatsapp</div>
			<hr>

			<label for="">Nomor Whatsapp</label>
			<input type="text" class="form-control" bind:value={request.number} on:input="{(e) => (request.number = numberOnly(e.target.value))}" required="true" maxlength="50" placeholder="Masukkan Nomor Whatsapp">

			<label for="">Api Key</label>
			<input type="text" class="form-control" bind:value={request.key} required="true" placeholder="Masukkan Api Key">

			<!-- <label for="">Pesan Ulang Tahun</label>
			<textarea rows="3" class="form-control" required="true" bind:value={request.pesan.ultah} placeholder="Masukkan Pesan"></textarea> -->

			<label for="">Pesan Service Selesai</label>
			<textarea rows="3" class="form-control" required="true" bind:value={request.pesan.service} placeholder="Masukkan Pesan"></textarea>

			<i>{'{nama}'} untuk hasil nama pelanggan. {'{kode}'} untuk hasil kode service</i>

			<div slot="footer">
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Card>
	</form>
</main>