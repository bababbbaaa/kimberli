{* Bar Kimberli form *}
<div class="container">
<div class="row">
    <div class="col-sm-12 text-center">
<a class="btn btn_black btn_account"  title="Забронюй комплимент від BAR KIMBERLI" href="#bar_kimberli_popup" onclick="$.fancybox.open({
                    src: '#bar_kimberli_popup',
                    type: 'inline'
                }); return false;">
    <span>Забронюй комплімент від BAR KIMBERLI</span>
</a>
    </div>
</div>
</div>
<div class="hidden">
    <div class="bar_kimberli_popup" id="bar_kimberli_popup">
        <div class="body">
            <form class="bar_kimberli_form popup form-inline" id="form_bar_kimberli"  method="post">
                {* The form heading *}
                <div class="row">
                    {* User's name *}
                    <div class="col-lg-6 form_group">
                        <input class="form_input_accaunt" type="text" name="name" required minlength="2" value="{$user->name|escape}" data-language="form_name" placeholder="{$lang->form_name}*">
                    </div>
                    <div class="col-lg-6 form_group">
                        <input class="form_input_accaunt" type="text" name="phone" required value="{$user->phone|escape}" data-language="form_phone" placeholder="{$lang->form_phone}">
                    </div>
                </div>
                {* Submit button *}
                <div class="boxed_button">
                    <input class="btn btn_black btn_account" type="submit" id="bar_kimberli_submit" name="bar_kimberli_submit" value="Отримати комплімент">
                </div>
            </form>
            <div id="coupon_sms_verification" style="text-align: center; display: none">
                {* The form heading *}
                {* <div class="popup_heading">
                     <span data-language="sms_code_header">{$lang->sms_code_header}</span>
                 </div>*}
                <div class="sms_code_message" data-language="sms_code_message">
                    {$lang->sms_code_message}
                </div>
                <div class="sms_hide_error" data-language="sms_code_error" style="display: none;text-align: center;color: red;">
                    {$lang->sms_code_error}
                </div>
                <div class="signin-sms__wrap">
                    <input class="sms-input" id="sms_code_run" type="tel" maxlength="4" onkeyup="this.value = this.value.replace (/[^\d,]/g, '')">
                </div>
                <input class="btn btn_big btn btn_black btn_cart send_code_button" style="margin-top: 20px;" type="submit" name="submit2" data-method="confirm" onclick="return checkValidCode('form_bar_kimberli', 'bar-kimberli-popup');"  data-language="sms_code_checkout"  value="{$lang->sms_code_checkout}">

            </div>
            <div class="result" style="font-size: 14px; color: green"></div>
        </div>
    </div>
</div>