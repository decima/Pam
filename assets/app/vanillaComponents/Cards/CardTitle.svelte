{#if (h1)}
    <h1 class="m-2">
        <slot/>
    </h1>
{/if}
{#if (h2)}
    <h2 class="m-2">
        <slot/>
    </h2>
{/if}
{#if (h3 || (!h1 && !h2 && !h4 && !h5 && !h6))}
    <h3 class="m-2">
        <slot/>
    </h3>
{/if}
{#if (h4)}
    <h4 class="m-2">
        <slot/>
    </h4>
{/if}
{#if (h5)}
    <h5 class="m-2">
        <slot/>
    </h5>
{/if}
{#if (h6)}
    <h6 class="m-2">
        <slot/>
    </h6>
{/if}

<script>
    export let h1 = false;
    export let h2 = false;
    export let h3 = false;
    export let h4 = false;
    export let h5 = false;
    export let h6 = false;
</script>