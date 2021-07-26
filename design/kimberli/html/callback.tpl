{* Callback form *}
<div class="hidden">
    <form id="fn_callback" class="callback_form popup fn_validate_callback" method="post">

        {* The form heading *}
        <div class="popup_heading">
            <span data-language="callback_header">{$lang->callback_header}</span>
        </div>

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

        <input name="url" type="hidden" value="">
        {* Submit button *}
        <div class="boxed_button">
            <input class="btn btn_black btn_account g-recaptcha" type="submit"
                   onClick="gtag( 'event', 'WriteInCallback', { 'event_category': 'send'});"
                   name="callback" data-language="callback_order" value="{$lang->callback_order}">
        </div>

    </form>
</div>
