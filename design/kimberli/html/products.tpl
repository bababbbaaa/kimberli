{* The Categories page *}

{* The canonical address of the page *}
{if $set_canonical || $self_canonical}
    {if $category}
        {$canonical="/catalog/{$category->url}" scope=parent}
    {elseif $brand}
        {$canonical="/brands/{$brand->url}" scope=parent}
    {elseif $page->url=='discounted'}
        {$canonical="/discounted" scope=parent}
    {elseif $page->url=='bestsellers'}
        {$canonical="/bestsellers" scope=parent}
    {elseif $keyword}
        {$canonical="/all-products" scope=parent}
    {else}
        {$canonical="/all-products" scope=parent}
    {/if}
{/if}
{include file='popap/coupon.tpl'}
<div class="">
    <div class="row {if !$products}mb-3{/if}">
        <div class="col-md-12">
            {* The page heading *}
            <div class="wrap_heading_page" style="{if $category->image}background: url({$category->image|resize:1800:550:false:$config->resized_categories_dir}) no-repeat center top;{else if $page->image}background: url({$page->image|resize:1800:550:false:$config->resized_pages_dir}) no-repeat center top;{/if}">
                <div class="inner_heading_page">
                    {if $keyword}
                        <h1 class="heading_page"><span data-language="products_search">{$lang->products_search}</span> {$keyword|escape}</h1>
                    {elseif $page}
                        <h1 class="heading_page">
                            <span data-page="{$page->id}">{if $page->name_h1|escape}{$page->name_h1|escape}{else}{$page->name|escape}{/if}</span>
                        </h1>
                    {elseif $seo_filter_pattern->h1}
                        <h1 class="h1 heading_page">{$seo_filter_pattern->h1|escape}</h1>
                    {elseif $category->id == 114 && $filter_meta->h1}
                         <h1 class="h1 heading_page">{$filter_meta->h1|escape}</h1>
                    {else}
                        <h1 class="heading_page"><span data-category="{$category->id}">{if $category->name_h1|escape}{$category->name_h1|escape}{else}{$category->name|escape}{/if}</span> <br>
                        <span class="font_6e">{$brand->name|escape} {$filter_meta->h1|escape}</span>
                        </h1>
                    {/if}
                </div>
            </div>
        </div>
    </div>
    
    {if $products}
    <div class="wrap_border_bottom">
        <div class="row">
            <div class="col-md-6 hidden-md-down">
                {include file='breadcrumb.tpl'}
            </div>
            <div class="col-sm-6 col-md-6 hidden-lg-up">
                <div class="filters_heading_box fn_filter_switch">
                    <span data-language="filters">{$lang->filters}</span>
                    {include file='svg.tpl' svgId='arrow_right'}
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                {* Product Sorting *}
                <div class="fn_products_sort wrap_products_sort">
                    {include file="products_sort.tpl"}
                </div>
            </div>
        </div>
    </div>        
    {/if}
    
    <div class="row">
        <div class="sidebar col-lg-3 col-xl-25">

            <div class="fn_selected_features">
                {include 'selected_features.tpl'}
            </div>

            <div class="sidebar_top fn_features">
                {include file='categories.tpl'}
                {include file='features.tpl'}
            </div>
            
            <div class="hidden-md-down">
                {get_browsed_products var=browsed_products limit=4}
                {if $browsed_products}
                    <div class="filters_heading">
                        <span data-language="features_manufacturer">{$lang->features_browsed}</span>
                    </div>

                    <div class="browsed clearfix row">
                        {foreach $browsed_products as $browsed_product}
                            <div class="browsed_item col-xs-6 col-sm-3 col-lg-4">
                                <a href="{$lang_link}products/{$browsed_product->url}">
                                    {if $browsed_product->image->filename}
                                        <img src="{$browsed_product->image->filename|resize:70:70}" alt="{$browsed_product->name|escape}" title="{$browsed_product->name|escape}">
                                    {else}
                                        <img width="70" height="70" src="design/{$settings->theme}/images/no_image.png" alt="{$browsed_product->name|escape}" title="{$browsed_product->name|escape}"/>
                                    {/if}
                                </a>
                            </div>
                        {/foreach}
                    </div>
                {/if}
            </div>    
        </div>

        <div class="products_container col-lg-9 col-xl-85">
            {if $current_page_num == 1 && ($category->annotation || $brand->annotation) && !$is_filter_page && !$smarty.get.page && !$smarty.get.sort}
                <div class="block padding">
                    {* Краткое описание категории *}
                    {$category->annotation}

                    {* Краткое описание бренда *}
                    {$brand->annotation}
                </div>
            {/if}

            

            {* Product list *}
            <div id="fn_products_content" class="fn_categories products clearfix">
                {include file="products_content.tpl"}
            </div>

            {if $products}
                {* Friendly URLs Pagination *}
                <div class="fn_pagination">
                    {include file='chpu_pagination.tpl'}
                </div>
            {/if}

    {if $current_page_num == 1 && $page->description}
                <div class="block padding">
                    {$page->description}
                </div>
            {/if}

    {if $current_page_num == 1}
        {*SEO шаблон описания страницы фильтра*}
        {if $seo_filter_pattern->description}
            <div class="block padding">
                {$seo_filter_pattern->description}
            </div>
            {elseif (!$category || !$brand) && ($category->description || $brand->description) && !$is_filter_page && !$smarty.get.page && !$smarty.get.sort}
                <div class="block padding">
                    {* Описание категории *}
                    {$category->description}

                    {* Описание бренда *}
                    {$brand->description}
                </div>
            {/if}
    {/if}

        </div>
    </div>  
</div>      
