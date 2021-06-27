<div class="hidden">
    <div id="fn_sms_verification" style="text-align: center;">
        {* The form heading *}
        <div class="popup_heading">
            <span data-language="sms_code_header">{$lang->sms_code_header}</span>
        </div>
        <div class="sms_code_message" data-language="sms_code_message">
            {$lang->sms_code_message}
        </div>
        <div class="sms_hide_error" data-language="sms_code_error" style="display: none;text-align: center;color: red;">
            {$lang->sms_code_error}
        </div>
        <div class="signin-sms__wrap">
            <input class="sms-input" id="sms_code_run" type="tel" maxlength="4" onkeyup="this.value = this.value.replace (/[^\d,]/g, '')">
        </div>
        <input class="btn btn_big btn btn_black btn_cart send_code_button" style="margin-top: 20px;" disabled="true" type="submit" name="submit2" data-method="confirm"  data-language="sms_code_checkout"  value="{$lang->sms_code_checkout}">

    </div>
</div>
<literal>
    <script>
    $('#sms_code_run').on('keyup', function(e) {
       let value =  $(this).val();
    if(
        value != ''
        && value.length == 4
        && typeof(readCookie('sms_code')) != "undefined"
        && readCookie('sms_code') !== null
        && value == readCookie('sms_code')) {
        $('.send_code_button').removeAttr('disabled');
    } else {
        $('.send_code_button').prop("disabled", true);
    }
    });
    </script>
</literal>