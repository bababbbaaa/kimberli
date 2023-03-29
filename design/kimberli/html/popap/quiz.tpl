<div class="hidden">
    <div class="quiz-popup " id="quiz-popup">
        <div class="popup_heading">
            <span data-language="popup_quiz_title">{$lang->popup_quiz_title}</span>
        </div>
        <div class="body">
            <div class="quiz-popup_wrapp">
                <div class="quiz-popup_preview">
                    <img src="design/{$settings->theme|escape}/images/quiz-popup-img.jpg" alt="">
                </div>
                <div class="quiz-popup_content">
                    <div class="quiz-popup_heading" data-language="popup_quiz_heading">{$lang->popup_quiz_heading}</div>
                    <div class="quiz-popup_descr">
                        <p data-language="popup_quiz_descr_p1">{$lang->popup_quiz_descr_p1}</p>
                        <p data-language="popup_quiz_descr_p2">{$lang->popup_quiz_descr_p2}</p>
                        <p data-language="popup_quiz_descr_p3">{$lang->popup_quiz_descr_p3}</p>
                    </div>
                    <form class="quiz-popup_form form-inline popup" id="quiz_sale_form"  method="post">
                        <div class="inline" >
                            {* User's phone *}
                            <div class="form_group">
                                <input type="hidden" value="{$lang->popup_quiz_heading|escape}" name="subject">
                                <input class="form_input feature_input phone" type="text" id="phone" name="phone" placeholder="{$lang->form_phone}"
                                       data-rule-required="true"
                                       data-rule-minlength="10"
                                       data-msg="{$lang->phone_valid_msg}"
                                       data-language="form_phone" >
                                <input class="btn btn_black feature_multi_values" type="submit" id="send_quiz_form"  name="quiz" data-language="popup_sale_submit" value="{$lang->popup_sale_submit}">
                            </div>
                        </div>
                    </form>
                    <div class="quiz-popup_rules">
                        <p data-language="popup_quiz_rules_p1">{$lang->popup_quiz_rules_p1}</p>
                        <p data-language="popup_quiz_rules_p2">{$lang->popup_quiz_rules_p2}</p>
                        <p data-language="popup_quiz_rules_p3">{$lang->popup_quiz_rules_p3}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>