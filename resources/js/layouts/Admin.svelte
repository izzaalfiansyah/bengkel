<script>
	import { onMount } from 'svelte';
	import { url, asset, nick, user as getUser, modal } from '../app';
	import { Router, Route, link } from 'svelte-navigator';
	import Modal from '$component/Modal.svelte';
	import Sidebar from './admin/Sidebar.svelte'
	import Footer from './admin/Footer.svelte'

	import User from '$component/admin/User.svelte';
	import Dashboard from '$component/admin/Dashboard.svelte';
	import Supplier from '$component/admin/Supplier.svelte';
	import Pelanggan from '$component/admin/Pelanggan.svelte';
	import Teknisi from '$component/admin/Teknisi.svelte';
	import KendaraanPelanggan from '$component/admin/KendaraanPelanggan.svelte';
	import Bengkel from '$component/admin/Bengkel.svelte';
	import BengkelCreate from '$component/admin/BengkelCreate.svelte';
	import BengkelEdit from '$component/admin/BengkelEdit.svelte';
	import Jasa from '$component/admin/Jasa.svelte';
	import Produk from '$component/admin/Produk.svelte';
	import Transaksi from '$component/admin/Transaksi.svelte';
	import TransaksiAdd from '$component/admin/transaksi/Add.svelte';
	import TransaksiEdit from '$component/admin/transaksi/Edit.svelte';
	import TransaksiDetail from '$component/admin/transaksi/Detail.svelte';
	import Estimasi from '$component/admin/Estimasi.svelte';
	import Invoice from '$component/admin/Invoice.svelte';
	import WorkOrder from '$component/admin/WorkOrder.svelte';
	import ServiceAdd from '$component/admin/service/Add.svelte';
	import ServiceDetail from '$component/admin/service/Detail.svelte';
	import Kas from '$component/admin/Kas.svelte';
	import Pengaturan from '$component/admin/Pengaturan.svelte';
	import Akun from '$component/admin/Akun.svelte';
	import LaporanKas from '$component/admin/laporan/Kas.svelte';
	import LaporanPenjualan from '$component/admin/laporan/Penjualan.svelte';

	// data
	let user = {
		level: '1'
	};

	let handleSidebar = (e) => {
		if(document.body.clientWidth <= 980) {
			document.getElementById('sidebar').classList.remove('collapsed');
		}
	}

	let removeActiveClass = () => {
		document.querySelectorAll('li.sidebar-item').forEach(obj => obj.classList.remove('active'));
	}

	let addActiveClass = (obj) => {
		obj.parentElement.classList.add('active');
		if (obj.parentElement.parentElement.parentElement.nodeName.toLowerCase() == 'li') {
			obj.parentElement.parentElement.classList.add('show');
			obj.parentElement.parentElement.parentElement.classList.add('active');
		}
	}

	// function
	onMount(async() => {
		await getUser().then(res => {
			user = res.data;
		});

		const path = window.location.href.replace(window.location.hash, '');

		setTimeout(() => {
			document.querySelectorAll('li.sidebar-item>a').forEach(obj => {
				if (obj.href == path) {
					addActiveClass(obj);
				}

				obj.addEventListener('click', () => {
					removeActiveClass();
					addActiveClass(obj);
				})
			})
		}, 400)
	})
</script>

<div class="wrapper">
	<Sidebar handleSidebar={handleSidebar} />

	<div class="main">
		<nav class="navbar navbar-expand navbar-light navbar-bg">
			<a class="sidebar-toggle d-flex" href="#0">
		      <i class="hamburger align-self-center"></i>
		    </a>

			<form class="d-none d-sm-inline-block">
				<div class="input-group input-group-navbar">
					<input type="text" class="form-control" placeholder="Search…" aria-label="Search">
					<button class="btn" type="button">
			          <i class="align-middle" data-feather="search"></i>
			        </button>
				</div>
			</form>

			<div class="navbar-collapse collapse">
				<ul class="navbar-nav navbar-align">
					<li class="nav-item dropdown">
						<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="/back/#" data-bs-toggle="dropdown">
				            <i class="align-middle" data-feather="user"></i>
				          </a>

						<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="0#" data-bs-toggle="dropdown">
				            <span class="text-dark">{user.username}</span>
				          </a>
						<div class="dropdown-menu dropdown-menu-end">
							<a class="dropdown-item" href="/admin/akun.html" use:link><i class="align-middle me-1" data-feather="user"></i> Profile</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="#0" data-bs-toggle="modal" data-bs-target="#logout"><i class="align-middle me-1" data-feather="lock"></i>Log out</a>
						</div>
					</li>
				</ul>
			</div>
		</nav>

		<main class="content">
			<div class="container-fluid p-0">
				<Router primary={false}>
					<Route path="/admin/dashboard.html">
						<Dashboard />
					</Route>
					<Route path="/admin/user.html">
						<User />
					</Route>
					<Route path="/admin/supplier.html">
						<Supplier />
					</Route>
					<Route path="/admin/pelanggan.html">
						<Pelanggan />
					</Route>
					<Route path="/admin/teknisi.html">
						<Teknisi />
					</Route>
					<Route path="/admin/kendaraan.html">
						<KendaraanPelanggan />
					</Route>
					<Route path="/admin/jasa.html">
						<Jasa />
					</Route>
					<Route path="/admin/part.html">
						<Produk />
					</Route>
					<Route path="/admin/transaksi.html">
						<Transaksi />
					</Route>
					<Route path="/admin/transaksi/add.html">
						<TransaksiAdd />
					</Route>
					<Route path="/admin/transaksi/:id/edit.html" let:params>
						<TransaksiEdit id={params.id} />
					</Route>
					<Route path="/admin/transaksi/:id/detail.html" let:params>
						<TransaksiDetail id={params.id} />
					</Route>
					<Route path="/admin/estimasi.html">
						<Estimasi />
					</Route>
					<Route path="/admin/invoice.html">
						<Invoice />
					</Route>
					<Route path="/admin/work-order.html">
						<WorkOrder />
					</Route>
					<Route path="/admin/service/add.html">
						<ServiceAdd />
					</Route>
					<Route path="/admin/service/:id/detail.html" let:params>
						<ServiceDetail id={params.id} />
					</Route>
					<Route path="/admin/service/:id/transaksi.html" let:params>
						<TransaksiAdd id_service={params.id} />
					</Route>
					<Route path="/admin/kas.html">
						<Kas />
					</Route>
					<Route path="/admin/akun.html">
						<Akun />
					</Route>
					<Route path="/admin/laporan/kas.html">
						<LaporanKas />
					</Route>
					<Route path="/admin/laporan/penjualan.html">
						<LaporanPenjualan />
					</Route>
					<Route path="/admin/bengkel.html">
						<Bengkel />
					</Route>
					<Route path="/admin/bengkel/create.html">
						<BengkelCreate />
					</Route>
					<Route path="/admin/bengkel/:id/edit.html" let:params>
						<BengkelEdit id={params.id} />
					</Route>
					<Route path="/admin/pengaturan.html">
						<Pengaturan />
					</Route>
				</Router>
			</div>
		</main>

		<Footer/>

		<Modal id="logout" title="Logout">
			<p>Anda yakin akan mengakhiri sesi?</p>

			<div slot="footer">
				<button class="btn btn-default" on:click={modal.close}>Batal</button>
				<a href="{ url('logout') }" class="btn btn-danger">Keluar</a>
			</div>
		</Modal>
	</div>
</div>