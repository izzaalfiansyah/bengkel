<script>
	import { onMount } from 'svelte';
	import { http, app } from '$app'
	import Card from '$component/Card.svelte';
	import Header from './Header.svelte';

	// data
	let data_produk = 0;
	let data_jasa = 0;
	let data_kas = [];
	let report = {
		total_omset: 0,
		total_pengaluran: 0,
		laba_kotor: 0
	};

	let getProduk = () => {
		http.get('api/produk').then(res => { data_produk = res.data.length })
	}

	let getJasa = () => {
		http.get('api/jasa').then(res => { data_jasa = res.data.length })
	}

	function getKas() {
		http.get('api/kas/graphic').then(res => { 
			data_kas = res.data;
			setTimeout(() => {
				renderChart();
			}, 400)
		});
	}

	function renderChart() {
		var ctx = document.getElementById("chart").getContext('2d');
		new Chart(ctx, {
			type: 'bar',
			data: {
				labels: data_kas.label,
				datasets: [
					{
						label: 'pendapatan',
						data: data_kas.pendapatan,
						backgroundColor: 'lightblue',
						// borderColor: 'lightblue',
						borderWidth: 3
					},
					{
						label: 'pengeluaran',
						data: data_kas.pengeluaran,
						backgroundColor: 'pink',
						// borderColor: 'pink',
						borderWidth: 3
					},
					{
						label: 'profit',
						data: data_kas.profit,
						backgroundColor: 'lightgreen',
						// borderColor: 'lightgreen',
						borderWidth: 3
					}
				]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	}

	function getReport () {
		http.get('api/transaksi/report').then(res => report = res.data)
	}

	onMount(async () => {
		await getProduk();
		await getJasa();
		await getKas();
		await getReport()

		setTimeout(() => {
	        var calendarEl = document.getElementById('calendar');
	        var calendar = new FullCalendar.Calendar(calendarEl, {
	        	initialView: 'dayGridMonth'
	        });
			calendar.render();
		}, 400)
	})
</script>

<main>
	<Header>Dashboard</Header>

	<div class="row text-center text-white">
		<div class="col-md-4">
			<div class="card" style="background: lightblue">
				<div class="card-body">
					<div class="card-title">
						Total Omset
					</div>
					<h3>IDR {parseInt(report.total_omset).toLocaleString('id-ID')}</h3>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card" style="background: pink">
				<div class="card-body">
					<div class="card-title">
						Total Pengaluran
					</div>
					<h3>IDR {parseInt(report.total_pengaluran).toLocaleString('id-ID')}</h3>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card" style="background: lightgreen">
				<div class="card-body">
					<div class="card-title">
						Laba Kotor
					</div>
					<h3>IDR {parseInt(report.laba_kotor).toLocaleString('id-ID')}</h3>
				</div>
			</div>
		</div>
	</div>
	
	<Card>
		<canvas id="chart"></canvas>
	</Card>

	<div class="row">
		<div class="col-md-5">
			<Card>
				<div align="center">
					<h1>{data_produk}</h1>
					<small>Total Produk</small>
				</div>
			</Card>
			<Card>
				<div align="center">
					<h1>{data_jasa}</h1>
					<small>Total Jasa</small>
				</div>
			</Card>
		</div>
		<div class="col-md-7">
			<Card>
				<div id="calendar"></div>
			</Card>
		</div>
	</div>
</main>