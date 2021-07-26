<div class="career">
    <div class="container-fluid">
        <div class="career_heading">
            {*<div class="career_title">Работа в Kimberli</div>*}
            <div class="career_descr">Актуальные вакансии в компании</div>
        </div>
{if $vacancies }
        <div class="vacancies">
            {foreach $vacancies as $vacancy}
                <div class="vacancy">
                    <div class="vacancy_preview">
                        <div class="name">{$vacancy->name|escape}</div>
                        <div class="details">
                            <span>Опыт работы {$vacancy->experience|escape}</span>
                            <span>{$vacancy->schedule|escape}</span>
                            <span>{$vacancy->city|escape}</span>
                        </div>
                        <div class="arrow">
                            <span>Подробней</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="16" viewBox="0 0 25 16" fill="none">
                                <path d="M24.7071 8.70711C25.0976 8.31658 25.0976 7.68342 24.7071 7.29289L18.3431 0.928932C17.9526 0.538408 17.3195 0.538408 16.9289 0.928932C16.5384 1.31946 16.5384 1.95262 16.9289 2.34315L22.5858 8L16.9289 13.6569C16.5384 14.0474 16.5384 14.6805 16.9289 15.0711C17.3195 15.4616 17.9526 15.4616 18.3431 15.0711L24.7071 8.70711ZM0 9H24V7H0V9Z" fill="#000"/>
                            </svg>
                        </div>
                    </div>
                    <div class="vacancy_content">
                        <div class="vacancy_details">
                            <div class="vacancy_details_item">
                                <span>Опыт работы</span>
                                <p>{$vacancy->experience|escape}</p>
                            </div>
                            <div class="vacancy_details_item">
                                <span>Тип работы</span>
                                <p>{$vacancy->schedule|escape}</p>
                            </div>
                            <div class="vacancy_details_item">
                                <span>Город</span>
                                <p>{$vacancy->city|escape}</p>
                            </div>
                            <div class="vacancy_details_item">
                                <span>Дата вакансии</span>
                                <p>{$vacancy->date_vacancy|date}</p>
                            </div>
                        </div>

                        {if $vacancy->description}
                            <div class="vacancy_descr">
                                <div class="vacancy_descr_title">Описание</div>
                                {$vacancy->description}
                            </div>
                        {/if}
                        {if $vacancy->responsibilities}
                        <div class="vacancy_info">
                            <div class="vacancy_info_title">Обязанности</div>
                            {$vacancy->responsibilities}
                        </div>
                        {/if}
                        {if $vacancy->required_skills}
                        <div class="vacancy_info">
                            <div class="vacancy_info_title">Необходимые навыки</div>
                            {$vacancy->required_skills}
                        </div>
                        {/if}
                        {if $vacancy->extra_skills}
                        <div class="vacancy_info">
                            <div class="vacancy_info_title">Будет плюсом</div>
                            {$vacancy->extra_skills}
                        </div>
                        {/if}
                        {if $vacancy->offer}
                        <div class="vacancy_info">
                            <div class="vacancy_info_title">Предлагаем</div>
                            {$vacancy->offer}
                        </div>
                        {/if}

                        <button class="vacancy_submit" data-vacancy="PHP developer" type="button">Отправить резюме</button>
                    </div>
                </div>
            {/foreach}
        </div>
{/if}
    </div>
</div>

<div class="atelier-request vacancy-request">
    <div class="container-fluid">
        <div class="atelier-request_heading">
            <div class="atelier-request_heading_title">подать свое резюме</div>
        </div>
        <form action="" class="atelier-request_form">
            <div class="form-group">
                <input type="text" name="name" placeholder="Имя*" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone" placeholder="Номер телефона*" required>
            </div>
            <div class="form-group">
                <input type="text" name="vacancy" placeholder="Желаемая должность">
            </div>
            <div class="form-group upload">
                <input type="file" id="file-input">
                <label for="file-input">
                    <svg xmlns="http://www.w3.org/2000/svg" class="upload-icon" viewBox="0 0 512.056 512.056">
                        <path d="M426.635,188.224C402.969,93.946,307.358,36.704,213.08,60.37C139.404,78.865,85.907,142.542,80.395,218.303     C28.082,226.93-7.333,276.331,1.294,328.644c7.669,46.507,47.967,80.566,95.101,80.379h80v-32h-80c-35.346,0-64-28.654-64-64     c0-35.346,28.654-64,64-64c8.837,0,16-7.163,16-16c-0.08-79.529,64.327-144.065,143.856-144.144     c68.844-0.069,128.107,48.601,141.424,116.144c1.315,6.744,6.788,11.896,13.6,12.8c43.742,6.229,74.151,46.738,67.923,90.479     c-5.593,39.278-39.129,68.523-78.803,68.721h-64v32h64c61.856-0.187,111.848-50.483,111.66-112.339     C511.899,245.194,476.655,200.443,426.635,188.224z"/>
                        <path d="M245.035,253.664l-64,64l22.56,22.56l36.8-36.64v153.44h32v-153.44l36.64,36.64l22.56-22.56l-64-64     C261.354,247.46,251.276,247.46,245.035,253.664z"/>
                    </svg>
                    <svg class="check-icon" width="11" height="9" viewBox="0 0 11 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 4L4 7L10 1" stroke="#BE9948" stroke-width="1.5"/>
                    </svg>
                    <span>Загрузить резюме</span>
                </label>
                <div class="remove-file">
                    <svg xmlns="http://www.w3.org/2000/svg" height="512pt" viewBox="0 0 512 512" width="512pt"><path d="m256 0c-141.164062 0-256 114.835938-256 256s114.835938 256 256 256 256-114.835938 256-256-114.835938-256-256-256zm0 0" fill="#f44336"/><path d="m350.273438 320.105469c8.339843 8.34375 8.339843 21.824219 0 30.167969-4.160157 4.160156-9.621094 6.25-15.085938 6.25-5.460938 0-10.921875-2.089844-15.082031-6.25l-64.105469-64.109376-64.105469 64.109376c-4.160156 4.160156-9.621093 6.25-15.082031 6.25-5.464844 0-10.925781-2.089844-15.085938-6.25-8.339843-8.34375-8.339843-21.824219 0-30.167969l64.109376-64.105469-64.109376-64.105469c-8.339843-8.34375-8.339843-21.824219 0-30.167969 8.34375-8.339843 21.824219-8.339843 30.167969 0l64.105469 64.109376 64.105469-64.109376c8.34375-8.339843 21.824219-8.339843 30.167969 0 8.339843 8.34375 8.339843 21.824219 0 30.167969l-64.109376 64.105469zm0 0" fill="#fafafa"/></svg>
                </div>
            </div>
            <div class="form-group w-100">
                <textarea name="comment" placeholder="Добавить сообщение"></textarea>
            </div>
            <button class="submit">Отправить резюме</button>
        </form>
    </div>
</div>

<script>
    $('.vacancy_preview').on('click', function() {
        $(this).closest('.vacancy').toggleClass('active');
    });

    $('.vacancy_submit').on('click', function() {
        $(".atelier-request_form input[name=vacancy]").val($(this).attr('data-vacancy'));
        if($(window).width() > 768) {
            var topMg = 200;
        }else{
            var topMg = 120;
        }
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".vacancy-request").offset().top - topMg
        }, 1000);
    });

    $('document').ready(function(){
        var $file = $('#file-input'),
            $label = $file.next('label'),
            $labelIcon = $label.find('.upload-icon'),
            $labelCheck = $label.find('.check-icon'),
            $labelText = $label.find('span'),
            $labelRemove = $('.remove-file'),
            labelDefault = $labelText.text();

        $file.on('change', function(event){
            var fileName = $file.val().split( '\\' ).pop();
            if( fileName ){
                $labelText.text(fileName).addClass('check');
                $labelIcon.hide();
                $labelCheck.show();
                $labelRemove.show();
            }else{
                $labelText.text(labelDefault).removeClass('check');;
                $labelRemove.hide();
                $labelCheck.hide();
                $labelIcon.show();
            }
        });

        $labelRemove.on('click', function(event){
            $file.val("");
            $labelText.text(labelDefault).removeClass('check');
            $labelRemove.hide();
            $labelCheck.hide();
            $labelIcon.show();
        });
    })
</script>