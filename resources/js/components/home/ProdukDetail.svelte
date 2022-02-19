<script>
	import { onMount } from 'svelte';
	import { url, asset, http, getWhatsapp } from '../../app';
	import { navigate } from 'svelte-navigator';
	import Section from './Section.svelte';

	export let id = '';

	// data
	let data = {
		foto: {}
	};
	let whatsapp;

	// function
	let get = () => {
		http.get('api/produk/' + id).then(res => {
			if (res.data) {
				data = res.data;
				setTimeout(() => {
			        jQuery('.product-active').slick({
			            dots: false,
			            infinite: false,
			            arrows: true,
			            prevArrow:'<span class="prev"><i class="mdi mdi-chevron-left"></i></span>',
			            nextArrow: '<span class="next"><i class="mdi mdi-chevron-right"></i></span>',
			            speed: 800,
			            slidesToShow: 1,
			            slidesToScroll: 1,
			        });
				}, 400);
			} else {
				notif('produk tidak diketahui', 'danger');
				navigate('/produk.html');
			}
		});
	}

	onMount(async () => {
		await getWhatsapp().then(res => {
			whatsapp = res.data.number[0] == '0' ? '62' + res.data.number.slice(1) : res.data.number;
		});
		await get();
	})
</script>

<Section title={data.nama}>
	<div class="p-4 bg-white shadow-sm">
		<div class="row">
			<div class="col-md-5 mb-4 md-mb-0">
				<div class="product-style-1">
					<div class="product-image">
						<div class="p-4 rounded" style="background: #DDD">
							<div class="product-active">
				                {#each data.foto as foto, i}
				                    <div class="product-item detail { i == '0' ? 'active' : '' }">
				                        <img src="{ asset('asset/produk/' + foto) }" alt="" class="img-produk">
				                    </div>
				                {/each}
				            </div>
			            </div>
		            </div>
		        </div>
			</div>
			<div class="col-md-7">
				<div class="text-center">
					<b>Deskripsi</b>
					<hr>
					<p>{data.deskripsi}</p>
					<br>
					<div class="row">
						<div class="col-md-12">
							<div class="p-3 shadow-sm">
								{data.stok} stok tersedia
							</div>
						</div>
						<div class="col-md-12">
							<div class="p-3 shadow-sm">
								IDR {parseInt(data.harga_jual).toLocaleString('id-ID')}
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="mt-4">
					<a href="https://api.whatsapp.com/send?phone={whatsapp}&text={encodeURIComponent('saya ingin memesan ' + data.nama + ' yang saya ketahui dari situs ' + url() + '.')}" target="_blank" class="main-btn primary-btn">
                        Pesan
                    </a>
				</div>
			</div>
		</div>
	</div>
</Section>