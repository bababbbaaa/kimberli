{get_banner var="banner_full_page_banner" group="full_page_banner"}

                        {if $banner_full_page_banner->items}
                        <div class="box">
                            <div class="fn_banner_full_page_banner slick-banner">
                                {foreach $banner_full_page_banner->items as $bi}
                                <div>
                                    {if $bi->url}
                                        <a href="{$bi->url}" >
                                    {/if}
                                    {if $bi->image}
                                        <img src="{$bi->image|resize:1920:720:false:$config->resized_banners_images_dir}" alt="{$bi->alt}" title="{$bi->title}"/>
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
                                {/foreach}
                            </div>
                        </div>
                        {/if}