<script>
	import { onMount } from 'svelte';
	import { navigate } from 'svelte-navigator';
	import { http, blank, url, modal } from '$app';
	import Card from '$component/Card.svelte';
	import Table from '$component/Table.svelte';
	import Modal from '$component/Modal.svelte';

	export let id;
	export let id_service = '';

	// data
	let data = {
		user: {},
		grand_total: 0,
		total_bayar: 0,
		produk: [],
		jasa: []
	};

	let uang_kekurangan = 0;

	// function
	let get = () => {
		http.get('api/transaksi/' + id).then(res => { data = res.data });
	}

	let destroy = (e) => {
		e.preventDefault();
		http.delete('api/transaksi/' + id).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				navigate('/admin/transaksi.html');
				if (id_service) {
					setTimeout(() => navigate('/admin/service/' + id_service + '/detail.html'), 100);
				}
			}
		})
	}

	let update = (e) => {
		e.preventDefault();
		data.status = '1';
		http.put('api/transaksi/' + id, data).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success');
				modal.close();
				get();
			}
		})
	}

	let pay = (e) => {
		e.preventDefault();
		data.total_bayar = data.total_bayar + uang_kekurangan;
		http.put('api/transaksi/' + id, data).then(res => {
			if (res.error) {
				notif(res.message, 'error', true);
			} else {
				notif(res.message, 'success');
				uang_kekurangan = 0;
				modal.close();
				get();
			}
		})
	}

	onMount(async () => {
		await get();
	})
</script>

<main>
	<div class="row">
		<div class="col-md-5">
			<Card>
				<Table mode="striped">
					<tr>
						<td>Kode</td>
						<td>:</td>
						<td>{data.kode}</td>
					</tr>
					<tr>
						<td>Total</td>
						<td>:</td>
						<td style="min-width: 100px">IDR {data.grand_total.toLocaleString('id-ID')}</td>
					</tr>
					<tr>
						<td>Bayar</td>
						<td>:</td>
						<td style="min-width: 100px">IDR {data.total_bayar.toLocaleString('id-ID')}</td>
					</tr>
					<tr>
						{#if data.total_bayar >= data.grand_total}
							<td>Kembalian</td>
						{:else}
							<td>Kekurangan</td>
						{/if}
						<td>:</td>
						<td style="min-width: 100px">IDR {(data.total_bayar - data.grand_total).toLocaleString('id-ID')}</td>
					</tr>
					<tr>
						<td>Keterangan</td>
						<td>:</td>
						<td>{@html data.total_bayar >= data.grand_total ? '<span class="text-success">Lunas</span>' : '<span class="text-danger">Piutang</span>' }</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>:</td>
						<td>{data.status == '1' ? 'Selesai' : 'Belum Selesai'}</td>
					</tr>
				</Table>
				<div align="right">
					<button class="btn btn-primary" on:click="{() => blank(url('print/transaksi/' + data.id))}">Print</button>
				</div>
			</Card>
		</div>
		<div class="col-md-7">
			<Card title="Data Part">
				<Table mode="bordered" head="{['Part', 'Qty', 'Harga', 'Jumlah']}">
					{#if data.produk.length}
						{#each data.produk as item}
							<tr>
								<td>{item.produk.nama}</td>
								<td align="center">{item.qty}</td>
								<td style="min-width: 100px">IDR {item.produk.harga_jual.toLocaleString('id-ID')}</td>
								<td style="min-width: 100px">IDR {(item.produk.harga_jual * item.qty).toLocaleString('id-ID')}</td>
							</tr>
						{/each}
					{:else}
						<tr>
							<td colspan="4" align="center">data kosong</td>
						</tr>
					{/if}
				</Table>
			</Card>
			<Card title="Data Jasa">
				<Table mode="bordered" head="{['Jasa', 'Qty', 'Harga', 'Jumlah']}">
					{#if data.jasa.length}
						{#each data.jasa as item}
							<tr>
								<td>{item.jasa.nama}</td>
								<td align="center">1</td>
								<td style="min-width: 100px">IDR {item.jasa.harga.toLocaleString('id-ID')}</td>
								<td style="min-width: 100px">IDR {item.jasa.harga.toLocaleString('id-ID')}</td>
							</tr>
						{/each}
					{:else}
						<tr>
							<td colspan="4" align="center">data kosong</td>
						</tr>
					{/if}
				</Table>
			</Card>

			<form on:submit={destroy}>
				<Modal id="destroy" title="Hapus Transaksi">
					<p>anda yakin untuk menghapus transaksi?</p>

					<div slot="footer">
						<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
						<button class="btn btn-danger" type="submit">Hapus</button>
					</div>
				</Modal>
			</form>

			<form on:submit={update}>
				<Modal id="end" title="Selesaikan Transaksi">
					<p>anda yakin untuk menyelesaikan transaksi?</p>

					<div slot="footer">
						<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
						<button class="btn btn-primary" type="submit">Oke</button>
					</div>
				</Modal>
			</form>

			<form on:submit={pay}>
				<Modal id="pay" title="Bayar Kekurangan">
					<label for="">Kekurangan</label>
					<input type="number" class="form-control" disabled="true" value="{data.total_bayar - data.grand_total}">

					<label for="">Bayar Kekurangan</label>
					<input type="number" class="form-control" placeholder="Masukkan Uang Kekurangan" bind:value={uang_kekurangan} required="true" min="0">

					<div slot="footer">
						<button class="btn btn-default" type="button" on:click={modal.close}>Batal</button>
						<button class="btn btn-primary" type="submit">Bayar</button>
					</div>
				</Modal>
			</form>
		</div>
	</div>
	<Card title="Detail Transaksi">
		<div slot="action">
			<b>IDR {data.grand_total.toLocaleString('id-ID')}</b>
		</div>
		<Table head="{['Kode', 'Pelanggan', 'Penulis', 'Opsi']}">
			<tr>
				<td style="min-width: 180px;">{data.kode}</td>
				<td>{data.pelanggan ? data.pelanggan.nama : '-'}</td>
				<td>{data.user.nama}</td>
				<td align="center">
					{#if data.total_bayar < data.grand_total}
						<button class="btn btn-sm btn-warning" type="button" on:click="{() => modal.open('#pay')}">Bayar Kekurangan</button>
					{/if}
					{#if data.status !== '1'}
						<button class="btn btn-success btn-sm" type="button" on:click="{() => modal.open('#end')}">Selesaikan</button>
						<button class="btn btn-primary btn-sm" on:click="{() => navigate('/admin/transaksi/' + id + '/edit.html')}">
							<i class="material-icons">edit</i>
						</button>
					{/if}
					<button class="btn btn-danger btn-sm" on:click="{() => modal.open('#destroy')}">
						<i class="material-icons">delete</i>
					</button>
				</td>
			</tr>
		</Table>
	</Card>
</main>