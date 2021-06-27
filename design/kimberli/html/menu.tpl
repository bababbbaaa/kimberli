{if $menu_items}
    <div class="menu_group menu_group_{$menu->group_id}">
        {function name=menu_items_tree}
            {if $menu_items}
                <ul class="fn_menu_list menu_list menu_list_{$level}">
                    {foreach $menu_items as $item}
                        {if $item->visible == 1}
                            <li class="menu_item menu_item_{$level} {if !empty($item->submenus) && $item->count_children_visible>0}menu_eventer{/if}">
                                <a class="menu_link {if !empty($item->submenus)}fn_switch {/if}" {if $item->url} href="{if !preg_match('~^https?://~', {$item->url})}{$lang_link}{/if}{$item->url}"{/if} {if empty($item->submenus) && $item->is_target_blank}target="_blank"{/if}>
                                    <span class="text">{$item->name|escape}</span>
                                    {if !empty($item->submenus)}
                                        <i class="cat_switch2 hidden-md-down">{include file='svg.tpl' svgId='arrow_down'}</i>
                                        <i class="cat_switch2 hidden-lg-up">{include file='svg.tpl' svgId='arrow_triangle'}</i>
                                    {/if}
                                </a>
                                {menu_items_tree menu_items=$item->submenus level=$level + 1}
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            {/if}
        {/function}
        {menu_items_tree menu_items=$menu_items level=1}
    </div>
{/if}
