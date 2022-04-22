<script>
    import Tree from "../vanillaComponents/Tree/Tree.svelte";
    import {onMount} from "svelte";
    import {categories} from "../store/categoryTree";
    import NavbarTreeGroup from "./NavbarTreeGroup.svelte";
    import Tag from "../vanillaComponents/Tags/Tag.svelte";
    import Row from "../vanillaComponents/grid/Row.svelte";

    onMount(() => {
        categories.load()
    })
</script>


<div class="h-screen overflow-auto pb-4  ">
    <div class="mb-10">
        <h3>Tags</h3>

        <Tag>Lorem</Tag>
        <Tag>ipsum</Tag>
        <Tag>dolor</Tag>
        <Tag>sit</Tag>
        <Tag>amet</Tag>
    </div>

    <h3>Categories</h3>
    <Tree>
        {#each $categories["hydra:member"] as category}
            <NavbarTreeGroup category={category}/>
        {/each}
    </Tree>
</div>

<style>
    h3 {
        @apply font-black mx-2 px-1 pb-2 border-b border-b-gray-800 uppercase mb-2;
    }
</style>

