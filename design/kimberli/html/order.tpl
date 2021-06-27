{* Order page *}

{* The page title *}
{$meta_title = "`$lang->email_order_title` `$order->id`" scope=parent}
<div class="page_container">
    {* The page heading *}
    <div class="wrap_blog_heading_page">
        <h1 class="heading_page">
            <span data-language="order_header">{$lang->order_header}</span> {$order->id} 
        </h1>
    </div>


    <table class="purchase">
        <thead class="mobile-hidden">
            <tr>
                <th colspan="2" class="text-md-left" data-language="cart_head_name">{$lang->cart_head_name}</th>
                <th data-language="cart_head_amoun">{$lang->cart_head_amoun}</th>
                <th data-language="cart_head_total">{$lang->cart_head_total}</th>
            </tr>
        </thead>

        {foreach $purchases as $purchase}
            <tr>
                {* Product image *}
                <td class="purchase_image">
                    <a href="{$lang_link}products/{$purchase->variant->url}">
                        {if $purchase->product->image}
                            <img align="middle" src="{$purchase->product->image->filename|resize:90:90}" />
                        {else}
                            <img width="90" height="90" src="{$config->root_url}/design/{$settings->theme}/images/no_image.png" alt="{$purchase->product->name|escape}" title="{$purchase->product->name|escape}">
                        {/if}
                    </a>
                </td>

                {* Product name *}
                <td class="purchase_name_box text-md-left">
                    <a class="purchase_name" href="{$lang_link}products/{$purchase->variant->url}">{$purchase->product_name|escape}</a>
                    
                  {*  {if $purchase->variant->name}
                        <div class="purchase_variant_name">{$purchase->variant->name|escape}</div>
                    {/if}
                   
                    {if $purchase->variant->stock == 0}
                        <div class="preorder_label">{$lang->product_pre_order}</div>
                    {/if}
                   
                    {if $order->paid && $purchase->variant->attachment}
                        <a class="button" href="{$lang_link}order/{$order->url}/{$purchase->variant->attachment}" data-language="order_download_file">{$lang->order_download_file}</a>
                    {/if}*}
                    
                    {* Price per unit *}
                    <div class="purchase_name_price">{($purchase->variant->price)|convert} {$currency->sign} {if $purchase->units}/ {$purchase->units|escape}{/if}</div>
                </td>

                {* Quantity *}
                <td class="purchase_amount">{$purchase->amount|escape}</td>

                {* Extended price *}
                <td class="purchase_sum">
                    <span class="nowrap">{($purchase->price*$purchase->amount)|convert} {$currency->sign|escape}</span>
                </td>
            </tr>
        {/foreach}

        {* Discount *}
        {if $order->discount > 0}
            <tr>
                <td colspan="2" class="text-md-left" data-language="cart_discount">{$lang->cart_discount}</td>
                <td></td>
                <td>{$order->discount}%</td>
                
            </tr>
        {/if}

        {* Coupon *}
        {if $order->coupon_discount > 0}
            <tr>
                <td colspan="2" class="text-md-left">
                    <span data-language="cart_coupon">{$lang->cart_coupon}</span>
                </td>
                <td>{$order->coupon->coupon_percent|escape} %</td>
                <td>{$order->coupon_discount|convert} {$currency->sign|escape}</td>
                
            </tr>
        {/if}

        {* Delivery price *}
        {if $order->separate_delivery || !$order->separate_delivery && $order->delivery_price > 0}
            <tr>
                <td colspan="2" class="text-md-left">
                    <span data-language="order_delivery">{$lang->order_delivery}</span>
                </td>
                <td></td>
                <td>{$order->delivery_price|convert} {$currency->sign|escape}</td>
            </tr>
        {/if}

        {* Delivery price *}
        {if $order->separate_delivery}
            <tr>
                <td colspan="2" class="text-md-left">
                    <span data-language="order_delivery">{$lang->order_delivery}</span>
                </td>
                <td></td>
                <td>{$order->delivery_price|convert} {$currency->sign|escape}</td>
            </tr>
        {/if}

        {* Total *}
        <tfoot>
            <tr>
                <td colspan="4" class="purchase_total text-md-right">
                    <span data-language="cart_total_price">{$lang->cart_total_price}:</span>
                    <span class="total_sum nowrap">{$order->total_price|convert} {$currency->sign|escape}</span>
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="wrap_block clearfix">
        <div class="">
            <div class="heading_box">
                <span data-language="order_details">{$lang->order_details}</span>
            </div>
            
            {* Order details *}
            <div class="block padding">
                <table class="order_details">
                    <tr>
                        <td>
                            <span data-language="user_order_status"><b>{$lang->user_order_status}</b></span>
                        </td>
                        <td>
                            {$order_status->name|escape}
                            {if $order->paid == 1}
                                , <span data-language="status_paid">{$lang->status_paid}</span>
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span data-language="order_date"><b>{$lang->order_date}</b></span>
                        </td>
                        <td>{$order->date|date} <span data-language="order_time">{$lang->order_time}</span> {$order->date|time}</td>
                    </tr>
                    <tr>
                        <td>
                            <span data-language="order_name"><b>{$lang->order_name}</b></span>
                        </td>
                        <td>{$order->name|escape}</td>
                    </tr>
                    <tr>
                        <td>
                            <span data-language="order_email"><b>{$lang->order_email}</b></span>
                        </td>
                        <td>{$order->email|escape}</td>
                    </tr>
                    {if $order->phone}
                        <tr>
                            <td>
                                <span data-language="order_phone"><b>{$lang->order_phone}</b></span>
                            </td>
                            <td>{$order->phone|escape}</td>
                        </tr>
                    {/if}
                    {if $order->address}
                        <tr>
                            <td>
                                <span data-language="order_address"><b>{$lang->order_address}</b></span>
                            </td>
                            <td>{$order->address|escape}</td>
                        </tr>
                    {/if}
                    {if $order->comment}
                        <tr>
                            <td>
                                <span data-language="order_comment"><b>{$lang->order_comment}</b></span>
                            </td>
                            <td>{$order->comment|escape|nl2br}</td>
                        </tr>
                    {/if}
                </table>
            </div>
        </div>

        <div class="c">
            {if !$order->paid}
                {* Payments *}
                <div class="heading_box">
                    <span data-language="order_payment_details">{$lang->order_payment_details}</span>
                </div>
                

                {if $payment_methods && !$payment_method && $order->total_price>0}
                    <div class="delivery padding block">
                        <form method="post">
                            {foreach $payment_methods as $payment_method}
                                <div class="delivery_item">
                                    <label class="delivery_label{if $payment_method@first} active{/if}">
                                        <input class="input_delivery"  type="radio" name="payment_method_id" value="{$payment_method->id}" {if $delivery@first && $payment_method@first} checked{/if} id="payment_{$delivery->id}_{$payment_method->id}">

                                        <span class="delivery_name">
                                            {if $payment_method->image}
                                                <img src="{$payment_method->image|resize:50:50:false:$config->resized_payments_dir}"/>
                                            {/if}
                                            {$total_price_with_delivery = $cart->total_price}
                                            {if !$delivery->separate_payment && $cart->total_price < $delivery->free_from}
                                                {$total_price_with_delivery = $cart->total_price + $delivery->price}
                                            {/if}

                                            {$payment_method->name|escape} {$lang->cart_deliveries_to_pay} <span class="nowrap">{$order->total_price|convert:$payment_method->currency_id} {$all_currencies[$payment_method->currency_id]->sign}</span>
                                        </span>
                                    </label>
                                    <div class="delivery_description">
                                        {$payment_method->description}
                                    </div>
                                </div>
                            {/foreach}

                            <input type="submit" data-language="cart_checkout" value="{$lang->cart_checkout}" name="checkout" class="btn btn_small btn_black">
                        </form>
                    </div>
                {elseif $payment_method}
                    {* Selected payment *}
                    <div class="padding block clearfix">
                        <div class="method">
                            <span data-language="order_payment">{$lang->order_payment}</span>
                            <span class="method_name">{$payment_method->name|escape}</span>

                            <form class="method_form" method="post">
                                <input class="method_link" type=submit name='reset_payment_method' data-language="order_change_payment" value='{$lang->order_change_payment}'/>
                            </form>

                            {if $payment_method->description}
                                <div class="method_description delivery_description">
                                    {$payment_method->description}
                                </div>
                            {/if}
                        </div>

                        {* Payment form is generated by payment module *}
                        {checkout_form order_id=$order->id module=$payment_method->module product=$purchases}
                    </div>                
                {/if}
            {/if}
        </div>
    </div>
</div>    