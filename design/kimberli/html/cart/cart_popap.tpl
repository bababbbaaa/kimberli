{if $cart->purchases}
    {* The page heading *}
    <div class="wrap_blog_heading_page">
        <p class="heading_page">
            <span data-language="cart_header">{$lang->cart_header}</span>
        </p>
    </div>

    <table class="purchase">
        <thead class="mobile-hidden">
        <tr>
            <th colspan="2" class="text-xs-left" data-language="cart_head_name">{$lang->cart_head_name}</th>
            <th data-language="cart_head_amoun">{$lang->cart_head_amoun}</th>
            <th class="hidden-sm-down" data-language="cart_head_total">{$lang->cart_head_total}</th>
            <th></th>
        </tr>
        </thead>

        {foreach $cart->purchases as $purchase}
            <tr>
                {* Product image *}
                <td class="purchase_image">
                    <a href="{$lang_link}products/{$purchase->variant->url}">
                        {if $purchase->product->image}
                            <img src="{$purchase->product->image->filename|resize:90:90}" alt="{$purchase->product->name|escape}" title="{$purchase->product->name|escape}">
                        {else}
                            <img width="90" height="90" src="design/{$settings->theme}/images/no_image.png" alt="{$purchase->product->name|escape}" title="{$purchase->product->name|escape}">
                        {/if}
                    </a>
                </td>

                {* Product name *}
                <td class="purchase_name_box text-md-left">
                    <a class="purchase_name" href="{$lang_link}products/{$purchase->variant->url}">{$purchase->product->name|escape}</a>
                    {if $purchase->variant->stock > 0}
                        {* Price per unit *}
                        <div class="purchase_name_price hidden-sm-down">{($purchase->variant->price)|convert} {$currency->sign} {if $purchase->variant->units}/ {$purchase->variant->units|escape}{/if}</div>

                        {* Extended price *}
                        <div class="purchase_sum hidden-md-up">
                            <span class="nowrap">{($purchase->variant->price*$purchase->amount)|convert} {$currency->sign}</span>
                        </div>
                    {/if}
                </td>

                {* Quantity *}
                <td class="purchase_amount">
                    <div class="fn_product_amount{if $settings->is_preorder} fn_is_preorder{/if} amount">
                        <input class="input_amount" type="text" data-id="{$purchase->variant->id}" name="amounts[{$purchase->variant->id}]" value="{$purchase->amount}" onblur="ajax_change_amount(this, {$purchase->variant->id});" data-max="{$purchase->variant->stock}">
                    </div>
                </td>

                {* Extended price *}
                <td class="purchase_sum hidden-sm-down">
                    {if $purchase->variant->stock > 0}
                        <span class="nowrap">{($purchase->variant->price*$purchase->amount)|convert} {$currency->sign}</span>
                    {else}
                        <div class="preorder_label">{$lang->product_pre_order}</div>
                    {/if}
                </td>

                {* Remove button *}
                <td class="purchase_remove">
                    <a href="{$lang_link}cart/remove/{$purchase->variant->id}" onclick="ajax_remove({$purchase->variant->id});return false;" title="{$lang->cart_remove}">
                        {include file='svg.tpl' svgId='remove_icon'}
                    </a>
                </td>
            </tr>
        {/foreach}
    </table>
{else}
    <div class="block">
        <div class="wrap_blog_heading_page">
            <h1 class="heading_page">
                <span data-language="cart_header">{$lang->cart_header}</span>
            </h1>
        </div>

        <div class="accaunt_promo_heading">
            <span data-language="cart_empty">{$lang->cart_empty}</span>
        </div>
    </div>
{/if}
<div class="row product_buttons1">
    <div class="col-sm-12 {if $cart->total_products > 0} col-md-6 {else} col-md-12 {/if} text-center">
        <button data-fancybox-close="" class="btn btn_white btn-block btn_cart px-2 py-1" title="Close">{$lang->close_cart_popap}</button>
    </div>
    <div class="col-sm-12 col-md-6 text-center">
        {if $cart->total_products > 0}
            <a href="{$lang_link}cart" class="btn btn_white btn-block btn_cart px-2 py-1" data-language="index_cart" style="" title="{$lang->go_to_cart}">
                {$lang->go_to_cart}
            </a>
        {/if}
    </div>
</div>
    
