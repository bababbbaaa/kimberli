<form action="" class="order_fitting" id="order_fitting">
{if $cart->purchases}
    {* The page heading *}
    <div class="wrap_blog_heading_page">
        <p class="heading_page">
            <span data-language="cart_header">Бронюй прикрасу</span>
        </p>
        <p>
            Бронюй прикрасу, яка сподобалась, для примірки в наших магазинах або замовляй безкоштовний приїзд кур'єра (по Києву)
        </p>
    </div>

    <table class="purchase">
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
                        <div class="purchase_name_price hidden-sm-down">
                            {($purchase->variant->price)}
                            {$currency->sign}
                            {if $purchase->variant->units}
                                / {$purchase->variant->units|escape}
                            {/if}</div>

                        <input class="input_amount hidden" type="text" data-id="{$purchase->variant->id}" name="amounts[{$purchase->variant->id}]" value="{$purchase->amount}"  data-max="{$purchase->variant->stock}">
                        <input class="hidden" name="total" value="{$cart->total_price}">
                        <input type="hidden" name="currency" value="{$currency->code}">
                        {* Extended price *}
                        <div class="purchase_sum hidden-md-up">
                            <span class="nowrap">{($purchase->variant->price*$purchase->amount)} {$currency->sign}</span>
                        </div>
                    {/if}
                </td>
            </tr>
        {/foreach}
    </table>
    <div class="row">
        <div class="col-lg-6">
            <div class="">
                <input class="form_input feature_input" type="tel" id="shopping_popup_phone" name="phone" placeholder="{$lang->form_phone}"  minlength="19" maxlength="19"  required data-language="form_phone" >
            </div>
        </div>
        <div class="col-lg-6">
            <div class="shopping_popup">
                <label>
                    <input class="form_input feature_input" type="checkbox" value="1" id="dop_variant" name="dop_variant">
                    <span>Хочу підібрати декілька прикрас</span>
                </label>
            </div>
        </div>
        <div class="col-lg-12 text-center">
                <!-- SMS Code input -->
                <div class="signin-sms__wrap" style="display: none">
                    <p class="label text-center">Для підтвердження, введіть код з СМС</p>
                    <! –– container should be fieldset element but there is bug in Chromium https://bugs.chromium.org/p/chromium/issues/detail?id=262679 ––>
                    <input class="sms-input" type="tel" id="shopping_cod_sms" minlength="4" maxlength="4" placeholder="••••" />
                </div>
                <!-- End SMS Code input -->
        </div>
    </div>
    <br><br>
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
        <button class="btn btn_white btn-block btn_cart px-2 py-1 " data-fancybox-close="" data-language="close_cart_popap" title="Close">{$lang->close_cart_popap}</button>
    </div>
    <div class="col-sm-12 col-md-6 text-center">
        {if $cart->total_products > 0}
            <input type="submit" class="btn btn_white btn-block btn_cart px-2 py-1" value="Замовити примірку">
        {/if}
    </div>
</div>
</form>