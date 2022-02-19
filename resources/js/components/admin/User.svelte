<script>
	import { onMount } from 'svelte';
	import { http, modal, user as getUser } from '../../app';

	import Header from './Header.svelte';
	import Card from '../Card.svelte';
	import Modal from '../Modal.svelte';
	import DataTable from '../DataTable.svelte';

	let user = {};

	// data
	let data = []
	let data_bengkel = []
	let limit = 5;
	let search = '';
	let record = 0;
	let recordTotal = 0;
	let page = 1;
	let pageTotal = 0;
	let id;
	let username;
	let password;
	let password_konfirmasi;
	let nama;
	let email;
	let telepon;
	let alamat;
	let id_bengkel;
	let level;
	let filter_id_bengkel;

	// function
	let nullable = () => {
		id = '';
		username = '';
		password = '';
		password_konfirmasi = '';
		nama = '';
		email = '';
		telepon = '';
		alamat = '';
		if (user.level == '1') {
			id_bengkel = '';
		} else {
			id_bengkel = user.id_bengkel;
		}
		level = '';
	}

	let request = () => {
		return {
			id: id,
			username: username,
			password: password,
			nama: nama,
			email: email,
			telepon: telepon,
			alamat: alamat,
			id_bengkel: id_bengkel,
			level: level
		}
	}

	let getLevel = () => {
		if (user.level !== '1') {
			level = '3';
		} else {
			level = '';
			id_bengkel = user.id_bengkel;
		}
	}

	let getBengkel = () => {
		http.get('api/bengkel').then(res => {
			data_bengkel = res.data;
		});
	}

	let get = () => {
		nullable();
		http.get('api/user?limit=' + limit + '&search=' + search + '&page=' + page + '&id_bengkel=' + filter_id_bengkel).then(res => {
			data = res.data;
			record = res.data.length;
			recordTotal = res.recordTotal;
			pageTotal = res.pageTotal;
		});
	}

	let store = (e) => {
		e.preventDefault();
		if (password_konfirmasi !== password) {
			return notif('password konfirmasi harus sama', 'warning', true);
		}
		http.post('api/user', request()).then(res => {
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
		http.put('api/user/' + id, request()).then(res => {
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
		http.delete('api/user/' + id).then(res => {
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
			id_bengkel = user.id_bengkel;
		});
		await get();
		await getBengkel();
		await getLevel();
	})
</script>

<main>
	<Header>User</Header>
	<Card title="Data User">
		<div slot="action">
			{#if user.level == '1' || user.level == '2'}
				<button class="btn btn-primary" type="button" on:click="{() => { modal.open('#store'); nullable() }}">
					<i class="material-icons">add</i>
					Tambah
				</button>
			{/if}
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
			head="{['No', 'Username', 'Nama', 'Email', 'Telepon', 'Opsi']}"
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
						<td>{item.username}</td>
						<td>{item.nama}</td>
						<td>{item.email}</td>
						<td>{item.telepon}</td>
						<td style="min-width: 100px" class="text-center">
							{#if user.level == '1' || (user.level == '2' && item.id_bengkel == user.id_bengkel)}
								<button type="button" class="btn btn-sm btn-primary" on:click="{() => {
									id = item.id;
									username = item.username;
									email = item.email;
									telepon = item.telepon;
									alamat = item.alamat;
									id_bengkel = item.id_bengkel;
									level = item.level;
									id = item.id;
									nama = item.nama;
									modal.open('#update');
								}}">
									<i class="material-icons">edit</i>
								</button>
								<button type="button" class="btn btn-sm btn-danger" on:click="{() => {
									id = item.id
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
					<td colspan="6" align="center">data tidak tersedia</td>
				</tr>
			{/if}
		</DataTable>
	</Card>

	<form on:submit={store}>
		<Modal id="store" title="Tambah User" size="lg">
			<div class="row">
				<div class="col-md-6">
					<label for="">Username</label>
					<input type="text" class="form-control" placeholder="Masukkan Username" required="true" bind:value={username} minlength="5" maxlength="20">

					<label for="">Password</label>
					<input type="password" class="form-control" placeholder="Masukkan Password" required="true" bind:value={password} minlength="8" maxlength="20">

					<label for="">Password Konfirmasi</label> <small class="text-danger">{(password !== password_konfirmasi && password_konfirmasi) ? 'password konfirmasi harus sama' : ''}</small>
					<input type="password" class="form-control" placeholder="Masukkan Password Konfirmasi" required="true" bind:value={password_konfirmasi}>

					<label for="">Nama</label>
					<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={nama}>

					<label for="">Email</label>
					<input type="email" class="form-control" placeholder="Masukkan Email" required="true" bind:value={email}>

					<label for="">Telepon</label>
					<input type="text" class="form-control" placeholder="Masukkan Telepon" required="true" bind:value={telepon}>
				</div>
				<div class="col-md-6">
					<label for="">Alamat</label>
					<textarea rows="3" class="form-control" placeholder="Masukkan Alamat" required="true" bind:value={alamat} />

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

					<label for="">Level</label>
					<select bind:value={level} class="form-control" required="true">
						<option value="">- Pilih Level -</option>
						{#if user.level == '1'}
							<option value="1">Root</option>
						{/if}
						<option value="2">Admin</option>
						<option value="3">Pekerja</option>
						<option value="4">Kasir</option>
					</select>
				</div>
			</div>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>

	<form on:submit={update}>
		<Modal id="update" title="Edit User" size="lg">
			<div class="row">
				<div class="col-md-6">
					<label for="">Username</label>
					<input type="text" class="form-control" placeholder="Masukkan Username" required="true" bind:value={username} minlength="5" maxlength="20" disabled={true}>

					<label for="">Nama</label>
					<input type="text" class="form-control" placeholder="Masukkan Nama" required="true" bind:value={nama}>

					<label for="">Email</label>
					<input type="email" class="form-control" placeholder="Masukkan Email" required="true" bind:value={email}>

					<label for="">Telepon</label>
					<input type="text" class="form-control" placeholder="Masukkan Telepon" required="true" bind:value={telepon}>
				</div>
				<div class="col-md-6">
					<label for="">Alamat</label>
					<textarea rows="3" class="form-control" placeholder="Masukkan Alamat" required="true" bind:value={alamat} />

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

					<label for="">Level</label>
					<select bind:value={level} class="form-control" required="true">
						<option value="">- Pilih Level -</option>
						{#if user.level == '1'}
							<option value="1">Root</option>
						{/if}
						<option value="2">Admin</option>
						<option value="3">Pekerja</option>
						<option value="4">Kasir</option>
					</select>
				</div>
			</div>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</Modal>
	</form>

	<form on:submit={destroy}>
		<Modal id="destroy" title="Hapus User">
			<p>Anda yakin menghapus user <strong>{nama}</strong>?</p>

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-danger">Hapus</button>
			</div>
		</Modal>
	</form>
</main>