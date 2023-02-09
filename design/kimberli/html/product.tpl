{* Product page *}

{* The canonical address of the page *}
{$canonical="/products/{$product->url}" scope=parent}
{* Форма обратного звонка *}
{include file='product/quick_order.tpl'}

<div class="fn_product product wrap_product" itemscope itemtype="http://schema.org/Product">
    <meta itemprop="brand" content="{$brand->name|escape}">
    <meta itemprop="name" content="{$product->name|escape}">
    <meta itemprop="productID" content="{$product->id}">
    <meta itemprop="item_group_id" content="{$product->sku}">
    <div class="">
        <div class="product-container fn_transfer">
            <div class="product_breadcrumbs mob">
                {include file='breadcrumb.tpl'}
            </div>

            <h1 class="product_heading mob">
                <span data-product="{$product->id}" itemprop="name">{$product->name|escape} {*{if $product->variants|count == 1 && !empty($product->variant->name)}({$product->variant->name|escape}){/if}*}</span>
            </h1>
            <div class="product-preview {if $product->images|count > 1} {else} product-preview-empty {/if}">
                {* Additional product images *}
                {if $product->images|count > 1}
                    <div class="product-preview_mini">
                        {if $product->variant->discount}
                            <div class="product-preview_discount">
                                -{$product->variant->discount}%
                            </div>
                        {/if}
                        <div class="fn_images images clearfix">
                            {* cut removes the first image, if you need start from the second - write cut:2 *}
                            <div class="images_item">
                                <div class="images_link" data-link="{$product->image->filename|resize:1300:1300}" data-img="{$product->image->filename|resize:700:700}" data-zoom="{$product->image->filename|resize:1300:1300}">
                                    <img src="{$product->image->filename|resize:700:700}" alt="{$product->name|escape}"/>
                                </div>
                            </div>
                            {foreach $product->images|cut as $i=>$image}
                                <div class="images_item">
                                    <div class="images_link" data-link="{$image->filename|resize:1300:1300}" data-img="{$image->filename|resize:700:700}" data-zoom="{$image->filename|resize:1300:1300}">
                                        <img src="{$image->filename|resize:700:700}" alt="{$product->name|escape}"/>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                {/if}
                <div class="product-preview_main">
                    {if $product->variant->discount}
                        <div class="product-preview_discount">
                            -{$product->variant->discount}%
                        </div>
                    {/if}
                    <div class="product_image">
                        {* Main product image *}
                        {if $product->image}
                            <a href="{$product->image->filename|resize:1300:1300}" data-fancybox="group" data-caption="{$product->name|escape}">
                                <img {if $is_mobile == false && $is_tablet == false} id="zoom_image"{/if} class="fn_img product_img" itemprop="image" src="{$product->image->filename|resize:700:700}" data-zoom-image="{$product->image->filename|resize:1300:1300}" alt="{$product->name|escape}" title="{$product->name|escape}">
                            </a>
                        {else}
                            <img class="fn_img" src="design/{$settings->theme}/images/no_image.png" width="340" height="340" alt="{$product->name|escape}"/>
                        {/if}

                        {* Promo image *}
                        {if $product->special}
                            <img class="promo_img" alt='{$product->special}' title="{$product->special}"  src='files/special/{$product->special}'/>
                        {/if}
                    </div>
                </div>
                <div class="product-preview_benefits desktop-v {if $product->images|count > 1} {else} full {/if}">
                    <div class="product-preview_benefits_heading">{$lang->product_should_choose} Kimberli?</div>
                    <ul class="product-preview_benefits_list">
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_personal_consultations}</li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_handmade}</li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_high_quality_products}</li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_selected_stones}</li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_worldwide_delivery_choose}</li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_years_market}</li>
                        <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_clients_trust}</li>
                    </ul>
                </div>
            </div>


            <div class="product-content">
                <div class="product_details" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                    {* Schema.org *}
                    <span class="hidden">
                            <time itemprop="priceValidUntil" datetime="{$product->created|date:'Ymd'}"></time>
                            {if $product->variant->stock > 0}
                                <link itemprop="availability" href="https://schema.org/InStock" />
                            {else}
                            <link itemprop="availability" href="http://schema.org/OutOfStock" />
                            {/if}
                            <link itemprop="itemCondition" href="https://schema.org/NewCondition" />
                            <span itemprop="seller" itemscope itemtype="http://schema.org/Organization">
                            <span itemprop="name">{$settings->site_name}</span></span>
                            <link itemprop="url" href="{$config->root_url}{$lang_link}/products/{$product->url}" />
                        </span>

                    {* The product name *}
                    <div class="product_breadcrumbs desc">
                        {include file='breadcrumb.tpl'}
                    </div>

                    <h1 class="product_heading desc">
                        <span data-product="{$product->id}" itemprop="name">{$product->name|escape} {*{if $product->variants|count == 1 && !empty($product->variant->name)}({$product->variant->name|escape}){/if}*}</span>
                    </h1>

                    <div class="clearfix product_raits">
                        <span class="details_label" data-language="product_rating">{$lang->product_rating}:</span>

                        {* Product Rating *}
                        <div id="product_{$product->id}" class="product_rating"{if $product->rating > 0} itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating"{/if}>

                                <span class="rating_starOff">
                                    <span class="rating_starOn" style="width:{$product->rating*90/5|string_format:'%.0f'}px;"></span>
                                </span>
                            <span class="rating_text"></span>

                            {*Вывод количества голосов данного товара, скрыт ради микроразметки*}
                            {if $product->rating > 0}
                                <span class="hidden" itemprop="reviewCount">{$product->votes|string_format:"%.0f"}</span>
                                <span class="hidden" itemprop="ratingValue">({$product->rating|string_format:"%.1f"})</span>
                                {*Вывод лучшей оценки товара для микроразметки*}
                                <span class="hidden" itemprop="bestRating" style="display:none;">5</span>
                            {else}
                                <span class="hidden">({$product->rating|string_format:"%.1f"})</span>
                            {/if}
                        </div>
                        {* Stock *}
                        <div class="product_info row">
                            <div class="col-md-12">
                                {if $brand}
                                    <div class="product_brand clearfix">
                                        <span>{$lang->product_brand_name}:</span>
                                        <a href="{$lang_link}brands/{$brand->url}"><span>{$brand->name|escape}</span></a>
                                    </div>
                                {/if}

                                <div class="product_shtr clearfix{if !$product->variant->shtr} hidden{/if}">
                                    <span data-language="product_sku">{$lang->product_sku}:</span>
                                    <span class="fn_shtr shtr_nubmer" {if $product->variant->shtr}itemprop = "shtr"{/if}>{$product->variant->shtr|escape}</span>
                                </div>

                                <div class="product_sku clearfix{if !$product->variant->sku} hidden{/if}">
                                    <span data-language="product_shtr">{$lang->product_shtr}:</span>
                                    <span class="fn_sku sku_nubmer" {if $product->variant->sku}itemprop = "sku"{/if}>{$product->variant->sku|escape}</span>
                                </div>
                                {if $product->variant->certificate}
                                <div class="product_sku additional-sku clearfix">
                                    <span data-language="certificate_gia_hrd">{$lang->certificate_gia_hrd}:</span>
                                    <span class="fn_shtr sku_nubmer">
                                        {$product->variant->certificate}
                                    </span>
                                </div>
                                {/if}
                                {if $product->outlet}
                                    <div class="product_sku additional-sku clearfix">
                                        <span class="fn_shtr sku_nubmer">OUTLET</span>
                                    </div>
                                {/if}
                                {*<div class="">
                                    <span class="details_label quontity_label" data-language="product_quantity">
                                        {$lang->product_quantity}<span class="fn_units">{if $product->variant->units}, {$product->variant->units|escape}{/if}</span>:
                                    </span>
                                </div>*}
                            </div>
                        </div>
                    </div>
                    <form class="fn_variants" action="/{$lang_link}cart">
                        <div class="product_buy">
                            <div class="product_buy_top">
                                {if $product->variant->discount}
                                    <div class="product_buy_discount">
                                        <span>-{$product->variant->discount}%</span>
                                    </div>
                                {/if}
                                <div class="product_available">
                                    <span class="no_stock fn_not_stock{if $product->variant->stock > 0} hidden{/if}" data-language="product_estimated_price">{$lang->product_estimated_price}</span>
                                    <span class="fn_in_stock{if $product->variant->stock < 1} hidden{/if}" data-language="product_in_stock">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"/>
                                            </svg>
                                            {$lang->product_in_stock}
                                        </span>
                                </div>
                            </div>
                            <div class="product_buy_main">
                                <div class="product_prices {if $product->variant->stock <= 0} product_stock {/if}">

                                        {* Price *}
                                        <div class="price ">
                                            <meta property="product:price:amount" content="{$product->variant->price}">
                                            <meta property="product:price:currency" content="{$currency->code|escape}">
                                            <span class="fn_price" itemprop="price" content="{$product->variant->price}">{$product->variant->price|convert}</span>
                                            <span itemprop="priceCurrency" content="{$currency->code|escape}">{$currency->sign|escape}</span>
                                        </div>
                                        {* Old price *}
                                        <del class="old_price{if !$product->variant->compare_price} hidden{/if}">
                                            <span class="fn_old_price">{$product->variant->compare_price|convert}</span> {$currency->sign|escape}
                                        </del>

                                    <select name="variant" class="fn_variant variant_select hidden">
                                        {foreach $product->variants as $v}
                                            <option{if $product->variant->sku == $v->sku} selected{/if} value="{$v->id}" data-href="{$lang_link}/products/{$v->url}" data-price="{$v->price|convert}" data-stock="{$v->stock}"{if $v->compare_price > 0} data-cprice="{$v->compare_price|convert}"{/if}{if $v->sku} data-sku="{$v->sku|escape}"{/if} {if $v->units}data-units="{$v->units}"{/if}>{if $v->name}{$v->name|escape}{if $v->weight}, {$lang->weight} - {$v->weight}{/if} - {$v->price|convert} {$currency->sign|escape}{else}{$product->name|escape}{/if}</option>
                                        {/foreach}
                                    </select>
                                    <!--<div class="row">
                                        <div class="col-md-12">
                                            <div class="fn_is_stock product_inlines_box {if $product->variant->stock < 1} hidden{/if}">
                                                {* Quantity *}
                                                <div class="amount fn_product_amount">
                                                    <span class="minus">&minus;</span>
                                                    <input class="input_amount" type="text" name="amount" value="1" data-max="{$product->variant->stock}">
                                                    <span class="plus">&plus;</span>
                                                </div>
                                            </div>
        
                                            <div class="product_variants product_inlines_box {if $product->variants|count < 2} hidden{/if}">
                                                {* Product variants *}
                                                <select name="variant" class="fn_variant variant_select{if $product->variants|count < 2} hidden{/if}">
                                                    {foreach $product->variants as $v}
                                                        <option{if $product->variant->sku == $v->sku} selected{/if} value="{$v->id}" data-href="{$lang_link}/products/{$v->url}" data-price="{$v->price|convert}" data-stock="{$v->stock}"{if $v->compare_price > 0} data-cprice="{$v->compare_price|convert}"{/if}{if $v->sku} data-sku="{$v->sku|escape}"{/if} {if $v->units}data-units="{$v->units}"{/if}>{if $v->name}{$v->name|escape}{if $v->weight}, {$lang->weight} - {$v->weight}{/if} - {$v->price|convert} {$currency->sign|escape}{else}{$product->name|escape}{/if}</option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </div>
                                    </div>-->
        
                                </div>
                                <div class="wrap_product_buttons">
                                    <div class="product_buttons1 row">
                                        <div style="display: block;" class="block_quick_and_cart {if $product->variant->stock <= 0} col-sm-12 col-lg-6{/if}">
                                            {if !$settings->is_preorder}
                                                {* No stock *}
                                                <span class="fn_not_preorder {if $product->variant->stock > 0} hidden{/if}">
                                                    <button class="disable_button product_button1 btn btn_green btn-block btn_cart px-2" type="button" data-language="product_out_of_stock">{$lang->product_out_of_stock}</button>
                                                </span>
                                            {else}
                                                {* Preorder *}
                                                <span class="fn_is_preorder {if $product->variant->stock > 0} hidden{/if} ">
                                                    <button class="btn btn_green btn-block btn_cart px-2" type="submit"
        
                                                            onclick=" var dataLayer = window.dataLayer || [];
                                                            dataLayer.push({
                                                                    'event': 'add_to_cart',
                                                                    'value': '{$product->variant->price|escape}',
                                                                    'items': [
                                                                    {
                                                                    'id': '{$product->variant->sku|escape}',
                                                                    'google_business_vertical': 'retail'
                                                                    }
                                                                    ]
                                                                    });"
                                                         {*   onClick="fbq('track', 'AddToCart', {
           value: {$product->variant->price|escape},
           currency: 'UAH',
           content_ids: {$product->variant->sku|escape},
           content_type: 'product',
           content_name: '{$product->name|escape}',
           content_type: '{$category->name|escape}',
        });"*}
                                                            data-language="product_pre_order">{$lang->product_pre_order}</button>
                                                </span>
                                            {/if}
                                            {* Submit button *}
                                            <div class="col-sm-12 col-lg-6 {if $product->variant->stock < 1} hidden{/if}">
                                                <button class="fn_is_stock btn btn_green btn-block btn_cart px-2 fn_variants"
                                                       {* onClick="fbq('track', 'AddToCart', {
           value: {$product->variant->price|escape},
           currency: 'UAH',
           content_ids: {$product->variant->sku|escape},
           content_type: 'product',
           content_name: '{$product->name|escape}',
           content_type: '{$category->name|escape}',
        });"*}
        
                                                         onClick="gtag('event', 'AddToCart', {
                                                         'items': [
                            {
                                'name': '{$product->name|escape}',
                                'id': '{$product->variant->sku|escape}',
                                'price': {$product->variant->price|escape},
                                'category': '{$category->name|escape}',
                                'variant': '{$product->name|escape}',
                                'quantity': 1
                            }
                        ]
                        });"
                                                        type="submit" data-language="product_add_cart">
                                                    {include file="svg.tpl" svgId="shopping_cart"}
                                                    <span>{$lang->product_add_cart}</span>
                                                </button>
                                            </div>
                                            {* quick order button *}
                                            {if $product->variant->stock > 0}
                                                <div class="col-sm-12 col-lg-6">
                                                    <a class="product_button1 fn_quick_order btn btn_white btn-block btn_cart px-2"  title="{$lang->index_back_call}"
                                                      {* onClick="fbq('track', 'SpeedСall', {
           value: {$product->variant->price|escape},
           currency: 'UAH',
           content_ids: {$product->variant->sku|escape},
           content_type: 'product',
           content_name: '{$product->name|escape}',
           content_type: '{$category->name|escape}',
        });"*}
                                                       href="#fn_quick_order"
                                                       data-language="quick_order_header">
                                                        <span>{$lang->quick_order_header}</span>
                                                    </a>
                                                </div>
                                            {/if}
                                        </div>
                                        {if false}
                                            <div  class="block_dop_button">
                                                {* Wishlist *}
        
                                                {if $product->id|in_array:$wished_products}
                                                    <a href="#" data-id="{$product->id}" class="fn_wishlist selected product_wished"
                                                       title="{$lang->product_remove_favorite}"
                                                       data-result-text="{$lang->product_add_favorite}"
                                                       data-language="product_remove_favorite"
                                                    >
                                                        {include file="svg.tpl" svgId="wishlist"}
                                                    </a>
                                                {else}
                                                    <a href="#" data-id="{$product->id}" class="fn_wishlist product_wished"
                                                     {*  onClick="fbq('track', 'AddToWishlist', {
           value: {$product->variant->price|escape},
           currency: 'UAH',
           content_ids: {$product->variant->sku|escape},
           content_type: 'product',
           content_name: '{$product->name|escape}',
           content_type: '{$category->name|escape}',
        });"*}
                                                       title="{$lang->product_add_favorite}" data-result-text="{$lang->product_remove_favorite}" data-language="product_add_favorite">
                                                        {include file="svg.tpl" svgId="wishlist"}
                                                    </a>
                                                {/if}
        
        
                                                {* Comparison *}
        
                                                {if !in_array($product->id, $comparison->ids)}
                                                    <a class="fn_comparison product_comparison" href="#" data-id="{$product->id}" title="{$lang->product_add_comparison}" data-result-text="{$lang->product_remove_comparison}" data-language="product_add_comparison">
                                                        {include file="svg.tpl" svgId="comparison"}
                                                    </a>
                                                {else}
                                                    <a class="fn_comparison selected product_comparison" href="#" data-id="{$product->id}" title="{$lang->product_remove_comparison}" data-result-text="{$lang->product_add_comparison}" data-language="product_remove_comparison">
                                                        {include file="svg.tpl" svgId="comparison"}
                                                    </a>
                                                {/if}
                                                <a class="phone product_comparison binct-phone-number-2" href="tel:0932537677"  title="Phone"
                                                 {*  onClick="fbq('track', 'СallProduct', {
           value: {$product->variant->price|escape},
           currency: 'UAH',
           content_ids: {$product->variant->sku|escape},
           content_type: 'product',
           content_name: '{$product->name|escape}',
           content_type: '{$category->name|escape}',
        });" *}
                                                >
                                                    {include file="svg.tpl" svgId="callback"}
                                                </a>
                                                <a class="viber product_comparison" href="viber://pa?chatURI=kimberlijewelleryhouse" target="_blank" title="Viber"
                                                {*   onClick="fbq('track', 'ProductMessenger', {
           value: {$product->variant->price|escape},
           currency: 'UAH',
           content_ids: {$product->variant->sku|escape},
           content_type: 'product',
           content_name: '{$product->name|escape}',
           content_type: '{$category->name|escape}',
        });" *}
                                                >
                                                    {include file="svg.tpl" svgId="viber"}
                                                </a>
                                                <a class="telegram product_comparison" href="https://t.me/KIMBERLI_JEWELLERY_HOUSE_BOT" target="_blank" title="Telegram"
                                                  {* onClick="fbq('track', 'ProductMessenger', {
           value: {$product->variant->price|escape},
           currency: 'UAH',
           content_ids: {$product->variant->sku|escape},
           content_type: 'product',
           content_name: '{$product->name|escape}',
           content_type: '{$category->name|escape}',
        });" *}
                                                >
                                                    {include file="svg.tpl" svgId="telegram"}
                                                </a>
                                                <a class="messanger product_comparison" href="https://www.messenger.com/t/kimberlijewelleryhouse" target="_blank" title="Messanger"
                                                 {*  onClick="fbq('track', 'ProductMessenger', {
           value: {$product->variant->price|escape},
           currency: 'UAH',
           content_ids: {$product->variant->sku|escape},
           content_type: 'product',
           content_name: '{$product->name|escape}',
           content_type: '{$category->name|escape}',
        });" *}
                                                >
                                                    {include file="svg.tpl" svgId="messenger"}
                                                </a>
                                            </div>
                                        {/if}
        
                                    </div>
                                </div>
                                <div class="product_benefits">
                                    <div class="product_benefits_column">
                                        <div class="product_benefits_heading">{$lang->product_warranty}</div>
                                        <ul class="product_benefits_list">
                                            <li>{$lang->product_cleaning}</li>
                                            <li>{$lang->product_rhodium}</li>
                                            <li>{$lang->product_correction}</li>
                                        </ul>
                                    </div>
                                    <div class="product_benefits_column">
                                        <div class="product_benefits_heading">{$lang->product_delivery_free}</div>
                                        <ul class="product_benefits_list">
                                            <li>{$lang->product_pickup}</li>
                                            <li>{$lang->product_courier_delivery}</li>
                                            <li>{$lang->product_worldwide_delivery}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {if $product->annotation}
                            <div class="product_annotation">
                                {$product->annotation}
                            </div>
                        {/if}

                        {* *  <div class="product_info row">
                               <div class="col-md-12">
                                   {* Share buttons }
                                   <div class="product_share">
                                       <div class="fn_share jssocials"></div>
                                   </div>
                               </div>
                           </div>*}


                    </form>

                    <div class="product_tabs">
                        {if $product->description}
                            <div class="product_tab">
                                <div class="product_heading" data-language="product_description">{$lang->product_description}</div>
                                <div class="product_tab_content" itemprop="description">
                                    {$product->description}
                                </div>
                            </div>
                        {/if}
                        <div class="product-preview_benefits mobile-v">
                            <div class="product-preview_benefits_heading">{$lang->product_should_choose} Kimberli?</div>
                            <ul class="product-preview_benefits_list">
                                <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_personal_consultations}</li>
                                <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_handmade}</li>
                                <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_high_quality_products}</li>
                                <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_selected_stones}</li>
                                <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_worldwide_delivery_choose}</li>
                                <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_years_market}</li>
                                <li><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M4.19632 10.2058C4.04557 10.2058 3.89481 10.1481 3.77996 10.0333L0.172757 6.42595C-0.0575858 6.19571 -0.0575858 5.82345 0.172757 5.59322C0.402993 5.36298 0.775144 5.36298 1.00549 5.59322L4.19632 8.78406L10.9946 1.98591C11.2248 1.75567 11.597 1.75567 11.8273 1.98591C12.0575 2.21625 12.0575 2.5884 11.8273 2.81875L4.6128 10.0333C4.49795 10.1481 4.34708 10.2058 4.19632 10.2058Z" fill="#048225"></path> </svg> {$lang->product_clients_trust}</li>
                            </ul>
                        </div>
                        {if !$product->description}
                            <meta itemprop="description" content="{$product->name|escape}">
                        {/if}
                        {if $product->features}
                            <div class="product_tab">
                                <div class="product_tab_heading" data-language="product_features">{$lang->product_features}</div>
                                <div class="product_tab_content">
                                    <ul class="product_features_list">
                                        {foreach $product->features as $f}
                                            <li>
                                                <span class="product_feature_name"><span>{$f->name|escape}</span></span>
                                                <span class="product_feature_value">
                                                        {foreach $f->values as $value}
                                                            {if $category && $f->url_in_product && $f->in_filter && $value->to_index}
                                                                <a href="{$lang_link}catalog/{$category->url}/{$f->url}-{$value->translit}">{$value->value|escape}</a>{if !$value@last},{/if}
                                                            {else}
                                                                {$value->value|escape}{if !$value@last},{/if}
                                                            {/if}
                                                        {/foreach}
                                                    </span>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                                <div class="arrow">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.8" d="M1 1L7 7L13 1" stroke="black"/>
                                    </svg>
                                </div>
                            </div>
                        {/if}
                        {if $product->insertions}
                            <div class="product_tab">
                                <div class="product_tab_heading" data-language="product_insertions">{$lang->product_insertions}</div>
                                <div class="product_tab_content">
                                    {foreach $product->insertions as $i}
                                        <div class="insertions_tab_block">
                                            <span class="insertions_tab_title">{$i->title}</span>
                                            <ul class="product_features_list">
                                                <li>
                                                    <span class="product_feature_name">{$lang->insertions_name}</span>
                                                    <span class="product_feature_value">{$i->name}</span>
                                                </li>
                                                <li>
                                                    <span class="product_feature_name">{$lang->insertions_number}</span>
                                                    <span class="product_feature_value">{$i->count}</span>
                                                </li>
                                                <li>
                                                    <span class="product_feature_name">{$lang->insertions_weight}</span>
                                                    <span class="product_feature_value">{$i->mass}</span>
                                                </li>
                                            </ul>
                                        </div>
                                    {/foreach}
                                </div>
                                <div class="arrow">
                                    <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.8" d="M1 1L7 7L13 1" stroke="black"/>
                                    </svg>
                                </div>
                            </div>
                        {/if}
                        <div class="product_tab">
                            <div class="product_tab_heading" data-language="product_delivery_pay">{$lang->product_delivery_pay}</div>
                            <div class="product_tab_content">
                                <div class="insertions_tab_block">
                                    <span class="insertions_tab_title">{$lang->product_delivery_self_pickup_heading}</span>
                                    <p>{$lang->product_delivery_self_pickup_p1} <a href="{$lang_link}contact" target="_blank">{$lang->product_delivery_self_pickup_href}</a>.</p>
                                    <p>{$lang->product_delivery_self_pickup_p2}</p>
                                </div>
                                <div class="insertions_tab_block">
                                    <span class="insertions_tab_title">{$lang->product_delivery_del_ukraine_heading}</span>
                                    <p>{$lang->product_delivery_del_ukraine_p1}</p>
                                    <p>{$lang->product_delivery_del_ukraine_p2}</p>
                                </div>
                                <div class="insertions_tab_block">
                                    <span class="insertions_tab_title">{$lang->product_delivery_del_world_heading}</span>
                                    <p>{$lang->product_delivery_del_world_p1}</p>
                                    <p>{$lang->product_delivery_del_world_p2}</p>
                                </div>
                            </div>
                            <div class="arrow">
                                <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.8" d="M1 1L7 7L13 1" stroke="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="product_tab">
                            <div class="product_tab_heading" data-language="product_comments">{$lang->product_comments}</div>
                            <div class="product_tab_content">
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
                                        <span data-language="product_no_comments">{$lang->product_no_comments}</span>
                                    </div>
                                {/if}
                                <form id="captcha_id" class="comment_form fn_validate_product comment_form txt_left" method="post">

                                    <div class="comment_write_heading ">
                                        <span data-language="product_write_comment">{$lang->product_write_comment}</span>
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
                                        <div class="col-lg-12 col-xl-6 form_group">
                                            <input class="form_input" type="text" name="name" value="{$comment_name|escape}" placeholder="{$lang->form_name}*"/>
                                        </div>

                                        {* User's email *}
                                        <div class="col-lg-12 col-xl-6 form_group">
                                            <input class="form_input" type="text" name="email" value="{$comment_email|escape}" data-language="form_email" placeholder="{$lang->form_email}"/>
                                        </div>
                                    </div>

                                    {* User's comment *}
                                    <div class="form_group">
                                        <textarea class="form_textarea" rows="3" name="text" placeholder="{$lang->form_enter_comment}*">{$comment_text}</textarea>
                                    </div>

                                    {* Captcha *}
                                    {if $settings->captcha_product}
                                        {if $settings->captcha_type == "v2"}
                                            <div class="captcha">
                                                <div id="recaptcha1"></div>
                                            </div>
                                        {elseif $settings->captcha_type == "default"}
                                            {get_captcha var="captcha_product"}
                                            <div class="captcha">
                                                <div class="secret_number">{$captcha_product[0]|escape} + ? =  {$captcha_product[1]|escape}</div>
                                                <input class="form_input input_captcha" type="text" name="captcha_code" value="" placeholder="{$lang->form_enter_captcha}*"/>
                                            </div>
                                        {/if}
                                    {/if}
                                    <input type="hidden" name="comment" value="1">
                                    <input type="hidden" name="type" value="product">
                                    <input type="hidden" name="url" value="{$url}">
                                    <input type="hidden" name="object" value="{$product->id}">
                                    {* Submit button *}
                                    <input class="btn btn_big btn_black btn_comment g-recaptcha" style="margin-left: auto; display: block;" type="submit" name="comment" data-language="form_send" {if $settings->captcha_type == "invisible"}data-sitekey="{$settings->public_recaptcha_invisible}" data-badge='bottomleft' data-callback="onSubmit"{/if} value="{$lang->form_send}"/>
                                </form>
                            </div>
                            <div class="arrow">
                                <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.8" d="M1 1L7 7L13 1" stroke="black"/>
                                </svg>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    {if $product->youtube}
        <div class="atelier-movie">
            <iframe width="100%" height="100%"  src="https://www.youtube.com/embed/{$product->youtube}?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    {/if}
    <div class="">

        {* Previous/Next product *}
        {if $prev_product || $next_product}
            <div class="page_container">
                <div class="post_pagination">
                    {if $prev_product}
                        <div class="prev">
                            <a href="{$lang_link}products/{$prev_product->url}"><i></i><span>{$prev_product->name|escape}</span></a>
                        </div>
                    {/if}
                    {if $next_product}
                        <div class="next">
                            <a href="{$lang_link}products/{$next_product->url}"><span>{$next_product->name|escape}</span><i></i></a>
                        </div>
                    {/if}
                </div>
            </div>
        {/if}
    </div>
</div>


{* Related products *}
{*var_dump($related_products)*}

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

{if $related_posts}
    <div class="post_block ">
        <div class="">
            <div class="heading_box">
                <span data-language="product_related_post">{$lang->product_related_post}</span>
            </div>

            <div class="news clearfix block row">
                {foreach $related_posts as $r_p}
                    <div class="news_item col-sm-4">

                        <div class="news_item_image">
                            <a class="news_image" href="{$lang_link}{$r_p->type_post}/{$r_p->url}">
                                {if $r_p->image}
                                    <img class="news_img" src="{$r_p->image|resize:650:650:false:$config->resized_blog_dir}" alt="{$r_p->name|escape}" title="{$r_p->name|escape}"/>
                                {/if}
                            </a>
                        </div>
                        <div class="news_item_content">
                            {* News type *}
                            <a class="type" href="{$lang_link}}{$r_p->type_post}/{$r_p->url}">{$post->type_post}</a>

                            {* News name *}
                            <a class="title" href="{$lang_link}}{$r_p->type_post}/{$r_p->url}" data-post="{$r_p->id}">{$r_p->name|escape}</a>

                            {* News date *}
                            <p class="date"><span>{$r_p->date|date}</span></p>
                            
                            {* The short description of the post *}
                            {*<div class="blog_annotation">{$r_p->annotation}</div>*}
                        </div>
                    </div>
                {/foreach}
            </div>
        </div>
    </div>
{/if}

<script>
    $('.product_tab_heading').on('click', function() {
        if($(this).closest('.product_tab').hasClass('active')){
            $('.product_tab').removeClass('active');
        }else{
            $('.product_tab').removeClass('active');
            $(this).closest('.product_tab').addClass('active');
        }
    });

        $('#video-play').on('click', function(evt) {
        var video = $('.atelier-movie video')[0];

        video.play();
        video.controls = true;

        video.addEventListener('ended', f);
        $('.atelier-movie').addClass('active');

        function f(){
        $('.atelier-movie').removeClass('active');
        video.controls = false;
    }

    });
    var dataLayer = window.dataLayer || [];
    dataLayer.push({
        'event': 'view_item',
       // event_id: (new Date()).getTimezoneOffset()/1000,
        'value': '{$product->variant->price|escape}',
        'items': [
            {
                'id': '{$product->variant->sku|escape}',
                'google_business_vertical': 'retail'
            }
        ]
    });
</script>
{*
{literal}

<script>

fbq('track', 'ViewContent', {
    event_id: (new Date()).getTimezoneOffset()/1000,
    value: {/literal}{$product->variant->price|escape}{literal},
   currency: 'UAH',
   content_ids: {/literal}{$product->variant->sku|escape}{literal},
   content_type: 'product',
    product: '{/literal}{$product->name|escape}{literal}',
    product_group: '{/literal}{$category->name|escape}{literal}',
});
   </script>
{/literal}
*}

{*микроразметка по схеме JSON-LD*}
{*
Микроразметка Json-LD отключена в связи с тем, что Яндекс не воспринимает Json-LD,
а Google расценивает двойную разметку (Microdata и Json-LD) как спам.
Если нужно разметить для Яндекс, то включаем Json-LD, а Microdata отключаем.
*}
{*
{literal}
<script type="application/ld+json">
{
"@context": "http://schema.org/",
"@type": "Product",
"name": "{/literal}{$product->name|escape}{literal}",
"image": "{/literal}{$product->image->filename|resize:330:300}{literal}",
"description": "{/literal}{$product->annotation|strip_tags|escape}{literal}",
"mpn": "{/literal}{if $product->variant->sku}{$product->variant->sku|escape}{else}Не указано{/if}{literal}",
{/literal}
{if $brand->name}
{literal}
"brand": {
"@type": "Brand",
"name": "{/literal}{$brand->name|escape}{literal}"
},
{/literal}
{/if}
{if $product->rating > 0}
{literal}
"aggregateRating": {
"@type": "AggregateRating",
"ratingValue": "{/literal}{$product->rating|string_format:'%.1f'}{literal}",
"ratingCount": "{/literal}{$product->votes|string_format:'%.0f'}{literal}"
},
{/literal}
{/if}
{literal}
"offers": {
"@type": "Offer",
"priceCurrency": "{/literal}{$currency->code|escape}{literal}",
"price": "{/literal}{$product->variant->price|convert:null:false}{literal}",
"priceValidUntil": "{/literal}{$smarty.now|date_format:'%Y-%m-%d'}{literal}",
"itemCondition": "http://schema.org/NewCondition",
{/literal}
{if $product->variant->stock > 0}
{literal}
"availability": "http://schema.org/InStock",
{/literal}
{else}
{literal}
"availability": "http://schema.org/OutOfStock",
{/literal}
{/if}
{literal}
"seller": {
"@type": "Organization",
"name": "{/literal}{$settings->site_name|escape}{literal}"
}
}
}
</script>
{/literal}
*}
