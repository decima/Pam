<Router>


    <div class="flex w-full">
        <div class="w-96 h-screen shadow">
            <Navbar></Navbar>
        </div>

        <main class="w-full mx-4">
            <Route path="/">
            </Route>
            <Crud domain="category"
                  edit="{Category.Edit}"
                  view="{Category.View}"
                  list="{Category.List}"
                  create="{Category.Create}"/>
            <Crud domain="asset"
                  edit="{Asset.Edit}"
                  view="{Asset.View}"
                  list="{Asset.List}"
                  create="{Asset.Create}"/>
        </main>
    </div>
</Router>


<script>
    import {Route, Router} from "svelte-navigator";
    import Category from "./routes/Category/actions.js";
    import Asset from "./routes/Assets/actions.js";
    import Crud from "./routes/default/Crud.svelte";
    import Navbar from "./components/Navbar.svelte";
</script>
