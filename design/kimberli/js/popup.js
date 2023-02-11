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