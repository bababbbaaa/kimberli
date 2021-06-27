{* Информер избранного (отдаётся аяксом) *}
{if $wished_products|count > 0}
    <a href="{$lang_link}wishlist" data-language="wishlist_header" title="{$lang->wishlist_header}">
        {include file="svg.tpl" svgId="wishlist"}
        <span class="informer_counter">{$wished_products|count}</span>
        <span class="text">{$lang->breadcrumb_wishlist}</span>
    </a>
{else}
    <a data-language="wishlist_header" title="{$lang->wishlist_header}">
        {include file="svg.tpl" svgId="wishlist"}
        <span class="text">{$lang->breadcrumb_wishlist}</span>
    </a>
{/if}
