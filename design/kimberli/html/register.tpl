{* Registration page *}

{* The canonical address of the page *}
{$canonical="/user/register" scope=parent}

{* The page title *}
{$meta_title = $lang->register_title scope=parent}

<div class="page_container">

    {* The page heading *}
    <div class="wrap_blog_heading_page">
        <h1 class="heading_page">
            <span data-language="register_header">{$lang->register_header}</span>
        </h1>
    </div>
    
    <div class="accaunt_promo_heading">
        <span data-language="login_text">{$lang->register_text}</span>
        {* Link to registration *}
        <a href="{$lang_link}user/login" class="button" data-language="login_registration">{$lang->login_login}</a>
    </div>
    
    
    <div class="block clearfix">
        <div class="">
            {* Form error messages *}
            {if $error}
                <div class="message_error">
                    {if $error == 'empty_name'}
                        <span data-language="form_enter_name">{$lang->form_enter_name}</span>
                    {elseif $error == 'empty_email'}
                        <span data-language="form_enter_email">{$lang->form_enter_email}</span>
                    {elseif $error == 'empty_password'}
                        <span data-language="form_enter_password">{$lang->form_enter_password}</span>
                    {elseif $error == 'user_exists'}
                        <span data-language="register_user_registered">{$lang->register_user_registered}</span>
                    {elseif $error == 'captcha'}
                        <span data-language="form_error_captcha">{$lang->form_error_captcha}</span>
                    {else}
                        {$error}
                    {/if}
                </div>
            {/if}

            <form id="captcha_id" method="post" class="fn_validate_register">

                <div class="row">
                    {* User's  name *}
                    <div class="col-lg-6 form_group mb-2">
                        <input class="form_input_accaunt" type="text" name="name" value="{$name|escape}" data-language="form_name" placeholder="{$lang->form_name}*"/>
                    </div>

                    {* User's  email *}
                    <div class="col-lg-6 form_group mb-2">
                        <input class="form_input_accaunt" type="text" name="email" value="{$email|escape}" data-language="form_email" placeholder="{$lang->form_email}*"/>
                    </div>

                    {* User's  phone *}
                    <div class="col-lg-6 form_group mb-2">
                        <input class="form_input_accaunt" type="text" name="phone" value="{$phone|escape}" data-language="form_phone" placeholder="{$lang->form_phone}"/>
                    </div>

                    {* User's  address *}
                    <div class="col-lg-6 form_group mb-2">
                        <input class="form_input_accaunt" type="text" name="address" value="{$address|escape}" data-language="form_address" placeholder="{$lang->form_address}"/>
                    </div>

                    {* User's  password *}
                    <div class="col-lg-6 form_group">
                        <input class="form_input_accaunt" type="password" name="password" value="" data-language="form_enter_password" placeholder="{$lang->form_enter_password}*"/>
                    </div>
                    
                    {if $settings->captcha_register}
                {if $settings->captcha_type == "v2"}
                    <div class="captcha">
                        <div id="recaptcha1"></div>
                    </div>
                {elseif $settings->captcha_type == "default"}
                        {get_captcha var="captcha_register"}
                        <div class="col-lg-6 captcha">
                            <div class="secret_number">{$captcha_register[0]|escape} + ? =  {$captcha_register[1]|escape}</div>
                            <input class="input_captcha form_input_accaunt" type="text" name="captcha_code" value="" data-language="form_enter_captcha" placeholder="{$lang->form_enter_captcha}*">
                        </div>
                    {/if}
                {/if}
                    <input name="register" type="hidden" value="1">
                </div>

               <div class="boxed_button">
                    {* Submit button *}
                    <input type="submit" class="btn btn_black btn_account g-recaptcha" name="register" data-language="register_create_account" {if $settings->captcha_type == "invisible"}data-sitekey="{$settings->public_recaptcha_invisible}" data-badge='bottomleft' data-callback="onSubmit"{/if} value="{$lang->register_create_account}">
                </div>
            </form>
        </div>
    </div>
</div>