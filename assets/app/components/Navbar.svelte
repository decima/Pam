<script>
    import Tree from "../vanillaComponents/Tree/Tree.svelte";
    import {onMount} from "svelte";
    import {categories} from "../store/categoryTree";
    import NavbarTreeGroup from "./NavbarTreeGroup.svelte";
    import Tag from "../vanillaComponents/Tags/Tag.svelte";
    import Row from "../vanillaComponents/grid/Row.svelte";
    import {tags} from "../store/tags";
    import {navigate} from "svelte-navigator";
    import AutocompleteTagInput from "./AutocompleteTagInput.svelte";
    import Icon from "../vanillaComponents/Icon.svelte";


    let tagList = [];
    onMount(async () => {
        await categories.load()

        const result = await tags.topTags();
        tagList = result["hydra:member"];
    })

    function onSelect(tagEvent) {
        const tag = tagEvent.detail;
        console.log(tagEvent)
        if (tag.key !== -1) {
            navigate(`/tags/${tag.key}`)
        }else{
            navigate(`/tags/new?name=${tag.value}`)

        }
    }
</script>


<div class="h-screen overflow-auto pb-4  ">
    <div class="mb-10">
        <h3><span>Tags</span>
            <label class="float-right">
                <Icon icon="magnifying-glass"/>
                <AutocompleteTagInput on:select={onSelect} on:right={onSelect}/>
            </label>
        </h3>
        {#each tagList as tag}
            <Tag color="{tag.color}" foregroundColor={tag.foregroundColor} on:click={()=>{navigate("/tags/"+tag.id)}}>{tag.name}</Tag>
        {/each}

    </div>

    <h3><span>Categories</span></h3>
    <Tree>
        {#each $categories["hydra:member"] as category}
            <NavbarTreeGroup category={category}/>
        {/each}
    </Tree>
</div>

<style>
    h3{
       @apply border-b border-b-gray-800 mb-2  mx-2 px-1 pb-2 ;
    }
    h3 span {
        @apply font-black uppercase ;
    }
</style>


