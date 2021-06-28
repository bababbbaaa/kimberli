{* Account page *}

{* The page title *}
{$meta_title = $lang->user_title scope=parent}

<div class="page_container">
    {* The page heading*}
    <div class="wrap_blog_heading_page">
        <h1 class="heading_page">
            <span data-language="user_header">{$lang->user_header}</span>
        </h1>
    </div>
    
    <div class="block padding">
        <div class="row">
            <div class="col-lg-12">

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
                        {else}
                            {$error}
                        {/if}
                    </div>
                {/if}

                <form method="post" class="fn_validate_register">

                    <div class="row">
                        {* User's name *}
                        <div class="col-lg-6 form_group">
                            <input class="form_input_accaunt" value="{$name|escape}" name="name" type="text" data-language="form_name" placeholder="{$lang->form_name}*"/>
                        </div>

                        {* User's email *}
                        <div class="col-lg-6 form_group">
                            <input class="form_input_accaunt" value="{$email|escape}" name="email" type="text" data-language="form_email" placeholder="{$lang->form_email}*"/>
                        </div>

                        {* User's phone *}
                        <div class="col-lg-6 form_group">
                            <input class="form_input_accaunt" value="{$phone|escape}" name="phone" type="text" data-language="form_phone" placeholder="{$lang->form_phone}"/>
                        </div>

                        {* User's address *}
                        <div class="col-lg-6 form_group">
                            <input class="form_input_accaunt" value="{$address|escape}" name="address" type="text" data-language="form_address" placeholder="{$lang->form_address}"/>
                        </div>

                        {* User's password *}
                        <div class="col-lg-6 form_group">
                            <p class="change_pass password_remind" onclick="$('#password').toggle();return false;" style="cursor:pointer;"><span data-language="user_change_password">{$lang->user_change_password}</span></p>

                            <input class="form_input_accaunt" id="password" value="" name="password" type="password" style="display:none;" placeholder="{$lang->user_change_password}"/>
                        </div>
                    </div>
                    
                    <div class="boxed_button">
                        {* Submit button *}
                        <input type="submit" class="btn btn_black btn_account" name="user_save" data-language="form_save" value="{$lang->form_save}">
                        
                         {* Logout *}
                        <a href="{$lang_link}user/logout" class="btn btn_black btn_account" data-language="user_logout">{$lang->user_logout}</a>
                    </div>
                    
                </form>
            </div>

            {* Orders history *}
            {if $orders}
                <div class="col-lg-7">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <span data-language="user_number_of_order">{$lang->user_number_of_order}</span>
                                </th>
                                <th>
                                    <span data-language="user_order_date">{$lang->user_order_date}</span>
                                </th>
                                <th>
                                    <span data-language="user_order_status">{$lang->user_order_status}</span>
                                </th>
                            </tr>
                        </thead>
                        {foreach $orders as $order}
                            <tr>
                                {* Order number *}
                                <td>
                                    <a href='{$language->label}/order/{$order->url}'><span data-language="user_order_number">{$lang->user_order_number}</span>{$order->id}</a>
                                </td>

                                {* Order date *}
                                <td>{$order->date|date}</td>

                                {* Order status *}
                                <td>
                                    {if $order->paid == 1}
                                        <span data-language="status_paid">{$lang->status_paid}</span>,
                                    {/if}
                                    {$orders_status[$order->status_id]->name|escape}
                                </td>
                            </tr>
                        {/foreach}
                    </table>
                </div>
            {/if}
        </div>
    </div>
</div>    