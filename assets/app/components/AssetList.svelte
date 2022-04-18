<Loading loaded={!$AssetPage.loading}>

    <FilterBar bind:itemsPerPage={perPage} on:change={calculateFilter}></FilterBar>
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

    <Row>
        {#each $AssetPage["hydra:member"] as item}

            <Col>
                <Asset item="{item}"/>
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
    import Asset from "./AssetCard.svelte";
    import {onMount} from "svelte";
    import {AssetPage} from "../store/assets";
    import {queryParameters} from "../store/queryParametersUtils";
    import Pagination from "../vanillaComponents/Paginations/Pagination.svelte";
    import Loading from "../vanillaComponents/Loading.svelte";
    import FilterBar from "./FilterBar.svelte";
    import {userPreferences} from "../store/userPreferences";

    let currentPage
    let maxNumberOfPages
    let perPage
    let totalItems

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
        AssetPage.load(params)

    })

    function changeURL(newURL) {
        const params = queryParameters.parseUrl(newURL)
        delete params["category[]"];
        queryParameters.navigate(params)
    }

    async function previousPage() {
        const newURL = await AssetPage.previousPage()
        changeURL(newURL)
    }

    async function nextPage() {
        const newURL = await AssetPage.nextPage()
        changeURL(newURL)

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
</script>
