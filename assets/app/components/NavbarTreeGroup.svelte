
{#if category.children.length > 0}
    <TreeGroup title={category.name} on:click={()=>navigate("/categories/"+category.id)}>
        {#each category.children as child}
            <NavbarTreeGroup category={child}/>
        {/each}
    </TreeGroup>
{:else}
    <TreeLeaf  on:click={()=>navigate("/categories/"+category.id)}>{category.name}</TreeLeaf>

{/if}

<script>
    import TreeGroup from "../vanillaComponents/Tree/TreeGroup.svelte";
    import TreeLeaf from "../vanillaComponents/Tree/TreeLeaf.svelte";
    import NavbarTreeGroup from "./NavbarTreeGroup.svelte";
    import {navigate} from "svelte-navigator";

    export let category = {name: "", children: []};
</script>