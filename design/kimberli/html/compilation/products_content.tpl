{if $compilation}
    {foreach $compilation as $product}
        <div class="no_padding products_item col-sm-6 col-md-4 col-lg-4 col-xl-3">
            {include file="product_list.tpl"}
        </div>
    {/foreach}
{else}
    <div class="boxed boxed_notify">
        <span data-language="products_not_found">{$lang->products_not_found}</span>
    </div>
{/if}