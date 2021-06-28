{* The main page template *}
{* The canonical address of the page *}
{$canonical="" scope=parent}

{* full page banner*}
{if $full_banner}{$full_banner}{/if}


{* Featured products *}
{get_featured_products var=featured_products limit=6}
{if $featured_products}
    <div class="featured_block ">
        <div class="container-fluid">
            <div class="heading_box">
                <span data-language="main_recommended_products">{$lang->main_recommended_products}</span>
            </div>

            <div class="fn-main_products main_products clearfix">
                {foreach $featured_products as $product}
                    <div class=" products_item col-sm-6 col-lg-3 col-xl-25">
                        {include "product_list.tpl"}
                    </div>
                {/foreach}
            </div>
            <div class="boxed_button">
                <a class="btn btn_big btn_white" href="{$lang_link}bestsellers" data-language="main_look_all"><span>{$lang->main_look_all}</span> <i></i></a>
            </div>
        </div>
    </div>    
{/if}

{* Banners collection *}
{if $collection }{$collection}{/if}

{* New products *}
{get_new_products var=new_products limit=5}
{if $new_products}
    <div class="new_block">
        <div class="container-fluid">
            <div class="heading_box">
                <span data-language="main_new_products">{$lang->main_new_products}</span>
            </div>

            <div class="fn-main_products main_products clearfix">
                {foreach $new_products as $product}
                    <div class="products_item col-sm-6 col-lg-3 col-xl-25">
                        {include "product_list.tpl"}
                    </div>
                {/foreach}
            </div>
            <div class="boxed_button">
                <a class="btn btn_big btn_white" href="{$lang_link}catalog" data-language="main_look_all"><span>{$lang->main_look_all}</span> <i></i></a>
            </div>
        </div>
    </div>        
{/if}

{* Banners grid for four *}
{if $pages_banner }{$pages_banner}{/if}

    
{* Last news *}    
{get_posts var=last_posts limit=3 type_post="news"}
{if $last_posts}
    <div class="post_block1 box_grey">
        <div class="container-fluid">
           <div class="heading_box">
                <span data-language="main_news">{$lang->main_news}</span>
            </div>

            <div class="news clearfix block row">
                {foreach $last_posts as $post}
                    <div class="news_item col-sm-4 px-2">
                        <div class="news_item_image">
                           <a class="news_image" href="{$lang_link}{$post->type_post}/{$post->url}">
                                {if $post->image}
                                    <img class="news_img" src="{$post->image|resize:650:650:false:$config->resized_blog_dir}" alt="{$post->name|escape}" title="{$post->name|escape}"/>
                                {/if}
                            </a>
                            {* News type *}
                            <div class="news_category">{$post->type_post}</div>
                        </div>
                        <div class="news_item_contents">
                            {* News date *}
                            <p class="date"><span>{$post->date|date}</span></p>
                            {* News name *}
                            <a class="title" href="{$lang_link}{$post->type_post}/{$post->url}" data-post="{$post->id}">{$post->name|escape}</a>
                            {* News text *}
                            <p class="annotation">{$post->annotation}</p>

                        </div>
                    </div>
                {/foreach}
            </div>
            <div class="boxed_button">
                <a class="btn btn_big btn_black" href="{$lang_link}news" data-language="main_all_news"><span>{$lang->main_all_news}</span><i></i></a>
            </div>
        </div>
    </div>
{/if}
    
{* Discount products *}
{get_discounted_products var=discounted_products limit=5}
{if $discounted_products}
    <div class="new_block">
        <div class="container-fluid">
            <div class="heading_box">
                <span data-language="main_discount_products">{$lang->main_discount_products}</span>
            </div>

            <div class="fn-main_products main_products clearfix">
                {foreach $discounted_products as $product}
                    <div class="products_item col-sm-6 col-lg-3 col-xl-25">
                        {include "product_list.tpl"}
                    </div>
                {/foreach}
            </div>
            <div class="boxed_button">
                <a class="btn btn_big btn_white" href="{$lang_link}discounted" data-language="main_look_all"><span>{$lang->main_look_all}</span> <i></i></a>
            </div>
        </div>
    </div>        
{/if}

    {* Banners 3 *}
{if $kamni} {$kamni} {/if}

{* Brand list *}
{*
{if $is_mobile === false || $is_tablet === true}
    {get_brands var=all_brands visible_brand=1}
    {if $all_brands}
        <div class="brands">
            <div class="container-fluid">
                <div class="heading_box">
                    <span data-language="main_brands">{$lang->main_brands}</span>
                </div>

                <div class="fn_all_brands all_brands block row">
                    {foreach $all_brands as $b}
                        <div class="brands_item">
                            <a class="all_brands_link" href="{$lang_link}brands/{$b->url}" data-brand="{$b->id}">
                                {if $b->image}
                                    <img class="brand_img" src="{$b->image|resize:180:90:false:$config->resized_brands_dir}" alt="{$b->name|escape}" title="{$b->name|escape}">
                                {else}
                                    <div class="brand_name">
                                        <span>{$b->name|escape}</span>
                                    </div>
                                {/if}
                            </a>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>        
    {/if}
{/if}
*}
    
    
    
    
    
    
    
    
    
{if  false }{*$is_mobile === false && $is_tablet === false*}
    <div class="advantages">
        <div class="container-fluid">
            <div class="advantages_item row">
                <div class="col-md-3 p-0">
                    <div class="advantage advantage_1">
                        {include file="svg.tpl" svgId="wishlist"}
                        <h3 data-language="advantage_1">{$lang->advantage_1}</h3>
                        <p>dsgfds fdsf df dsghdh</p>
                    </div>
                </div>
                <div class="col-md-3 p-0">
                    <div class="advantage advantage_2">
                        {include file="svg.tpl" svgId="wishlist"}
                        <h3 data-language="advantage_2">{$lang->advantage_2}</h3>
                        <p>dsgfds fdsf df dsghdh</p>
                    </div>
                </div>
                <div class="col-md-3 p-0">
                    <div class="advantage advantage_3">
                        {include file="svg.tpl" svgId="wishlist"}
                        <h3 data-language="advantage_3">{$lang->advantage_3}</h3>
                        <p>dsgfds fdsf df dsghdh</p>
                    </div>
                </div>
                <div class="col-md-3 p-0">
                    <div class="advantage advantage_4">
                        {include file="svg.tpl" svgId="wishlist"}
                        <h3 data-language="advantage_4">{$lang->advantage_4}</h3>
                        <p>dsgfds fdsf df dsghdh</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}

{if $page->description}
    <div class="advantages1 pb-2">
        <div class="container-fluid">
            <div class="heading_box">
                <span data-language="main_about_store" class="">{$lang->main_about_store}</span>
            </div>

            <div class="block padding">
                {*<h1 class="h4">{$page->name|escape}</h1>*}
                <div class="main_text">{$page->description}</div>
            </div>
        </div>    
    </div>
{/if}
    
    
