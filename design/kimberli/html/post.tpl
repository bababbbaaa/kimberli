{* Post page *}

{* The canonical address of the page *}
{if $smarty.get.type_post == "blog"}
    {$canonical="/blog/{$post->url}" scope=parent}
{else}
    {$canonical="/news/{$post->url}" scope=parent}
{/if}

{* The page heading *}

    <div class="wrap_heading_page mb-2" {if $post->image} style="background: rgb(36, 38, 38) url({$post->image|resize:1920:539:false:$config->resized_blog_dir});" {/if}>
        <div class="inner_heading_page txt_center">
          {*  <div class="type_heading_post">
                {$post->type_post}
            </div>*}
            <h1 class="heading_page">
                <span data-post="{$post->id}">{$post->name|escape}</span>
            </h1>
            <img class="border" src="design/{$settings->theme|escape}/images/heading_border.png" alt="post_border">
            <div class="heading_date">
                <span>{$post->date|date}</span>
            </div>
        </div>
    </div>
    

<div class="blog_container">
    <div class="adnin_formated">
        {*if $post->image}
            <img class="blog_img" src="{$post->image|resize:920:300:false:$config->resized_blog_dir}" alt="{$post->name|escape}" title="{$post->name|escape}">
        {/if*}
        

        {* Post content *}
        <div class="wrap_post_description">
            {$post->description}
        </div>
        
        {if $form}
            {$form}
        {/if}
        
        {* Social share *}
        <div class="post_share">
            <div class="share_text">
                <span data-language="{$translate_id['product_share']}">{$lang->product_share}:</span>
            </div>
            <div class="fn_share jssocials"></div>
        </div>

        {* Previous/Next posts *}
        {if $prev_post || $next_post}
            <div class="post_pagination">
                {if $prev_post}
                    <div class="prev">
                        <a href="{$smarty.get.type_post}/{$prev_post->url}"><i></i><span>{$prev_post->name}</span></a>
                    </div>
                {/if}
                {if $next_post}
                    <div class="next">
                        <a href="{$smarty.get.type_post}/{$next_post->url}"><span>{$next_post->name}</span> <i></i></a>
                    </div>
                {/if}
            </div>
        {/if}
    </div>
        {if $compilation }
             <div class="page_compilation">
            {* Product list *}
            <div id="fn_products_content" class="fn_categories products clearfix">
                {include file="compilation/products_content.tpl"}
            </div>
            </div>
        {/if}                


    <div id="comments">
        <div class="h2">
            <span data-language="post_comments">{$lang->post_comments}</span>
        </div>

        <div class="padding block">
            <div class="row">
                <div class="col-md-12">
                    {if $comments}
                        {function name=comments_tree level=0}
                            {foreach $comments as $comment}

                                {* Comment anchor *}
                                <a name="comment_{$comment->id}"></a>

                                {* Comment list *}
                                <div class="comment_item{if $level > 0} admin_note{/if}">

                                    <div class="comment_header">
                                        {* Comment name *}
                                        <span class="comment_author">{$comment->name|escape}</span>

                                        {* Comment date *}
                                        <span class="comment_date">{$comment->date|date}, {$comment->date|time}</span>

                                        {* Comment status *}
                                        {if !$comment->approved}
                                            <span data-language="post_comment_status">({$lang->post_comment_status})</span>
                                        {/if}
                                    </div>

                                    {* Comment content *}
                                    <div class="comment_content">
                                        {$comment->text|escape|nl2br}
                                    </div>

                                     {if isset($children[$comment->id])}
                                        {comments_tree comments=$children[$comment->id] level=$level+1}
                                    {/if}
                                </div>

                            {/foreach}
                        {/function}
                        {comments_tree comments=$comments}
                    {else}
                        <div class="no_comments">
                            <span data-language="post_no_comments">{$lang->post_no_comments}</span>
                        </div>
                    {/if}
                </div>

                <div class="col-md-12">
                   {* Comment form *}
                   <form id="fn_blog_comment" class="fn_validate_post comment_form"  method="post" action="">
                        
                        <div class="comment_write_heading">
                            <span data-language="post_write_comment">{$lang->post_write_comment}</span>
                        </div>

                        {* Form error messages *}
                        {if $error}
                            <div class="message_error">
                                {if $error=='captcha'}
                                    <span data-language="form_error_captcha">{$lang->form_error_captcha}</span>
                                {elseif $error=='empty_name'}
                                    <span data-language="form_enter_name">{$lang->form_enter_name}</span>
                                {elseif $error=='empty_comment'}
                                    <span data-language="form_enter_comment">{$lang->form_enter_comment}</span>
                                {elseif $error=='empty_email'}
                                    <span data-language="form_enter_email">{$lang->form_enter_email}</span>
                                {/if}
                            </div>
                        {/if}

                        <div class="row">
                            {* User's name *}
                            <div class="col-lg-6 form_group">
                                <input class="form_input" type="text" name="name" value="{$comment_name|escape}" placeholder="{$lang->form_name}*">
                            </div>

                            {* User's email *}
                            <div class="col-lg-6 form_group">
                                <input class="form_input" type="text" name="email" value="{$comment_email|escape}" placeholder="{$lang->form_email}"/>
                            </div>
                        </div>

                        {* User's comment *}
                        <div class="form_group">
                            <textarea class="form_textarea" rows="3" name="text" placeholder="{$lang->form_enter_comment}*">{$comment_text}</textarea>
                        </div>

                        {* Captcha *}
                        {if $settings->captcha_post}
                        {if $settings->captcha_type == "v2"}
                             <div class="captcha row" style="">
                                 <div id="recaptcha1"></div>
                             </div>
                        {elseif $settings->captcha_type == "default"}
                            {get_captcha var="captcha_post"}
                            <div class="captcha">
                                <div class="secret_number">{$captcha_post[0]|escape} + ? =  {$captcha_post[1]|escape}</div>
                                <input class="form_input input_captcha" type="text" name="captcha_code" value="" placeholder="{$lang->form_enter_captcha}*">
                            </div>
                        {/if}
                    {/if}
                   <input type="hidden" name="comment" value="1">

                        {* Submit button *}
                        <input class="btn btn_big btn_black btn_comment float-md-right g-recaptcha" type="submit" name="comment" data-language="form_send" {if $settings->captcha_type == "invisible"}data-sitekey="{$settings->public_recaptcha_invisible}" data-badge='bottomleft' data-callback="onSubmit"{/if} value="{$lang->form_send}">
                   </form>
               </div>
           </div>
        </div>
    </div>
</div>
                   
{* Related products *}
{if $related_products}
    <div class="featured_block ">
        <div class="">
            <div class="heading_box">
                <span data-language="product_recommended_products">{$lang->product_recommended_products}</span>
            </div>

            <div class="fn-main_products main_products clearfix">
                {foreach $related_products as $p}
                    <div class=" products_item col-sm-6 col-lg-3 col-xl-25">
                        {include "product_list.tpl" product = $p}
                    </div>
                {/foreach}
            </div>
        </div>
    </div>   
{/if}
