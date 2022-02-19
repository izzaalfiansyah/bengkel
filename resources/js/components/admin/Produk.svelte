<script>
	import { onMount } from 'svelte';
	import { http, modal, asset, read, user as getUser } from '../../app';

	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';
	import DataTable from '../DataTable.svelte';

	// data
	let user = {};
	let data = [];
	let data_bengkel = [];
	let limit = 5;
	let search = '';
	let record = 0;
	let recordTotal = 0;
	let page = 1;
	let pageTotal = 0;
	let id;
	let nama;
	let deskripsi;
	let stok;
	let harga_beli;
	let harga_jual;
	let foto = [];
	let fotoSrc;
	let id_bengkel;
	let filter_id_bengkel;

	// function
	let nullable = () => {
		id = '';
		nama = '';
		deskripsi = '';
		stok = '';
		harga_beli = '';
		harga_jual = '';
		foto = [];
		fotoSrc = '';
		id_bengkel = user.id_bengkel;
	}

	let request = () => {
		return {
			nama: nama,
			deskripsi: deskripsi,
			stok: stok,
			harga_beli: harga_beli,
			harga_jual: harga_jual,
			foto: foto,
			id_bengkel: id_bengkel,
		}
	}

	let get = () => {
		nullable();
		http.get('api/produk?limit=' + limit + '&search=' + search + '&page=' + page + '&id_bengkel=' + filter_id_bengkel).then(res => {
			data = res.data;
			record = res.data.length;
			recordTotal = res.recordTotal;
			pageTotal = res.pageTotal;
		});
	}

	let getBengkel = () => {
		http.get('api/bengkel').then(res => (data_bengkel = res.data));
	}

	let store = (e) => {
		e.preventDefault();
		http.post('api/produk', request()).then(res => {
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
		http.put('api/produk/' + id, request()).then(res => {
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
		http.delete('api/produk/' + id).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	onMount(async () => {
		await getUser().then(res => { 
			user = res.data; 
			id_bengkel = res.data.id_bengkel 
		})
		await getBengkel();
		await get();
	})
</script>

<main>
	<Header>Part</Header>
	<Card title="Data Part">
		<div slot="action">
			<button class="btn btn-primary" type="button" on:click="{() => { modal.open('#store'); nullable() }}">
				<i class="material-icons">add</i>
				Tambah
			</button>
		</div>

		<div class="row justify-content-end">
			<div class="col-md-4">
				<select bind:value={filter_id_bengkel} on:blur="{() => {}}" on:change={get} class="form-control">
					<option value="">- Semua Bengkel -</option>
					{#each data_bengkel as item}
						<option value={item.id}>{item.nama}</option>
					{/each}
				</select>
			</div>
		</div>

		<DataTable
			head="{['No', 'Nama', 'Stok', 'Harga', 'Bengkel', 'Foto', 'Opsi']}"
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
						<td>{item.stok}</td>
						<td style="min-width: 200px">
							Harga Jual: <span class="text-success">IDR {parseInt(item.harga_jual).toLocaleString('id-ID')}</span><br>
							Harga Beli: <span class="text-danger">IDR {parseInt(item.harga_beli).toLocaleString('id-ID')}</span>
						</td>
						<td>{item.bengkel.nama}</td>
						<td>
							<a href="#0" data-bs-toggle="modal" data-bs-target="#lihat-foto" on:click="{() => {
								foto = item.foto;
							}}">lihat</a>
						</td>
						<td style="min-width: 100px" class="text-center">
							{#if user.level == '1' || user.id_bengkel == item.id_bengkel}
								<button type="button" class="btn btn-sm btn-primary" on:click="{() => {
									id = item.id;
									nama = item.nama;
									deskripsi = item.deskripsi;
									stok = item.stok;
									harga_jual = item.harga_jual;
									harga_beli = item.harga_beli;
									id_bengkel = item.id_bengkel;
									foto = [];
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
							{:else}
								-
							{/if}
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
	<form on:submit={store}>
		<Modal id="store" title="Tambah Part">
			<label for="">Nama</label>
			<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={nama} maxlength="50">

			<label for="">Deskripsi</label>
			<textarea rows="3" placeholder="Masukkan Deskripsi" class="form-control" required="true" bind:value={deskripsi} />

			<label for="">Stok</label>
			<input type="number" class="form-control" placeholder="Masukkan Stok" required="true" bind:value={stok} min="0">

			<div class="row">
				<div class="col-md-6">
					<label for="">Harga Jual</label>
					<input type="number" class="form-control" placeholder="Masukkan Harga Jual" required="true" bind:value={harga_jual} min="0">
				</div>
				<div class="col-md-6">
					<label for="">Harga Beli</label>
					<input type="number" class="form-control" placeholder="Masukkan Harga Beli" required="true" bind:value={harga_beli} min="0">
				</div>
			</div>

			<label for="">Foto</label>
			<input type="file" class="form-control" multiple="true" placeholder="Masukkan Foto" required="true" accept="image/*" on:change="{(e) => {
				foto = [];
				e.target.files.forEach((obj, i) => {
					read(obj, (result) => {
						foto.push(result);
					});
				});
			}}">

			<label for="">Bengkel</label>
			{#if user.level == '1'}
				<select required="true" bind:value={id_bengkel} class="form-control">
					<option value="">- Pilih Bengkel -</option>
					{#each data_bengkel as item}
						<option value={item.id}>{item.nama}</option>
					{/each}
				</select>
			{:else}
				<select required="true" bind:value={id_bengkel} class="form-control" disabled="true">
					<option value="">- Pilih Bengkel -</option>
					{#each data_bengkel as item}
						<option value={item.id}>{item.nama}</option>
					{/each}
				</select>
			{/if}

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={update}>
		<Modal id="update" title="Edit Part">
			<label for="">Nama</label>
			<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={nama} maxlength="50">

			<label for="">Deskripsi</label>
			<textarea rows="3" placeholder="Masukkan Deskripsi" class="form-control" required="true" bind:value={deskripsi} />

			<label for="">Stok</label>
			<input type="number" class="form-control" placeholder="Masukkan Stok" required="true" bind:value={stok} min="0">

			<div class="row">
				<div class="col-md-6">
					<label for="">Harga Jual</label>
					<input type="number" class="form-control" placeholder="Masukkan Harga Jual" required="true" bind:value={harga_jual} min="0">
				</div>
				<div class="col-md-6">
					<label for="">Harga Beli</label>
					<input type="number" class="form-control" placeholder="Masukkan Harga Beli" required="true" bind:value={harga_beli} min="0">
				</div>
			</div>

			<label for="">Foto</label>
			<input type="file" class="form-control" multiple="true" placeholder="Masukkan Foto" accept="image/*" on:change="{(e) => {
				foto = [];
				e.target.files.forEach((obj, i) => {
					read(obj, (result) => {
						foto.push(result);
					});
				});
			}}">

			<label for="">Bengkel</label>
			{#if user.level == '1'}
				<select required="true" bind:value={id_bengkel} class="form-control">
					<option value="">- Pilih Bengkel -</option>
					{#each data_bengkel as item}
						<option value={item.id}>{item.nama}</option>
					{/each}
				</select>
			{:else}
				<select required="true" bind:value={id_bengkel} class="form-control" disabled="true">
					<option value="">- Pilih Bengkel -</option>
					{#each data_bengkel as item}
						<option value={item.id}>{item.nama}</option>
					{/each}
				</select>
			{/if}

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>
	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus Part">
			<p>Anda yakin menghapus Part <strong>{nama}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
	<Modal id="lihat-foto" size="lg" title="Foto Part">
		<div class="row">
			{#each foto as item}
				<div class="col-md-4 col-6">
					<img src="{asset('asset/produk/' + item)}" alt="" class="shadow foto-produk">
				</div>
			{/each}
		</div>

		<div slot="footer">
			<button class="btn btn-default" on:click={modal.close} type="button">Tutup</button>
		</div>
	</Modal>
</main>