<script>
    import AssetList from "../../components/AssetList.svelte";
    import {onMount} from "svelte";
    import {tags} from "../../store/tags";
    import Icon from "../../vanillaComponents/Icon.svelte";

    export let id = 0;
    let filter = {"tags.id[1]": id};
    let tag = null
    onMount(async () => {
        tag = await tags.getTag(id)
    })

    function updateTagColor() {
        tags.updateTag(id, tag.color)
    }

</script>
{#if tag}

    <div class="flex  justify-between  rounded-full h-10 w-1/3	" style="color: {tag.color}; ">
        <label class=" rounded-l-full grow" style="background-color:{tag.color};">
            <input type="color" bind:value={tag.color}
                   class=" w-0 h-0 opacity-0"
                   on:change={updateTagColor}>
        </label>
        <h2 class="capitalize text-2xl mx-8 ">{tag.name}

        </h2>
        <label class=" hover:brightness-125 cursor-pointer rounded-r-full grow" style="background-color:{tag.color};">



            <input type="color" bind:value={tag.color}
                   class=" w-0 h-0 opacity-0"
                   on:change={updateTagColor}>

        </label>
    </div>

{/if}
<AssetList filters={filter}></AssetList>

