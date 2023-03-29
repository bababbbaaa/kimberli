<!DOCTYPE html>
<html {if $language->href_lang}lang="{$language->href_lang|escape}"{/if} prefix="og: http://ogp.me/ns#">
<head>
    {* Full base address *}
    <base href="{$config->root_url}/">

    {* Meta data *}
    {include "head.tpl"}

    {* Favicon *}
    <link href="design/{$settings->theme}/images/favicon.png" type="image/x-icon" rel="icon">
    <link href="design/{$settings->theme}/images/favicon.png" type="image/x-icon" rel="shortcut icon">

    {* JQuery *}
    <script src="design/{$settings->theme}/js/jquery-2.1.4.min.js{if $js_version}?v={$js_version}{/if}"></script>

    {* Slick slider *}
    <script src="design/{$settings->theme}/js/slick.min.js{if $js_version}?v={$js_version}{/if}"></script>

    {* Match height *}
    <script src="design/{$settings->theme}/js/jquery.matchHeight-min.js{if $js_version}?v={$js_version}{/if}"></script>

    {* Fonts *}
    {*<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i&amp;subset=cyrillic" rel="stylesheet">*}

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>

    {* CSS *}

    <link href="design/{$settings->theme|escape}/css/okay.css{if $css_version}?v={$css_version}{/if}" rel="stylesheet">
    <link href="design/{$settings->theme|escape}/css/media.css{if $css_version}?v={$css_version}{/if}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fork-awesome@1.1.7/css/fork-awesome.min.css" >


    {if $counters['head']}
        {foreach $counters['head'] as $counter}
            {$counter->code}
        {/foreach}
    {/if}

    {if $settings->captcha_type == "v2"}
        <script type="text/javascript">
            var onloadCallback = function() {
                mysitekey = "{$settings->public_recaptcha}";
                if($('#recaptcha1').size()>0){
                    grecaptcha.render('recaptcha1', {
                        'sitekey' : mysitekey
                    });
                }
                if($('#recaptcha2').size()>0){
                    grecaptcha.render('recaptcha2', {
                        'sitekey' : mysitekey
                    });
                }
            };
        </script>
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
    {elseif $settings->captcha_type == "invisible"}
        <script>
            function onSubmit(token) {
                document.getElementById("captcha_id").submit();
            }
            function onSubmitCallback(token) {
                document.getElementById("fn_callback").submit();
            }
            function onSubmitBlog(token) {
                document.getElementById("fn_blog_comment").submit();
            }
        </script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
    {/if}
    {include file='../common/header_scripts.tpl'}

</head>
<body>
{include file='../common/body_scripts.tpl'}
{if $counters['body_top']}
    {foreach $counters['body_top'] as $counter}
        {$counter->code}
    {/foreach}
{/if}

{* Header *}
<header>
    <div class="top_header">
        <div class="container-fluid">
            <div class="row">
                {if $is_mobile !== true }
                <div class="leftbar col-lg-5">
                    <div class="inner">
                        <div class="clone_menu"></div>
                        {* Search *}
                        <div id="search" class="informer hidden-md-down">
                            <form id="fn_search" class="" action="{$lang_link}all-products">
                                {*<div class="actions">
                                    <span title="Search" class="fn-action_serch search">{include file="svg.tpl" svgId="search_icon"}</span>
                                </div>*}
                                <div class="field search">
                                    <input class="fn_search search_input" type="text" name="keyword" value="{$keyword|escape}" data-language="index_search" placeholder="{$lang->index_search}"/>
                                    <button class="search_button" type="submit">{include file="svg.tpl" svgId="search_icon"}</button>
                                </div>
                            </form>
                        </div>

                        {* Comparison informer
                        <div id="comparison" class="informer">
                            {include "comparison_informer.tpl"}
                        </div>
                        *}
                    </div>
                </div>
                {/if}
                <div class="centerbar hidden-md-down col-lg-2">
                    <div class="inner">
                        {* Logo *}
                        <a class="logo" href="{if $smarty.get.module=='MainView'}javascript:;{else}{$lang_link}{/if}">
                            <img src="design/{$settings->theme|escape}/images/{$settings->site_logo}" alt="{$settings->site_name|escape}"/>
                            {*<span class="font_logo" data-language="site_name">{$lang->site_name}</span>*}
                        </a>
                    </div>
                </div>
                <div class="rightbar col-lg-5">
                    <div class="inner">
                        <div class="mobi_menu">
                            {if $is_mobile === true }

                                <div class="wrap_navigation">
                                    {* Catalog heading *}
                                    <div class="categories_heading  hidden-lg-up">
                        <span class="fn_menu_switch icon_category_mobile">
                            <div class="no_active">{include file="svg.tpl" svgId="menu_icon"}</div>
                            <div class="active">{include file="svg.tpl" svgId="menu_close"}</div>
                        </span>
                                        <a class="logo" href="{if $smarty.get.module=='MainView'}javascript:;{else}{$lang_link}{/if}">
                                            {*<span class="font_logo" data-language="site_name">{$lang->site_name}</span>*}
                                            <img src="design/{$settings->theme|escape}/images/{$settings->site_logo}" alt="{$settings->site_name|escape}"/>
                                        </a>
                                    </div>

                                    <div id="menu_top">
                                        <div id="search" class="informer">
                                            <form id="fn_search" class="" action="{$lang_link}all-products">
                                                {*<div class="actions">
                                                    <span title="Search" class="fn-action_serch search">{include file="svg.tpl" svgId="search_icon"}</span>
                                                </div>*}
                                                <div class="field search">
                                                    <input class="fn_search search_input" type="text" name="keyword" value="{$keyword|escape}" data-language="index_search" placeholder="{$lang->index_search}"/>
                                                    <button class="search_button" type="submit">{include file="svg.tpl" svgId="search_icon"}</button>
                                                </div>
                                            </form>
                                        </div>
                                        {* Main menu *}
                                        <div class="menu">
                                            <div class="menu_item level1 menu_item_categories">
                                                <a class="menu_link {if $is_mobile || $is_tablet }fn_cat_switch categories_eventer{/if}" href="{if $is_mobile === false && $is_tablet === false}{$lang_link}catalog/all{/if}">
                                                    <i class="cat_switch2 hidden-md-down">{include file='svg.tpl' svgId='menu_icon'}</i>
                                                    <span data-language="index_categories">{$lang->index_categories}</span>
                                                </a>
                                                {include file='header_categories.tpl'}
                                            </div>
                                            {*{foreach $pages as $p}
                                                {if $p->menu_id == 1}
                                                    <li class="menu_item level1">
                                                        <a class="menu_link" data-page="{$p->id}" href="{$lang_link}{$p->url}">{$p->name|escape}</a>
                                                    </li>
                                                {/if}
                                             {/foreach}*}
                                            {$menu_header}
                                        </div>
                                        <div class="account mobile-menu-lnk">
                                            {if $user}
                                                {* User account *}
                                                <a class="account_link" href="{$lang_link}user" data-language="index_account" title="{$lang->index_account}">
                                                    {include file="svg.tpl" svgId="user"}
                                                    <span class="account_name">{$user->name|escape}</span>
                                                </a>
                                            {else}
                                                {* Login *}
                                                <a class="account_link" href="javascript:;" onclick="document.location.href = '{$lang_link}user/login'" title="{$lang->index_login}">
                                                    {include file="svg.tpl" svgId="user"}
                                                    <span>{$lang->user_title}</span>
                                                </a>
                                            {/if}
                                        </div>
                                        {* Wishlist informer *}
                                        <div class="wishlist-data mobile-menu-lnk">
                                            {include file="wishlist_informer.tpl"}
                                        </div>
                                        {* Callback *}
                                        <a class="callback1 informer binct-phone-number-1"  title="{$lang->index_back_call}" href="tel:0932537677" data-language="index_back_call">
                                            {include file="svg.tpl" svgId="callback"}
                                        </a>
                                    </div>

                                </div>
                            {/if}
                        </div>
                        {* Call *}
                        <div class="phone1 informer hidden-md-down">
                            {*include file="svg.tpl" svgId="phone"*}
                            <a class="phone binct-phone-number-1" href="tel:0932537677" title="Phone">
                                <span class="">0932537677</span>
                            </a>
                        </div>
                        <div class="account informer hidden-md-down">
                            {if $user}
                                {* User account *}
                                <a class="account_link" href="{$lang_link}user" data-language="index_account" title="{$lang->index_account}">
                                    {include file="svg.tpl" svgId="user"}
                                    <span class="account_name hidden-md-down">{$user->name|escape}</span>
                                </a>
                            {else}
                                {* Login *}
                                <a class="account_link hidden-md-down" href="javascript:;" onclick="document.location.href = '{$lang_link}user/login'" title="{$lang->index_login}">
                                    {include file="svg.tpl" svgId="user"}
                                </a>
                            {/if}
                        </div>
                        {* Wishlist informer *}
                        <div id="wishlist" class="informer hidden-md-down wishlist-data">
                            {include file="wishlist_informer.tpl"}
                        </div>

                        {* Cart informer*}
                        <div id="cart_informer" class="informer">
                            {include file='cart_informer.tpl'}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="navigation header_bottom">
        <div class="container-fluid">
            {if $is_mobile === false }
                <div class="wrap_navigation">
                    {* Catalog heading *}
                    <div class="categories_heading  hidden-lg-up">
                        <span class="fn_menu_switch icon_category_mobile">
                           {include file="svg.tpl" svgId="menu_icon"}
                        </span>
                        <a class="logo" href="{if $smarty.get.module=='MainView'}javascript:;{else}{$lang_link}{/if}">
                            {*<span class="font_logo" data-language="site_name">{$lang->site_name}</span>*}
                            <img src="design/{$settings->theme|escape}/images/{$settings->site_logo}" alt="{$settings->site_name|escape}"/>
                        </a>
                    </div>

                    <div id="menu_top">
                        {* Main menu *}
                        <div class="menu">
                            <div class="menu_item level1 menu_item_categories">
                                <a class="menu_link {if $is_mobile || $is_tablet }fn_cat_switch categories_eventer{/if}" href="{if $is_mobile === false && $is_tablet === false}{$lang_link}catalog/all{/if}">
                                    <i class="cat_switch2 hidden-md-down">{include file='svg.tpl' svgId='menu_icon'}</i>
                                    <i class="cat_switch hidden-lg-up">{include file='svg.tpl' svgId='arrow_triangle'}</i>
                                    <span data-language="index_categories">{$lang->index_categories}</span>
                                </a>
                                {include file='header_categories.tpl'}
                            </div>
                            {*{foreach $pages as $p}
                                {if $p->menu_id == 1}
                                    <li class="menu_item level1">
                                        <a class="menu_link" data-page="{$p->id}" href="{$lang_link}{$p->url}">{$p->name|escape}</a>
                                    </li>
                                {/if}
                             {/foreach}*}
                            {$menu_header}
                        </div>
                    </div>

                </div>
            {/if}
        </div>
    </div>
</header>

{* Content *}
<div id="fn_content"  class="main">
    <div class="{if $module != 'MainView'}container-fluid fliud-tag{/if}">
        {if $smarty.get.module !== "ProductsView" && $smarty.get.module !== "ProductView" && $smarty.get.module !== "OrderView" && $page->url !== '404'}
            {include file='breadcrumb.tpl'}
        {/if}
        <div class="fn_ajax_content">
            {*include file='popap/coupon.tpl'*}
            {*include file='popap/info.tpl'*}
            {*include file='popap/vd_13.tpl'*}
            {*include file='popap/sale.tpl'*}
            {include file='popap/quiz.tpl'}
            {$content}
        </div>
    </div>
</div>

{* Top up *}
<div class="to_top">
    <i class="fa fa-long-arrow-up"></i>
</div>

{* Footer *}
<footer>
    <div class="subscribe_block">
        <div class="container-fluid">
            {* Subscribing *}
            <div id="subscribe_container">
                <div class="icon_subscribe">
                    {include file="svg.tpl" svgId="newsletter_icon"}
                </div>
                <div class="subscribe_heading">
                    <span data-language="subscribe_heading">{$lang->subscribe_heading}</span>
                </div>

                <div class="subscribe_promotext">
                    <span data-language="subscribe_promotext">{$lang->subscribe_promotext}</span>
                </div>

                <form class="subscribe_form fn_validate_subscribe" method="post">
                    <input type="hidden" name="subscribe" value="1"/>

                    <div class="form_group">
                        <input class="subscribe_input" type="email" name="subscribe_email" value="" data-format="email" placeholder="{$lang->form_email}"/>
                    </div>

                    <div class="boxed_button">
                        {* Submit button *}
                        <button class="btn btn_black subscribe_button" type="submit"><span data-language="subscribe_button">{$lang->subscribe_button}</span><i></i></button>
                    </div>

                    {if $subscribe_error}
                        <div id="subscribe_error" class="popup">
                            {if $subscribe_error == 'email_exist'}
                                <span data-language="subscribe_already">{$lang->index_subscribe_already}</span>
                            {/if}
                            {if $subscribe_error == 'empty_email'}
                                <span data-language="form_enter_email">{$lang->form_enter_email}</span>
                            {/if}
                        </div>
                    {/if}

                    {if $subscribe_success}
                        <div id="fn_subscribe_sent" class="popup">
                            <span data-language="subscribe_sent">{$lang->index_subscribe_sent}</span>
                        </div>
                    {/if}
                </form>
            </div>
        </div>
    </div>
    <div class="footer_top">
        <div class="container-fluid">
            {* Logo *}
            <div class="logo_footer">
                <a class="logo" href="{if $smarty.get.module=='MainView'}javascript:;{else}{$lang_link}{/if}">
                    {*<img src="design/{$settings->theme|escape}/images/logo.png" alt="{$settings->site_name|escape}"/>*}
                    {*<span class="font_logo" data-language="site_name">{$lang->site_name}</span>*}
                    <img src="design/{$settings->theme|escape}/images/{$settings->site_logo}" alt="{$settings->site_name|escape}"/>
                </a>
            </div>

            {* Main menu *}
            <div class="menu_footer">
                {*<ul>
                    {foreach $pages as $p}
                        {if $p->menu_id == 1}
                            <li class="foot_item">
                                <a href="{$lang_link}{$p->url}">{$p->name|escape}</a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>*}
                {$menu_footer}
            </div>

            {* Social buttons *}
            <div class="foot_social">
                <a class="phone binct-phone-number-1" href="tel:0932537677"  title="Phone">
                    {include file="svg.tpl" svgId="callicon"}
                </a>
                <a class="fb" href="https://facebook.com/Kimberli-Jewellery-House-155258051160989" target="_blank" title="Facebook">
                    {include file="svg.tpl" svgId="facebookicon"}
                </a>
                <a class="ins" href="https://www.instagram.com/kimberli.ua/" target="_blank"  title="Instagram">
                    {include file="svg.tpl" svgId="instagramicon"}
                </a>
                <a class="tl telegram" href="https://t.me/KIMBERLI_JEWELLERY_HOUSE_BOT" target="_blank" title="Telegram">
                    {include file="svg.tpl" svgId="telegrammicon"}
                </a>
                <a class="vb viber" href="viber://pa?chatURI=kimberlijewelleryhouse" target="_blank" title="Viber">
                    {include file="svg.tpl" svgId="vibericon"}
                </a>
                <a class="fbm messanger" href="https://www.messenger.com/t/kimberlijewelleryhouse" target="_blank" title="Messanger">
                    {include file="svg.tpl" svgId="messangericon"}
                </a>
                {*<a class="tw" href="https://twitter.com/okaycms" target="_blank" title="Twitter">
                    <i class="fa fa-twitter"></i>
                </a>
                <a class="gp" href="{$lang_link}#" target="_blank" title="Google plus">
                    <i class="fa fa-google-plus"></i>
                </a>*}
            </div>
        </div>
    </div>
    <div class="footer_bottom">
        <div class="container-fluid">
            <p class="float-sm-left">
                <span>© {$smarty.now|date_format:"%Y"}</span>

                <span data-language="index_copyright">{$lang->index_copyright}</span>

                {*<a id="sm_logo" href="https://simplamarket.com/" target="_blank" title="Сделано в Simplamarket" style="margin-left: 10px;"><img src="design/{$settings->theme|escape}/images/sm_logo.png" /></a>*}
            </p>
            <div class="float-sm-right">
                <ul class="informers">
                    {* Languages *}
                    {if $languages|count > 1}
                        {$cnt = 0}
                        {foreach $languages as $ln}
                            {if $ln->enabled}
                                {$cnt = $cnt+1}
                            {/if}
                        {/foreach}
                        {if $cnt>1}
                            <li class="informer languages">
                                <div class="fn_switch_dropdown wrap_dropdown lang_switch">
                                    <span class="informer_name tablet-hidden">{$language->current_name}</span>
                                    <span class="informer_name lg-hidden">{$language->label}</span>
                                    <i class="fa fa-caret-down" aria-hidden="true" style="margin-left: 5px; margin-right: 5px;"></i>

                                    <div class="dropdown-menu">
                                        {foreach $languages as $l}
                                            {if $l->enabled}
                                                <a class="dropdown_item{if $language->id == $l->id} active{/if}"
                                                   href="{preg_replace('/^(.+)\/$/', '$1', $l->url)}">
                                                    <span class="tablet-hidden">{$l->current_name}</span>
                                                    <span class="lg-hidden">{$l->label}</span>
                                                </a>
                                            {/if}
                                        {/foreach}
                                    </div>
                                </div>
                            </li>
                        {/if}
                    {/if}

                    {* Currencies *}
                    {if $currencies|count > 1}
                        <li class="informer currencies">
                            <div class="fn_switch_dropdown wrap_dropdown cur_switch">

                                {*<span class="informer_name tablet-hidden">{$currency->name}</span>*}
                                <span data-language="currency_name">{$lang->currency_name}:</span>
                                <span class="informer_name lg-hidden">{$currency->sign}</span>
                                <i class="fa fa-caret-down" aria-hidden="true" style="margin-left: 5px; margin-right: 5px;"></i>

                                <div class="dropdown-menu">
                                    {foreach $currencies as $c}
                                        {if $c->enabled}
                                            <a class="dropdown_item{if $currency->id== $c->id} active{/if}" href="#" onClick="change_currency({$c->id}); return false;">
                                                <span class="tablet-hidden">{$c->name}</span>
                                                <span class="lg-hidden">{$c->sign}</span>
                                            </a>
                                        {/if}
                                    {/foreach}
                                </div>
                            </div>
                        </li>
                    {/if}
                </ul>
            </div>
        </div>
    </div>
</footer>



{* Временный код *}

{* Shop opening hours *}
{*<div class="times">
    <div class="times_inner">
        <span class="times_text" data-language="index_we_open">{$lang->index_we_open}</span>
        <div><span data-language="company_open_hours">{$lang->company_open_hours}</span></div>
    </div>
</div>*}

{* Phones *}
{*<div class="phones">
    <div class="phones_inner">
        <div><a href="tel:{$lang->company_phone_1}" data-language="company_phone_1" >{$lang->company_phone_1}</a></div>
        <div><a href="tel:{$lang->company_phone_2}" data-language="company_phone_2" >{$lang->company_phone_2}</a></div>
    </div>
</div>*}

{* Catalog heading *}
{*<div class="categories_heading fn_switch">
    {include file="svg.tpl" svgId="menu_icon"}
    <span class="small-hidden" data-language="index_categories">{$lang->index_categories}</span>
</div>*}

{*include file="categories.tpl"*}



{* Форма обратного звонка *}
{include file='callback.tpl'}

{* Всплывающая корзина *}
{include file='cart/cart_popap_block.tpl'}


{*template scripts*}
{* JQuery UI *}
{* Библиотека с "Slider", "Transfer Effect" *}
<script src="design/{$settings->theme}/js/jquery-ui.min.js{if $js_version}?v={$js_version}{/if}"></script>

{* Fancybox *}
<link href="design/{$settings->theme|escape}/css/jquery.fancybox.min.css{if $css_version}?v={$css_version}{/if}" rel="stylesheet">
<script src="design/{$settings->theme|escape}/js/jquery.fancybox.min.js{if $js_version}?v={$js_version}{/if}" defer></script>

{* Autocomplete *}
<script src="design/{$settings->theme}/js/jquery.autocomplete-min.js{if $js_version}?v={$js_version}{/if}" defer></script>

<script src="design/{$settings->theme}/js/jquery.mask.js{if $js_version}?v={$js_version}{/if}" defer></script>

{* Social share buttons *}
{if $smarty.get.module == 'ProductView' || $smarty.get.module == "BlogView"}
    <link href="design/{$settings->theme|escape}/css/jssocials.css{if $css_version}?v={$css_version}{/if}" rel="stylesheet">
    <link href="design/{$settings->theme|escape}/css/jssocials-theme-flat.css{if $css_version}?v={$css_version}{/if}" rel="stylesheet">
    <script src="design/{$settings->theme|escape}/js/jssocials.min.js{if $js_version}?v={$js_version}{/if}" ></script>
{/if}

{* Zoom image *}
{if $smarty.get.module == 'ProductView'}
    <script src="design/{$settings->theme|escape}/js/jquery.elevatezoom.js{if $js_version}?v={$js_version}{/if}" type="text/javascript"></script>
{/if}

{$admintooltip}

{*JQuery Validation*}
<script src="design/{$settings->theme}/js/jquery.validate.min.js{if $js_version}?v={$js_version}{/if}" ></script>
<script src="design/{$settings->theme}/js/additional-methods.min.js{if $js_version}?v={$js_version}{/if}"></script>

{* Okay *}
{include file="scripts.tpl"}
<script src="design/{$settings->theme}/js/okay.js{if $js_version}?v={$js_version}{/if}"></script>

{*template scripts*}

{if $counters['body_bottom']}
    {foreach $counters['body_bottom'] as $counter}
        {$counter->code}
    {/foreach}
{/if}
</body>
</html>
