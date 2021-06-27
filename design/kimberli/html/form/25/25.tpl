<div class="row box_bottom_25">
    <div class="col-sm-12 col-md-4" style="text-align: center">
        <button type="button" onClick="loadCupon(this);" style="background: #0a5345;color: white;font-size: larger;height: 60px;"  class="btn btn_big ">%</button>
    </div>
    <div class="col-sm-12 col-md-4" style="text-align: center">
        <button type="button" onClick="loadCupon(this);" style="background: #0a5345;color: white;font-size: larger;height: 60px;"  class="btn btn_big ">%</button>
    </div>
    <div class="col-sm-12 col-md-4" style="text-align: center">
        <button type="button" onClick="loadCupon(this);" style="background: #0a5345;color: white;font-size: larger;height: 60px;"  class="btn btn_big " >%</button>
    </div>
</div>
<div class="row box_result_25 d-none"></div>
<div class="wrap_post_description"></div>
{literal}
    <script>
        function loadCupon(e)
        {        
            /* ajax запрос */
  $.ajax( {
        url: "ajax/25.php",
        method: 'POST',
        data: {
            url: window.location.href
        },
        dataType: 'json',
        success: function(data) {
            $(e).text(data.proc);
            $('.box_bottom_25 button').prop('disabled', true);
            console.log(data);
       // $('.box_bottom_25').hide();
         $('.box_result_25').html(data.message).show();
        }
    } );
            return false;
        }
</script>
{/literal}