            <div class="">
                {* Feedback form *}
                <form id="captcha_id" method="post" class="fn_validate_feedback atelier-request_form">

                    {* Form heading *}
                    {*<div class="comment_write_heading" data-language="feedback_feedback">{$lang->feedback_feedback}</div>*}

                    <div class="block padding">
                        {* Form error messages *}
                        {if $error}
                            <div class="message_error">
                                {if $error=='captcha'}
                                    <span data-language="form_error_captcha">{$lang->form_error_captcha}</span>
                                {elseif $error=='empty_name'}
                                    <span data-language="form_enter_name">{$lang->form_enter_name}</span>
                                {elseif $error=='empty_email'}
                                    <span data-language="form_enter_email">{$lang->form_enter_email}</span>
                                {elseif $error=='empty_text'}
                                    <span data-language="form_enter_message">{$lang->form_enter_message}</span>
                                {/if}
                            </div>
                        {/if}

                        <div class="row">
                            {* User's name *}
                            <div class="col-lg-6 form_group">
                                <input class="form_input" value="{if $user->name}{$user->name|escape}{else}{$name|escape}{/if}" name="name" type="text" data-language="form_name" placeholder="{$lang->form_name}*"/>
                            </div>

                            {* User's email *}
                            <div class="col-lg-6 form_group">
                                <input class="form_input" value="{if $user->phone}{$user->phone|escape}{else}{$phone|escape}{/if}" name="phone" type="text" data-language="form_phone" placeholder="{$lang->form_phone}*"/>
                            </div>
                        </div>
                        
                        {* User's message *}
                        <div class="form_group">
                            <textarea class="form_textarea" rows="3" name="message" data-language="form_enter_message" placeholder="{$lang->form_enter_message}*">{$message|escape}</textarea>
                        </div>

                        {* Captcha *}
                        {if $settings->captcha_feedback}
                        {if $settings->captcha_type == "v2"}
                            <div class="captcha row" style="">
                                <div id="recaptcha1"></div>
                            </div>
                        {elseif $settings->captcha_type == "default"}
                            {get_captcha var="captcha_feedback"}
                            <div class="captcha form_group">
                                <div class="secret_number">{$captcha_feedback[0]|escape} + ? =  {$captcha_feedback[1]|escape}</div>
                                <input class="form_input input_captcha" type="text" name="captcha_code" value="" data-language="form_enter_captcha" placeholder="{$lang->form_enter_captcha}*"/>
                            </div>
                        {/if}
                    {/if}
                        {$formId = 'captcha_id'}
                        {include file='popap/sms.tpl'}
                    <input type="hidden" name="feedback" value="1">

                        {* Submit button *}
                        <input class="submit" type="submit"  name="feedback" data-language="form_send" {if $settings->captcha_type == "invisible"}data-sitekey="{$settings->public_recaptcha_invisible}" data-badge='bottomleft' data-callback="onSubmit"{/if} value="{$lang->form_send}"/>
                    </div>
                </form>
            </div>

