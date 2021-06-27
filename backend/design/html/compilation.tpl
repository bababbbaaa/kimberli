{if $compilation->compilation_id}
    {$meta_title = $compilation->name scope=parent}
{else}
    {$meta_title = $btr->compilation_new_menu scope=parent}
{/if}
{*Название страницы*}
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="wrap_heading">
            <div class="box_heading heading_page">
                {if !$compilation->compilation_id}
                    {$btr->menu_new_menu|escape}
                {else}
                    {$compilation->name|escape}
                {/if}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12 col-sm-12 float-xs-right"></div>
</div>

{*Вывод успешных сообщений*}
{if $message_success}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="boxed boxed_success">
                <div class="heading_box">
                    {if $message_success == 'added'}
                        {$btr->compilation_added|escape}
                    {elseif $message_success == 'updated'}
                        {$btr->compilation_updated|escape}
                    {/if}
                    {if $smarty.get.return}
                        <a class="btn btn_return float-xs-right" href="{$smarty.get.return}">
                            {include file='svg_icon.tpl' svgId='return'}
                            <span>{$btr->general_back|escape}</span>
                        </a>
                    {/if}
                </div>
            </div>
        </div>
    </div>
{/if}

{*Вывод ошибок*}
{if $message_error}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="boxed boxed_warning">
                <div class="heading_box">
                    {if $message_error == 'group_id_exists'}
                        {$btr->compilation_id_exists|escape}
                    {elseif $message_error == 'empty_group_id'}
                        {$btr->compilation_enter_id|escape}
                    {else}
                        {$message_error|escape}
                    {/if}
                </div>
            </div>
        </div>
    </div>
{/if}

{*Главная форма страницы*}
<form method="post" enctype="multipart/form-data" class="fn_fast_button">
    <input type=hidden name="session_id" value="{$smarty.session.id}">
    <input type="hidden" name="lang_id" value="{$lang_id}" />
    <div class="row">
        <div class="col-xs-12">
            <div class="boxed">
                <div class="row d_flex">
                    {*Название элемента сайта*}
                    <div class="col-lg-10 col-md-9 col-sm-12">
                        <div class="heading_label">
                            {$btr->general_name|escape}
                        </div>
                        <div class="form-group">
                            <input class="form-control mb-h" name="name" type="text" value="{$compilation->name|escape}"/>
                            <input name="compilation_id" type="hidden" value="{$compilation->compilation_id|escape}"/>
                        </div>
                    </div>
                    {*Видимость элемента*}
                    <div class="col-lg-2 col-md-3 col-sm-12">
                        <div class="activity_of_switch">
                            <div class="activity_of_switch_item"> {* row block *}
                                <div class="okay_switch clearfix">
                                    <label class="switch_label">{$btr->general_enable|escape}</label>
                                    <label class="switch switch-default">
                                        <input class="switch-input" name="visible" value='1' type="checkbox" id="visible_checkbox" {if $compilation->visible}checked=""{/if}/>
                                        <span class="switch-label"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{if $compilation->compilation_id}
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="boxed fn_toggle_wrap min_height_210px">
                <div class="heading_box">
                    {$btr->compilation_items|escape}
                    <div class="toggle_arrow_wrap fn_toggle_card text-primary">
                        <a class="btn-minimize" href="javascript:;" ><i class="fa fn_icon_arrow fa-angle-down"></i></a>
                    </div>
                </div>
                <div class="toggle_body_wrap on fn_card fn_sort_list">
                    <div class="okay_list ok_related_list">
                        <div class="okay_list_body sortable related_products ">
                            {foreach $compilation_items as $related_product}
                                <div class="fn_row okay okay_list_body_item fn_sort_item">
                                    <div class="okay_list_row">
                                        <div class="okay_list_boding okay_list_drag move_zone">
                                            {include file='svg_icon.tpl' svgId='drag_vertical'}
                                        </div>
                                        <div class="okay_list_boding okay_list_related_photo">
                                            <input type="hidden" name=related_products[] value='{$related_product->id}'>
                                            <a href="{url module=ProductAdmin id=$related_product->id}">
                                                {if $related_product->image}
                                                    <img class="product_icon" src='{$related_product->image->filename|resize:40:40}'>
                                                {else}
                                                    <img class="product_icon" src="design/images/no_image.png" width="40">
                                                {/if}
                                            </a>
                                        </div>
                                        <div class="okay_list_boding okay_list_related_name">
                                            <a class="link" href="{url module=ProductAdmin id=$related_product->id}">{$related_product->name|escape}  (<b>{$related_product->variants[0]->price|convert} грн.</b>)</a>
                                        </div>
                                        <div class="okay_list_boding okay_list_close">
                                            <button data-hint="{$btr->general_delete_product|escape}" type="button" class="btn_close fn_remove_item hint-bottom-right-t-info-s-small-mobile  hint-anim">
                                                {include file='svg_icon.tpl' svgId='delete'}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                            <div id="new_related_product" class="fn_row okay okay_list_body_item fn_sort_item" style='display:none;'>
                                <div class="okay_list_row">
                                    <div class="okay_list_boding okay_list_drag move_zone">
                                        {include file='svg_icon.tpl' svgId='drag_vertical'}
                                    </div>
                                    <div class="okay_list_boding okay_list_related_photo">
                                        <input type="hidden" name="related_products[]" value="">
                                        <img class=product_icon src="">
                                    </div>
                                    <div class="okay_list_boding okay_list_related_name">
                                        <a class="link related_product_name" href=""></a>
                                    </div>
                                    <div class="okay_list_boding okay_list_close">
                                        <button data-hint="{$btr->general_delete_product|escape}" type="button" class="btn_close fn_remove_item hint-bottom-right-t-info-s-small-mobile  hint-anim">
                                            {include file='svg_icon.tpl' svgId='delete'}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="heading_label">{$btr->general_recommended_add|escape}</div>
                    <div class="autocomplete_arrow">
                        <input type=text name=related id="related_products" class="form-control" placeholder='{$btr->general_add_product|escape}'>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    {/if}
</form>

{* On document load *}
{literal}
    <script src="design/js/autocomplete/jquery.autocomplete-min.js"></script>
    <script>
        $(window).on("load", function() {
            $('input[name="date"]').datepicker();

            // Удаление товара
        $(document).on( "click", ".fn_remove_item", function() {
            $(this).closest(".fn_row").fadeOut(200, function() { $(this).remove(); });
            return false;
        });


        // Добавление связанного товара
        var new_related_product = $('#new_related_product').clone(true);
        $('#new_related_product').remove().removeAttr('id');

        $("input#related_products").devbridgeAutocomplete({
            serviceUrl:'ajax/search_products.php',
            minChars:3,
            orientation:'auto',
            noCache: true,
            onSelect:
                    function(suggestion){
                        console.log(suggestion);
                        $("input#related_products").val('').focus().blur();
                        new_item = new_related_product.clone().appendTo('.related_products');
                        new_item.removeAttr('id');
                        new_item.find('a.related_product_name').html(suggestion.data.name);
                        new_item.find('a.related_product_name').attr('href', 'index.php?module=ProductAdmin&id='+suggestion.data.id);
                        new_item.find('input[name*="related_products"]').val(suggestion.data.id);
                        if(suggestion.data.image)
                            new_item.find('img.product_icon').attr("src", suggestion.data.image);
                        else
                            new_item.find('img.product_icon').remove();
                        new_item.show();
                    },
            formatResult:
                    function(suggestions, currentValue){
                        var reEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
                        var pattern = '(' + currentValue.replace(reEscape, '\\$1') + ')';
                        return "<div>" + (suggestions.data.image?"<img align=absmiddle src='"+suggestions.data.image+"'> ":'') + "</div>" +  "<span>" + suggestions.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') + "</span>";
                    }

        });
        });
    </script>
{/literal}
