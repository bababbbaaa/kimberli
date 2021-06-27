{* Compaison informer (given by Ajax) *}
{if $comparison->products|count > 0}
    <a href="{$lang_link}comparison" data-language="index_comparison" title="{$lang->index_comparison}">
        {include file="svg.tpl" svgId="comparison"}
        <span class="informer_counter">{$comparison->products|count}</span>
    </a>
{else}
    <div data-language="index_comparison" title="{$lang->index_comparison}">
        {include file="svg.tpl" svgId="comparison"}
    </div>
{/if}
