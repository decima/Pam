<Router primary={false}>
    <div class="min-h-screen flex flex-row flex-auto flex-shrink-0 antialiased bg-slate-200 dark:bg-slate-500 text-slate-800 dark:text-slate-50">
        <Navbar/>
        <div class="p-2 md:p-10  ml-10 md:ml-0 w-full ">
            <main class=" bg-white dark:bg-slate-800  p-10 rounded-lg shadow">
                <Route path="/">
                    <About/>
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
    </div>
</Router>


<script>
    import {Route, Router} from "svelte-navigator";
    import Category from "./routes/Category/actions.js";
    import Asset from "./routes/Assets/actions.js";
    import Tag from "./routes/Tag/actions.js";
    import Crud from "./routes/default/Crud.svelte";
    import Navbar from "./components/Navbar.svelte";
    import About from "./routes/About.svelte";
</script>
