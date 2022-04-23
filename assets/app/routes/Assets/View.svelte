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
    import AutocompleteTagInput from "../../components/AutocompleteTagInput.svelte";

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
        const tagElement = event.detail
        if (tagElement.value.trim().length > 0) {
            await Asset.addTag(id, tagElement.value.trim())
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
        navigate(`/tags/${tag}`)
    }

    function gotoNext() {
        if (pagination.next != null) {

            navigate('/assets/' + pagination?.next?.id + "?" + queryParameters.stringify(currentParams))
        }
    }

    function gotoCatalog() {
        console.log(pagination)
    }

    function gotoPrevious() {
        if (pagination.previous != null) {
            navigate('/assets/' + pagination?.previous?.id + "?" + queryParameters.stringify(currentParams))
        }
    }

    async function suggestTag(inputUsed) {
        const r =  await tags.autocomplete(inputUsed);
        let result = [];
        for (let i = 0; i < r["hydra:member"].length; i++) {
            result.push(r["hydra:member"][i].name)
        }
        return result;
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
            <Tag color={tag.color} foregroundColor={tag.foregroundColor} on:click={()=>{viewTag(tag.id)}}>{tag.name}
                <span slot="after" on:click={()=>{detachTag(tag)}}><Icon icon="xmark"/></span>
            </Tag>
        {/each}
        <span class="border p-2">
        <Icon icon="tag"/>


            <AutocompleteTagInput bind:tagInput on:select={addTag}  bind:newTag bind:enableFullKeyboardUsage />


        </span>
    </Loading>
</div>