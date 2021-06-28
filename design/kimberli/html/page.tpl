{* Page template *}

{* The canonical address of the page *}
{$canonical="/{$page->url}" scope=parent}

{if $page->url == '404'}
    {include file='page_404.tpl'}
{else}
    <div class="wrap_heading_page mb-2" {if $page->image} style="background: rgb(36, 38, 38) url({$page->image|resize:1920:539:false:$config->resized_pages_dir});" {/if}>
        <div class="inner_heading_page txt_center">
            <h1 class="heading_page">
                  <span data-page="{$page->id}">{if $page->name_h1|escape}{$page->name_h1|escape}{else}{$page->name|escape}{/if}</span>
            </h1>
            <img class="border" src="design/{$settings->theme|escape}/images/heading_border.png" alt="page_border">
        </div>
    </div>
    <div class="page_container1">
         {if $dop_files_header}
            {*$dop_files_header*}
        {/if}
        {* The page heading *}
       {* <div class="wrap_blog_heading_page">
            <h1 class="heading_page">
                <span data-page="{$page->id}">{if $page->name_h1|escape}{$page->name_h1|escape}{else}{$page->name|escape}{/if}</span>
            </h1>
        </div>*}

        {if $page->content}
            {$page->content}
        {else}
            {* The page content *}
            <div class="admin_formated" style="padding-top: 20px;">
                {$page->description}
            </div>
            {if $dop_files_footer}
                {$dop_files_footer}
            {/if}
        {/if}
    </div>
         {if $compilation }
             <div class="page_compilation">
            {* Product list *}
            <div id="fn_products_content" class="fn_categories products clearfix">
                {include file="compilation/products_content.tpl"}
            </div>
            </div>
        {/if}
{/if}
