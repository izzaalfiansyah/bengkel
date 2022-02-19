<script>
    export let now = 0;
    export let total = 0;

    export let action = () => console.log('pagination action');
</script>
<nav>
    <ul class="pagination pagination-primary float-end float-right">
        <li class="page-item">
            <a class="page-link" href="#0" on:click="{() => { now = 1; action() }}">
                <span aria-hidden="true">
                    &laquo;
                </span>
            </a>
        </li>
        <li class="page-item">
            {#if now > 1}
                <a class="page-link" href="#0" on:click="{() => { now -= 1; action(); }}">
                    <span aria-hidden="true">
                        &lsaquo;
                    </span>
                </a>
            {:else}
                <a class="page-link" href="#0" on:click="{() => { false }}">
                    <span aria-hidden="true">
                        &lsaquo;
                    </span>
                </a>
            {/if}
        </li>
        <li class="page-item">
            {#if now < total}
                <a class="page-link" href="#0" on:click="{() => { now += 1; action(); }}">
                    <span aria-hidden="true">
                        &rsaquo;
                    </span>
                </a>
            {:else}
                <a class="page-link" href="#0" on:click="{() => { false }}">
                    <span aria-hidden="true">
                        &rsaquo;
                    </span>
                </a>
            {/if}
        </li>
        <li class="page-item">
            <a class="page-link" href="#0" on:click="{() => { now = total; action() }}">
                <span aria-hidden="true">
                    &raquo;
                </span>
            </a>
        </li>
    </ul>
</nav>