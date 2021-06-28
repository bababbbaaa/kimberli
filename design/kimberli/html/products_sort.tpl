{if $products|count > 0}
    <div class="sort">
        <span class="sort_title" data-language="products_sort_by">{$lang->products_sort_by}:</span>

        <select class="select_sort {if $ajax} is_ajax{/if}">
            <option class="option{if $sort=='position'} active{/if}" value="{furl sort=position page=null}">{$lang->products_by_default}</option>
            <option class="option{if $sort=='price'} active{/if}" value="{furl sort=price page=null}">{$lang->products_by_price_up}</option>
            <option class="option{if $sort=='price_desc'} active{/if}" value="{furl sort=price_desc page=null}">{$lang->products_by_price_down}</option>
            <option class="option{if $sort=='name'} active{/if}" value="{furl sort=name page=null}">{$lang->products_by_name_down}</option>
            <option class="option{if $sort=='name_desc'} active{/if}" value="{furl sort=name_desc page=null}">{$lang->products_by_name_up}</option>
            <option class="option{if $sort=='rating'} active{/if}" value="{furl sort=rating page=null}">{$lang->products_by_rating}</option>
            <option class="option{if $sort=='sku'} active{/if}" value="{furl sort=sku page=null}">{$lang->products_by_sku}</option>
            <option class="option{if $sort=='sku_desc'} active{/if}" value="{furl sort=sku_desc page=null}">{$lang->products_by_sku_up}</option>
            {*<option class="option{if $sort=='rating_desc'} active{/if}" value="{furl sort=rating_desc page=null}">{$lang->products_by_rating_desc}</option>*}
        </select>
    </div>
{/if}



{*if $products|count > 0}
    <div class="fn_ajax_buttons sort clearfix">
        <span class="fn_sort_pagination_link sort_title" data-language="products_sort_by">{$lang->products_sort_by}:</span>


        <form method="post">
            <button type="submit" name="prg_seo_hide" class="fn_sort_pagination_link sort_link{if $sort=='position'} active_up{/if} no_after" value="{furl sort=position page=null}">
                <span data-language="products_by_default">{$lang->products_by_default}</span>
            </button>
        </form>

        <form method="post">
            <button type="submit" name="prg_seo_hide" class="fn_sort_pagination_link sort_link{if $sort=='price'} active_up{elseif $sort=='price_desc'} active_down{/if}" value="{if $sort=='price'}{furl sort=price_desc page=null}{else}{furl sort=price page=null}{/if}">
                <span data-language="products_by_price">{$lang->products_by_price}</span>
            </button>
        </form>

        <form method="post">
            <button type="submit" name="prg_seo_hide" class="fn_sort_pagination_link sort_link{if $sort=='name'} active_up{elseif $sort=='name_desc'} active_down{/if}" value="{if $sort=='name'}{furl sort=name_desc page=null}{else}{furl sort=name page=null}{/if}">
                <span data-language="products_by_name">{$lang->products_by_name}</span>
            </button>
        </form>

        <form method="post">
            <button type="submit" name="prg_seo_hide" class="fn_sort_pagination_link sort_link {if $sort=='rating'} active_up{elseif $sort=='rating_desc'} active_down{/if}" value="{if $sort=='rating'}{furl sort=rating_desc page=null}{else}{furl sort=rating page=null}{/if}">
                <span data-language="products_by_rating">{$lang->products_by_rating}</span>
            </button>
        </form>
    </div>
{/if*}