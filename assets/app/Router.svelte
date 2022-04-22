<Router>
    <div class="min-h-screen flex flex-row flex-auto flex-shrink-0 antialiased bg-slate-200 text-slate-800">
        <div class="w-96 bg-white border-r h-screen sticky top-0">
            <Navbar></Navbar>
        </div>

        <main class="w-full  bg-white  m-10 p-10 rounded-lg shadow">
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
            <Crud domain="tag"
                  edit="{Tag.List}"
                  view="{Tag.View}"
                  list="{Tag.List}"
                  create="{Tag.List}"/>
        </main>
    </div>
</Router>


<script>
    import {Route, Router} from "svelte-navigator";
    import Category from "./routes/Category/actions.js";
    import Asset from "./routes/Assets/actions.js";
    import Tag from "./routes/Tag/actions.js";
    import Crud from "./routes/default/Crud.svelte";
    import Navbar from "./components/Navbar.svelte";
</script>
