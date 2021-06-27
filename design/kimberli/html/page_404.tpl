{* The template of page 404 *}
    {* The page heading
    <div class="wrap_blog_heading_page">
        <h1 class="heading_page">
            <span data-page="{$page->id}">{$page->name|escape}</span>
        </h1>
    </div>*}
    
    {* The page content *}
    <div class="block padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-5">
        {$page->description}
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="menu_404">
            <div class="text_404">
                <span data-language="page404_text">{$lang->page404_text}</span>
            </div>
            {* 404 menu *}
            {$menu_404}
        </div>
    </div>
</div>
    </div>
</div>