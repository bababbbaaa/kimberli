{get_banner var=banner_group2 group=group2}
        {if $banner_group2->items}
            <div class="pb-2">
                <div class="px-1">
                    <div class="heading_box">
                        <span data-language="main_new_collection">{$lang->main_new_collection}</span>
                    </div>
                <div class="box row">
                    {foreach $banner_group2->items as $bi}

                        <div class="col-md-6 col-lg-4 col-xl-4 p-0">
                            <div class="inner_cat_banner">
                                {if $bi->url}
                                <a href="{$bi->url}" >
                                {/if}
                                    {if $bi->image}
                                        <img src="{$bi->image|resize:615:252:false:$config->resized_banners_images_dir}" alt="{$bi->alt}" title="{$bi->title}"/>
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
                                {if $bi->url}
                                </a>
                                {/if}
                            </div>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>
    {/if}