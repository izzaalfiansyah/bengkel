<script>
    import { url, asset, http, getWhatsapp } from '../../app';
    import { onMount } from 'svelte';
    import Section from './Section.svelte';
    import Table from '../Table.svelte';

    // data
    let data = [];
    let search = '';
    let whatsapp = '';

    // function
    let get = () => {
        http.get('api/jasa?search=' + search).then(res => {
            data = res.data;
        });
    }

    onMount(async () => {
        await getWhatsapp().then(res => {
            whatsapp = res.data.number[0] == '0' ? '62' + res.data.number.slice(1) : res.data.number;
        });
        await get();
    })
</script>
<Section title="Jasa">
    <div class="p-4 bg-white shadow-sm">
        <div class="row justify-content-end">
            <div class="col-md-4">
                <input type="text" placeholder="Cari" class="form-control" bind:value={search} on:input={get}>
            </div>
        </div>
        <Table head="{['No', 'Nama Jasa', 'Harga', 'Opsi']}">
            {#each data as item, i}
                <tr>
                    <td>{i + 1}</td>
                    <td>{item.nama}</td>
                    <td>IDR {item.harga.toLocaleString('id-ID')}</td>
                    <td class="text-center">
                        <a href="https://api.whatsapp.com/send?phone={whatsapp}&text={encodeURIComponent('saya ingin jasa ' + item.nama + ' yang saya ketahui dari situs ' + url() + '.')}" target="_blank" class="btn btn-sm btn-success">
                            Pesan
                        </a>
                    </td>
                </tr>
            {/each}
        </Table>
    </div>
</Section>