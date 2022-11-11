<div class="container">
    <div class="row">
        <div class="col-sm-12 text-center">
            <a class="btn btn_black btn_account mb-2"  title="ЗАПИСАТИСЯ ONLINE" href="#welcome-to-the-boutique_popup" onclick="$.fancybox.open({
                    src: '#welcome-to-the-boutique_popup',
                    type: 'inline'
                }); return false;">
                <span>ЗАПИСАТИСЯ ONLINE</span>
            </a>
        </div>
    </div>
</div>

<div class="hidden">
    <div class="welcome-to-the-boutique" id="welcome-to-the-boutique_popup">
        <div class="body">
            <form id="welcome-to-the-boutique" class="code_argo welcome-to-the-boutique_form">
                {* The form heading *}
                <div class="row">
                    {* User's name *}
                    <div class="col-lg-6 form_group">
                        <input class="form_input_accaunt" type="text" name="name" id="cod_argo" required minlength="2" maxlength="50" value="" data-language="form_name" placeholder="{$lang->form_name}">
                    </div>
                    <div class="col-lg-6 form_group">
                        <input class="form_input_accaunt" type="text" name="phone" required value="" data-language="form_phone" placeholder="{$lang->form_phone}">
                    </div>
                </div>
                {* Submit button *}
                <div class="boxed_button">
                    <input class="btn btn_black btn_account" type="submit" name="code_page" data-language="callback_order" value="{$lang->form_send}">
                </div>
            </form>
            <div class="result" style="font-size: 14px; color: green; padding: 15px"></div>
        </div>
    </div>
</div>
