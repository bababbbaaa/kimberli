{get_banner var="banner_bar_kimberli_banner" group="bar_kimberli_banner"}
{if $banner_bar_kimberli_banner->items}
    <div class="container-fluid hidden-md-down">
        <div class="fn_banner_bar_kimberli_banner slick-banner">
            {foreach $banner_bar_kimberli_banner->items as $bi}
                <div>
                    {if $bi->url}
                    <a href="{$bi->url}" target="_blank">
                        {/if}
                        {if $bi->image}
                            <img src="{$bi->image|resize:1049:700:false:$config->resized_banners_images_dir}" alt="{$bi->alt}" title="{$bi->title}"/>
                        {/if}
                        <span class="slick-name">
                                        {$bi->title}
                                    </span>
                        {if $bi->description}
                            <span class="slick-description">
                                        {$bi->description}
                                    </span>
                        {/if}
                        {if $bi->url}
                    </a>
                    {/if}
                </div>
            {/foreach}
        </div>
    </div>
{/if}