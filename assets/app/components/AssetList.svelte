<Loading loaded={!$AssetPage.loading}>

    <Pagination
            hydraView={$AssetPage["hydra:view"]}
            bind:totalItems
            bind:currentPage
            bind:maxNumberOfPages
            on:clickNext={nextPage}
            on:clickPrevious={previousPage}
            on:clickFirst={firstPage}
            on:clickLast={lastPage}
    />

    <div class="flex">
        <div class="mr-2">
            <FilterBar bind:itemsPerPage={perPage} on:change={calculateFilter} on:selectAll={()=>toggleAll(true)} on:deselectAll={()=>toggleAll(false)} on:select={tagSelection}></FilterBar>
        </div>

    </div>

    <Row>
        {#each $AssetPage["hydra:member"] as item}
            <Col>
                <AssetCard item={item} checked={allChecked} on:click={()=>{gotoAsset(item.id)}} on:check={()=>addToCheck(item)} on:uncheck={()=>removeFromCheck(item)} clickForCheck={checkOnly}/>
            </Col>
        {/each}

    </Row>
    <Pagination
            hydraView={$AssetPage["hydra:view"]}
            bind:totalItems
            bind:currentPage
            bind:maxNumberOfPages
            on:clickNext={nextPage}
            on:clickPrevious={previousPage}
            on:clickFirst={firstPage}
            on:clickLast={lastPage}
    />


</Loading>
<script>
    import Row from "../vanillaComponents/grid/Row.svelte";
    import Col from "../vanillaComponents/grid/Col.svelte";
    import {onMount} from "svelte";
    import {Asset, AssetPage} from "../store/assets";
    import {queryParameters} from "../store/queryParametersUtils";
    import Pagination from "../vanillaComponents/Paginations/Pagination.svelte";
    import Loading from "../vanillaComponents/Loading.svelte";
    import FilterBar from "./FilterBar.svelte";
    import {userPreferences} from "../store/userPreferences";
    import {navigate} from "svelte-navigator";
    import AssetCard from "./AssetCard.svelte";

    let currentPage
    let maxNumberOfPages
    let perPage
    let totalItems
    let currentParams = {};
    let checkedAssets = [];
    let checkOnly = false;


    function toggleAll(shouldCheck) {
        if (shouldCheck) {
            if ($AssetPage["hydra:member"].length > checkedAssets.length)
                allChecked = false;
            setTimeout(() => {
                allChecked = true;
                checkOnly = true
            }, 10)
        } else {
            if (checkedAssets.length > 0)
                allChecked = true;
            setTimeout(() => {
                allChecked = false;
                checkOnly = false
            }, 10)
        }
    }

    export let filters = {};
    AssetPage.subscribe(async (state) => {
        if (!state["hydra:view"]) {
            return;
        }
        const id = state["hydra:view"]["@id"]
        totalItems = state["hydra:totalItems"]
        const props = queryParameters.parseUrl(id)
        currentPage = props.page || 1;
        perPage = props.itemsPerPage || 24;
        maxNumberOfPages = Math.ceil(totalItems / perPage);
    });
    onMount(() => {
        let params = queryParameters.get();
        params = {...params, ...filters}
        perPage = $userPreferences.itemsPerPage;
        params.itemsPerPage = params.itemsPerPage || perPage;
        currentParams = params;
        AssetPage.load(params)

    })

    function changeURL(newURL) {
        const params = queryParameters.parseUrl(newURL)
        currentParams = params;
        delete params["category[]"];
        queryParameters.navigate(params)
        setTimeout(() => toggleAll(false), 10)
    }

    async function previousPage() {
        const newURL = await AssetPage.previousPage()
        changeURL(newURL)
    }

    async function nextPage() {
        const newURL = await AssetPage.nextPage()
        changeURL(newURL)

    }

    async function tagSelection(event) {
        const tag = event.detail;
        if (tag.value.trim().length > 0) {
            for (let i = 0; i < checkedAssets.length; i++) {
                await Asset.addTag(checkedAssets[i].id, tag.value.trim())
            }
        }
        alert(`Tag ${tag.value} added to ${checkedAssets.length} assets`)
        toggleAll(false);

    }

    async function firstPage() {
        const newURL = await AssetPage.firstPage()
        changeURL(newURL)

    }

    async function lastPage() {
        const newURL = await AssetPage.lastPage()
        changeURL(newURL)
    }

    function calculateFilter() {
        let params = queryParameters.get();
        params = {...params, ...filters}
        params.itemsPerPage = perPage
        AssetPage.load(params)
    }

    function gotoAsset(id) {
        const str = queryParameters.stringify(currentParams)

        navigate(`/assets/${id}?${str}`);
    }

    function addToCheck(item) {
        checkedAssets = [...checkedAssets, item];
        checkOnly = true;
    }

    function removeFromCheck(item) {
        checkedAssets = checkedAssets.filter(i => i.id !== item.id);
        if (checkedAssets.length === 0) {
            checkOnly = false;
        }

    }

    let allChecked = false;
</script>
