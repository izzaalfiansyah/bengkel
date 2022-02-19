<script>
	import { onMount } from 'svelte';
	import Header from '$component/admin/Header.svelte';
	import Card from '$component/Card.svelte';
	import Table from '$component/Table.svelte';
	import Modal from '$component/Modal.svelte';
	import { http, userID, modal } from '$app';
	import AutoComplete from 'simple-svelte-autocomplete/src/SimpleAutoComplete.svelte';

	export let id = '';
	// data
	let data_pelanggan = [];

	let request = {
		id_pelanggan: '',
		id_user: userID(),
		total_bayar: 0,
		status: '0',
		pajak_ppn: 0,
		grand_total: 0,
		ppn: 0
	}

	let data_produk = [];
	let data_produk_by_id = [];
	let keranjang_produk = [];
	let total_produk = 0;

	let produk = {
		id: '',
		qty: 0,
		harga: 0
	};

	let data_jasa = [];
	let data_jasa_by_id = [];
	let keranjang_jasa = [];
	let total_jasa = 0;

	let jasa = {
		id: '',
		harga: 0
	};

	let auto_jasa, auto_produk;

	// function
	let getPelanggan = () => {
		http.get('api/pelanggan').then(res => { data_pelanggan = res.data });
	}

	let getProduk = () => {
		http.get('api/produk').then(res => { 
			data_produk = res.data; 
			res.data.forEach(obj => {
				data_produk_by_id[obj.id] = obj;
			});
		});
	}
	let getHargaProduk = () => {
		if (auto_produk) {
			produk.id = auto_produk.id;
			produk.harga = data_produk_by_id[produk.id].harga_jual * produk.qty;
		}
	}
	let addKeranjangProduk = (e) => {
		e.preventDefault();
		keranjang_produk = keranjang_produk.concat(produk);
		produk = {
			id: '',
			qty: 0,
			harga: 0
		};
		totalProduk();
	}
	let deleteKeranjangProduk = (id) => {
		keranjang_produk = keranjang_produk.filter(item => (id !== item.id))
		totalProduk();
	}
	let totalProduk = () => {
		total_produk = 0;
		keranjang_produk.forEach(obj => {
			total_produk += obj.harga;
		});
		count()
	}

	let getJasa = () => {
		http.get('api/jasa').then(res => { 
			data_jasa = res.data; 
			res.data.forEach(obj => {
				data_jasa_by_id[obj.id] = obj;
			});
		});
	}
	let getHargaJasa = () => {
		if (auto_jasa) {
			jasa.id = auto_jasa.id;
			jasa.harga = data_jasa_by_id[jasa.id].harga;
		}
	}
	let addKeranjangJasa = (e) => {
		e.preventDefault();
		keranjang_jasa = keranjang_jasa.concat(jasa);
		jasa = {
			id: '',
			harga: 0
		};
		totalJasa();
	}
	let deleteKeranjangJasa = (id) => {
		keranjang_jasa = keranjang_jasa.filter(item => (id !== item.id))
		totalJasa();
	}
	let totalJasa = () => {
		total_jasa = 0;
		keranjang_jasa.forEach(obj => {
			total_jasa += obj.harga;
		});
		count()
	}

	function count() {
		request.pajak_ppn = (total_jasa + total_produk) * request.ppn / 100
		request.grand_total = request.pajak_ppn + (total_jasa + total_produk)
	}

	let update = (e) => {
		e.preventDefault();
		request.produk = keranjang_produk;
		request.jasa = keranjang_jasa;
		request.total_harga = (total_produk + total_jasa);
		http.put('api/transaksi/' + id, request).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				modal.close();
				notif(res.message, 'success');
				get();
			}
		})
	}

	let get = () => {
		http.get('api/transaksi/' + id).then(res => {
			request = {
				id_pelanggan: res.data.id_pelanggan,
				id_user: res.data.id_user,
				total_bayar: res.data.total_bayar,
				status: res.data.status,
				pajak_ppn: res.data.pajak_ppn,
				grand_total: res.data.grand_total
			}
			request.total_harga = res.data.total_harga;
			request.ppn = 100 / request.total_harga * request.pajak_ppn;
			keranjang_produk = res.data.produk;
			keranjang_jasa = res.data.jasa;
			totalProduk();
			totalJasa();
		})
	}

	onMount(async () => {
		await getProduk();
		await getJasa();
		await getPelanggan();
		get();
	})
</script>

<main>
	<Header>Edit Transaksi</Header>
	<hr>
	<Header>Produk</Header>
	<div class="row">
		<div class="col-md-4">
			<form on:submit={addKeranjangProduk}>
				<Card>
					<label for="">Cari Produk</label>
					<AutoComplete 
						items={data_produk}
						labelFunction={item => item.nama + ' (IDR ' + item.harga_jual.toLocaleString('id-ID') + ')'}
						id="produk-autocomplete"
						bind:selectedItem={auto_produk}
						className="w-100"
						inputClassName="form-control"
						onChange={getHargaProduk}
						required="true"
					></AutoComplete>

					<label style="margin-top: 8px;" for="">Qty</label>
					<input type="number" min="1" class="form-control" bind:value={produk.qty} required="true" on:input={getHargaProduk}>

					<label for="">Harga</label>
					<input type="text" class="form-control" disabled="true" value="IDR {produk.harga.toLocaleString('id-ID')}">
					<div align="right" class="mt-3">
						<button type="submit" class="btn btn-primary">
							<i class="material-icons">add</i>
							Tambah
						</button>
					</div>
				</Card>
			</form>
		</div>
		<div class="col-md-8">
			<Card title="Keranjang Produk">
				<Table
					mode="bordered"
				>
					<tr>
						<th>Produk</th>
						<th>Qty</th>
						<th>Harga</th>
						<th>Total</th>
						<th>Opsi</th>
					</tr>
					{#if keranjang_produk.length}
						{#each keranjang_produk as item}
							<tr>
								<td>{data_produk_by_id[item.id].nama}</td>
								<td align="center">{item.qty}</td>
								<td style="min-width: 100px">IDR {data_produk_by_id[item.id].harga_jual.toLocaleString('id-ID')}</td>
								<td style="min-width: 100px">IDR {item.harga.toLocaleString('id-ID')}</td>
								<td align="center">
									<button class="btn btn-sm btn-danger" on:click='{() => deleteKeranjangProduk(item.id)}'>
										<i class="material-icons">delete</i>
									</button>
								</td>
							</tr>
						{/each}
						<tr>
							<td colspan="3"><b>Total</b></td>
							<td colspan="2">
								<b>IDR {total_produk.toLocaleString('id-ID')}</b>
							</td>
						</tr>
					{:else}
						<tr>
							<td colspan="5" align="center">keranjang kosong</td>
						</tr>
					{/if}
				</Table>
			</Card>
		</div>
	</div>
	<hr>
	<Header>Jasa</Header>
	<div class="row">
		<div class="col-md-4">
			<form on:submit={addKeranjangJasa}>
				<Card>
					<label for="">Cari Jasa</label>
					<AutoComplete 
						items={data_jasa}
						labelFunction={item => item.nama + ' (IDR ' + item.harga.toLocaleString('id-ID') + ')'}
						id="jasa-autocomplete"
						bind:selectedItem={auto_jasa}
						className="w-100"
						inputClassName="form-control"
						onChange={getHargaJasa}
						required="true"
					></AutoComplete>

					<label style="margin-top: 8px;" for="">Harga</label>
					<input type="text" class="form-control" disabled="true" value="IDR {jasa.harga.toLocaleString('id-ID')}">
					<div align="right" class="mt-3">
						<button type="submit" class="btn btn-primary">
							<i class="material-icons">add</i>
							Tambah
						</button>
					</div>
				</Card>
			</form>
		</div>
		<div class="col-md-8">
			<Card title="Keranjang Jasa">
				<Table
					mode="bordered"
				>
					<tr>
						<th>Jasa</th>
						<th>Harga</th>
						<th>Opsi</th>
					</tr>
					{#if keranjang_jasa.length}
						{#each keranjang_jasa as item}
							<tr>
								<td>{data_jasa_by_id[item.id].nama}</td>
								<td style="min-width: 100px">IDR {data_jasa_by_id[item.id].harga.toLocaleString('id-ID')}</td>
								<td align="center">
									<button class="btn btn-sm btn-danger" on:click='{() => deleteKeranjangJasa(item.id)}'>
										<i class="material-icons">delete</i>
									</button>
								</td>
							</tr>
						{/each}
						<tr>
							<td><b>Total</b></td>
							<td colspan="2">
								<b>IDR {total_jasa.toLocaleString('id-ID')}</b>
							</td>
						</tr>
					{:else}
						<tr>
							<td colspan="3" align="center">keranjang kosong</td>
						</tr>
					{/if}
				</Table>
			</Card>
		</div>
	</div>

	<Card>
		<div class="row align-items-end">
			<div class="col-6">
				<b>
					Sub Total: IDR {(total_jasa + total_produk).toLocaleString('id-ID')} <br>
					Pajak PPN: IDR {request.pajak_ppn.toLocaleString('id-ID')} <br>
					Grand Total: IDR {(request.grand_total + request.pajak_ppn).toLocaleString('id-ID')}
				</b>
			</div>
			<div class="col-6" align="right">
				<button class="btn btn-primary" on:click="{() => modal.open('#bayar')}">Edit</button>
			</div>
		</div>
	</Card>

	<form on:submit={update}>
		<Modal id="bayar" title="Konfirmasi Pembayaran">
			<label for="">Pelanggan</label><br>
			<select bind:value={request.id_pelanggan} class="form-control" disabled="true">
				<option value="">-</option>
				{#each data_pelanggan as item}
					<option value={item.id}>{item.nama}</option>
				{/each}
			</select>

			<label for="">Sub Total</label>
			<input type="text" class="form-control" disabled="true" value="IDR {(total_jasa + total_produk).toLocaleString('id-ID')}">
			
			<label for="">PPN</label>
			<small>(dalam bentuk persentase)</small>
			<input type="number" class="form-control" bind:value={request.ppn} on:keyup={count} min="0" max="100">
			
			<label for="">Pajak PPN</label>
			<input type="text" class="form-control" disabled="true" value="IDR {request.pajak_ppn.toLocaleString('id-ID')}">
			
			<label for="">Grand Total</label>
			<input type="text" class="form-control" disabled="true" value="IDR {request.grand_total.toLocaleString('id-ID')}">

			<label for="">Bayar</label>
			<input type="number" class="form-control" bind:value={request.total_bayar} required="true">

			<div slot="footer">
				<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</Modal>
	</form>
</main>