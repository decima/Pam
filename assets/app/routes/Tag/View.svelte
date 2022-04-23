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
    <div class="w-full flex  justify-between	" style="border-bottom-color: {tag.color}; color: {tag.color}; background-color:{tag.foregroundColor}; ">
        <h2 class="uppercase">
            <label class="text-5xl ">{tag.name}</label>

        </h2>
        <label class="flex hover:brightness-125 cursor-pointer" style="background-color:{tag.color};">
            <input type="color" bind:value={tag.color}
                   class="w-5 h-6 absolute opacity-0"
                   on:change={updateTagColor}>

            <svg width="192" height="100" viewBox="180 0 192 265" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M149 265C46.5 90.5 283.5 174.5 149 0.5H0V265H149Z" fill={tag.foregroundColor}/>
            </svg>
            <span class="mx-2 my-2" style="color:{tag.foregroundColor}">change color</span>
        </label>
    </div>

{/if}
<AssetList filters={filter}></AssetList>

