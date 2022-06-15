{* Callback form *}
<div class="form_code_argo">
    <form id="code_argo" class="code_argo" method="get">

        {* The form heading *}
        <div class="popup_heading">
            <span data-language="header_26">{$lang->header_29}</span>
        </div>

        <div class="row">
            {* User's name *}
            <div class="col-lg-6 form_group">
                <input class="form_input_accaunt" type="text" name="code" id="cod_argo" required minlength="14" maxlength="20" value="{$user->code|escape}" data-language="form_check" placeholder="ХХХ-Х0-0000000">
            </div>
            <div class="col-lg-6 form_group">
                <input class="form_input_accaunt" type="text" name="phone" required value="{$user->phone|escape}" data-language="form_phone" placeholder="{$lang->form_phone}">
            </div>
        </div>
        {* Submit button *}
        <div class="boxed_button">
            <input class="btn btn_black btn_account" type="submit" name="code_page" data-language="callback_order" value="{$lang->form_send}">
        </div>

    </form>
</div>
