<script>
    import { url, asset } from '../app';
    import { link, Router, Route, navigate } from 'svelte-navigator';

    import Index from '../components/Home/Index.svelte';
    import Bengkel from '../components/Home/Bengkel.svelte';
    import Produk from '../components/Home/Produk.svelte';
    import ProdukDetail from '../components/Home/ProdukDetail.svelte';
    import Jasa from '../components/Home/Jasa.svelte';
    import Login from '../components/Home/Login.svelte';

    // data
    let search;

    // function
    function mobileNavCheck() {
        const width = document.body.clientWidth;

        if (width < 780) {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebar-overlay').classList.toggle('open');
        }
    }

    let searchProduk = (e) => {
        e.preventDefault();
        navigate('/');
        setTimeout(() => navigate('/produk.html?q=' + search), 1);
    }
</script>

<Router primary={false}>
    <div class="preloader">
        <div class="loader">
            <div class="ytp-spinner">
                <div class="ytp-spinner-container">
                    <div class="ytp-spinner-rotator">
                        <div class="ytp-spinner-left">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                        <div class="ytp-spinner-right">
                            <div class="ytp-spinner-circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="navigation" style="position: sticky; top: 0; right: 0; left: 0; z-index: 1000">
        <header class="navbar-style-7 position-relative">
            <div class="container">
                <div class="navbar-mobile d-lg-none">
                    <div class="row align-items-center">
                        <div class="col-3">
                            <div class="navbar-toggle icon-text-btn">
                                <a class="icon-btn primary-icon-text mobile-menu-open-7" href="#0">
                                    <i class="mdi mdi-menu"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mobile-logo text-center">
                                <a href="/" use:link><img src="{ asset() }logo.png" style="height: 50px;" alt="Logo"></a>
                            </div>
                        </div>
                    </div>
                    <form on:submit={searchProduk} class="navbar-search mt-15 search-style-5">
                        <div class="search-input">
                            <input type="text" placeholder="Cari Produk" bind:value={search}>
                        </div>
                        <div class="search-btn">
                            <button type="submit"><i class="lni lni-search-alt"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="navbar-container navbar-sidebar-7" id="sidebar">
                <div class="navbar-close d-lg-none">
                    <a class="close-mobile-menu-7" href="#0"><i class="mdi mdi-close"></i></a>
                </div>

                <div class="navbar-top-wrapper">
                    <div class="container-lg">
                        <div class="navbar-top d-lg-flex justify-content-between">
                            <div class="navbar-top-left">
                                <!-- <ul class="navbar-top-link">
                                    <li><a href="#0">About</a></li>
                                    <li><a href="#0">Contact</a></li>
                                    <li>
                                        <a href="#0">
                                            <i class="mdi mdi-phone-in-talk"></i>
                                            +8801234567890
                                        </a>
                                    </li>
                                </ul> -->
                            </div>
                            <div class="navbar-top-right">
                                <ul class="navbar-top-link">
                                    <li><a on:click={mobileNavCheck} href="/login.html" use:link><i class="mdi mdi-account"></i>Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="navbar-wrapper">
                    <div class="container-lg">
                        <nav class="main-navbar d-lg-flex justify-content-between align-items-center">
                            <div class="desktop-logo d-none d-lg-block">
                                <a on:click={mobileNavCheck} href="/" use:link><img src="{ asset() }logo.png" style="height: 50px;" alt="Logo"></a>
                            </div>
                            <div class="navbar-menu">
                                <ul class="main-menu">
                                    <li><a use:link on:click={mobileNavCheck} href="/bengkel.html">Bengkel</a></li>
                                    <li><a use:link on:click={mobileNavCheck} href="/produk.html">Produk</a></li>
                                    <li><a use:link on:click={mobileNavCheck} href="/jasa.html">Jasa</a></li>
                                </ul>
                            </div>
                            <form on:submit={searchProduk} class="navbar-search-cart d-none d-lg-flex">
                                <div class="navbar-search search-style-5">
                                    <div class="search-input">
                                        <input type="text" placeholder="Cari Produk" bind:value={search}>
                                    </div>
                                    <div class="search-btn">
                                        <button type="submit"><i class="lni lni-search-alt"></i></button>
                                    </div>
                                </div>
                            </form>
                        </nav>
                    </div>
                </div>
            </div>
            <div id="sidebar-overlay" class="overlay-7"></div>
        </header>
    </div>
    <Route path="/">
        <Index /> 
    </Route>
    <Route path="/bengkel.html">
        <Bengkel /> 
    </Route>
    <Route path="/jasa.html">
        <Jasa /> 
    </Route>
    <Route path="/produk.html" let:location>
        <Produk queryString={location.search} /> 
    </Route>
    <Route path="/produk/:id/detail.html" let:params>
        <ProdukDetail id={params.id} /> 
    </Route>
    <Route path="/login.html">
        <Login /> 
    </Route>
    <section class="footer-style-3 p-3">
        <div class="container">
            <div class="footer-top">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-7 col-sm-10">
                        <h5 class="heading-5 text-center mt-30">Follow Us</h5>
                        <ul class="footer-follow text-center">
                            <li><a href="#0"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="#0"><i class="lni lni-twitter-filled"></i></a></li>
                            <li><a href="#0"><i class="lni lni-linkedin-original"></i></a></li>
                            <li><a href="#0"><i class="lni lni-instagram-original"></i></a></li>
                            <li><a href="#0"><i class="lni lni-whatsapp"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer-copyright text-center">
                <p><a href="https://fopegram.id/" target="_blank">Fopegram</a> &copy; 2021</p>
            </div>
        </div>
    </section>
</Router>