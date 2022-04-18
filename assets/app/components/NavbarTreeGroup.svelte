
{#if category.children.length > 0}
    <TreeGroup title={category.name} on:click={()=>navigate("/category/"+category.id)}>
        {#each category.children as child}
            <NavbarTreeGroup category={child}/>
        {/each}
    </TreeGroup>
{:else}
    <TreeLeaf  on:click={()=>navigate("/category/"+category.id)}>{category.name}</TreeLeaf>

{/if}

<script>
    import TreeGroup from "../vanillaComponents/Tree/TreeGroup.svelte";
    import TreeLeaf from "../vanillaComponents/Tree/TreeLeaf.svelte";
    import NavbarTreeGroup from "./NavbarTreeGroup.svelte";
    import Button from "../vanillaComponents/Button.svelte";
    import Icon from "../vanillaComponents/Icon.svelte";
    import {navigate} from "svelte-navigator";

    export let category = {name: "", children: []};
</script>