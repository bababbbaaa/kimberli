
<div class="order_products">
    {foreach $cart->purchases as $purchase}
        <div class="order_product">
            <a href="{$lang_link}cart/remove/{$purchase->variant->id}" class="close" onclick="ajax_remove({$purchase->variant->id});return false;" title="{$lang->cart_remove}">
                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line x1="1.6615" y1="1.09778" x2="12.1241" y2="11.5604" stroke="black" stroke-width="0.804817"/>
                    <line x1="1.09241" y1="11.5604" x2="11.555" y2="1.0978" stroke="black" stroke-width="0.804817"/>
                </svg>
            </a>
            {* Product image *}
            <a href="{$lang_link}products/{$purchase->variant->url}" class="order_product_preview">
                {if $purchase->product->image}
                    <img src="{$purchase->product->image->filename|resize:90:90}" alt="{$purchase->product->name|escape}" title="{$purchase->product->name|escape}">
                {else}
                    <img width="90" height="90" src="design/{$settings->theme}/images/no_image.png" alt="{$purchase->product->name|escape}" title="{$purchase->product->name|escape}">
                {/if}
            </a>
            <div class="order_product_details">
                {* Product name *}
                <a href="{$lang_link}products/{$purchase->variant->url}" class="order_product_name">{$purchase->product->name|escape}</a>
                <!--{if $purchase->variant->name}
                    <div class="purchase_variant_name">{$purchase->variant->name|escape}</div>
                {/if}-->
                {*if $purchase->variant->stock == 0}
                    <div class="preorder_label">{$lang->product_pre_order}</div>
                {/if*}
                {* Quantity *}
                <div class="order_product_count">
                    <div class="fn_product_amount{if $settings->is_preorder} fn_is_preorder{/if} amount">
                        <span class="minus">
                            -
                        </span>
                        <input class="input_amount" type="text" data-id="{$purchase->variant->id}" name="amounts[{$purchase->variant->id}]" value="{$purchase->amount}" onblur="ajax_change_amount(this, {$purchase->variant->id});" data-max="{$purchase->variant->stock}">
                        <span class="plus">
                            +
                        </span>
                    </div>
                </div>
                {* Extended price *}
                {if $purchase->variant->stock > 0}
                    <div class="order_product_price">{($purchase->variant->price*$purchase->amount)|convert} {$currency->sign}</div>
                {else}
                    <div class="preorder_label">{$lang->product_pre_order}</div>
                {/if}
            </div>
        </div>
    {/foreach}
</div>

<div class="order_nav">
    {* Total *}
    <div class="order_price">
        <span data-language="cart_total_price">{$lang->cart_total_price}:</span>
        <p class="total_sum nowrap">{$cart->total_price|convert} {$currency->sign|escape}</p>
    </div>

    {* Discount *}
    {if $user->discount}
        <div class="order_price">
            <span data-language="cart_discount">{$lang->cart_discount}</span>
            <p class="total_sum nowrap">{$user->discount}%</p>
        </div>
    {/if}

    {* Coupon *}
    {if $coupon_request}
        {if $cart->coupon_discount > 0}
            <p data-language="cart_coupon">{$lang->cart_coupon}</p>
            <p>{$cart->coupon->coupon_percent|escape} %</p>
            <p>&minus; {$cart->coupon_discount|convert} {$currency->sign|escape}</p>
        {/if}
    {/if}

    {if $coupon_request}
        {* Coupon *}
        {* Coupon error messages *}
        {if $coupon_error}
            <div class="message_error">
                {if $coupon_error == 'invalid'}
                    {$lang->cart_coupon_error}
                {/if}
            </div>
        {/if}
        {if $cart->coupon->min_order_price > 0}
            <div class="message_success">
                {$lang->cart_coupon} {$cart->coupon->code|escape} {$lang->cart_coupon_min} {$cart->coupon->min_order_price|convert} {$currency->sign|escape}
            </div>
        {/if}

        <div class="order_promo">
            <input class="fn_coupon" type="text" name="coupon_code" value="{$cart->coupon->code|escape}" placeholder="{$lang->cart_coupon}">
            <button type="button" class="fn_sub_coupon">{$lang->cart_purchases_coupon_apply}</button>
        </div>
    {/if}
</div>

