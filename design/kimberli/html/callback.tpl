{* Callback form *}
<div class="hidden">
    <form id="fn_callback" class="callback_form popup fn_validate_callback" method="post">

        {* The form heading *}
        <div class="popup_heading">
            <span data-language="callback_header">{$lang->callback_header}</span>
        </div>
        
        {if $call_error}
            <div class="message_error">
                {if $call_error=='captcha'}
                    <span data-language="form_error_captcha">{$lang->form_error_captcha}</span>
                {elseif $call_error=='empty_name'}
                    <span data-language="form_enter_name">{$lang->form_enter_name}</span>
                {elseif $call_error=='empty_phone'}
                    <span data-language="form_enter_phone">{$lang->form_enter_phone}</span>
                {elseif $call_error=='empty_comment'}
                    <span data-language="form_enter_comment">{$lang->form_enter_comment}</span>
                {else}
                    <span>{$call_error}</span>
                {/if}
            </div>
        {/if}

        {* User's name *}
        <div class="form_group">
            <input class="form_input_accaunt" type="text" name="name" value="{if $callname}{$callname|escape}{else}{$user->name|escape}{/if}" data-language="form_name" placeholder="{$lang->form_name}*">
        </div>

        {* User's phone *}
        <div class="form_group">
            <input class="form_input_accaunt" type="text" name="phone" value="{if $callphone}{$callphone|escape}{else}{$user->phone|escape}{/if}" data-language="form_phone" placeholder="{$lang->form_phone}*">
        </div>

        {* User's message *}
        <div class="form_group">
            <textarea class="form_textarea_accaunt" rows="3" name="message" data-language="form_enter_message" placeholder="{$lang->form_enter_message}">{$callmessage|escape}</textarea>
        </div>
        
        {* Captcha *}
        {if $settings->captcha_callback}
            {if $settings->captcha_type == "v2"}
                <div class="captcha row">
                    <div id="recaptcha2"></div>
                </div>
            {elseif $settings->captcha_type == "default"}
            {get_captcha var="captcha_callback"}
            <div class="captcha form_group">
                <div class="secret_number">{$captcha_callback[0]|escape} + ? =  {$captcha_callback[1]|escape}</div>
                <input class="form_input input_captcha" type="text" name="captcha_code" value="" placeholder="{$lang->form_enter_captcha}*">
            </div>
        {/if}
        {/if}
        <input name="callback" type="hidden" value="1">
        {* Submit button *}
        <div class="boxed_button">
            <input class="btn btn_black btn_account g-recaptcha" type="submit"
                   onClick="gtag( 'event', 'WriteInCallback', { 'event_category': 'send'});"
                   name="callback" data-language="callback_order" value="{$lang->callback_order}">
        </div>

    </form>
</div>

{* The modal window after submitting *}
{if $call_sent}
    <div class="hidden">
        <div id="fn_callback_sent" class="popup">
            <div class="popup_heading">
                <span data-language="callback_sent_header">{$lang->callback_sent_header}</span>
            </div>

            <div data-language="callback_sent_text">{$lang->callback_sent_text}</div>
        </div>
    </div>
{literal}
    <script>
        fbq('track', 'BackCall', {
            content_name: '{/literal}{$content_name|escape}{literal}',
            content_content: '{/literal}{$content_content|escape}{literal}',
        });
    </script>
{/literal}
{/if}
