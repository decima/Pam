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
    <div class="border-b-8 w-full" style="border-bottom-color: {tag.color}; color: {tag.color}; ">
        <h2 class="text-5xl uppercase font-black">{tag.name}
            <label class="absolute text-xl">
                <Icon icon="palette"/>
                <input type="color" id="colorPicker" bind:value={tag.color}
                       class="w-5 h-6 absolute opacity-0"
                on:change={updateTagColor}>
            </label>
        </h2>
    </div>

{/if}
<AssetList filters={filter}></AssetList>

