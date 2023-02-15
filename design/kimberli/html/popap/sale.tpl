<div class="hidden">
    <div class="coupon-popup" id="sale-popup">
        <div class="popup_heading">
            <span data-language="popup_sale_header">{$lang->popup_sale_header}</span>
        </div>
        <div class="body">
            <p class="percent" data-language="coupon_percent">- 40% OFF</p>
            <p class="text-center" style="margin-bottom: 20px" data-language="popup_sale_pre_form">{$lang->popup_sale_pre_form}</p>
            <form class="coupon_form popup form-inline" id="popup_sale_form"  method="post">
                <div class="inline" >
                    {* User's phone *}
                    <div class="form_group">
                        <input class="form_input feature_input phone" style="max-width: 320px" type="text" id="phone" name="phone" placeholder="{$lang->form_phone}"
                               data-rule-required="true"
                               data-rule-minlength="10"
                               data-msg="{$lang->phone_valid_msg}"
                               data-language="form_phone" >
                        <input class="btn btn_black feature_multi_values" style="max-width: 320px" type="submit" id="send_coupon_form"  name="coupon" data-language="popup_sale_submit" value="{$lang->popup_sale_submit}">
                    </div>
                </div>
            </form>
            <p class="coupon_footer" style="font-size: smaller;" data-language="popup_sale_footer">*{$lang->popup_sale_footer}</p>
        </div>
        <div class="popup_sale_footer_result hidden"></div>
    </div>
</div>