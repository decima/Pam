<script>
    import AssetList from "../../components/AssetList.svelte";
    import {onMount} from "svelte";
    import {category} from "../../store/category";


    export let id = 0;
    export let filter = {};
    let categoriesToFilter = null;
    onMount(async () => {
        categoriesToFilter = await category.getWithAllDescendants(id);
        for (let i = 0; i < categoriesToFilter.length; i++) {
            filter["category["+i+"]"] = categoriesToFilter[i];
        }
    })

</script>
{#if categoriesToFilter}
    <AssetList filters={filter}></AssetList>
{/if}
