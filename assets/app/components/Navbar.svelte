<script>
    import Tree from "../vanillaComponents/Tree/Tree.svelte";
    import {onMount} from "svelte";
    import {categories} from "../store/categoryTree";
    import NavbarTreeGroup from "./NavbarTreeGroup.svelte";

    onMount(() => {
        categories.load()
    })
</script>

<div class="h-full overflow-auto">
    <Tree>
        {#each $categories["hydra:member"] as category}
            <NavbarTreeGroup category={category}/>
        {/each}
    </Tree>
</div>

