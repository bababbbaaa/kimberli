<div class="hidden">
    <div class="coupon-popup" id="coupon-popup">
        <div class="popup_heading">
            <span data-language="callback_header">{$lang->coupon_header}</span>
        </div>
        <div class="body">
            <p class="percent" data-language="coupon_percent">{$lang->coupon_percent}</p>

            <form class="coupon_form popup form-inline" id="coupon_form"  method="post">
                <div class="inline" >
                    {* User's phone *}
                    <div class="form_group">
                        <input class="form_input feature_input phone" type="text" id="phone" name="phone" placeholder="{$lang->form_phone}"
                               data-rule-required="true"
                               data-rule-minlength="10"
                               data-msg="Введите корректный номер телефона"
                               data-language="form_phone" >
                        <input class="btn btn_black feature_multi_values" type="submit" id="send_coupon_form"  name="coupon" data-language="coupon_submit" value="{$lang->coupon_submit}">
                    </div>
                </div>
                {*include file='popap/sms.tpl'*}
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
                <input class="btn btn_big btn btn_black btn_cart send_code_button" style="margin-top: 20px;" type="submit" name="submit2" data-method="confirm" onclick="return checkValidCode('coupon_form', 'coupon-popup');"  data-language="sms_code_checkout"  value="{$lang->sms_code_checkout}">

            </div>
            <p class="coupon_footer" data-language="coupon_footer_1">{$lang->coupon_footer_1}</p>
            <p class="coupon_footer" data-language="coupon_footer">{$lang->coupon_footer}</p>
            <p class="coupon_footer" style="margin-top: -15px;font-size: small;" data-language="coupon_footer_2">{$lang->coupon_footer_2}</p>
        </div>
    </div>
</div>