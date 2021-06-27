{if $deliveries}

    {* Delivery *}
    <div class="order_step step-two">
        <div class="order_step_heading" data-language="cart_delivery">2. {$lang->cart_delivery}</div>
        {foreach $deliveries as $delivery}
            <div class="order_step_radio-group">
                <input type="radio" name="delivery_id" value="{$delivery->id}" id="deliveries_{$delivery->id}"  onclick="change_payment_method({$delivery->id})" {if $delivery_id==$delivery->id || $delivery@first} checked{/if}>
                <label for="deliveries_{$delivery->id}">{$delivery->name|escape}
                    {if $cart->total_price < $delivery->free_from && $delivery->price>0 && !$delivery->separate_payment}
                        <span class="nowrap">({$delivery->price|convert} {$currency->sign|escape})</span>
                    {elseif $delivery->separate_payment}
                        <span data-language="cart_free">({$lang->cart_paid_separate})</span>
                    {elseif $cart->total_price >= $delivery->free_from && !$delivery->separate_payment}
                        <span data-language="cart_free">({$lang->cart_free})</span>
                    {/if}
                </label>
            </div>
        {/foreach}
    </div>

    {* Payment methods *}
    <div class="order_step step-two">
        <div class="order_step_heading" data-language="cart_payment">3. {$lang->cart_payment}</div>
        {foreach $deliveries as $delivery}
            {if $delivery->payment_methods}
                <div class="fn_delivery_payment" id="fn_delivery_payment_{$delivery->id}"{if $delivery@iteration != 1} style="display:none"{/if}>
                    {foreach $delivery->payment_methods as $payment_method}
                        <div class="order_step_radio-group {if $payment_method@first} active{/if}">
                            <input id="payment_{$delivery->id}_{$payment_method->id}" type="radio" name="payment_method_id" value="{$payment_method->id}"{if $delivery@first && $payment_method@first} checked{/if} />
                            <label for="payment_{$delivery->id}_{$payment_method->id}">
                                <!--{$total_price_with_delivery = $cart->total_price}
                            {if !$delivery->separate_payment && $cart->total_price < $delivery->free_from}
                                {$total_price_with_delivery = $cart->total_price + $delivery->price}
                            {/if}-->
                                <span>{$payment_method->name|escape} <!--{$lang->cart_deliveries_to_pay}--></span>
                                <!--<span class="nowrap">{$total_price_with_delivery|convert:$payment_method->currency_id} {$all_currencies[$payment_method->currency_id]->sign|escape}</span>-->
                            </label>
                        </div>
                    {/foreach}
                </div>
            {/if}
        {/foreach}
    </div>
{/if}
