{* Cart informer (given by Ajax) *}
{*if $cart->total_products > 0*}
    {*{$lang_link}cart*}
    <a href="#fn_cart" class="cart_info fn_cart" data-language="index_cart" title="{$lang->index_cart}">
        {include file="svg.tpl" svgId="shopping_cart_plus"}
        <span class="informer_counter cart_counter">{$cart->total_products}</span>
        {*<span class="cart_total">{($cart->total_price)|convert} {$currency->sign|escape}</span>*}
    </a>
        {*
{else}
    <div class="cart_info"  data-language="index_cart" title="{$lang->index_cart}">
        {include file="svg.tpl" svgId="shopping_cart"}
    </div>
{/if}*}
