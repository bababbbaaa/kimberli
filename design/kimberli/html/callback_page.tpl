{* Callback form *}
    <form id="fn_callback_page" class="callback_form_page fn_validate_callback atelier-request_form" method="post">

        {* The form heading *}
        {*<div class="popup_heading">
            <span data-language="callback_header">{$lang->callback_page_header}</span>
        </div>*}
        
        <div class="message_error d-none"></div>

        {* User's name *}
        <div class="form_group">
            <input class="form_input_accaunt name" type="text" name="name" value="{$user->name|escape}" data-language="form_name" placeholder="{$lang->form_name}*">
        </div>

        {* User's phone *}
        <div class="form_group">
            <input class="form_input_accaunt phone" type="text" name="phone" value="{$user->phone|escape}" data-language="form_phone" placeholder="{$lang->form_phone}*">
        </div>

        {* User's message *}
        <div class="form_group">
            <textarea class="form_textarea_accaunt message" rows="3" name="message" data-language="form_enter_message" placeholder="{$lang->form_enter_message}"></textarea>
        </div>
        
        {* Submit button *}
        <div class="boxed_button">
            <button class="btn btn_black btn_account submit"  type="submit" name="callback_page" data-language="callback_order">{$lang->callback_order}</button>
        </div>

    </form>
<div class="d-none result_callback_page"></div>
