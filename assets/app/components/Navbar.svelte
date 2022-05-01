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

    let expanded = true;
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
        } else {
            navigate(`/tags/new?name=${tag.value}`)

        }
    }

    function handleSize(event) {
        if (window.innerWidth < 768) {
            expanded = false;
        } else {
            expanded = true;
        }
    }
</script>
<svelte:window on:load="{handleSize}" on:resize={handleSize}/>
<div
        class:w-10={!expanded}
        class:w-96={expanded}
        class="transition-all h-screen bg-white dark:bg-slate-800 border-r h-screen absolute md:sticky top-0"
>

    <div class="flex justify-between p-2" class:flex-col={!expanded}>
        <div class="w-6 flex">
            <img src="/pam.svg" class="mx-auto">
            <h1>
                <span class="text-4xl font-black" class:hidden={!expanded}>.Pam</span>
            </h1>
        </div>


        <div on:click={()=>{expanded=!expanded}} class="cursor-pointer hover:bg-slate-100 p-2 rounded-full flex justify-center items-center">
            <div class="w-3.5 h-6">
                <Icon icon="bars"/>
            </div>
        </div>
    </div>
    <div class=" overflow-auto pb-4  " class:hidden={!expanded}>

        <div class="mb-10">
            <h3 class="flex"><span>Tags</span>
                <label class="">
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
</div>


<style>
    h3 {
        @apply border-b border-b-gray-800 mb-2  mx-2 px-1 pb-2 ;
    }

    h3 span {
        @apply font-black uppercase ;
    }
</style>


