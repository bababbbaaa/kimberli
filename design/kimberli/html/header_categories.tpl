<div class="header_categories_nav">
    {function name=categories_tree2}
        {if $categories}

            <ul class="{if $level == 1}header_categories_menu level_{$level}{else}subcategory_header level_{$level} {/if}">
                {foreach $categories as $c}
                    {if $c->id == 114 && $is_mobile === false}{continue}{/if}
                    {if $c->visible}
                        {if !empty($c->subcategories) && $c->count_children_visible}
                            <li class="header_category_item">
                                <a class="header_category_link{if $category->id == $c->id} selected{/if} {if !empty($c->subcategories) } category-mobile-heading {/if}" href="{$lang_link}catalog/{$c->url}" data-category="{$c->id}">
                                    <div class="icon">
                                        {include file='svg.tpl' svgId={$c->url}}
                                    </div>
                                    <span>{$c->name|escape}</span>
                                    <i class="cat_switch2 switch hidden-md-down">{include file='svg.tpl' svgId='arrow_down'}</i>

                                </a>
                                <!--<i class="fn_switch cat_switch hidden-lg-up">{include file='svg.tpl' svgId='arrow_triangle'}</i>-->
                                <div class="header_category_sublist">
                                    {categories_tree2 categories=$c->subcategories level=$level + 1}
                                    <a href="{$lang_link}catalog/{$c->url}" class="header_category_sublist_all">
                                        {$lang->comparison_all} <span>{$c->name|escape}</span>
                                        <svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5" d="M12.3536 4.35355C12.5488 4.15829 12.5488 3.84171 12.3536 3.64645L9.17157 0.464466C8.97631 0.269204 8.65973 0.269204 8.46447 0.464466C8.2692 0.659728 8.2692 0.976311 8.46447 1.17157L11.2929 4L8.46447 6.82843C8.2692 7.02369 8.2692 7.34027 8.46447 7.53553C8.65973 7.7308 8.97631 7.7308 9.17157 7.53553L12.3536 4.35355ZM0 4.5H12V3.5H0V4.5Z" fill="black"/>
                                        </svg>
                                    </a>
                                </div>
                                <div class="header_category_item_preview" style="background-image: url(design/{$settings->theme|escape}/images/bg_catalog_{$c->url}.jpg);"></div>
                            </li>
                        {else}
                            <li class="header_category_item">
                                <a class="header_category_link{if $category->id == $c->id} selected{/if}" href="{$lang_link}catalog/{$c->url}" data-category="{$c->id}">
                                    <div class="icon">
                                        {include file='svg.tpl' svgId={$c->url}}
                                    </div>
                                    <span>{$c->name|escape}</span>
                                </a>
                            </li>
                        {/if}

                    {/if}
                {/foreach}
            </ul>
        {/if}
    {/function}
    {categories_tree2 categories=$categories level=1}
</div>