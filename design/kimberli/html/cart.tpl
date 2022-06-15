{* The cart page template *}

{* The page title *}
{$meta_title = $lang->cart_title scope=parent}

<div class="order">
    <div class="container-fluid">
        {if $cart->purchases}
            {* Cart form *}
            <form id="captcha_id" method="post" name="cart" class="fn_validate_cart">
                <div class="order_heading">{$lang->order_heading}</div>
                <div class="order_wrapp">
                    <div class="order_dataset">
                        {* Form error messages *}
                        {if $error}
                            <div class="message_error">
                                <!--{if $error == 'empty_name'}
                                <span data-language="form_enter_name">{$lang->form_enter_name}</span>
                            {/if}
                            {if $error == 'empty_email'}
                                <span data-language="form_enter_email">{$lang->form_enter_email}</span>
                            {/if}
                            {if $error == 'captcha'}
                                <span data-language="form_error_captcha">{$lang->form_error_captcha}</span>
                            {/if}-->
                                {if $error == 'empty_phone'}
                                    <span data-language="form_error_phone">{$lang->form_error_phone}</span>
                                {/if}
                            </div>
                        {/if}
                        <div class="order_step">
                            <div class="order_step_heading">1. {$lang->cart_form_header}</div>
                            <button class="order_step_back">{$lang->edit}</button>
                            <div class="order_step_contacts">
                                <!--{* User's name *}
                            <div class="order_step_input-group">
                                <input class="form_input req" name="name" type="text" value="{$name|escape}" data-language="form_name" placeholder="{$lang->form_name}*">
                                <span class="label">{$lang->form_name}*</span>
                            </div>-->
                                {* User's phone *}
                                <div class="order_step_input-group">
                                    <input class="form_input req" name="phone" type="text" value="{$phone|escape}" data-language="form_phone" placeholder="{$lang->form_phone}*">
                                    <span class="label">{$lang->form_phone}*</span>
                                </div>
                                <!--{* User's email *}
                            <div class="order_step_input-group">
                                <input class="form_input req" name="email" type="text" value="{$email|escape}" data-language="form_email" placeholder="{$lang->form_email}*">
                                <span class="label">{$lang->form_email}*</span>
                            </div>
                            {* User's address *}
                            <div class="order_step_input-group">
                                <input class="form_input" name="address" type="text" value="{$address|escape}" data-language="form_address" placeholder="{$lang->form_address}">
                                <span class="label">{$lang->form_address}</span>
                            </div>-->
                                <div class="error-empty">
                                    {$lang->order_empty_error} (*)
                                </div>
                                <button type="button">{$lang->order_step_one_btn}</button>
                            </div>
                        </div>

                        {* Delivery and Payment *}
                        <div id="fn_ajax_deliveries">
                            {include file='cart_deliveries.tpl'}
                        </div>

                        <div class="order_comment step-two">
                            {* User's message *}
                            <button type="button">
                                <div class="icon"></div>
                                <span>{$lang->order_step_comment}</span>
                            </button>
                            <div class="order_step_input-group">
                                <textarea name="comment" data-language="cart_order_comment" placeholder="{$lang->cart_order_comment}">{$comment|escape}</textarea>
                                <span class="label">{$comment|escape}</span>
                            </div>
                        </div>
                        {* Submit button *}
                        <button type="submit" class="order_submit mob btn_cart g-recaptcha" name="submit1" data-method="create" data-language="cart_checkout" {if $settings->captcha_type == "invisible"}data-sitekey="{$settings->public_recaptcha_invisible}" data-badge='bottomleft' data-callback="onSubmit"{/if}>{$lang->cart_checkout}</button>

                        {* Captcha *}
                        {if $settings->captcha_cart}
                            {if isset($settings->captcha_type) && $settings->captcha_type == "v2"}
                                <div class="captcha row" style="">
                                    <div id="recaptcha1"></div>
                                </div>
                            {elseif $settings->captcha_type == "default"}
                                {get_captcha var="captcha_cart"}
                                <div class="captcha">
                                    <div class="secret_number">{$captcha_cart[0]|escape} + ? =  {$captcha_cart[1]|escape}</div>
                                    <input class="form_input input_captcha" type="text" name="captcha_code" value="" data-language="form_enter_captcha" placeholder="{$lang->form_enter_captcha}*">
                                </div>
                            {/if}
                        {/if}
                        {include file='popap/sms.tpl'}
                        <input type="hidden" name="checkout" value="1">
                        <input type="hidden" name="currency" value="{$currency->code}">
                    </div>
                    <div class="order_info">
                        {* The list of products in the cart *}
                        <div id="fn_purchases">
                            {include file='cart_purchases.tpl'}
                        </div>
                        {* Submit button *}
                        <input type="submit" class="order_submit desk btn_cart" name="submit1" data-method="create" data-language="cart_checkout"  value="{$lang->cart_checkout}"/>
                    </div>
                </div>
            </form>

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
    </div>
</div>


<script>
    $('.order_step_contacts button').on('click', function() {
        let valid = true;
        $('.order_step_contacts input.req').each(function(){
            if(!$(this).val() || $(this).hasClass('error')){
                valid = false;
            }
        });
        if(valid){
            $('.order').addClass('finally-step');
            $('.error-empty').hide();
        }else{
            $('.error-empty').show();
        }

    });

    $('.order_comment button').on('click', function() {
        $('.order_comment').toggleClass('active');
    });

    $('.order_step_back').on('click', function() {
        $('.order').removeClass('finally-step');
    });
</script>