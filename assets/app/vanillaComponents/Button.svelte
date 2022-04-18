<button
        class="p-button"
        class:p-button--base={base}
        class:p-button--positive={positive}
        class:p-button--negative={negative}
        class:p-button--brand={brand}
        class:p-button--link={link}
        class:is-inline={inline}
        class:is-dense={dense}
        class:is-small={small}
        class:has-icon={iconPrefix||iconSuffix}
        disabled="{disabled}"

        on:click
        on:focus
        on:blur
        on:mouseover
        on:mouseleave
        on:mousedown
        on:mouseup

>
    {#if (iconPrefix)}
        <Icon icon="{iconPrefix}"  light></Icon>

    {/if}
    {#if $$slots.default}
        <span><slot/></span>
    {/if}
    {#if (iconSuffix)}
        <Icon icon="{iconSuffix}" light></Icon>
    {/if}

</button>


<script>
    import Icon from "./Icon.svelte";

    export let disabled = false;

    /** layout */
    export let inline = false;

    /** colors */
    export let base = false;
    export let positive = false;
    export let negative = false;
    export let brand = false;
    export let link = false;


    /** sizes */
    export let dense = false;
    export let small = false;

    /** icons*/
    export let iconPrefix = false;
    export let iconSuffix = false;

</script>
