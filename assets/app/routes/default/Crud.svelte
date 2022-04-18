<script>
    import {Route} from "svelte-navigator";
    export let domain;
    export let list;
    export let edit;
    export let view;
    export let create;
</script>

<Route path="{domain}/*">
    <Route path="/new">
        <svelte:component this={create}/>
    </Route>
    <Route path=":id/*" let:params>
        <Route path="/">
            <svelte:component this={view} id={params.id}/>
        </Route>
        <Route path="/edit">
            <svelte:component this={edit} id={params.id}/>
        </Route>
    </Route>
    <Route path="/">

        <svelte:component this={list}/>
    </Route>
</Route>