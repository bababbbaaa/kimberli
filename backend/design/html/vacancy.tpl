{if $vacancy->id}
    {$meta_title = $vacancy->name scope=parent}
{else}
    {$meta_title = $btr->vacancy_new scope=parent}
{/if}

{*Название страницы*}
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="wrap_heading">
            <div class="box_heading heading_page">
                {if !$vacancy->id}
                    {$btr->vacancy_add|escape}
                {else}
                    {$vacancy->name|escape}
                {/if}
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-12 col-sm-12 float-xs-right"></div>
</div>

{*Вывод успешных сообщений*}
{if $message_success}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="boxed boxed_success">
                <div class="heading_box">
                    {if $message_success == 'added'}
                        {$btr->vacancy_added|escape}
                    {elseif $message_success == 'updated'}
                        {$btr->vacancy_updated|escape}
                    {/if}
                    {if $smarty.get.return}
                        <a class="btn btn_return float-xs-right" href="{$smarty.get.return}">
                            {include file='svg_icon.tpl' svgId='return'}
                            <span>{$btr->general_back|escape}</span>
                        </a>
                    {/if}
                </div>
            </div>
        </div>
    </div>
{/if}

{*Вывод ошибок*}
{if $message_error}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="boxed boxed_warning">
                <div class="heading_box">
                    {if $message_error == 'url_exists'}
                        {$btr->general_exists|escape}
                    {elseif $message_error=='empty_name'}
                        {$btr->general_enter_title|escape}
                    {elseif $message_error == 'url_wrong'}
                        {$btr->general_not_underscore|escape}
                    {else}
                        {$message_error|escape}
                    {/if}
                </div>
            </div>
        </div>
    </div>
{/if}

{*Главная форма страницы*}
<form method="post" enctype="multipart/form-data" class="fn_fast_button">
    <input type=hidden name="session_id" value="{$smarty.session.id}">
    <input type="hidden" name="lang_id" value="{$lang_id}" />

    <div class="row">
        <div class="col-xs-12 col-lg-12">
            <div class="boxed match_matchHeight_true min_height_200px">
                {*Название элемента сайта*}
                <div class="row d_flex">
                    <div class="col-lg-12 col-md-9 col-sm-12">
                        <div class="heading_label">
                            {$btr->general_name|escape}
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-lg-10 col-md-10">
                                <div class="form-group">
                            <input class="form-control" name="name" type="text" value="{$vacancy->name|escape}"/>
                            <input name="id" type="hidden" value="{$vacancy->id|escape}"/>
                        </div>
                            </div>
                             <div class="col-xs-12 col-lg-2 col-md-2">
                                <div class="activity_of_switch">
                            <div class="activity_of_switch_item"> {* row block *}
                                <div class="okay_switch clearfix">
                                    <label class="switch_label">{$btr->general_enable|escape}</label>
                                    <label class="switch switch-default">
                                        <input class="switch-input" name="visible" value='1' type="checkbox" id="visible_checkbox" {if $vacancy->visible}checked=""{/if}/>
                                        <span class="switch-label"></span>
                                        <span class="switch-handle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                            </div>
                        </div>
                        <div class="row">
                             <div class="col-lg-3 col-sm-12">
                                <span class="heading_label">Опыт работы</span>
                                <input name="experience" class="form-control" type="text" value="{$vacancy->experience|escape}" />
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <span class="heading_label">Тип работы</span>
                                <input name="schedule" class="form-control" type="text" value="{$vacancy->schedule|escape}" />
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <span class="heading_label">Город</span>
                                <input name="city" class="form-control" type="text" value="{$vacancy->city|escape}" />
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <span class="heading_label">Дата вакансии</span>
                                <input name="date_vacancy" class="form-control" type="text" value="{$vacancy->date_vacancy|date}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {*Обязанности*}
        <div class="col-lg-12 col-md-12">
            <div class="boxed match fn_toggle_wrap">
                <div class="heading_box">
                    Описание
                    <div class="toggle_arrow_wrap fn_toggle_card text-primary">
                        <a class="btn-minimize" href="javascript:;" ><i class="fa fn_icon_arrow fa-angle-down"></i></a>
                    </div>
                </div>
                <div class="toggle_body_wrap on fn_card row">
                    <textarea name="description" id="fn_editor" class="editor_small">{$vacancy->description|escape}</textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {*Обязанности*}
        <div class="col-lg-6 col-md-12">
            <div class="boxed match fn_toggle_wrap">
                <div class="heading_box">
                    Обязанности
                    <div class="toggle_arrow_wrap fn_toggle_card text-primary">
                        <a class="btn-minimize" href="javascript:;" ><i class="fa fn_icon_arrow fa-angle-down"></i></a>
                    </div>
                </div>
                <div class="toggle_body_wrap on fn_card row">
                    <textarea name="responsibilities" id="fn_editor" class="editor_small">{$vacancy->responsibilities|escape}</textarea>
                </div>
            </div>
        </div>
        {*Предлагаем*}
        <div class="col-lg-6 col-md-12">
            <div class="boxed match fn_toggle_wrap">
                <div class="heading_box">
                    Предлагаем
                    <div class="toggle_arrow_wrap fn_toggle_card text-primary">
                        <a class="btn-minimize" href="javascript:;" ><i class="fa fn_icon_arrow fa-angle-down"></i></a>
                    </div>
                </div>
                <div class="toggle_body_wrap on fn_card row">
                    <textarea name="offer" id="fn_editor" class="editor_small">{$vacancy->offer|escape}</textarea>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        {*Необходимые навыки*}
        <div class="col-lg-6 col-md-12">
            <div class="boxed match fn_toggle_wrap">
                <div class="heading_box">
                    Необходимые навыки
                    <div class="toggle_arrow_wrap fn_toggle_card text-primary">
                        <a class="btn-minimize" href="javascript:;" ><i class="fa fn_icon_arrow fa-angle-down"></i></a>
                    </div>
                </div>
                <div class="toggle_body_wrap on fn_card row">
                    <textarea name="required_skills" id="fn_editor" class="editor_small">{$vacancy->required_skills|escape}</textarea>
                </div>
            </div>
        </div>
        {*Будет плюсом*}
        <div class="col-lg-6 col-md-12">
            <div class="boxed match fn_toggle_wrap">
                <div class="heading_box">
                    Будет плюсом
                    <div class="toggle_arrow_wrap fn_toggle_card text-primary">
                        <a class="btn-minimize" href="javascript:;" ><i class="fa fn_icon_arrow fa-angle-down"></i></a>
                    </div>
                </div>
                <div class="toggle_body_wrap on fn_card row">
                    <textarea name="extra_skills" id="fn_editor" class="editor_small">{$vacancy->extra_skills|escape}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 mt-1 mb-2">
            <button type="submit" class="btn btn_small btn_blue float-md-right">
                {include file='svg_icon.tpl' svgId='checked'}
                <span>{$btr->general_apply|escape}</span>
            </button>
        </div>
    </div>
</form>
{* Подключаем Tiny MCE *}
{include file='tinymce_init.tpl'}
