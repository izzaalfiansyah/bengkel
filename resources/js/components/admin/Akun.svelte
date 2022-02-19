<script>
	import { onMount } from 'svelte';
	import { http, userID } from '../../app';
	import Card from '../Card.svelte';

	// data
	let data_bengkel = [];
	let username;
	let password;
	let password_lama;
	let password_konfirmasi;
	let nama;
	let email;
	let telepon;
	let alamat;
	let id_bengkel;
	let level;

	// function
	let get = () => {
		if (password_konfirmasi !== password) {
			return notif('password konfirmasi harus sama', 'warning', true);
		}
		http.get('api/user/' + userID()).then(res => {
			username = res.data.username;
			nama = res.data.nama;
			email = res.data.email;
			telepon = res.data.telepon;
			alamat = res.data.alamat;
			id_bengkel = res.data.id_bengkel;
			level = res.data.level;
		})
	}

	let update = (e) => {
		e.preventDefault();
		http.put('api/user/' + userID(), {
			username: username,
			password_lama: password_lama,
			password_baru: password,
			nama: nama,
			email: email,
			telepon: telepon,
			alamat: alamat,
			id_bengkel: id_bengkel,
			level: level
		}).then(res => {
			if (res.error) {
				notif(res.message, 'warning', true);
			} else {
				notif(res.message, 'success');
			}
		})
	}

	onMount(async () => {
		await get();
	})
</script>

<form on:submit={update}>
	<Card title="Pengaturan Akun">
		<div class="row">
			<div class="col-md-6">
				<label for="">Username</label>
				<input type="text" class="form-control" placeholder="Masukkan Username" required="true" bind:value={username} minlength="5" maxlength="20">

				<label for="">Password Lama</label>
				<input type="password" class="form-control" placeholder="Masukkan Password Lama" required="true" bind:value={password_lama} minlength="8" maxlength="20">

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

				<hr>
				<strong>Optional (boleh tidak diisi)</strong>
				<hr>

				<label for="">Password</label>
				<input type="password" class="form-control" placeholder="Masukkan Password" bind:value={password} minlength="8" maxlength="20">

				<label for="">Password Konfirmasi</label> <small class="text-danger">{(password !== password_konfirmasi && password_konfirmasi) ? 'password konfirmasi harus sama' : ''}</small>
				<input type="password" class="form-control" placeholder="Masukkan Password Konfirmasi" bind:value={password_konfirmasi}>
			</div>
		</div>

		<div slot="footer">
			<button type="submit" class="btn btn-primary">Simpan</button>
		</div>
	</Card>
</form>