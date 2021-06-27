{get_banner var=banner_m_grid_1 group='m_grid_1'}
{get_banner var=banner_m_grid_2 group='m_grid_2'}
    
    {if $banner_m_grid_1->items || $banner_m_grid_2->items}
        <div class="box">
            <div class="{if $banner_m_grid_1->items && $banner_m_grid_2->items}col-md-6{else} col-md-12{/if} p-0">
                {foreach $banner_m_grid_1->items as $bi}
                    <div class="inner_cat_banner p-0">
                        {if $bi->url}
                        <a href="{$bi->url}">
                        {/if}
                        {if $bi->image}
                            <img src="{$bi->image|resize:950:933:false:$config->resized_banners_images_dir}" alt="{$bi->alt}" title="{$bi->title}"/>
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
            <div class="{if $banner_m_grid_1->items && $banner_m_grid_2->items}col-md-6{else} col-md-12{/if} p-0">
                {foreach $banner_m_grid_2->items as $bi}
                    <div class="inner_cat_banner p-0">
                        {if $bi->url}
                        <a href="{$bi->url}" >
                        {/if}
                            {if $bi->image}
                                <img src="{$bi->image|resize:950:933:false:$config->resized_banners_images_dir}" alt="{$bi->alt}" title="{$bi->title}"/>
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