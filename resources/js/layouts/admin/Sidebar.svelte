<script>
    import { onMount } from 'svelte'
    import { asset, user as getUser } from '$app'
    import { link } from 'svelte-navigator'

    export let handleSidebar

    let user = {
        level: '1'
    }

    onMount(async () => {
        await getUser().then(res => {
            user = res.data
        })
    })
</script>

<nav id="sidebar" class="sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" on:click={handleSidebar} href="/admin/dashboard.html" use:link>
            <img src="{asset()}/logo.png" alt="" style="max-width: 100%;">
          <!-- <span class="align-middle">{nick}</span> -->
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Main Menu
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" on:click={handleSidebar} href="/admin/dashboard.html" use:link>
                  <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            {#if user.level == '1' || user.level == '2'}
                <li class="sidebar-item" hidden="true">
                    <a class="sidebar-link" on:click={handleSidebar} href="/admin/bengkel.html" use:link>
                      <i class="align-middle" data-feather="credit-card"></i> <span class="align-middle">Bengkel</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link" on:click={handleSidebar} href="/admin/user.html" use:link>
                      <i class="align-middle" data-feather="users"></i> <span class="align-middle">User</span>
                    </a>
                </li>
            {/if}

            {#if user.level !== '4'}
                <li class="sidebar-item">
                    <a href="#data" data-bs-toggle="collapse" class="sidebar-link collapsed">
                      <i class="align-middle" data-feather="coffee"></i> <span class="align-middle">Data Bengkel</span>
                    </a>
                    <ul id="data" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                        <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/part.html">Data Part</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/jasa.html">Data Jasa</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/supplier.html">Data Supplier</a></li>
                        <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/teknisi.html">Data Teknisi</a></li>
                    </ul>
                </li>
            {/if}

            <li class="sidebar-item">
                <a href="#transaksi" data-bs-toggle="collapse" class="sidebar-link collapsed">
                  <i class="align-middle" data-feather="briefcase"></i> <span class="align-middle">Penjualan</span>
                </a>
                <ul id="transaksi" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/pelanggan.html">Pelanggan</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/kendaraan.html">Kendaraan</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/transaksi.html">Produk & Jasa</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/estimasi.html">Estimasi</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/invoice.html">Invoice</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/work-order.html">Work Order</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" on:click={handleSidebar} href="/admin/kas.html" use:link>
                  <i class="align-middle" data-feather="book"></i> <span class="align-middle">Kas</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="#laporan" data-bs-toggle="collapse" class="sidebar-link collapsed">
                  <i class="align-middle" data-feather="map"></i> <span class="align-middle">Laporan</span>
                </a>
                <ul id="laporan" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
                    <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/laporan/kas.html">Arus Kas</a></li>
                    <li class="sidebar-item"><a class="sidebar-link" use:link on:click={handleSidebar} href="/admin/laporan/penjualan.html">Penjualan & Service</a></li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" on:click={handleSidebar} href="/admin/akun.html" use:link>
                  <i class="align-middle" data-feather="user"></i> <span class="align-middle">Akun</span>
                </a>
            </li>

            {#if user.level == '1'}
                <li class="sidebar-item">
                    <a class="sidebar-link" on:click={handleSidebar} href="/admin/pengaturan.html" use:link>
                      <i class="align-middle" data-feather="tool"></i> <span class="align-middle">Pengaturan</span>
                    </a>
                </li>
            {/if}
            
    </div>
</nav>