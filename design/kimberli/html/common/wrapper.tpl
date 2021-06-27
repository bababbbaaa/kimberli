<!DOCTYPE html>
<html lang="{$language->label}" prefix="og: http://ogp.me/ns#"  xmlns="http://www.w3.org/1999/xhtml" >
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>{$meta.title}</title>
	<base href="{$baseUrl}/">

	{* Meta *}
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta name="description" content="{$meta.description}">
	<meta name="keywords" content="{$meta.keywords}">
        <meta name="image" content="{$baseUrl}/design/kimberli/images/logo.svg">
	<meta property="og:title" content="{$meta.title|escape}">
	<meta property="og:type" content="website">
	<meta property="og:url" content="{$baseUrl}/{$language->url}">
	<meta property="og:image" content="{$baseUrl}/design/kimberli/images/logo.svg">
	<meta property="og:description" content="{$meta.description|escape} ">
            <meta name="google-site-verification" content="tcZlOH9iNtfkCtwnAEnVnyJWSuktyFo1HlzfByWvnlw" />
	{* Cannonical *}
	{if !empty($meta.canonical)}
		<link rel="canonical" href="{$meta.canonical}"/>
	{/if}
	{* Language attribute *}
	{foreach $languages as $l}
		<link rel="alternate" hreflang="{$l->href_lang}" href="{$baseUrl}/{$l->url}">
	{/foreach}

	{* Favicon *}
	<link href="{$themeUrl}/images/favicon.png" type="image/x-icon" rel="icon">
	<link href="{$themeUrl}/images/favicon.png" type="image/x-icon" rel="shortcut icon">

	{* Style *}
        <link  rel="stylesheet"  href="{$baseUrl}/dist/bootstrap/css/bootstrap-3.min.css" >
	<!-- <link href='{$baseUrl}/dist/style.css?ver=158.8.9' rel='stylesheet'>-->
        <link href='{$baseUrl}/dist/font-awesome.min.css' rel="stylesheet">
      
        <link href='{$baseUrl}/dist/style_1.css?v=1.2.11' rel='stylesheet' >
         <link href='{$baseUrl}/dist/style_mobil.css?v=1.1.2' rel='stylesheet' media="(max-width: 768px)">
       <link href='{$baseUrl}/dist/products_1.css?ver=1.3.8' rel='stylesheet'> 
        <link href='{$baseUrl}/dist/lite-collection.css?ver=1.1' rel='stylesheet'>
	<script>const lang = '{$language->label}'; const baseUrl = '{$baseUrl}';</script>
        
  
	{include file='common/header_scripts.tpl'}
	{*<meta name="google-site-verification" content="efJNNiluLXm6rebjbjq5fX52LrntlCjADnmkrkEDLa8" />*}

</head>
<body>
{include file='common/body_scripts.tpl'}

<header id="header">
	{include file="common/header.tpl"}
</header>

<div class="container {if $module == 'MainView'} no-mobile hide {/if} ">
	<div class="main-h1">
		{if $meta.h1}
			<h1>{$meta.h1}</h1>
		{elseif $product->name}
		{elseif $category->name}
			<h1>{$category->name}</h1>
		{elseif $catalog_item->name}
			<h1>{$catalog_item->name}</h1>
		{else}
			<h1>{$page->name|escape}</h1>
		{/if}
	</div>
	{include file='components/breadcrumb.tpl'}
</div>


<main id="content" {if $module == 'MainView' || $module == 'ProductsView'}class="catalog-bg"{/if} itemscope itemtype="http://schema.org/Organization">
	<div class="hidden">
		{* Schema.org Organization *}
		<span itemprop="name">Kimberli Jewellery House</span>
		<span itemprop="brand">Kimberli</span>
		<span itemprop="url">https://kimberli.ua</span>
		<span itemprop="email">{$lang->company_email}</span>
		<span itemprop="telephone">{$lang->company_phone_1}</span>
		<span itemprop="telephone">{$lang->company_phone_2}</span>
                <span itemprop="telephone">{$lang->company_phone_3}</span>
		<img itemprop="logo" src="{$themeUrl}/images/logo.svg" alt="Kimberli Jewellery House">
	</div>
	{$content}
</main>


{* Footer *}
<footer id="footer">{include file='common/footer.tpl'}</footer>

{*include file='components/binotel.tpl'*}

{* Popup *}
<div id="popup">
	<div class="popup__background"></div>
	<div class="v-wrapper">
		<div class="v-middle">
			<div class="popup__wrapper">
				<div class="popup__body"></div>
			</div>
		</div>
	</div>
</div>

{* Scripts bottom *}
<script src="{$themeUrl}/js/script.js?v=1.1"></script>
<script src="{$themeUrl}/js/kimberli.js?v=1.5"></script>
<script src="{$themeUrl}/js/custom-scrollbar.js"></script>

{if count($errors)}
   <script> toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "progressBar": true,
        "preventDuplicates": false
    };
    </script>
    {foreach $errors as $error}
        <script>
            toastr.error('{$error}');
        </script>
    {/foreach}
{/if}
{if isset($needBootstrap) }
    <script src="{$baseUrl}/dist/bootstrap/js/bootstrap.min.js" ></script>
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.0/js/bootstrap.min.js"></script>-->
        <script> 
          //  $("head").append('<link  rel="stylesheet"  href="{$baseUrl}/dist/bootstrap/css/bootstrap.min.css"   >');
         //   $("head").append('<link  rel="stylesheet"  href="{$themeUrl}/js/assets/owl.carousel.css"   >');
            </script>
	<script src="{$themeUrl}/js/owl.carousel2.js"></script>
	<script>
		$('.owl-banners-home').owlCarousel({  
			loop: true,
			margin: 10,
			nav: true,
                        dots: true,
                        autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    animateOut: 'fadeOut',
    items: 1,
    responsive: {
		0 : {
                    items : 1,
                    nav: false,
                },
                480: {
                    items : 1,
                  nav: false,
                },
                768 : {
                    items : 1,
                    nav: false,
                }
			}
});
        
	</script>
        <script src="{$themeUrl}/js/owl_category_home.js?v=1.12"></script>
{/if}
<script>


$(window).load(function() {
   
/** код будет запущен когда страница будет полностью загружена, включая все фреймы, объекты и изображения **/
       [].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
img.setAttribute('src', img.getAttribute('data-src'));
img.onload = function() {
img.removeAttribute('data-src');

};
});


});
$(document).on('click', 'a.ui-icon-service-viber', function(){
   fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Viber click' });
 gtag('event', 'WriteInViber', {
  'event_category': 'click',
});
   
});
$(document).on('click', 'a.ui-icon-service-fb', function(){
   fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'FB click'});
gtag('event', 'WriteInFb', {
  'event_category': 'click',
});
});
$(document).on('click', 'a.ui-icon-service-telegram', function(){
   fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Telegram click'});
gtag('event', 'WriteInTelegram', {
  'event_category': 'click',
});
});
$(document).on('click', '.phone_change a', function(){
    fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Phone click', });
    gtag('event', 'WriteInPhone', {
  'event_category': 'click',
});
});
$(document).on('click', 'a.viber_change', function(){
    fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Viber click', });
    gtag('event', 'WriteInViber', {
  'event_category': 'click',
});
});
$(document).on('click', 'a.telegram_change', function(){
    fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Telegram click', });
    gtag('event', 'WriteInTelegram', {
  'event_category': 'click',
});
});
$(document).on('click', 'a.fb_change', function(){
    fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'FB click', });
    gtag('event', 'WriteInFb', {
  'event_category': 'click',
});
});


</script>
</body>
</html>