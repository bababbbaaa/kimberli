<script>
    /* Глобальный обьект */
    /* все глобальные переменные добавляем в оъект и работаем с ним!!! */
    var okay = {literal}{}{/literal};
    okay.max_order_amount = {$settings->max_order_amount};

        {*Сброс фильтра*}
        {if $smarty.get.module == 'ProductsView'}
        $(document).on('click', '.fn_filter_reset', function () {
            var date = new Date(0);
            document.cookie = "price_filter=; path=/; expires=" + date.toUTCString();
        });
        {/if}

    {* Предзаказ *}
    okay.is_preorder = {$settings->is_preorder};
    {* Ошибка при отправке комментария в посте *}
    {if $smarty.get.module == 'BlogView' && $error}
        {* Переход по якорю к форме *}
        $( window ).load( function() {
            location.href = location.href + '#fn_blog_comment';
            $( '#fn_blog_comment' ).trigger( 'submit' );
        } );
    {/if}

    {* Обратный звонок, отправка формы *}
    {if $call_sent}
        $( function() {
            $.fancybox.open( {
                src: '#fn_callback_sent',
                type : 'inline',
            } );
        } );
    {elseif $call_error}
        $(function() {
            $.fancybox.open({
                src: '#fn_callback',
                type : 'inline'
            });
        });
    {/if}

    {* Карточка товара, ошибка в форме *}
    {if $smarty.get.module == 'ProductView' && $error}
        $( window ).load( function() {
            $( '.tab_navigation a' ).removeClass( 'selected' );
            $( '.tab' ).hide();
            $( 'a[href="#comments"]' ).addClass( 'selected' );
             $( '#comments').show();
        } );
    {* Карточка товара, отправка комментария *}
    {elseif $smarty.get.module == 'ProductView'}
        $( window ).load( function() {
            if( location.hash.search('comment') !=-1 ) {
                $( '.tab_navigation a' ).removeClass( 'selected' );
                $( '.tab' ).hide();
                $( 'a[href="#comments"]' ).addClass( 'selected' );
                 $( '#comments').show();
            }
        } );
    {/if}

    {if $subscribe_success}
        $( function() {
            $.fancybox.open( {
                src: '#fn_subscribe_sent',
                type : 'inline',
            } );
        } );
    {elseif $subscribe_error}
        $( window ).load( function() {
            location.href = location.href + '#subscribe_error';
            $.fancybox.open( {
                src: '#subscribe_error',
                type : 'inline',
            } );
        } );
    {/if}

        var form_enter_name = "{$lang->form_enter_name|escape}";
        var form_enter_phone = "{$lang->form_enter_phone|escape}";
        var form_error_captcha = "{$lang->form_error_captcha|escape}";
        var form_enter_email = "{$lang->form_enter_email|escape}";
        var form_enter_password = "{$lang->form_enter_password|escape}";
        var form_enter_message = "{$lang->form_enter_message|escape}";

    if($(".fn_validate_product").size()>0) {
        $(".fn_validate_product").validate({
            rules: {
                name: "required",
                text: "required",
                captcha_code: "required"
            },
            messages: {
                name: form_enter_name,
                text: form_enter_message,
                captcha_code: form_error_captcha
            }
        });
    }
    if($(".fn_validate_callback").size()>0) {
        $.validator.addMethod("phoneUS", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length >= 10;
        }, "Please specify a valid phone number");

        $(".fn_validate_callback").validate({
            rules: {
                phone: {
                    required: true,
                    phoneUS: true

                }
            },
            messages: {
                phone: form_enter_phone,
            }
        });
    }



    if($(".fn_validate_subscribe").size()>0) {
        $(".fn_validate_subscribe").validate({
            rules: {
                subscribe_email: "required",
            },
            messages: {
                subscribe_email: form_enter_email
            }
        });
    }
    if($(".fn_validate_post").size()>0) {
        $(".fn_validate_post").validate({
            rules: {
                name: "required",
                text: "required",
                captcha_code: "required"
            },
            messages: {
                name: form_enter_name,
                text: form_enter_message,
                captcha_code: form_error_captcha
            }
        });
    }

    if($(".fn_validate_feedback").size()>0) {

        $.validator.addMethod("phoneUS", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length >= 10;
        }, "Please specify a valid phone number");

        $(".fn_validate_feedback").validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    required: true,
                    phoneUS: true

                },
                message: "required",
            },
            messages: {
                name: form_enter_name,
                email: form_enter_email,
                message: form_enter_message,
                phone: form_enter_phone
            }
        });
    }

    if($(".fn_validate_cart").length>0) {
        $.validator.addMethod("phoneUS", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || phone_number.length >= 10;
        }, "Please specify a valid phone number");

        $(".fn_validate_cart").validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                },
                phone: {
                    required: true,
                    phoneUS: true

                },
                captcha_code: "required"
            },
            messages: {
                name: form_enter_name,
                email: form_enter_email,
                phone: form_enter_phone,
                captcha_code: form_error_captcha
            }
        });
    }

    if($(".fn_validate_login").size()>0) {
        $(".fn_validate_login").validate({
            rules: {
                email: "required",
                password: "required",
            },
            messages: {
                email: form_enter_email,
                password: form_enter_password
            }
        });
    }

    if($(".fn_validate_register").size()>0) {
        $(".fn_validate_register").validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true
                },
                password: "required",
                captcha_code: "required"
            },
            messages: {
                name: form_enter_name,
                email: form_enter_email,
                captcha_code: form_error_captcha,
                password: form_enter_password
            }
        });
    }
      if($(".fn_share").size()>0) {
        $(".fn_share").jsSocials({
            showLabel: false,
            showCount: false,
            shares: ["twitter", "facebook", "googleplus", "vkontakte"]
        });
    }

</script>
<script>

    setTimeout(function(){
(function(w,d,u){
                var s=d.createElement('script');
                s.async=true;
                s.src=u+'?'+(Date.now()/60000|0);
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://cdn.bitrix24.ua/b13447481/crm/site_button/loader_2_8q7kzc.js');
}, 2000);

</script>
{literal}
<script id="bx24_form_inline" data-skip-moving="true">
        (function(w,d,u,b){w['Bitrix24FormObject']=b;w[b] = w[b] || function(){arguments[0].ref=u;
                (w[b].forms=w[b].forms||[]).push(arguments[0])};
                if(w[b]['forms']) return;
                var s=d.createElement('script');s.async=1;s.src=u+'?'+(1*new Date());
                var h=d.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);
        })(window,document,'https://kimberli.bitrix24.ua/bitrix/js/crm/form_loader.js','b24form');

      //  b24form({"id":"4","lang":"ua","sec":"6fmwit","type":"inline"});
</script>
    <script type="text/javascript">
        (function(d, w, s) {
            var widgetHash = 'e72w5gm6r7zne5p6v1y4', gcw = d.createElement(s);
            gcw.type = 'text/javascript';
            gcw.async = true;
            gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
            var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
        })(document, window, 'script');
    </script>
    <script type="text/javascript">
        (function(d, w, s) {
            var widgetHash = '2e1p9jiyu3cja1wwrlf6', ctw = d.createElement(s);
            ctw.type = 'text/javascript';
            ctw.async = true;
            ctw.src = '//widgets.binotel.com/calltracking/widgets/'+ widgetHash +'.js';
        var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(ctw, sn);
        })(document, window, 'script');
    </script>
{/literal}
<script>

/*
$(window).load(function() {

/** код будет запущен когда страница будет полностью загружена, включая все фреймы, объекты и изображения **/
    /*
[].forEach.call(document.querySelectorAll('img[data-src]'), function(img) {
img.setAttribute('src', img.getAttribute('data-src'));
img.onload = function() {
img.removeAttribute('data-src');

};
});


});*/

</script>
