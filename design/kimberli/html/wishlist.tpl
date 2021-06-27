{* page title *}
{$meta_title = $lang->wishlist_title scope=parent}

{* Page heading *}
<div class="wrap_blog_heading_page">
    <h1 class="heading_page">
        <span data-language="wishlist_header">{$lang->wishlist_header}</span>
    </h1>
</div>

{if $page->description}
    <div class="block padding">
        {$page->description}
    </div>
{/if}

{if $wished_products|count}
    <div class="fn_wishlist_page wish_products clearfix">
        {* Список избранных товаров *}
        {foreach $wished_products as $product}
            <div class="products_item col-sm-6 col-lg-3 col-xl-25">
                {include "product_list.tpl"}
            </div>
        {/foreach}
    </div>
{else}
    <div class="block padding">
        <span data-language="wishlist_empty">{$lang->wishlist_empty}</span>
    </div>
{/if}