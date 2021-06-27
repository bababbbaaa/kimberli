{* The blog page template *}

{* The canonical address of the page *}
{if $smarty.get.type_post == "blog"}
    {$canonical="/blog" scope=parent}
    {else if $smarty.get.type_post == "partnerstvo"}
    {$canonical="/partnerstvo" scope=parent}
    {else}
    {$canonical="/news" scope=parent}
{/if}

<div class="blog_container">
    {* The page heading *}
    <div class="wrap_blog_heading_page">
        <h1 class="heading_page"><span data-page="{$page->id}">{if $page->name_h1|escape}{$page->name_h1|escape}{else}{$page->name|escape}{/if}</span></h1>
    </div>
    
    {* The list of the blog posts *}
    <div class="blog clearfix">
        {foreach $posts as $post}
            <div class="blog_item no_padding col-sm-12"> 

                {* The post image *}
                <a class="blog_image" href="{$lang_link}{$smarty.get.type_post}/{$post->url}">
                    {if $post->image}
                        <img class="blog_img" src="{$post->image|resize:880:458:false:$config->resized_blog_dir}" alt="{$post->name|escape}" title="{$post->name|escape}">
                    {/if}
                </a>

                <div class="blog_content">
                    {* News type *}
                    <a class="type" href="{$lang_link}{$post->type_post}/{$post->url}">{$post->type_post}</a>
                                
                    {* The post name *}
                    <div class="blog_title">
                        <a href="{$lang_link}{$smarty.get.type_post}/{$post->url}" data-post="{$post->id}">{$post->name|escape}</a>
                    </div>

                    {* The post date *}
                    <div class="blog_date"><span>{$post->date|date}</span></div>

                    {* The short description of the post *}
                    {if $post->annotation}
                        <div class="blog_annotation">
                            {$post->annotation}
                        </div>
                    {/if}     
                    
                    <a class="btn btn_big btn_post" href="{$lang_link}{$smarty.get.type_post}/{$post->url}" >
                        <span data-language="post_learn_more">{$lang->post_learn_more}</span> 
                        <i></i>
                    </a> 
                </div>
            </div>
        {/foreach}
    </div>

    {* Pagination *}
    {include file='pagination.tpl'}
</div>
