{* Callback form *}
<div class="hidden">
    <div id="fn_quick_order" style="width: 100%;
    min-width: 320px;
    max-width: 700px;">
        {* The form heading *}
        <div class="popup_heading">
            <span data-language="callback_header">{$lang->quick_order_header}</span>
        </div>
        <div class="hide_result">
        {*<div class="product_image">

                        {if $product->image}
                                <img  class="fn_img product_img" itemprop="image" src="{$product->image->filename|resize:350:380}" alt="{$product->name|escape}" title="{$product->name|escape}">
                        {else}
                            <img class="fn_img" src="design/{$settings->theme}/images/no_image.png" width="340" height="340" alt="{$product->name|escape}"/>
                        {/if}
        </div>*}
        {* Price *}
      {*  <div class="price " style="
    margin: 15px;
    font-size: x-large;
    font-weight: bold;
    text-align: center;
">
                                        <span class="fn_price" itemprop="price" content="{$product->variant->price}">{$product->variant->price|convert}</span>
                                        <span itemprop="priceCurrency" content="{$currency->code|escape}">{$currency->sign|escape}</span>
        </div>
            *}

            <div class="purchase_name_box text-md-left " style="width: 99%; border-bottom: 1px solid #9e9e9e; border-top: 1px solid #9e9e9e; padding: 30px 0; margin-bottom: 40px;margin-top: 20px;">
                <span class="purchase_name" style="font-weight: bold;font-size: large;display: inline-block;">{$product->name|escape}</span>
                 {* Extended price *}
                <div class="purchase_sum" style="float: right;display: inline-block;">
                        <span class="nowrap">{$product->variant->price|convert} {$currency->sign}</span>
                </div>
            </div>
        
            
    <form class="quick_order_form popup fn_validate_callback"  method="post" id="quick_order_form">
        <input class="hidden" type="text"  name="variant" value="{$product->variant->id}" >
        <input type="hidden" name="currency" value="{$currency->code}">
        {* User's name *}
       {* <div class="form_group">
            <input class="form_input_accaunt" type="text" name="name" value="" data-language="form_name" placeholder="{$lang->form_name}*">
        </div>*}
<div class="inline" >
        {* User's phone *}
        <div class="form_group" style="max-width: 310px;display: inline-block; padding: 0 15px; float: left;">
            <div class="heading_label">{$lang->form_phone}</div>
            <input class="form_input" type="text" id="phone" name="phone" placeholder="{$lang->form_phone}"  required
                   data-rule-required="true"
                   data-rule-minlength="10"
                   data-language="form_phone" >
        </div>
        
        {* Captcha *}
        {if $settings->captcha_quick_order}
            <div class="form_group" style="max-width: 310px; display: inline-block; padding: 0 15px; padding-top: 25px;">
            {if $settings->captcha_type == "v2"}
                <div class="captcha row">
                    <div id="recaptcha2"></div>
                </div>
            {elseif $settings->captcha_type == "default"}
            {get_captcha var="captcha_quick_order"}
            <div class="captcha form_group">
                <div class="secret_number">{$captcha_quick_order[0]|escape} + ? =  {$captcha_quick_order[1]|escape}</div>
                <input class="form_input input_captcha" type="text" name="captcha_code" value="" placeholder="{$lang->form_enter_captcha}*">
            </div>
        {/if}
                <div class="message_error" style="display: none">
                    <span class="captcha" style="display: none" data-language="form_error_captcha">{$lang->form_error_captcha}</span>
                    {*<span class="name" style="display: none" data-language="form_enter_name">{$lang->form_enter_name}</span>*}
                    <span class="phone" style="display: none" data-language="form_enter_phone">{$lang->form_enter_phone}</span>
                </div>
            </div>
        {/if}

</div>
        {$formId = 'quick_order_form'}
        {include file='popap/sms.tpl'}
        {* Submit button *}
        <div class="boxed_button">
            <input class="btn btn_black btn_account g-recaptcha" type="submit"  name="callback" data-language="callback_order" value="{$lang->callback_order}">
        </div>
    </form>
    </div>
        <div class="d-none result_quick_order"></div>
    </div>
</div>

