<script>
    import {onMount, onDestroy} from "svelte";
    import {Asset} from "../../store/assets";
    import Loading from "../../vanillaComponents/Loading.svelte";
    import Tag from "../../vanillaComponents/Tags/Tag.svelte";
    import Icon from "../../vanillaComponents/Icon.svelte";
    import NextPreviousPagination from "../../vanillaComponents/Paginations/NextPreviousPagination.svelte";
    import {navigate} from "svelte-navigator";
    import {queryParameters} from "../../store/queryParametersUtils";
    import AutocompleteInput from "../../vanillaComponents/Autocomplete/AutocompleteInput.svelte";
    import {tags} from "../../store/tags";

    let tagInput;
    export let id;
    let enableFullKeyboardUsage = false;
    let currentParams = {};
    let pagination = {next: null, previous: null};
    onMount(async () => {
        let params = queryParameters.get();
        currentParams = params;
        document.addEventListener("keydown", keybinding)
        await Asset.load(id)
        pagination = await Asset.getPaginations(id, queryParameters.stringify(params))
        tagInput.focus()

    })
    onDestroy(async () => {
        document.removeEventListener("keydown", keybinding)

    })

    async function detachTag(tag) {
        await Asset.detachTag(id, tag.id)
        await Asset.load(id)
    }

    async function addTag(event) {
        const tag = event.detail
        if (tag.trim().length > 0) {
            await Asset.addTag(id, tag.trim())
            await Asset.load(id)
        }

    }


    async function keybinding(e) {

        switch (e.key) {
            case "ArrowRight":
                if (enableFullKeyboardUsage && newTag.trim().length > 0) return;
                await gotoNext();
                break;
            case "ArrowLeft":
                if (enableFullKeyboardUsage && newTag.trim().length > 0) return;

                await gotoPrevious();
                break;
            case "t":
                if (enableFullKeyboardUsage) return;
                tagInput.focus();
                enableFullKeyboardUsage = true;
                e.preventDefault()
                break;
            case "Escape":
                console.log(tagInput.autocompletionClosed());
                if (tagInput.autocompletionClosed()) {

                    tagInput.blur()
                    gotoCatalog();
                }
                break;
            default:
            //console.log(e.key)
        }
    }

    function viewTag(tag) {
        navigate(`/tag/${tag}`)
    }

    function gotoNext() {
        if (pagination.next != null) {

            navigate('/asset/' + pagination?.next?.id + "?" + queryParameters.stringify(currentParams))
        }
    }

    function gotoCatalog() {
        console.log(pagination)
    }

    function gotoPrevious() {
        if (pagination.previous != null) {
            navigate('/asset/' + pagination?.previous?.id + "?" + queryParameters.stringify(currentParams))
        }
    }

    async function suggestTag(inputUsed) {
        return await tags.autocomplete(inputUsed);
    }

    let newTag = "";

</script>


<div class="border w-1/3 mx-auto my-6">
    <img class="mx-auto" src="/api/assets/{id}/show"/>

</div>

<div class="mx-auto w-1/3">
    <div class="h-16">
        {#if (pagination.loading === false)}
            <NextPreviousPagination on:clickNext={gotoNext} on:clickPrevious={gotoPrevious} hasNext={pagination.next!=null} hasPrevious={pagination.previous!=null}>
                {pagination.currentIndex + 1} / {pagination.total}
            </NextPreviousPagination>
        {/if}
    </div>

    <Loading loaded={!$Asset.loading}>
        <h1 class="text-3xl">
            {$Asset.name}
        </h1>
        <p>{$Asset.category.name}</p>
        {#each $Asset.tags as tag}
            <Tag color={tag.color} on:click={()=>{viewTag(tag.id)}}>{tag.name}
                <span slot="after" on:click={()=>{detachTag(tag)}}><Icon icon="xmark"/></span>
            </Tag>
        {/each}
        <span class="border p-2">
        <Icon icon="tag"/>
        <AutocompleteInput placeholder="add tag" bind:this={tagInput} autocompletion={suggestTag} on:select={addTag} bind:value={newTag} on:blur={()=>{enableFullKeyboardUsage=false}} on:focus={()=>{enableFullKeyboardUsage=true}}/>
        </span>
    </Loading>
</div>