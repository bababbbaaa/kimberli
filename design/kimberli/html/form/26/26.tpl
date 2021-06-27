{* Callback form *}
<div class="form_santa">
    <form id="form_26" class="callback_form_page fn_validate_callback" method="post">

        {* The form heading *}
        <div class="popup_heading">
            <span data-language="header_26">{$lang->header_26}</span>
        </div>
        
        <div class="error_forma d-none"></div>

        <div class="row">
            {* User's name *}
        <div class="col-lg-6 form_group">
            <input class="form_input_accaunt" type="text" name="name" value="{$user->name|escape}" data-language="form_name" placeholder="{$lang->form_name}*">
        </div>

        {* User's phone *}
        <div class="col-lg-6 form_group">
            <input class="form_input_accaunt" type="text" name="phone" value="{$user->phone|escape}" data-language="form_phone" placeholder="{$lang->form_phone}*">
        </div>
        </div>

        {* User's message *}
        <div class="form_group">
            <textarea class="form_textarea_accaunt" rows="10" name="message" data-language="form_enter_message" placeholder="{$lang->form_enter_message}"></textarea>
        </div>
        
        {* Submit button *}
        <div class="boxed_button">
            <input class="btn btn_black btn_account" type="submit" name="callback_page" data-language="callback_order" value="{$lang->form_send}">
        </div>

    </form>
<div class="d-none result_forma"></div>
</div>
