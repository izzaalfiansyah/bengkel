<script>
    import { url, asset, http, getWhatsapp } from '../../app';
    import { onMount } from 'svelte';
    import { link } from 'svelte-navigator';

    // data
    let data = [];
    let whatsapp = '';

    // function
    let get = () => {
        http.get('api/produk?limit=8').then(res => {
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
        });
    }

    onMount(async () => {
        await getWhatsapp().then(res => {
            whatsapp = res.data.number[0] == '0' ? '62' + res.data.number.slice(1) : res.data.number;
        });
        await get();
    })
</script>

<section class="product-wrapper pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-50">
                    <h1 class="heading-1 font-weight-700">Produk Terbaru</h1>
                </div>
            </div>
        </div>
        <div class="row">
            {#each data as item}
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="product-style-1 mt-30">
                        <div class="product-image">
                            <div class="product-active">
                                {#each item.foto as foto, i}
                                    <div class="product-item { i == '0' ? 'active' : '' }">
                                        <img src="{ asset('asset/produk/' + foto) }" alt="product" class="img-produk">
                                    </div>
                                {/each}
                            </div>
                        </div>
                        <div class="product-content text-center text-truncate">
                            <h4 class="title text-truncate"><a href="/produk/{item.id}/detail.html" use:link>{item.nama}</a></h4>
                            <p class="text-truncate">{item.deskripsi}</p>
                            <a href="https://api.whatsapp.com/send?phone={whatsapp}&text={encodeURIComponent('saya ingin memesan ' + item.nama + ' yang saya ketahui dari situs ' + url() + '.')}" target="_blank" class="main-btn secondary-1-btn">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            {/each}
        </div>
    </div>
</section>