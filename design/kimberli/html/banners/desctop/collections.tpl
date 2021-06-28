{get_banner var=collection group='group1'}
{if $collection->items}
    <div class="box category_banner">
        {$banners_count = $collection->items|count}
            {foreach $collection->items as $bi}
                {if $bi->url}
                    <a href="{$bi->url}" >
                {/if}
            <div class="{if $banners_count == 3}col-xs-6 col-sm-4 col-md-4 {elseif $banners_count == 4} col-xs-6 col-sm-6 col-md-3 {elseif $banners_count == 2} col-xs-6 col-sm-6 {elseif $banners_count == 1} col-xs-12 col-sm-12 col-md-12 {/if}  p-0 inner_cat_banner">
                <div class="mask"></div>
                    {if $bi->image}
                        <img src="{$bi->image|resize:589:1000:false:$config->resized_banners_images_dir}" alt="{$bi->alt}" title="{$bi->title}"/>
                    {/if}
                    {if $bi->title || $bi->description}
                        <div class="title">
                            {if $bi->title}
                                <h3>{$bi->title}</h3>
                            {/if}
                            {if $bi->description}
                                <p>{$bi->description}</p>
                            {/if}

                            <button class="button"  data-language="collection_view"><span>{$lang->collection_view}</span> <i></i></button> </div>

                    {/if}

            </div>
                {if $bi->url}
                    </a>
                {/if}

        {/foreach}
    </div>
{/if}