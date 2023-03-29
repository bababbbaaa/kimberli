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

$(document).on('submit', '.popup', function(e) {
    e.preventDefault();
    let phone  = $(this).find('input[name=phone]').val();

    let body = $(this).parents().find('.body');
    let id = $(this).parents().find('.root').prop("id");
    let subject = $(this).find('input[name=subject]').val();

    if (phone) {
        $.ajax({
            url: "rest/popup/send-email",
            method: 'POST',
            data: {phone: phone, subject: subject},
            dataType: 'json',
            success: function (data, status) {
                if (status === 'success') {

                    if (data.data.message.length > 0) {
                        body.html(data.data.message);
                        setTimeout(function() {
                            $.fancybox.close({
                                src: '#' + id,
                                type: 'inline'
                            });
                        }, 3000);

                    } else {
                        $.fancybox.close({
                            src: '#' + id,
                            type: 'inline'
                        });
                    }

                } else {
                    $.fancybox.close({
                        src: '#' + id,
                        type: 'inline'
                    });
                }
            },
            error: function (e) {
                console.log(e);

                $.fancybox.close({
                    src: '#' + id,
                    type: 'inline'
                });
            }
        });

    }

    return false;
});