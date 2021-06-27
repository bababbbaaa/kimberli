{if $kupon && $procent}
    <div class="col-sm-12" style="text-align: center;margin-top: 30px;">
    <p>{$lang->new_year_hed} {$procent} %</p>
    <p>{$lang->new_year_hed_mess}.*</p>
    <br>
    <p style=" display: inline-block;   border-radius: 0px;border: 2px solid rgb(0, 0, 0);padding: 15px;" class="copy-to">{$kupon}</p>
    <br>
    <p style="text-align: left">
        <span style="font-size: x-small;">* - {$lang->new_year_message}.</span>
    </p>
    </div>
{literal}  
    <script>
       (function($) {     
    $( ".copy-to" ).on( "click", function() {
        console.log('fgsdf');
    $(".copy-to" ).css({'color':'red'});
     var  element = $(this).html();
     var $temp = $("<input>");
     $("body").append($temp);
     $temp.val(element).select();
     document.execCommand("copy");
     $temp.remove();  
}); 
  })(jQuery);
</script>
{/literal}
{/if}