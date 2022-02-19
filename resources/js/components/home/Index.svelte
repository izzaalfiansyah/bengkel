<script>
    import { onMount } from 'svelte';
    import { asset } from '../../app';
    import ProdukTerbaru from './ProdukTerbaru.svelte';

    // function
    let sendMessage = (e) => {
        e.preventDefault();
        notif('pesan sukses terkirim', 'success');
    }
</script>


<section class="content-card-style-4 pt-70 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="features-title text-center mb-50">
                    <h1 class="heading-1 font-weight-700">Mengapa Kami?</h1>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-7 col-sm-8">
                <div class="single-content mt-15 text-center">
                    <div class="content-icon">
                        <i class="mdi mdi-truck-fast"></i>
                    </div>
                    <div class="content-content">
                        <h4 class="title"><a href="#0">Sistem Online</a></h4>
                        <p>menggunakan teknologi yang memudahkan anda untuk memonitor situasi bengkel yang anda butuhkan.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-7 col-sm-8">
                <div class="single-content mt-15 text-center">
                    <div class="content-icon">
                        <i class="mdi mdi-ticket-percent"></i>
                    </div>
                    <div class="content-content">
                        <h4 class="title"><a href="#0">Temukan Bengkel</a></h4>
                        <p>menemukan bengkel terdekat yang cocok dengan anda.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-7 col-sm-8">
                <div class="single-content mt-15 text-center">
                    <div class="content-icon">
                        <i class="mdi mdi-message-text"></i>
                    </div>
                    <div class="content-content">
                        <h4 class="title"><a href="#0">Respon Cepat</a></h4>
                        <p>mengalami masalah? anda dapat menghubungi kami dan akan kami respon cepat.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<ProdukTerbaru />

<section class="features-section pt-100 pb-50 gray-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="features-title text-center mb-50">
                    <h1 class="heading-1 font-weight-700">Kontak</h1>
                </div>
            </div>
        </div>
        <div class="p-4 bg-white shadow-sm">
            <form on:submit={sendMessage}>
                <label for="">Email</label>
                <input type="email" class="form-control" placeholder="Masukkan Email">

                <label for="">Teks</label>
                <textarea rows="3" class="form-control" placeholder="Masukkan Pesan"></textarea>

                <button class="main-btn primary-btn btn-block mt-4">Kirim</button>
            </form>
        </div>
    </div>
</section>