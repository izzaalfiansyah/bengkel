<script>
    import { url, asset, http, getWhatsapp, readQueryString } from '../../app';
    import { onMount } from 'svelte';
    import { link } from 'svelte-navigator';
    import Section from './Section.svelte';
    import Pagination from '$component/Pagination.svelte';
    import Card from '$component/Card.svelte';

    // data
    export let queryString = '';
    let data = [];
    let whatsapp = '';
    let filter = {
        limit: 10,
        page: 1
    };
    let render = {
        pageTotal: 0,
        record: 0,
        recordTotal: 0
    };

    // function
    let get = () => {
        const search = readQueryString(queryString).q;
        http.get('api/produk?limit=10&search=' + (search ? search : '')).then(res => {
            data = res.data;
            render = {
                pageTotal: res.pageTotal,
                record: res.data.length,
                recordTotal: res.recordTotal
            }
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
<Section title="Produk">
    <div class="p-2 bg-white shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-6">
                Menampilkan {render.record} dari {render.recordTotal} data
            </div>
            <div class="col-md-6">
                <Pagination bind:now={filter.page} bind:total={render.pageTotal} action={get} />
            </div>
        </div>
    </div>
    <div class="row mb-4">
        {#if data.length}
            {#each data as item}
                <div class="col-lg-6">
                    <div class="product-style-7 bg-white shadow-sm mt-30">
                        <div class="product-image">
                            <div class="product-active">
                                {#each item.foto as foto, i}
                                    <div class="product-item { i == '0' ? 'active' : '' }">
                                        <img src="{ asset('asset/produk/' + foto) }" alt="" class="img-produk">
                                    </div>
                                {/each}
                            </div>
                        </div>
                        <div class="product-content text-truncate">
                            <h4 class="title text-truncate"><a use:link href="produk/{item.id}/detail.html">{item.nama}</a></h4>
                            <p class="text-truncate">{item.deskripsi}</p>
                            <span class="price">IDR {item.harga_jual.toLocaleString('id-ID')}</span>
                            <a href="https://api.whatsapp.com/send?phone={whatsapp}&text={encodeURIComponent('saya ingin memesan ' + item.nama + ' yang saya ketahui dari situs ' + url() + '.')}" target="_blank" class="main-btn primary-btn">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
            {/each}
        {:else}
            <div class="col-md-12" align="center">
                <div class="p-4 bg-white shadow-sm">
                    <p>produk tidak tersedia</p>
                </div>
            </div>
        {/if}
    </div>
    <div class="p-2 bg-white shadow-sm">
        <div class="row align-items-center">
            <div class="col-md-6">
                Menampilkan {render.record} dari {render.recordTotal} data
            </div>
            <div class="col-md-6">
                <Pagination bind:now={filter.page} bind:total={render.pageTotal} action={get} />
            </div>
        </div>
    </div>
</Section>