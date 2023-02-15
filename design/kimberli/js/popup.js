/* Document ready */
$(function(){

    /* показать попапы через 10 сек после загрузки страницы*/

    setTimeout(function() {

       // let pathname = $(location).attr('pathname');

            $.ajax( {
                url: "rest/check_session",
                method: 'GET',
                success: function(result, status) {
                    console.log(status, result);
                    if (status == 'success'  &&  result.data.popup.length !== 0) {

                        let popup = '';

                        result.data.popup.forEach((element) => {
                            popup = element;
                        });

                        showPopup(popup);

                       // setTimeout(function() {
                        //    showPopup40('coupon');
                      //  }, 9000000);

                        writeSession(popup);
                    }/* else if (pathname == '/cart') {
                        showPopup('coupon');
                    }*/
                },
                error: function(e) {
                    console.log(e);
                    return false;
                }
            });
        }, 10000);
});

$(document).on('submit', '#popup_sale_form', function(e) {
    e.preventDefault();
    let phone;

    /* Вариант */
    if ($(this).find('input[name=phone]').size() > 0) {
        phone = $(this).find('input[name=phone]').val();
    }

    if (phone) {
        $.ajax({
            url: "rest/popup/send-email",
            method: 'POST',
            data: {phone: phone},
            dataType: 'json',
            success: function (data, status) {
                if (status === 'success') {

                    gtag('event', 'popup', {'event_category': 'send_form',});

                    $('#sale-popup .body').html(data.data.message);

                    setTimeout(function(){
                        $.fancybox.close({
                            src: '#sale-popup',
                            type: 'inline'
                        });
                    }, 3000);

                } else {

                    $.fancybox.close({
                        src: '#sale-popup',
                        type: 'inline'
                    });
                }
            },
            error: function (e) {
                console.log(e);

                $.fancybox.close({
                    src: '#sale-popup',
                    type: 'inline'
                });
            }
        });

    }

    return false;
});