<div class="hidden">
    <div class="coupon-popup" id="coupon-popup">
        <div class="popup_heading">
            <span data-language="callback_header">{$lang->coupon_header}</span>
        </div>
        <div class="body">
            <p class="percent">{$lang->coupon_percent}</p>

            <form class="coupon_form popup fn_validate_callback form-inline"  method="post">
                <div class="inline" >
                    {* User's phone *}
                    <div class="form_group">
                        <input class="form_input feature_input" type="tel" id="phone" name="phone" placeholder="{$lang->form_phone}"  minlength="19" maxlength="19"  required data-language="form_phone" >
                        <input class="btn btn_black feature_multi_values" type="submit"  name="coupon" data-language="coupon_submit" value="{$lang->coupon_submit}">
                    </div>
                </div>
            </form>
            <p class="coupon_footer">{$lang->coupon_footer_1}</p>
            <p class="coupon_footer">{$lang->coupon_footer}</p>
        </div>
    </div>
</div>