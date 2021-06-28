{if ($category->subcategories && $category->count_children_visible) ||
($category->path[$category->level_depth-2]->subcategories && $category->path[$category->level_depth-2]->count_children_visible)}
    <div class="categories_nav">
        <div class="filters_heading">
            <span data-language="features_price">{$lang->index_categories}</span>
        </div>
        {function name=categories_tree_sidebar}
            {if $categories}

                <ul class="{if $level == 1}categories_menu level_{$level}{else}subcategory level_{$level} {/if}">
                    {foreach $categories as $c}
                        {if $c->visible}
                            <li class="category_item has_child">
                                <{if $c->id == $category->id}b{else}a{/if} class="category_link{if $c->subcategories} sub_cat{/if}{if $category->id == $c->id} selected{/if}" href="{$lang_link}catalog/{$c->url}" data-category="{$c->id}">
                                    <span>{$c->name|escape}</span>
                                </{if $c->id == $category->id}b{else}a{/if}>
                            </li>
                         {/if}
                    {/foreach}
                </ul>
            {/if}
        {/function}
        {if $category->subcategories && $category->count_children_visible}
        {categories_tree_sidebar categories=$category->subcategories level=1}
        {elseif $category->path[$category->level_depth-2]->subcategories && $category->path[$category->level_depth-2]->count_children_visible}
        {categories_tree_sidebar categories=$category->path[$category->level_depth-2]->subcategories level=1}
        {/if}
    </div>
{/if}

{if $brand->categories}
<div class="categories_nav">
    <div class="filters_heading">
        <span data-language="features_catalog">{$lang->features_catalog}</span>
    </div>
    <div class="categories_menu">
        {foreach $brand->categories as $c}
        <div class="category_item has_child">
            <a class="category_link" href="{$lang_link}catalog/{$c->url}/brand-{$brand->url}" data-category="{$c->id}">
                <span>{$c->name|escape}</span>
            </a>
        </div>
        {/foreach}
    </div>
</div>
{/if}