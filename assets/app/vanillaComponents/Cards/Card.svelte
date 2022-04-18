<div class="p-card  u-no-padding">

    {#if (cover)}
        <img class="p-card__image" src="{cover}">

    {/if}
    <div>
        <slot/>
    </div>


</div>
<script>
    export let cover = false;
</script>