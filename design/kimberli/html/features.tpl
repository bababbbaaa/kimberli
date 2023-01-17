{* Filters *}
{if ($category->brands || ($prices->range->min != '' && $prices->range->max != '') || $features)}
    <div class="filters tablet-hidden">
        {* Ajax Price filter *}
        {if $prices->range->min != '' && $prices->range->max != ''}
            <div class="filters_heading">
                <span data-language="features_price">{$lang->features_price}</span>
            </div>

            <div class="filter_group">
                {* Price slider *}
                <div id="fn_slider_price"></div>

                {* Price range *}
                <div class="price_range">
                    <div class="price_label">
                        <input class="min_input" id="fn_slider_min" name="p[min]" value="{($prices->current->min|default:$prices->range->min)|escape}" data-price="{$prices->range->min}" type="text">
                    </div>

                    <div class="price_label max_price">
                        <input class="max_input" id="fn_slider_max" name="p[max]" value="{($prices->current->max|default:$prices->range->max)|escape}" data-price="{$prices->range->max}" type="text">
                    </div>
                </div>
            </div>
        {/if}

        {* Other filters *}
        {if $other_filters}
            {* Brand name *}
            <div class="h2 filter_name">
                <span data-language="features_other_filter">{$lang->features_other_filter}</span>
            </div>
            <div class="filter_group">
                {* Display all brands *}
               {* <div class="filter_item">
                    <form method="post">
                        {$furl = {furl params=[filter=>null, page=>null]}}
                        <button type="submit" name="prg_seo_hide" class="filter_link {if !$smarty.get.filter} checked{/if}" value="{$furl|escape}">
                            <i class="filter_indicator"></i>
                            <span data-language="features_all">{$lang->features_all}</span>
                        </button>
                    </form>
                </div>*}
                {* Other filter list *}
                {foreach $other_filters as $f}
                    <div class="filter_item">
                        {$furl = {furl params=[filter=>$f->url, page=>null]}}
                        {if $seo_hide_filter || ($smarty.get.filter && in_array($f->url, $smarty.get.filter))}
                        <form method="post">
                            <button type="submit" name="prg_seo_hide" class="filter_link{if $smarty.get.filter && in_array($f->url, $smarty.get.filter)} checked{/if}" value="{$furl|escape}">
                                <i class="filter_indicator"></i>
                                <span data-language="{$f->translation}">{$f->name}</span>
                            </button>
                        </form>
                        {else}
                        <a class="filter_link{if $smarty.get.filter && in_array($f->url, $smarty.get.filter)} checked{/if}" href="{$furl}">
                            <i class="filter_indicator"></i>
                            <span data-language="{$f->translation}">{$f->name}</span>
                        </a>
                        {/if}
                    </div>
                {/foreach}
            </div>
        {/if}

        {* Brand filter *}
        {if $category->brands}
            {* Brand name *}
            <div class="filters_heading">
                <span data-language="features_manufacturer">{$lang->features_manufacturer}</span>
            </div>
            <div class="filter_group feature_content">
                {* Display all brands *}
                <div class="filter_item">
                    <form method="post">
                        {$furl = {furl params=[brand=>null, page=>null]}}
                        <button type="submit" name="prg_seo_hide" class="filter_link {if !$brand->id && !$smarty.get.b} checked{/if}" value="{$furl|escape}">
                            <i class="filter_indicator"></i>
                            <span data-language="features_all">{$lang->features_all}</span>
                        </button>
                    </form>
                </div>
                {* Brand list *}
                {foreach $category->brands as $b}
                    <div class="filter_item">
                        {$furl = {furl params=[brand=>$b->url, page=>null]}}
                        {if $seo_hide_filter || ($brand->id == $b->id || $smarty.get.b && in_array($b->id,$smarty.get.b))}
                        <form method="post">
                            <button type="submit" name="prg_seo_hide" class="filter_link{if $brand->id == $b->id || $smarty.get.b && in_array($b->id,$smarty.get.b)} checked{/if}" value="{$furl|escape}">
                                <i class="filter_indicator"></i>
                                <span>{$b->name|escape}</span>
                            </button>
                        </form>
                        {else}
                        <a class="filter_link{if $brand->id == $b->id || $smarty.get.b && in_array($b->id,$smarty.get.b)} checked{/if}" href="{$furl}">
                            <i class="filter_indicator"></i>
                            <span>{$b->name|escape}</span>
                        </a>
                        {/if}
                    </div>
                {/foreach}
            </div>
        {/if}
        
        {* Features filter *}
        {if $features}
            {foreach $features as $key=>$f}
                {* Feature name *}
                <div class="filters_heading" data-feature="{$f->id}">{$f->name|escape}</div>

                <div class="filter_group feature_content">
                    {* Display all features *}
                   {* <div class="filter_item">
                        <form method="post">
                            {$furl = {furl params=[$f->url=>null, page=>null]}}
                            <button type="submit" name="prg_seo_hide" class="filter_link {if !$smarty.get.$key} checked{/if}" value="{$furl|escape}">
                                <i class="filter_indicator"></i>
                                <span data-language="features_all">{$lang->features_all}</span>
                            </button>
                        </form>
                    </div>*}
                    {* Feture value *}
                    {$o_count = 0}
                    {foreach $f->features_values as $fv}
                        {$fv_count = $fv_count+1}
                        <div class="filter_item {if $fv && $fv_count > 4} closed{/if}">
                            {$furl = {furl params=[$f->url=>$fv->translit, page=>null]}}
                            {if !$fv->to_index || $seo_hide_filter || ($smarty.get.{$f@key} && in_array($fv->translit,$smarty.get.{$f@key},true))}
                            <form method="post">
                                <button type="submit" name="prg_seo_hide" class="filter_link{if $smarty.get.{$f@key} && in_array($fv->translit,$smarty.get.{$f@key},true)} checked{/if}" value="{$furl|escape}">
                                    <i class="filter_indicator"></i>
                                    <span>{$fv->value|escape}</span>
                                </button>
                            </form>
                            {else}
                            <a class="filter_link{if $smarty.get.{$f@key} && in_array($fv->translit,$smarty.get.{$f@key},true)} checked{/if}" href="{$furl}">
                                <i class="filter_indicator"></i>
                                <span>{$fv->value|escape}</span>
                            </a>
                            {/if}
                        </div>
                    {/foreach}
                    {if $fv_count > 4}
                        <div class="box_view_all_feature">
                            <a class="view_all_feature" data-view="{$lang->main_look_all}" data-close="{$lang->main_look_all_close}" href="">{$lang->main_look_all}</a>
                        </div>
                    {/if}
                </div>
            {/foreach}
        {/if}
        
    </div>
{/if}
