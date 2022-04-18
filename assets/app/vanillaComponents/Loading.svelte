{#if loaded}
    <slot/>
    {:else}
    chargement
{/if}

<script>
    export let loaded=false;
</script>