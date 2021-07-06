/* Начальное кол-во для смены в карточке и корзине */
var okay = {};
okay.amount = 1;

/* Аяксовая корзина */
$(document).on('submit', '.fn_variants', function(e) {
    e.preventDefault();
    var variant,
        amount;
    /* Вариант */
    if($(this).find('input[name=variant]:checked').size() > 0 ) {
        variant = $(this).find('input[name=variant]:checked').val();
    } else if($(this ).find('input[name=variant]').size() > 0 ) {
        variant = $(this).find('input[name=variant]').val();
    } else if($(this).find('select[name=variant]').size() > 0 ) {
        variant = $(this).find('select[name=variant]').val();
    }
    /* Кол-во */
    if($(this).find('input[name=amount]').size()>0) {
        amount = $(this).find('input[name=amount]').val();
    } else {
        amount = 1;
    }
    /* ajax запрос */
    $.ajax( {
        url: "ajax/cart.php",
        data: {
            variant: variant,
            amount: amount
        },
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            $( '#cart_informer a span' ).html( data.cart_informer );
            $('#fn_cart').html(data.cart_popap);
        }
    } );
    /* Улеталка */
    transfer( $('#cart_informer'), $(this) );
        /* Всплывающая корзина*/
     setTimeout('$(".fn_cart").trigger("click")', 1000);
});

/* Аякс callback */
$(document).on('submit', '#fn_callback_page', function(e) {
    e.preventDefault();
    var phone,
        name,
        message;
    /* Вариант */
    if($(this).find('input[name=phone]').size() > 0 ) {
        phone = $(this).find('input[name=phone]').val();
    }
    if($(this).find('input[name=name]').size() > 0 ) {
        name = $(this).find('input[name=name]').val();
    }
    if($(this).find('textarea[name=message]').size() > 0 ) {
        message = $(this).find('textarea[name=message]').val();
    }
    /* ajax запрос */
    $.ajax( {
        url: "ajax/callback.php",
        method: 'POST',
        data: {
            phone: phone,
            name: name,
            message: message,
            url: window.location.href
        },
        dataType: 'json',
        success: function(data) {
            $('.message_error').hide();
            if(data.errors){
                 $('.message_error').html(data.errors).show();
        }else{
           $('#fn_callback_page').fadeOut();
            $('.result_callback_page' ).html(data.text).fadeIn();
            fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'pick_a_gem', });
            gtag('event', 'pick_a_gem', {'event_category': 'send',});
        }
        }
    } );
});

setTimeout(function(){
    let str = $(location).attr('pathname');

    if ((str.includes('products') || str.includes('catalog')) && !readCookie('coupon')) {

        writeCookie('coupon', 'set', 43200); // 12 чвсов

        $.fancybox.open({
            src: '#coupon-popup',
            type: 'inline'
        });
    }
}, 3000);

$(document).on('submit', '.coupon_form', function(e) {
    e.preventDefault();
    let phone;

    /* Вариант */
    if ($(this).find('input[name=phone]').size() > 0) {
        phone = $(this).find('input[name=phone]').val();
    }

    if (phone) {

        $.ajax({
            url: "rest/coupon",
            method: 'POST',
            data: {phone: phone},
            dataType: 'json',
            success: function (data) {

                if (data.status === true) {

                    gtag('event', 'popup', {'event_category': 'send_form',});

                  $('.coupon-popup .body').html(data.data.message);

                    setTimeout(function(){
                        $.fancybox.close({
                            src: '#coupon-popup',
                            type: 'inline'
                        });
                    }, 1000);

                } else {

                    $.fancybox.close({
                        src: '#coupon-popup',
                        type: 'inline'
                    });
                }
            },
            error: function (e) {
                console.log(e);

                $.fancybox.close({
                    src: '#coupon-popup',
                    type: 'inline'
                });
            }
        });
    }

    return false;
});

$(function(){
    //2. Получить элемент, к которому необходимо добавить маску
    $("#phone").mask("+38 (099) 999-99-99");
});

/* Аякс feedback */
/* Аякс quick_order */
$(document).on('submit', '.fn_validate_feedback', function(e) {
    e.preventDefault();
    let val = $(document.activeElement);
    var phone;

    /* Вариант */
    if($(this).find('input[name=phone]').size() > 0 ) {
        phone = $(this).find('input[name=phone]').val();
    }

    if (phone) {
        val.prop("disabled", true);

        sendSms(phone);

        setTimeout(function(){
            val.removeAttr('disabled');
        }, 3000);

        console.log('send sms');
    }

    console.log('end');
    return false;
});

$('.fn_validate_feedback input[type="submit"]').click(function(e) {

    if ($(this).attr('data-method') == 'confirm') {

        if (typeof(readCookie('sms_code')) != "undefined" && readCookie('sms_code') !== null) {
            let cod = $('#sms_code_run').val();

            if (cod == readCookie('sms_code')) {

                console.log('confirmOrder');

                $('.send_code_button').val('Loading...');
                $('.send_code_button').prop("disabled", true);

                gtag('event', 'sms_confirmation', {
                    'event_category': 'send_form',
                });

                $.ajax({
                    url: "rest/feedback",
                    method: 'POST',
                    data: $('.fn_validate_feedback').serialize(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === true) {
                            fbq('track', 'Contact', { content_name: 'my-Name', content_category: 'Valuation Form submitted'});
                            gtag( 'event', 'WriteInContact', { 'event_category' : 'send' ,});

                            $.fancybox.close({
                                src: '#fn_sms_verification',
                                type: 'inline'
                            });

                            $('.fn_validate_feedback' ).html(data.data.message);
                        }
                    },
                    error: function (e) {
                        console.log(e);
                        $.fancybox.close({
                            src: '#fn_sms_verification',
                            type: 'inline'
                        });
                        return false;
                    }
                });

            } else {
                $('.send_code_button').prop("disabled", true);

                $('.sms_hide_error').fadeIn(100);

                setTimeout(function(){
                    $('.sms_hide_error').fadeOut(300);
                }, 3000);

                $('#sms_code_run').val('').focus();
            }
        } else {
            $.fancybox.close({
                src: '#fn_sms_verification',
                type: 'inline'
            });
            alert('Код устарел!');
        }
    }
});


/* Аякс quick_order */
$(document).on('submit', '.quick_order_form', function(e) {
    e.preventDefault();
    let val = $(document.activeElement);

    var phone,
        variant;

    /* Вариант */
    if($(this).find('input[name=phone]').size() > 0 ) {
        phone = $(this).find('input[name=phone]').val();
    }

    if($(this).find('input[name=variant]').size() > 0 ) {
        variant = $(this).find('input[name=variant]').val();
    }
    
    console.log(phone);
    console.log(variant);

    if (phone) {
        val.prop("disabled", true);

        sendSms(phone);

        setTimeout(function(){
            val.removeAttr('disabled');
        }, 3000);

        console.log('send sms');
    }

    console.log('end');
    return false;
});

$('.quick_order_form input[type="submit"]').click(function(e) {

    if ($(this).attr('data-method') == 'confirm') {

        if (typeof(readCookie('sms_code')) != "undefined" && readCookie('sms_code') !== null) {
            let cod = $('#sms_code_run').val();

            if (cod == readCookie('sms_code')) {

                console.log('confirmOrder');

                $('.send_code_button').val('Loading...');
                $('.send_code_button').prop("disabled", true);

                gtag('event', 'sms_confirmation', {
                    'event_category': 'send_form',
                });

                confirmQuickOrder($('.quick_order_form').serialize());
            } else {
                $('.send_code_button').prop("disabled", true);

                $('.sms_hide_error').fadeIn(100);

                setTimeout(function(){
                    $('.sms_hide_error').fadeOut(300);
                }, 3000);

                $('#sms_code_run').val('').focus();
            }
        } else {
            $.fancybox.close({
                src: '#fn_sms_verification',
                type: 'inline'
            });
            alert('Код устарел!');
        }
    }
});

function confirmQuickOrder(data)
{
    $.ajax({
        url: "rest/order/quick",
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            if (data.status === true) {
                fbq('track', 'Purchase', {
                    value: data.data.value,
                    currency: data.data.currency,
                });

                gtag('event', 'fasr_order', {  'event_category': 'send_form',});
               // fbq('track', 'AddQuickOrder', { content_name: 'my-Name', content_category: 'Valuation Form submitted'});

                $.fancybox.close({
                    src: '#fn_sms_verification',
                    type: 'inline'
                });

                $('.hide_result').hide();
                $('.result_quick_order' ).html(data.data.message).fadeIn();
            }
        },
        error: function (e) {
            console.log(e);
            $.fancybox.close({
                src: '#fn_sms_verification',
                type: 'inline'
            });
            return false;
        }
    });

    /* ajax запрос */
  /*  $.ajax( {
        url: "ajax/quick_order.php",
        method: 'POST',
        data: {
            phone: phone,
            name: name,
            variant: variant,
            captcha_code: captcha_code
        },
        dataType: 'json',
        success: function(data) {
            $('.message_error').hide();
            if(data.errors.length > 0){
                for(var key in data.errors) {
                    $('.message_error .'+data.errors[key]).show();
                }
                $('.message_error').show();
            }else{
                $('.hide_result').hide();
                $('.result_quick_order' ).html(data.text).fadeIn();
            }
        },
        error: function(e) {
            console.log(e);
        }
    } );*/

}


/* Ajax new order*/
$(document).on('submit', '.fn_validate_cart', function(e) {
    e.preventDefault();
    let val = $(document.activeElement);
    // серилизацию тем или иным способом
    if (val.attr('data-method') == 'create') {
        let phone = false;

        if($('.fn_validate_cart input[name=phone]').size() > 0 ) {
            phone = $('.fn_validate_cart input[name=phone]').val();
        }

        if (phone) {
            val.prop("disabled", true);

            sendSms(phone);

            setTimeout(function(){
                val.removeAttr('disabled');
            }, 3000);

            console.log('send sms');
        }
    }

    console.log('end');
    return false;
});

$('.fn_validate_cart input[type="submit"]').click(function(e) {

    if ($(this).attr('data-method') == 'confirm') {

    if (typeof(readCookie('sms_code')) != "undefined" && readCookie('sms_code') !== null) {
        let cod = $('#sms_code_run').val();

        if (cod == readCookie('sms_code')) {
            console.log('confirmOrder');
            $('.send_code_button').val('Loading...');
            $('.send_code_button').prop("disabled", true);

            gtag('event', 'sms_confirmation', {
                'event_category': 'send_form',
            });

            confirmOrder($('.fn_validate_cart').serialize());
        } else {
            $('.send_code_button').prop("disabled", true);

            $('.sms_hide_error').fadeIn(100);

            setTimeout(function(){
                $('.sms_hide_error').fadeOut(300);
            }, 3000);

            $('#sms_code_run').val('').focus();
        }
    } else {
        $.fancybox.close({
            src: '#fn_sms_verification',
            type: 'inline'
        });
        alert('Код устарел!');
    }
}
});


function sendSms(phone) {
    /* ajax запрос */
    $.ajax({
        url: "rest/order/sms/send",
        method: 'GET',
        data: {phone: phone},
        dataType: 'json',
        success: function(data) {
            writeCookie('sms_code', data.data.code, 60);
        },
        error: function(e) {
            console.log(e);
            return false;
        }
    }).done(function (data) {
        let id = data.data.id;

        checkSmsStatus(id);
    });
}

function checkSmsStatus(smsId, limit = 1)
{
    /* ajax запрос */
    $.ajax({
        url: "rest/order/sms/status",
        method: 'GET',
        data: {id: smsId},
        dataType: 'json',
        success: function(data) {
            if (!data.data.status && limit < 5) {
                checkSmsStatus(smsId, limit++);
            } else {
                console.log('fancybox sms');

                $.fancybox.open({
                    src: '#fn_sms_verification',
                    type: 'inline'
                });

                $('#sms_code_run').focus();
            }
        },
        error: function(e) {
            console.log(e);
            return false;
        }
    });

    return false;
}

function confirmOrder(data)
{
    $.ajax({
        url: "rest/order/create",
        method: 'POST',
        data: data,
        dataType: 'json',
        success: function (data) {
            if (data.status === true) {
                fbq('track', 'Purchase', {
                    value: data.data.value,
                    currency: data.data.currency,
                });

                window.location = data.data.url;
            }
            return false;
        },
        error: function (e) {
            console.log(e);
            $.fancybox.close({
                src: '#fn_sms_verification',
                type: 'inline'
            });
            return false;
        }
    });

}
/* Работаем с куками*/
function writeCookie(name, val, expires) {
    document.cookie = name+"="+val+"; path=/; max-age=" + expires;
}

function readCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : false;
}
/* Работаем с куками*/

/* Аякс santa */
$(document).on('submit', '#santa_form', function(e) {
    e.preventDefault();
    var phone,
        name,
        message;
    /* Вариант */
    if($(this).find('input[name=phone]').size() > 0 ) {
        phone = $(this).find('input[name=phone]').val();
    }
    if($(this).find('input[name=name]').size() > 0 ) {
        name = $(this).find('input[name=name]').val();
    }
    if($(this).find('textarea[name=message]').size() > 0 ) {
        message = $(this).find('textarea[name=message]').val();
    }
    /* ajax запрос */
    $.ajax( {
        url: "ajax/forma.php",
        method: 'POST',
        data: {
            phone: phone,
            name: name,
            message: message,
            url: window.location.href
        },
        dataType: 'json',
        success: function(data) {
           // console.log(data);
            $('.error_forma').hide();
            if(data.errors){
                 $('.error_forma').html(data.errors).show();
        }else{
           $('#santa_form').fadeOut();
            $('.result_forma' ).html(data.message).fadeIn();
            fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Santa', });
            gtag('event', 'pick_a_gem', {'event_category': 'Santa',});
        }
        },
        error: function(e) {
            console.log(e);
        }
    } );
});
/* Аякс santa */
$(document).on('submit', '#form_26', function(e) {
    e.preventDefault();
    var phone,
        name,
        message,
        id;
        id = 'form_26';
    /* Вариант */
    if($(this).find('input[name=phone]').size() > 0 ) {
        phone = $(this).find('input[name=phone]').val();
    }
    if($(this).find('input[name=name]').size() > 0 ) {
        name = $(this).find('input[name=name]').val();
    }
    if($(this).find('textarea[name=message]').size() > 0 ) {
        message = $(this).find('textarea[name=message]').val();
    }
    /* ajax запрос */
    $.ajax( {
        url: "ajax/26.php",
        method: 'POST',
        data: {
            phone: phone,
            name: name,
            message: message,
            url: window.location.href
        },
        dataType: 'json',
        success: function(data) {
            // console.log(data);
            $('.error_forma').hide();
            if(data.errors){
                 $('.error_forma').html(data.errors).show();
        }else{
           $('#'+id).fadeOut();
            $('.result_forma' ).html(data.message).fadeIn();
            fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: '26', });
            gtag('event', 'pick_a_gem', {'event_category': '26',});
        }
        },
        error: function(e) {
            console.log(e);
        }
    } );
});

$(document).on('change', '.fn_variant', function() {
    window.location = $(this).children(':selected').data('href');
});

/* Смена варианта в превью товара и в карточке */

$(document).on('change', '.fn_variant_list', function() {
    var selected = $( this ).children( ':selected' ),
        parent = selected.closest( '.fn_product' ),
        price = parent.find( '.fn_price' ),
        cprice = parent.find( '.fn_old_price' ),
        sku = parent.find( '.fn_sku' ),
        stock = parseInt( selected.data( 'stock' ) ),
        amount = parent.find( 'input[name="amount"]' ),
        camoun = parseInt( amount.val()),
        units = selected.data('units'),
        link = parent.find( 'a.product_name' ),
        link_img = parent.find( 'a.preview_image' ),
        href = selected.data('href');
    link.attr("href", href);
    link_img.attr("href", href);
    price.html( selected.data( 'price' ) );
    amount.data('max', stock);

    //parent.find('a.product_name').href(href);

    // Количество товаров
    if ( stock < camoun ) {
        amount.val( stock );
    } else if ( okay.amount > camoun ) {
        amount.val( okay.amount );
    }
    else if(isNaN(camoun)){
        amount.val( okay.amount );
    }
    // Цены
    if( selected.data( 'cprice' ) ) {
        cprice.html( selected.data( 'cprice' ) );
        cprice.parent().removeClass( 'hidden' );
    } else {
        cprice.parent().addClass( 'hidden' );
    }
    // Артикул
    if( typeof(selected.data( 'sku' )) != 'undefined' ) {
        sku.text( selected.data( 'sku' ) );
        sku.parent().removeClass( 'hidden' );
    } else {
        sku.text( '' );
        sku.parent().addClass( 'hidden' );
    }
    // Наличие на складе
    if (stock == 0) {
        parent.find('.fn_not_stock').removeClass('hidden');
        parent.find('.fn_in_stock').addClass('hidden');
    } else {
        parent.find('.fn_in_stock').removeClass('hidden');
        parent.find('.fn_not_stock').addClass('hidden');
    }
    // Предзаказ
    if (stock == 0 && okay.is_preorder) {
        parent.find('.fn_is_preorder').removeClass('hidden');
        parent.find('.fn_is_stock, .fn_not_preorder').addClass('hidden');
    } else if (stock == 0 && !okay.is_preorder) {
        parent.find('.fn_not_preorder').removeClass('hidden');
        parent.find('.fn_is_stock, .fn_is_preorder').addClass('hidden');
    } else {
        parent.find('.fn_is_stock').removeClass('hidden');
        parent.find('.fn_is_preorder, .fn_not_preorder').addClass('hidden');
    }
    if( typeof(units) != 'undefined' ) {
        parent.find('.fn_units').text(', ' + units);
    } else {
        parent.find('.fn_units').text('');
    }
});

/* Количество товара в карточке и корзине */
$( document ).on( 'click', '.fn_product_amount span', function() {
    var input = $( this ).parent().find( 'input' ),
        action;
    if ( $( this ).hasClass( 'plus' ) ) {
        action = 'plus';
    } else if ( $( this ).hasClass( 'minus' ) ) {
        action = 'minus';
    }
    amount_change( input, action );
} );

/* Функция добавления / удаления в папку сравнения */
$(document).on('click', '.fn_comparison', function(e){
    e.preventDefault();
    var button = $( this ),
        action = $( this ).hasClass( 'selected' ) ? 'delete' : 'add',
        product = parseInt( $( this ).data( 'id' ) );
    /* ajax запрос */
    $.ajax( {
        url: "ajax/comparison.php",
        data: { product: product, action: action },
        dataType: 'json',
        success: function(data) {
            $( '#comparison' ).html( data );
            /* Смена класса кнопки */
            if( action == 'add' ) {
                button.addClass( 'selected' );
            } else if( action == 'delete' ) {
                button.removeClass( 'selected' );
            }
            /* Смена тайтла */
            if( button.attr( 'title' ) ) {
                var text = button.data( 'result-text' ),
                    title = button.attr( 'title' );
                button.data( 'result-text', title );
                button.attr( 'title', text );
            }
            /* Если находимся на странице сравнения - перезагрузить */
            if( $( '.fn_comparison_products' ).size() ) {
                window.location = window.location;
            }
        }
    } );
    /* Улеталка */
    if( !button.hasClass( 'selected' ) ) {
        transfer( $( '#comparison' ), $( this ) );
    }
});

/* Функция добавления / удаления в папку избранного */
$(document).on('click', '.fn_wishlist', function(e){
    e.preventDefault();
    var button = $( this ),
        action = $( this ).hasClass( 'selected' ) ? 'delete' : '';
    /* ajax запрос */
    $.ajax( {
        url: "ajax/wishlist.php",
        data: { id: $( this ).data( 'id' ), action: action },
        dataType: 'json',
        success: function(data) {
            $( '.wishlist-data' ).html( data.info );
            /* Смена класса кнопки */
            if (action == '') {
                button.addClass( 'selected' );
            } else {
                button.removeClass( 'selected' );
            }
            /* Смена тайтла */
            if( button.attr( 'title' ) ) {
                var text = button.data( 'result-text' ),
                    title = button.attr( 'title' );
                button.data( 'result-text', title );
                button.attr( 'title', text );
            }
            /* Если находимся на странице сравнения - перезагрузить */
            if( $( '.fn_wishlist_page' ).size() ) {
                window.location = window.location;
            }
        }
    } );
    /* Улеталка */
    if( !button.hasClass( 'selected' ) ) {
        transfer( $( '.wishlist-data' ), $( this ) );
    }
});

/* Отправка купона по нажатию на enter */
$( document ).on( 'keypress', '.fn_coupon', function(e) {
    if( e.keyCode == 13 ) {
        e.preventDefault();
        ajax_coupon();
    }
} );

/* Отправка купона по нажатию на кнопку */
$( document ).on( 'click', '.fn_sub_coupon', function(e) {
    ajax_coupon();
} );

function change_currency(currency_id) {
    $.ajax({
        url: "ajax/change_currency.php",
        data: {currency_id: currency_id},
        dataType: 'json',
        success: function(data) {
            if (data == true) {
                document.location.reload()
            }
        }
    });
    return false;
}

function price_slider_init() {

    var slider_all = $( '#fn_slider_min, #fn_slider_max' ),
        slider_min = $( '#fn_slider_min' ),
        slider_max = $( '#fn_slider_max' ),
        current_min = slider_min.val(),
        current_max = slider_max.val(),
        range_min = slider_min.data( 'price' ),
        range_max = slider_max.data( 'price' ),
        link = window.location.href.replace( /\/page-(\d{1,5})/, '' ),
        ajax_slider = function() {
            $.ajax( {
                url: link,
                data: {
                    ajax: 1,
                    'p[min]': slider_min.val(),
                    'p[max]': slider_max.val()
                },
                dataType: 'json',
                success: function(data) {
                    $('#fn_products_content').html( data.products_content );
                    $('.fn_pagination').html( data.products_pagination );
                    $('.fn_products_sort').html(data.products_sort);
                    $('.fn_features').html(data.features);
                    $('.fn_selected_features').html(data.selected_features);
                    $('.products_item').matchHeight();
                    // Выпадающие блоки
                    $('.fn_switch').click(function(e){
                        e.preventDefault();

                        $(this).next().slideToggle(300);

                        if ($(this).hasClass('active')) {
                            $(this).removeClass('active');
                        }
                        else {
                            $(this).addClass('active');
                        }
                    });

                    price_slider_init();

                    $('.fn_ajax_wait').remove();
                }
            } );
        };
    link = link.replace(/\/sort-([a-zA-Z_]+)/, '');

    $( '#fn_slider_price' ).slider( {
        range: true,
        min: range_min,
        max: range_max,
        values: [current_min, current_max],
        slide: function(event, ui) {
            slider_min.val( ui.values[0] );
            slider_max.val( ui.values[1] );
        },
        stop: function(event, ui) {
            slider_min.val( ui.values[0] );
            slider_max.val( ui.values[1] );
            $('.fn_categories').append('<div class="fn_ajax_wait"></div>');
            ajax_slider();
        }
    } );

    slider_all.on( 'change', function() {
        $( "#fn_slider_price" ).slider( 'option', 'values', [slider_min.val(), slider_max.val()] );
        ajax_slider();
    } );
}

/* Document ready */
$(function(){

    if($(window).width() < 992) {
        $(document).on("click", ".category-mobile-heading", function(e) {
            e.preventDefault();
            if($(this).closest('.header_category_item').hasClass('active')){
                $('.header_category_item').removeClass('active');
            }else{
                $('.header_category_item').removeClass('active');
                $(this).closest('.header_category_item').addClass('active');
            }
        });
    }

    $(document).on("click", ".fn_menu_toggle", function() {
        $(this).next(".fn_menu_list").first().slideToggle(300);
        return false;
    });

    $(function(){
        $(window).scroll(function() {
            var screen = $(document);
            if (screen.scrollTop() > 150) {
                $(".clone_menu").html('');
                $(".navigation #menu_top").clone().appendTo(".clone_menu");
                $(".clone_menu #menu_top .menu_group").remove();

                $(".top_header").addClass('fixed');
            } else {
                $(".clone_menu").html('');
                $(".top_header").removeClass('fixed');
            }
        });
    });
    
    
    
    //Кнопка вверх
    $(window).scroll(function () {
    var scroll_height = $(window).height();

        if ($(this).scrollTop() >= scroll_height) {
            $('.to_top').fadeIn();
        } else {
            $('.to_top').fadeOut();
        }
    });

    $('.to_top').click(function(){
        $("html, body").animate({scrollTop: 0}, 500);
    });




    $('body').on('click', '.fn-action_serch', function(e) {
        if ($('#search').val() == '' ||  !$('.field').hasClass('opened')) {
            //* если текстовое поле пустое или свернуто - не даем форме отправиться
            //* и сворачиваем/разворачиваем его
            e.preventDefault();
            e.stopPropagation();
            $('.field').toggleClass('opened');
        }
    });
    //* не даем свернуться текстовому полю при клике на нём
    $('body').on('click', '.field', function(e) {
        e.stopPropagation();
    });
    //* сворачиваем поле при кли клике в любом месте
    $('html').on('click', function(e) {
        $('.field').removeClass('opened');
    });

    // Выпадающие блоки
    $('.fn_cat_switch').click(function(e){
        e.preventDefault();

        $(this).next().slideToggle(300);

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
        else {
            $(this).addClass('active');
        }
    });

    // Выпадающие блоки 2
    $('.fn_cat_switch_2').click(function(e){
        e.preventDefault();

        $(this).parent().next().slideToggle(300);

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
        else {
            $(this).addClass('active');
        }
    });

    /* Главное меню для мобильных */
    $('.fn_menu_switch').on("click", function(){

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(".top_header").removeClass('active');
            $('#menu_top').hide(100);
        }
        else {
            $(this).addClass('active');
            $(".top_header").addClass('active');
            $('#menu_top').show(100);
        }
    })

    /* Фильтр по товарам для мобильных */
    $('.fn_filter_switch').on("click", function(){

        $('.sidebar').slideToggle(300);

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
        else {
            $(this).addClass('active');
        }
    })

    // Выпадающие категории
    $('.fn_cat_switch').click(function(e){
        e.preventDefault();

        if ($(this).closest(".menu_item_categories").hasClass('active')) {
            $(this).closest(".menu_item_categories").removeClass('active');
        }
        else {
            $(this).closest(".menu_item_categories").addClass('active');
        }
    });
    // Выпадающие блоки
    $('.fn_switch').click(function(e){
        e.preventDefault();

        $(this).next().slideToggle(300);

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
        else {
            $(this).addClass('active');
        }
    });
    // Эмуляция наведения мыши на планшете и мобильном
    $('ul li.category_item.has_child').on("touchstart", function (e) {
        'use strict'; //satisfy code inspectors
        var link = $(this);
        if (link.hasClass('hover')) {
            return true;
        } else {
            if (link.parent().is('.level_1')) {
                $('ul li.category_item.has_child').removeClass('hover');
            } else {
                link.siblings('.hover').removeClass('hover');
            }
            link.addClass('hover');
            e.preventDefault();
            return false;
        }
    });

    // Выпадающее меню категории
    $('.fn_head_cat_switch').hover(function(e){
        e.preventDefault();

        $(this).parent().toggleClass("hover_active");

        if ($(this).hasClass('active')) {
            $(this).removeClass('active');
        }
        else {
            $(this).addClass('active');
        }
    });



    //Фильтры мобильные, каталог мобильные
    $('.subswitch').click(function(){
        $(this).parent().next().slideToggle(500);

        if ($(this).hasClass('down')) {
            $(this).removeClass('down');
        }
        else {
            $(this).addClass('down');
        }
    });
    $('.category_link.selected').closest('.subcategory').addClass('opened').find('> .cat_switch').addClass('active');


    $('.fn_switch_dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).fadeIn(200).toggleClass("hover");
        $(this).toggleClass("active");
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).fadeOut(200).toggleClass("hover");
        $(this).toggleClass("active");
    });

    //Табы в карточке товара
    var nav = $('.tabs').find('.tab_navigation');
    var tabs = $('.tabs').find('.tab_container');

    if(nav.children('.selected').size() > 0) {
        $(nav.children('.selected').attr("href")).show();
    } else {
        nav.children().first().addClass('selected');
        tabs.children().first().show();
    }

    $('.tab_navigation a').click(function(e){
        e.preventDefault();
        if($(this).hasClass('selected')){
            return true;
        }
        tabs.children().hide();
        nav.children().removeClass('selected');
        $(this).addClass('selected');
        $($(this).attr("href")).fadeIn(200);
    });



    /* Инициализация баннера */
    $('.fn_banner_group1').slick({
        infinite: true,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1,
        swipeToSlide : true,
        dots: true,
        arrows: false,
        adaptiveHeight: true,
        autoplaySpeed: 5000,
        autoplay: true,
        fade: true
    });


    /* Бренды слайдер*/
    $(".fn_all_brands").slick({
        infinite: true,
        speed: 500,
        slidesToShow: 6,
        slidesToScroll: 1,
        arrows: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 5
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 420,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    if( $( '#zoom_image' ).size() ) {
        $('#zoom_image').elevateZoom({
            zoomType: "inner",
            cursor: "crosshair",
            zoomWindowFadeIn: 500,
            zoomWindowFadeOut: 750
        });
    };

    /* Слайдеры продуктов на главной*/
    $('.fn-main_products').slick({
        speed: 500,
        slidesToShow: 5,
        slidesToScroll: 1,
        swipeToSlide : true,
        arrows: false,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                }
            },
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    /* Инициализация доп. фото в карточке */
    $(".fn_images").slick({
        infinite: false,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1,
        swipeToSlide : true,
        arrows: true,
        verticalSwiping: true,
        vertical: true,
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    verticalSwiping: false,
                    vertical: false,
                }
            },
            {
                breakpoint: 992,
                settings: {
                    verticalSwiping: false,
                    vertical: false,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    verticalSwiping: false,
                    vertical: false,
                    arrows: false,
                    dots: true
                }
            }
        ]
    });

    function setGalleryPreview(){
        $('.product_image a').attr('href', $('.images_item.slick-current .images_link').attr('data-link'));
        $('.product_image img').attr('src', $('.images_item.slick-current .images_link').attr('data-img'));
        $('.product_image img').attr('data-zoom-image', $('.images_item.slick-current .images_link').attr('data-zoom'));

        let zoomImg = document.querySelector('.zoomWindow');
        let zoomLink = $('.images_item.slick-current .images_link').attr('data-link');
        zoomImg.style.backgroundImage = "url('"+zoomLink+"')";
    };

    if($(window).width() > 768) {
      //  $(".fn_images").on("afterChange", function (){
       //     setGalleryPreview();
       // });

        $(".images_item").click(function(){
            slideIndex = $(this).index();
            $(".images_item").removeClass('slick-current');
            $(this).addClass('slick-current');
            $('.fn_images').slick('slickGoTo', parseInt(slideIndex));
            setGalleryPreview();
        });
    }

    $('.blog_item').matchHeight();
    $('.news_item').matchHeight();
    $('.brand_item').matchHeight();
    $('.preview').matchHeight();
    $('.product_name').matchHeight({
        byRow: true
    });
    $('.preview .product_images').matchHeight();
    $('.p_brand_item .brand_image').matchHeight();
    $('.fn_col').matchHeight();


    /* Показать все в фильтрах по свойствам */
    $('.view_all_feature').click(function(){
        var v = $(this).data('view');
        var clos = $(this).data('close');
        $(this).closest('.feature_content').toggleClass('opened');
        $('.view_all_feature').not($(this)).html(v);
        $('.view_all_feature').not($(this)).closest('.feature_content').removeClass('opened');
        if ($(this).closest('.feature_content').hasClass('opened')) {
            $(this).html(clos);
        } else {
            $(this).html(v);
        }
        return false;
    });

    /* Выборка второго изображения для ховера */
    /*$(".product_images").on("mouseover mouseout", "img[data-imagehover]", function (a) {
		if (a.type == "mouseover") {
			if ($(this).data("imageoriginal") === undefined) {
				$(this).data("imageoriginal", $(this).attr("src"))
			}
			if ($(this).data("imagehover") != "") {
				$(this).attr("src", $(this).data("imagehover"))
			}
		} else {
			if (a.type == "mouseout") {
				if ($(this).data("imageoriginal")) {
					$(this).attr("src", $(this).data("imageoriginal"))
				}
			}
		}
	});*/


    /* Обратный звонок */
    $('.fn_callback').fancybox();

    /* Всплывающая корзина*/
    $('.fn_cart').fancybox();

    /*Быстрый заказ*/
    $('.fn_quick_order').fancybox();


    /* Зум картинок в карточке */
    $('[data-fancybox]').fancybox({
        image : {
            protect: true
        }
    });

    $.fancybox.defaults.hash = false;

    /* Аяксовый фильтр по цене */
    if( $( '#fn_slider_price' ).size() ) {

        price_slider_init();

        // Если после фильтрации у нас осталось товаров на несколько страниц, то постраничную навигацию мы тоже проведем с помощью ajax чтоб не сбить фильтр по цене
        $( document ).on( 'change', '.select_sort', function(e) {
            e.preventDefault();
            var link = $(this).children(':selected').val();

            if ($(this).hasClass('is_ajax')){
                $('.fn_categories').append('<div class="fn_ajax_wait"></div>');
                var send_min = $("#fn_slider_min").val();
                send_max = $("#fn_slider_max").val();
                $.ajax( {
                    url: link,
                    data: { ajax: 1, 'p[min]': send_min, 'p[max]': send_max },
                    dataType: 'json',
                    success: function(data) {
                        $( '#fn_products_content' ).html( data.products_content );
                        $( '.fn_pagination' ).html( data.products_pagination );
                        $('#fn_products_sort').html(data.products_sort);
                        $('#fn_products_content .preview').matchHeight();
                        $('#fn_products_content .product_name').matchHeight();
                        $('.fn_ajax_wait').remove();
                    }
                } );
            }else{
                $(location).attr('href',link);
            };

        } );

    }

    /* Автозаполнитель поиска */
    $( ".fn_search" ).autocomplete( {
        serviceUrl: 'ajax/search_products.php',
        minChars: 1,
        noCache: true,
        onSelect: function(suggestion) {
            $( "#fn_search" ).submit();
        },
        transformResult: function(result, query) {
            var data = JSON.parse(result);
            $(".fn_search").autocomplete('setOptions', {triggerSelectOnValidInput: data.suggestions.length == 1});
            return data;
        },
        formatResult: function(suggestion, currentValue) {
            var reEscape = new RegExp( '(\\' + ['/', '.', '*', '+', '?', '|', '(', ')', '[', ']', '{', '}', '\\'].join( '|\\' ) + ')', 'g' );
            var pattern = '(' + currentValue.replace( reEscape, '\\$1' ) + ')';
            return "<div>" + (suggestion.data.image ? "<img align=absmiddle src='" + suggestion.data.image + "'> " : '') + "</div>" + "<a href=" + suggestion.lang + "products/" + suggestion.data.url + '>' + suggestion.value.replace( new RegExp( pattern, 'gi' ), '<strong>$1<\/strong>' ) + '<\/a>' + "<span>" + suggestion.price + " " + suggestion.currency + "</span>";
        }
    } );

    /* Слайдер в сравнении */
    if( $( '.fn_comparison_products' ).size() ) {
        $( '.fn_comparison_products' ).slick( {
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 1,
            arrows: true,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        } );

        resize_comparison();


        /* Показать / скрыть одинаковые характеристики в сравнении */
        $( document ).on( 'click', '.fn_show a', function(e) {
            e.preventDefault();
            $( '.fn_show a.active' ).removeClass( 'active' );
            $( this ).addClass( 'active' );
            if( $( this ).hasClass( 'unique' ) ) {
                $( '.cell.not_unique' ).hide();
            } else {
                $( '.cell.not_unique' ).show();
            }
        } );
    };
    /* Рейтинг товара */
    $('.product_rating').rater({ postHref: 'ajax/rating.php' });

    /* Переключатель способа оплаты */
    $( document ).on( 'click', '[name="payment_method_id"]', function() {
        $( '[name="payment_method_id"]' ).parent().removeClass( 'active' );
        $( this ).parent().addClass( 'active' );
    } );
});


/* Обновление блоков: cart_informer, cart_purchases, cart_deliveries */
function ajax_set_result(data) {
    $( '#cart_informer a span' ).html( data.cart_informer );
    $( '#fn_purchases' ).html( data.cart_purchases );
    $( '#fn_ajax_deliveries' ).html( data.cart_deliveries );
    $( '#fn_cart').html(data.cart_popap);
}

/* Аяксовое изменение кол-ва товаров в корзине */
function ajax_change_amount(object, variant_id) {
    var amount = $( object ).val(),
        coupon_code = $( 'input[name="coupon_code"]' ).val(),
        delivery_id = $( 'input[name="delivery_id"]:checked' ).val(),
        payment_id = $( 'input[name="payment_method_id"]:checked' ).val();
    /* ajax запрос */
    $.ajax( {
        url: 'ajax/cart_ajax.php',
        data: {
            coupon_code: coupon_code,
            action: 'update_citem',
            variant_id: variant_id,
            amount: amount
        },
        dataType: 'json',
        success: function(data) {
            if( data.result == 1 ) {
                ajax_set_result( data );
                $( '#deliveries_' + delivery_id ).trigger( 'click' );
                $( '#payment_' + delivery_id + '_' + payment_id ).trigger( 'click' );
            } else {
                $( '#cart_informer a span' ).html( data.cart_informer );
                $(".fn_ajax_content").html( data.content );
            }
        }
    } );
}

/* Функция изменения количества товаров */
function amount_change(input, action) {
    var max_val,
        curr_val = parseFloat( input.val() ),
        step = 1,
        id = input.data('id');
    if(isNaN(curr_val)){
        curr_val = okay.amount;
    }

    /* Если включен предзаказ макс. кол-во товаров ставим максимально количество товаров в заказе */
    if ( input.parent().hasClass('fn_is_preorder')) {
        max_val = okay.max_order_amount;
    } else {
        max_val = parseFloat( input.data( 'max' ) );
    }
    /* Изменение кол-ва товара */
    if( action == 'plus' ) {
        input.val( Math.min( max_val, Math.max( 1, curr_val + step ) ) );
        input.trigger('change');
    } else if( action == 'minus' ) {
        input.val( Math.min( max_val, Math.max( 1, (curr_val - step) ) ) );
        input.trigger('change');
    } else if( action == 'keyup' ) {
        input.val( Math.min( max_val, Math.max( 1, curr_val ) ) );
        input.trigger('change');
    }
    okay.amount = parseInt( input.val() );
    /* в корзине */
    if( $('div').is('#fn_purchases') && ( (max_val != curr_val && action == 'plus' ) || ( curr_val != 1 && action == 'minus' ) ) ) {
        ajax_change_amount( input, id );
    }
}

/* Функция анимации добавления товара в корзину */
function transfer(informer, thisEl) {
    var o1 = thisEl.offset(),
        o2 = informer.offset(),
        dx = o1.left - o2.left,
        dy = o1.top - o2.top,
        distance = Math.sqrt(dx * dx + dy * dy);

    thisEl.closest( '.fn_transfer' ).find( '.fn_img' ).effect( "transfer", {
        to: informer,
        className: "transfer_class"
    }, distance );

    var container = $( '.transfer_class' );
    container.html( thisEl.closest( '.fn_transfer' ).find( '.fn_img' ).parent().html() );
    container.find( '*' ).css( 'display', 'none' );
    container.find( '.fn_img' ).css( {
        'display': 'block',
        'height': '100%',
        'z-index': '2',
        'position': 'relative'
    } );

    return true;
}

/* Аяксовый купон */
function ajax_coupon() {
    var coupon_code = $('input[name="coupon_code"]').val(),
        delivery_id = $('input[name="delivery_id"]:checked').val(),
        payment_id = $('input[name="payment_method_id"]:checked').val();
    /* ajax запрос */
    $.ajax( {
        url: 'ajax/cart_ajax.php',
        data: {
            coupon_code: coupon_code,
            action: 'coupon_apply'
        },
        dataType: 'json',
        success: function(data) {
            if( data.result == 1 ) {
                ajax_set_result( data );
                $( '#deliveries_' + delivery_id ).trigger( 'click' );
                $( '#payment_' + delivery_id + '_' + payment_id ).trigger( 'click' );
            } else {
                $( '#cart_informer a span' ).html( data.cart_informer );
                $(".fn_ajax_content").html( data.content );
            }
        }
    } );
}

/* Изменение способа доставки */
function change_payment_method($id) {
    $( "#fn_delivery_payment_" + $id + " [name='payment_method_id']" ).first().trigger('click');
    $( ".fn_delivery_payment" ).hide();
    $( "#fn_delivery_payment_" + $id ).show();
    $( 'input[name="delivery_id"]' ).parent().removeClass( 'active' );
    $( '#deliveries_' + $id ).parent().addClass( 'active' );
}

/* Аяксовое удаление товаров в корзине */
function ajax_remove(variant_id) {
    var coupon_code = $('input[name="coupon_code"]').val(),
        delivery_id = $('input[name="delivery_id"]:checked').val(),
        payment_id = $('input[name="payment_method_id"]:checked').val();
    /* ajax запрос */
    $.ajax( {
        url: 'ajax/cart_ajax.php',
        data: {
            coupon_code: coupon_code,
            action: 'remove_citem',
            variant_id: variant_id
        },
        dataType: 'json',
        success: function(data) {
            if( data.result == 1 ) {
                ajax_set_result( data );
                $( '#deliveries_' + delivery_id ).trigger( 'click' );
                $( '#payment_' + delivery_id + '_' + payment_id ).trigger( 'click' );
            } else {
                console.log(location);
                $( '#cart_informer a span' ).html( data.cart_informer );
                if(location.pathname == '/cart') { $(".fn_ajax_content").html( data.content ); }
                $( '#fn_cart').html(data.cart_popap);
            }
        }
    } );
}

function ajax_sms() {
    /* ajax запрос */
    $.ajax( {
        url: 'ajax/send_sms.php',
        data: {
            phone: '380968171330',
        },
        dataType: 'json',
        success: function(data) {
            console.log(data);
        },
        error: function (e) {
            console.log('error' + e);
        }
    } );
}

/* Формирование ровных строчек для характеристик */
function resize_comparison() {
    var minHeightHead = 0;
    $('.fn_resize' ).each(function(){
        if( $(this ).height() > minHeightHead ) {
            minHeightHead = $(this ).height();
        }
    });
    $('.fn_resize' ).height(minHeightHead);
    if ($('[data-use]').size()) {
        $('[data-use]').each(function () {
            var use = '.' + $(this).data('use');
            var minHeight = $(this).height();
            if ($(use).size()) {
                $(use).each(function () {
                    if ($(this).height() >= minHeight) {
                        minHeight = $(this).height();
                    }
                });
                $(use).height(minHeight);
            }
        });
    }
}

/* В сравнении выравниваем строки */
$( window ).load( resize_comparison );

/* Звёздный рейтинг товаров */
$.fn.rater = function (options) {
    var opts = $.extend({}, $.fn.rater.defaults, options);
    return this.each(function () {
        var $this = $(this);
        var $on = $this.find('.rating_starOn');
        var $off = $this.find('.rating_starOff');
        opts.size = $on.height();
        if (opts.rating == undefined) opts.rating = $on.width() / opts.size;

        $off.mousemove(function (e) {
            var left = e.clientX - $off.offset().left;
            var width = $off.width() - ($off.width() - left);
            width = Math.ceil(width / (opts.size / opts.step)) * opts.size / opts.step;
            $on.width(width);
        }).hover(function (e) { $on.addClass('rating_starHover'); }, function (e) {
            $on.removeClass('rating_starHover'); $on.width(opts.rating * opts.size);
        }).click(function (e) {
            var r = Math.round($on.width() / $off.width() * (opts.units * opts.step)) / opts.step;
            $off.unbind('click').unbind('mousemove').unbind('mouseenter').unbind('mouseleave');
            $off.css('cursor', 'default'); $on.css('cursor', 'default');
            opts.id = $this.attr('id');
            $.fn.rater.rate($this, opts, r);
        }).css('cursor', 'pointer'); $on.css('cursor', 'pointer');
    });
};

$.fn.rater.defaults = {
    postHref: location.href,
    units: 5,
    step: 1
};

$.fn.rater.rate = function ($this, opts, rating) {
    var $on = $this.find('.rating_starOn');
    var $off = $this.find('.rating_starOff');
    $off.fadeTo(600, 0.4, function () {
        $.ajax({
            url: opts.postHref,
            type: "POST",
            data: 'id=' + opts.id + '&rating=' + rating,
            complete: function (req) {
                if (req.status == 200) { /* success */
                    opts.rating = parseFloat(req.responseText);

                    if (opts.rating > 0) {
                        opts.rating = parseFloat(req.responseText);
                        $off.fadeTo(200, 0.1, function () {
                            $on.removeClass('rating_starHover').width(opts.rating * opts.size);
                            var $count = $this.find('.rating_count');
                            $count.text(parseInt($count.text()) + 1);
                            $this.find('.rating_value').text(opts.rating.toFixed(1));
                            $off.fadeTo(200, 1);
                        });
                    }
                    else
                    if (opts.rating == -1) {
                        $off.fadeTo(200, 0.6, function () {
                            $this.find('.rating_text').text('Ошибка');
                        });
                    }
                    else {
                        $off.fadeTo(200, 0.6, function () {
                            $this.find('.rating_text').text('Вы уже голосовали!');
                        });
                    }
                } else { /* failure */
                    alert(req.responseText);
                    $on.removeClass('rating_starHover').width(opts.rating * opts.size);
                    $this.rater(opts);
                    $off.fadeTo(2200, 1);
                }
            }
        });
    });
};

/** init banners **/
$('.fn_banner_group_m').slick({ // banner category mobil
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    swipeToSlide : true,
    dots: false,
    arrows: true,
    adaptiveHeight: true,
    autoplaySpeed: 8000,
    autoplay: true
});

$('.fn_banner_full_page_banner').slick({ //full page banner
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    swipeToSlide : true,
    dots: true,
    arrows: false,
    adaptiveHeight: true,
    autoplaySpeed: 8000,
    autoplay: true
});
/** end init banners **/

$(document).on('click', 'a.viber', function(){
//fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Viber click' });
//fbq('track', 'Subscribe',{ value: '0.00', currency: 'USD', predicted_ltv: '0.00'});
    gtag('event', 'WriteInViber', {  'event_category': 'click',});

});
$(document).on('click', 'a.fb', function(){
    // fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'FB click'});
    // fbq('track', 'Subscribe',{ value: '0.00', currency: 'USD', predicted_ltv: '0.00'});
    gtag('event', 'WriteInFb', {  'event_category': 'click',});
});
$(document).on('click', 'a.telegram', function(){
    // fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Telegram click'});
    // fbq('track', 'Subscribe', { value: '0.00', currency:'USD', predicted_ltv:'0.00'});
    gtag('event', 'WriteInTelegram', {  'event_category': 'click',});
});
$(document).on('click', 'a.phone', function(){
    // fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Phone click', });
    //fbq('track', 'Contact', {  content_name: 'my-Name',  content_category: 'Valuation Form submitted', });
    gtag('event', 'WriteInPhone', {  'event_category': 'click',});
});
$(document).on('click', 'a.messanger', function(){
    // fbq('track', 'Subscribe', { value: '0.00', currency:'USD', predicted_ltv:'0.00'});
    // fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Messanger click', });
    gtag('event', 'WriteInMessanger', {  'event_category': 'click',});
});
$(document).on('click', 'a.ins', function(){
    // fbq('track', 'Subscribe', { value: '0.00', currency:'USD', predicted_ltv:'0.00'});
    //fbq('track', 'Lead', {  content_name: 'my-Name',  content_category: 'Instagram click', });
    gtag('event', 'WriteInInstagram', {  'event_category': 'click',});
});

$(document).on('click', '.foot_social a.fb, .foot_social a.ins, .foot_social a.tl, .foot_social a.vb, .foot_social a.fbm, .b24-widget-button-social-item.ui-icon-service-telegram, .b24-widget-button-social-item.ui-icon-service-viber', function(){
    fbq('trackCustom', 'Footermessenger');
});

$(document).on('click', 'div.foot_social a.phone', function(){
    fbq('trackCustom', 'FooterCall');
});

$(document).on('click', '.b24-widget-button-social-item.b24-widget-button-openline_livechat', function(){
    fbq('trackCustom', 'CrmChat');
});

$(document).on('click', '.block.padding a.binct-phone-number-1', function (){
    fbq('track', 'Contact');
});