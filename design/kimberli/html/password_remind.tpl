{* Password remind page *}

{* The canonical address of the page *}
{$canonical="/user/password_remind" scope=parent}

{* The page title *}
{$meta_title = $lang->password_remind_title scope=parent}

<div class="page_container">
    {* The page heading *}
    <div class="wrap_blog_heading_page">
        <h1 class="heading_page">
            <span data-language="password_remind_header">{$lang->password_remind_header}</span>
        </h1>
    </div>
    
    <div class="clearfix">
        {if $email_sent}
            <div class="accaunt_promo_heading">
                <span data-language="password_remind_on">{$lang->password_remind_on}</span> <b>{$email|escape}</b> <span data-language="password_remind_letter_sent">{$lang->password_remind_letter_sent}.</span>
            </div>
        {else}
            <div class="accaunt_promo_heading">
                <span class="label_block" data-language="password_remind_enter_your_email">{$lang->password_remind_enter_your_email}</span>
            </div>
            <div class="">
                <form method="post">
                    {* Form error messages *}
                    {if $error}
                        <div class="message_error">
                            {if $error == 'user_not_found'}
                                <span data-language="password_remind_user_not_found">{$lang->password_remind_user_not_found}</span>
                            {else}
                                {$error|escape}
                            {/if}
                        </div>
                    {/if}

                    <div class="form_group">
                        {* User's e-mail *}
                        <input class="form_input_accaunt" type="text" name="email" value="{$email|escape}" data-language="form_email" placeholder="{$lang->form_email}*">
                    </div>
                    
                    {* Submit button *}
                    <div class="boxed_button">
                        {* Submit button *}
                        <input type="submit" class="btn btn_black btn_account" data-language="password_remind_remember" value="{$lang->password_remind_remember}">
                    </div>
                </form>
            </div>
        {/if}
    </div>
 </div>    