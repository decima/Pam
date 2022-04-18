<div class="border w-1/3 mx-auto my-6">
    <img class="mx-auto" src="/api/assets/{id}/show"/>
</div>

<div class="mx-auto w-1/3">
    <Loading loaded={!$Asset.loading}>
        <h1 class="text-3xl">
            {$Asset.name}
        </h1>
        <p>{$Asset.category.name}</p>
        {#each $Asset.tags as tag}
            <Tag color={tag.color} on:click={()=>{viewTag(tag)}}>{tag.name}
                <span slot="after" on:click={()=>{detachTag(tag)}}><Icon icon="xmark"/></span>
            </Tag>
        {/each}
        <input on:keydown={addTag} placeholder="add tag..."/>
    </Loading>
</div>

<script>
    import {onMount} from "svelte";
    import {Asset} from "../../store/assets";
    import Loading from "../../vanillaComponents/Loading.svelte";
    import Tag from "../../vanillaComponents/Tags/Tag.svelte";
    import Icon from "../../vanillaComponents/Icon.svelte";

    export let id;
    onMount(async () => {
        await Asset.load(id)
    })

    async function detachTag(tag) {
        await Asset.detachTag(id, tag.id)
        await Asset.load(id)
    }

    async function addTag(e) {
        if (e.keyCode === 13) {
            let tag = e.target.value;
            e.target.value = "";
            await Asset.addTag(id, tag)
            await Asset.load(id)

        }

    }


    function viewTag(tag) {

    }

</script>