<script>
	import { onMount } from 'svelte';
	import { http, modal, url } from '../../app';

	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';
	import DataTable from '../DataTable.svelte';

	// data
	let data = []
	let limit = 5;
	let search = '';
	let record = 0;
	let recordTotal = 0;
	let page = 1;
	let pageTotal = 0;
	let id;
	let nama;
	let whatsapp;
	let tanggal_lahir;
	let alamat;
	let whatsapp_message;

	// function
	let nullable = () => {
		id = '';
		nama = '';
		whatsapp = '';
		tanggal_lahir = '';
		alamat = '';
	}

	let request = () => {
		return {
			nama: nama,
			whatsapp: whatsapp,
			tanggal_lahir: tanggal_lahir,
			alamat: alamat
		}
	}

	let get = () => {
		nullable();
		http.get('api/pelanggan?limit=' + limit + '&search=' + search + '&page=' + page).then(res => {
			data = res.data;
			record = res.data.length;
			recordTotal = res.recordTotal;
			pageTotal = res.pageTotal;
		});
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/pelanggan', request()).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	let update = (e) => {
		e.preventDefault();
		http.put('api/pelanggan/' + id, request()).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	let destroy = (e) => {
		e.preventDefault();
		http.delete('api/pelanggan/' + id).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	let sendWhatsapp = (e) => {
		e.preventDefault();
		http.post('api/whatsapp/send', {
			message: whatsapp_message,
			to: whatsapp
		}).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success', true);
				modal.close();
			}
		})
	}

	onMount(async () => {
		await get();
	})
</script>

<main>
	<Header>Pelanggan</Header>
	<Card title="Data Pelanggan">
		<div slot="action">
			<a class="btn btn-danger" href="{ url('print/pelanggan') }" target="_blank">
				<i class="material-icons">download</i>
				Export Pdf
			</a>
			<button class="btn btn-primary" type="button" on:click="{() => { modal.open('#store'); nullable() }}">
				<i class="material-icons">add</i>
				Tambah
			</button>
		</div>

		<DataTable
			head="{['No', 'Nama', 'Kontak', 'Tanggal Lahir', 'Alamat', 'Opsi']}"
			bind:limit={limit}
			bind:search={search}
			bind:record={record}
			bind:recordTotal={recordTotal}
			bind:page={page}
			bind:pageTotal={pageTotal}
			action={get}
		>
			{#if data.length}
				{#each data as item, i}
					<tr>
						<td>{(page * limit - limit) + parseInt(i) + 1}</td>
						<td>{item.nama}</td>
						<td>{item.whatsapp}</td>
						<td style="min-width: 140px">{item.tanggal_lahir}</td>
						<td>{item.alamat}</td>
						<td style="min-width: 100px" class="text-center">
							<button type="button" class="btn btn-sm btn-success" on:click="{() => {
								id = item.id;
								nama = item.nama;
								whatsapp = item.whatsapp;
								whatsapp_message = '';
								modal.open('#whatsapp');
							}}">
								<i class="material-icons">chat</i>
							</button>
							<button type="button" class="btn btn-sm btn-primary" on:click="{() => {
								id = item.id;
								nama = item.nama;
								whatsapp = item.whatsapp;
								alamat = item.alamat;
								tanggal_lahir = item.tanggal_lahir;
								modal.open('#update');
							}}">
								<i class="material-icons">edit</i>
							</button>
							<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
								id = item.id;
								nama = item.nama;
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
	<form on:submit={store}>
		<Modal id="store" title="Tambah Pelanggan">
			<label for="">Nama</label>
			<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={nama} maxlength="50">

			<label for="">Tanggal Lahir</label>
			<input type="date" class="form-control" placeholder="Masukkan Tanggal Lahir" required="true" bind:value={tanggal_lahir}>

			<label for="">Nomor Whatsapp</label>
			<input type="text" class="form-control" placeholder="Masukkan Nomor Whatsapp" required="true" bind:value={whatsapp} maxlength="50">

			<label for="">Alamat</label>
			<textarea bind:value={alamat} rows="3" class="form-control" placeholder="Masukkan Alamat"/>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={update}>
		<Modal id="update" title="Edit Pelanggan">
			<label for="">Nama</label>
			<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={nama} maxlength="50">

			<label for="">Tanggal Lahir</label>
			<input type="date" class="form-control" placeholder="Masukkan Tanggal Lahir" required="true" bind:value={tanggal_lahir}>

			<label for="">Nomor Whatsapp</label>
			<input type="text" class="form-control" placeholder="Masukkan Nomor Whatsapp" required="true" bind:value={whatsapp} maxlength="50">

			<label for="">Alamat</label>
			<textarea bind:value={alamat} rows="3" class="form-control" placeholder="Masukkan Alamat"/>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Pelanggan">
			<p>Anda yakin menghapus pelanggan <strong>{nama}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
	<form on:submit={sendWhatsapp}>
		<Modal id="whatsapp" title="Kirim Whatsapp">
			<label for="">Pelanggan</label>
			<input type="text" class="form-control" disabled="true" bind:value={nama}>

			<label for="">Pesan</label>
			<textarea rows="3" class="form-control" bind:value={whatsapp_message} required="true" placeholder="Masukkan Teks"></textarea>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-success">Kirim</button>
			</div>
		</Modal>
	</form>
</main>