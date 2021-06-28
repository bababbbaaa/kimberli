{get_banner var=collection group='group1'}
{if $collection->items}
        <div class="box category_banner">
            <div class="fn_banner_group_m slick-banner">
                {foreach $collection->items as $bi}
                    <div class="p-0 inner_cat_banner">
                        {if $bi->url}<a href="{$bi->url}">{/if}
                        {if $bi->image}
                            <img src="{$bi->image|resize:375:637:false:$config->resized_banners_images_dir}" alt="{$bi->alt}" title="{$bi->title}"/>
                        {/if}
                        {if $bi->title || $bi->description}
                            <div class="title">
                                {if $bi->title}
                                    <h3>{$bi->title}</h3>
                                {/if}
                                {if $bi->description}
                                    <p>{$bi->description}</p>
                                {/if}
                            </div>
                    {/if}
                    {if $bi->url}</a>{/if}
                    </div>
                {/foreach}
            </div>
        </div>
{/if}