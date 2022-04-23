<Router>
    <div class="min-h-screen flex flex-row flex-auto flex-shrink-0 antialiased bg-slate-200 dark:bg-slate-500 text-slate-800 dark:text-slate-50">
        <div class="w-96 bg-white dark:bg-slate-800 border-r h-screen sticky top-0">
            <Navbar></Navbar>
        </div>

        <main class="w-full  bg-white dark:bg-slate-800  m-10 p-10 rounded-lg shadow">
            <Route path="/">
            </Route>
            <Crud domain="categories"
                  edit="{Category.Edit}"
                  view="{Category.View}"
                  list="{Category.List}"
                  create="{Category.Create}"/>
            <Crud domain="assets"
                  edit="{Asset.Edit}"
                  view="{Asset.View}"
                  list="{Asset.List}"
                  create="{Asset.Create}"/>
            <Crud domain="tags"
                  edit="{Tag.List}"
                  view="{Tag.View}"
                  list="{Tag.List}"
                  create="{Tag.Create}"/>
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
