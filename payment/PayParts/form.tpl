    {$_SESSION['error_payment']}
<form action="/payment/PayParts/index.php" method="POST"   name="myForm" >
            <input type="hidden" value="{$merchantType}" name="merchantType">
            <input type="hidden" value="{$order->payment_method_id}" name="payment_method_id">
            <input type="hidden" value="{$order->id}" name="orderId">
  {foreach $purchases as $product}
    <input type="hidden" value="{$product->product->name}" name="products[{$product->product->id}][name]">
    <input type="hidden" value="{$product->amount}" name="products[{$product->product->id}][count]">
    <input type="hidden" value="{$product->variant->price}" name="products[{$product->product->id}][price]">
 {/foreach}
 <div class="row">
<div class="col-sm-12 form-group">
    <div class="input-group">
        <span class="input-group-addon">Термін кредиту (мic.)<em>*</em>:</span>
        <select id="monch" class="form-control" oninput="pay()" >
        <option  value="2"  selected>2</option>
        {for $foo=3 to $PartsCount}
    <li>{$foo}</li>
    <option value="{$foo}">{$foo}</option>
{/for}
      </select>
    </div>
</div>
      <div class="col-sm-12 form-group"><label class="payCount">Количество платежей: <b><output  class="form-control1" id="payCountLabel"></output><input type="hidden" value="" id="payCount" name="partsCount"></b></label></div>
<div class="col-sm-12 form-group"><label class="ppValuep">Первоначальный взнос: <b><output name="{$type}Valuep" class="form-control1" id="{$type}Valuep"></output></b></label></div>
<div class="col-sm-12 form-group"><label class="ppValue">Ежемесячный платеж: <b><output name="{$type}Value" class="form-control1" id="{$type}Value"></output></b></label></div>
<div class="col-sm-12 form-group"><label class="orderAmount">Стоимость заказа: <b><output  class="form-control1" id="orderAmount">{$order->total_price}</output> {$currency->sign}</b></label><input type="hidden" value="{(string)$order->total_price}" name="amount"></div>
<div class="col-sm-12 text-center"><input name="send_pay" class="btn btn_big btn_black" type="submit" value="{$lang->form_to_pay}"/></div>   
     </div>
    </form>

<script type="text/javascript" src="https://ppcalc.privatbank.ua/pp_calculator/resources/js/calculator.js"></script>
<script>
function pay() {
  var resCalc = PP_CALCULATOR.calculatePhys(parseInt($("#monch").val()), parseInt($("#orderAmount").val()));
  $("#payCountLabel").html(resCalc.payCount+" пл.");
  $("#payCount").val(resCalc.payCount);
  
  $("#{$type}Valuep").html(resCalc.{$type}Value+" {$currency->sign}");
  $("#{$type}Value").html(resCalc.{$type}Value+" {$currency->sign}");
     console.log(resCalc);
}
$( document ).ready(function() {
    pay();
});
</script>
