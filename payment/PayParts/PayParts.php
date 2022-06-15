<?php

require_once('api/Okay.php');

class PayParts extends Okay {
    
    private $prefix = 'ORDER';
    private $orderID;              //Уникальный номер платежа
    private $storeId;              //Идентификатор магазина
    private $password;             //Пароль вашего магазина
    private $PartsCount;           //Количество частей на которые делится сумма транзакции ( >1)
    private $MerchantType;         //Тип кредита
    private $responseUrl;          //URL, на который Банк отправит результат сделки
    private $redirectUrl;          //URL, на который Банк сделает редирект клиента
    private $amount;               //Окончательная сумма покупки, без плавающей точки
    private $ProductsList;
    private $recipientId;
    private $currency = 980;
    private $productsString;
    private $payURL = 'https://payparts2.privatbank.ua/ipp/v2/payment/create';
    private $holdURL = 'https://payparts2.privatbank.ua/ipp/v2/payment/hold';
    private $stateURL = 'https://payparts2.privatbank.ua/ipp/v2/payment/state';
    private $confirmHoldURL = 'https://payparts2.privatbank.ua/ipp/v2/payment/confirm';
    private $cancelHoldUrl = 'https://payparts2.privatbank.ua/ipp/v2/payment/cancel';

    private $LOG = array();

    private $keysProducts = ['name', 'count', 'price'];

    private $options = ['PartsCount', 'MerchantType', 'ProductsList'];

    /**
     * PayParts constructor.
     * создаём идентификаторы магазина
     *
     * @param string $StoreId - Идентификатор магазина
     * @param string $Password - Пароль вашего магазина
     * @throws \InvalidArgumentException
     */
   // public function __construct($StoreId, $Password)
   // {
       // $this->setStoreId($StoreId);
       // $this->setPassword($Password);
   // }
    public function checkout_form($order_id)
	{
		
		$order = $this->orders->get_order((int)$order_id);
		$liqpay_order_id = $order->id."-".rand(100000, 999999);
		$payment_method = $this->payment->get_payment_method($order->payment_method_id);
		$payment_currency = $this->money->get_currency(intval($payment_method->currency_id));
		$settings = $this->payment->get_payment_settings($payment_method->id);
		
		$price = round($this->money->convert($order->total_price, $payment_method->currency_id, false), 2);	

		// описание заказа
		// order description
		$desc = 'Оплата заказа №'.$order->id;

		$result_url = $this->config->root_url.'/order/'.$order->url;
		$server_url = $this->config->root_url.'/payment/Liqpay/callback.php';		
		
		$this->setStoreId($settings['store_id']);
                $this->setPassword($settings['password']);
                $this->setPartsCount($settings['parts_count']);
                
		$private_key = $settings['liqpay_private_key'];
		$public_key = $settings['liqpay_public_key'];
                
		$sign = base64_encode(sha1($private_key.$price.$payment_currency->code.$public_key.$liqpay_order_id.'buy'.$desc.$result_url.$server_url, 1));
                
                $type = [
                    'PP' => 'pp',
                    'II' => 'ip'
                ];
                $res = [
                    'merchantType' => $settings['merchantType'],
                    'PartsCount' => $settings['parts_count'],
                    'type' =>$type[$settings['merchantType']]
                        
                ];
        $res['public_key'] = $public_key;
        $res['price'] = $price;
        $res['payment_currency'] = $payment_currency;
        $res['desc'] = $desc;
        $res['liqpay_order_id'] = $liqpay_order_id;
        $res['result_url'] = $result_url;
        $res['server_url'] = $server_url;
        $res['sign'] = $sign;
        

		return $res;
	}
    /**
     * PayParts SetOptions.
     * @param array $options
     *
     * ResponseUrl - URL, на который Банк отправит результат сделки (НЕ ОБЯЗАТЕЛЬНО)<br>
     * RedirectUrl - URL, на который Банк сделает редирект клиента (НЕ ОБЯЗАТЕЛЬНО)<br>
     * PartsCount - Количество частей на которые делится сумма транзакции ( >1)<br>
     * Prefix - параметр не обязательный если Prefix указан с пустотой или не указа вовсе префикс будет ORDER<br>
     * OrderID' - если OrderID задан с пустотой или не укан вовсе OrderID сгенерится автоматически<br>
     * MerchantType - II - Мгновенная рассрочка; PP - Оплата частями<br>
     * Currency' - можна указать другую валюту 980 – Украинская гривна; 840 – Доллар США; 643 – Российский рубль. Значения в соответствии с ISO<br>
     * ProductsList - Список продуктов, каждый продукт содержит поля: name - Наименование товара price - Цена за еденицу товара (Пример: 100.00) count - Количество товаров данного вида<br>
     * recipientId - Идентификатор получателя, по умолчанию берется основной получатель. Установка основного получателя происходит в профиле магазина.
     * @throws InvalidArgumentException - Ошибка установки аргумента
     */
    public function setOptions(array $options)
    {
        if (empty($options) || !is_array($options)) {
            throw new InvalidArgumentException('Параметры должны быть установлены как массив');
        } else {
//$p = new PayParts();
            foreach ($options as $PPOptions => $value) {
               // echo $PPOptions.'<br>';
                if (method_exists('PayParts', "set$PPOptions")) {
                    call_user_func_array(array($this, "set$PPOptions"), array($value));
               }//else {
                 //  throw new InvalidArgumentException($PPOptions . ' не может быть установлен этим сеттером');
              // }
            }
        }

        $flag = 0;

        foreach ($this->options as $variable) {
            if (isset($this->{$variable})) {
                ++$flag;
            } else {
                throw new InvalidArgumentException($variable . ' is necessary');
            }
        }

        if ($flag === count($this->options)) {
            $this->options['SUCCESS'] = true;
        } else {
            $this->options['SUCCESS'] = false;
        }
    }

    public function pp($PartsCount = 4, $order = false, $products){
        $this->setPartsCount($PartsCount);
        $form = '<form action="" method="POST" xmlns="http://www.w3.org/1999/html"  name="myForm" >
            <input type="hidden" value="PP" name="merchantType">
            <input type="hidden" value="'.$order->payment_method_id.'" name="payment_method_id">
            <input type="hidden" value="'.$order->id.'" name="orderId">';
        foreach ($products as $product){
            $form.='<input type="hidden" value="'.$product->product->name.'" name="products['.$product->product->id.'][name]">'
                    . '<input type="hidden" value="'.$product->amount.'" name="products['.$product->product->id.'][count]">'
                    . '<input type="hidden" value="'.$product->product->price.'" name="products['.$product->product->id.'][price]">';
        }
        $form.='<div class="row">
<div class="col-sm-12 form-group">
    <div class="input-group">
        <span class="input-group-addon">Срок кредита (меc.)<em>*</em>:</span>
        <select id="monch" class="form-control" oninput="pay()" >
        <option  value="" disabled selected>Выбрать</option>';
        for($i=2;$i<=$this->PartsCount;$i++){$form.='<option value="'.$i.'">'.$i.'</option>';}
        $form.='</select>
    </div>
</div>
<div class="col-sm-12 form-group"><label class="payCount">Количество платежей: <b><output  class="form-control1" id="payCountLabel"></output><input type="hidden" value="" id="payCount" name="partsCount"></b></label></div>
<div class="col-sm-12 form-group"><label class="ppValuep">Первоначальный взнос: <b><output name="ppValuep" class="form-control1" id="ppValuep"></output></b></label></div>
<div class="col-sm-12 form-group"><label class="ppValue">Ежемесячный платеж: <b><output name="ppValue" class="form-control1" id="ppValue"></output></b></label></div>
<div class="col-sm-12 form-group"><label class="orderAmount">Стоимость заказа: <b><output  class="form-control1" id="orderAmount">'.$order->total_price.'</output> грн.</b></label><input type="hidden" value="'.(string)$order->total_price.'" name="amount"></div>
<div class="col-sm-12 text-center"><input name="send_pay" class="btn" type="submit" value="Оплатить"/></div>   
     </div>
</form>
<script type="text/javascript" src="https://ppcalc.privatbank.ua/pp_calculator/resources/js/calculator.js"></script>
<script>
function pay() {
  var resCalc = PP_CALCULATOR.calculatePhys(parseInt($("#monch").val()), parseInt($("#orderAmount").val()));
  $("#payCountLabel").html(resCalc.payCount+" пл.");
  $("#payCount").val(resCalc.payCount);
  
  $("#ppValuep").html(resCalc.ppValue+" грн.");
  $("#ppValue").html(resCalc.ppValue+" грн.");
     console.log(resCalc);
}
</script>
';
        return $form;
    }
    public function ip($PartsCount = 4, $order = false, $products){
        $this->setPartsCount($PartsCount);
        $form = '<form action="" method="POST" xmlns="http://www.w3.org/1999/html"  name="myForm" >
            <input type="hidden" value="II" name="merchantType">
            <input type="hidden" value="'.$order->payment_method_id.'" name="payment_method_id">
            <input type="hidden" value="'.$order->id.'" name="orderId">';
        foreach ($products as $product){
            $form.='<input type="hidden" value="'.$product->product->name.'" name="products['.$product->product->id.'][name]">'
                    . '<input type="hidden" value="'.$product->amount.'" name="products['.$product->product->id.'][count]">'
                    . '<input type="hidden" value="'.$product->product->price.'" name="products['.$product->product->id.'][price]">';
        }
        $form.='<div class="row">
<div class="col-sm-12 form-group">
    <div class="input-group">
        <span class="input-group-addon">Срок кредита (меc.)<em>*</em>:</span>
        <select id="monch" class="form-control" oninput="pay()" >
        <option  value="" disabled selected>Выбрать</option>';
        for($i=2;$i<=$this->PartsCount;$i++){$form.='<option value="'.$i.'">'.$i.'</option>';}
        $form.='</select>
    </div>
</div>
<div class="col-sm-12 form-group"><label class="payCount">Количество платежей: <b><output  class="form-control1" id="payCountLabel"></output>
<input type="hidden" value="" id="payCount" name="partsCount"></b></label></div>
<div class="col-sm-12 form-group"><label for="ipValuep">Первоначальный взнос: <b><output  class="form-control1" id="ipValuep"></output></b></label></div>
<div class="col-sm-12 form-group"><label for="ipValue">Ежемесячный платеж: <b><output  class="form-control1" id="ipValue"></output></b></label></div>
<div class="col-sm-12 form-group"><label for="orderAmount">Стоимость заказа: <b><output  class="form-control1" id="orderAmount">'.$order->total_price.'</output> грн.</b></label>'
                . '<input type="hidden" value="'.(string)$order->total_price.'" name="amount"></div>
<div class="col-sm-12 text-center"><input name="send_pay" class="btn" type="submit" value="Оплатить"/></div>   
     </div>
</form>
<script type="text/javascript" src="https://ppcalc.privatbank.ua/pp_calculator/resources/js/calculator.js"></script>
<script>
function pay() {
  var resCalc = PP_CALCULATOR.calculatePhys(parseInt($("#monch").val()), parseInt($("#orderAmount").val()));
  $("#payCountLabel").html(resCalc.payCount+" пл.");
  $("#payCount").val(resCalc.payCount);
  
  $("#ipValuep").html(resCalc.ipValue+" грн.");
  $("#ipValue").html(resCalc.ipValue+" грн.");
     console.log(resCalc);
}
</script>
';
        return $form;
    }

	/**
	 * PayParts Create.
	 * Создание платежа
	 *
	 * @param string $method
	 * <a href="https://bw.gitbooks.io/api-oc/content/pay.html">'hold'</a> - Создание платежа без списания<br>
	 * <a href="https://bw.gitbooks.io/api-oc/content/hold.html">'pay'</a> - Создание платежа со списанием
	 * @return mixed|string
	 * @throws \InvalidArgumentException
	 * @throws Exception
	 */
    public function create($method = 'pay')
    {
        if ($this->options['SUCCESS']) {

            //проверка метода
            if ($method === 'hold') {
                $Url = $this->holdURL;
                $this->LOG['Type'] = 'Hold';
            } else {
                $Url = $this->payURL;
                $this->LOG['Type'] = 'Pay';
            }

            $SignatureForCall = [
                $this->password,
                $this->storeId,
                $this->orderID,
                (string)($this->amount *100),
                $this->currency,
                $this->PartsCount,
                $this->MerchantType,
                $this->responseUrl,
                $this->redirectUrl,
                $this->productsString,
                $this->password
            ];

            $param['storeId'] = $this->storeId;
            $param['orderId'] = $this->orderID;
            $param['amount'] = $this->amount;
            $param['partsCount'] = $this->PartsCount;
            $param['merchantType'] = $this->MerchantType;
            $param['products'] = $this->ProductsList;
            $param['responseUrl'] = $this->responseUrl;
            $param['redirectUrl'] = $this->redirectUrl;
            $param['signature'] = $this->calcSignature($SignatureForCall);

            if (!empty($this->currency)) {
                $param['currency'] = $this->currency;
            }

            if (!empty($this->recipientId)) {
                $param['recipient'] = array('recipientId' => $this->recipientId);
            }


            $this->LOG['CreateData'] = json_encode($param);

			try {
				$curl = $this->sendPost($param, $Url);
			} catch (\Exception $e) {
				throw $e;
			}

            $CreateResult = json_decode($curl, true);

			$this->LOG['CreateResult'] = json_encode($CreateResult);

				if ($CreateResult['state'] == 'SUCCESS') {

				$checkSignature = [
					$this->password,
					$CreateResult['state'],
					$CreateResult['storeId'],
					$CreateResult['orderId'],
					$CreateResult['token'],
					$this->password
				];

					if ($this->calcSignature($checkSignature) === $CreateResult['signature']) {
						return $CreateResult;
					} else {
					   throw new RuntimeException('Error signature');
					}

				} else {
					$message = 'Error state';
					if (isset($CreateResult['message'])) {
						$message = $CreateResult['message'];
					} else if (isset($CreateResult['errorMessage'])) {
						$message = $CreateResult['errorMessage'];
					}

					throw new RuntimeException($message);
				}

        } else {
            throw new InvalidArgumentException('No options');
        }

    }
    /**
     * PayParts getState.
     * <a href="https://bw.gitbooks.io/api-oc/content/state.html">Получение результата сделки</a>
     * @param string $orderId -Уникальный номер платежа
     * @param bool $showRefund true - получить детали возвратов по платежу,<br> false - получить статус платежа без дополнительных деталей о возвратах
     * @return mixed|string
     */
    public function getState($orderId, $showRefund = true)
    {
        $SignatureForCall = [$this->password, $this->storeId, $orderId, $this->password];

        $data = array(
            'storeId' => $this->storeId,
            'orderId' => $orderId,
            'showRefund' => var_export($showRefund, true), //($showRefund) ? 'true' : 'false'
            'signature' => $this->calcSignature($SignatureForCall)
        );

        $res = json_decode($this->sendPost($data, $this->stateURL), true);

        $ResSignature = [
            $this->password,
            $res['state'],
            $res['storeId'],
            $res['orderId'],
            $res['paymentState'],
            $res['message'],
            $this->password
        ];

        if ($this->calcSignature($ResSignature) === $res['signature']) {
            return $res;
        } else {
            return 'error';
        }
    }


    /**
     * PayParts checkCallBack.
     * Получение результата сделки (асинхронный коллбэк)
     *
     * @param string $string результат post запроса
     * @return mixed|string валидирует и отдаёт ответ
     */
    public function checkCallBack($string)
    {
        $sa = json_decode($string, true);

        $srt = [$this->password, $this->storeId, $sa['orderId'], $sa['paymentState'], $sa['message'], $this->password];

        if ($this->calcSignature($srt) === $sa['signature']) {
            return $sa;
        } else {
            return 'error';
        }

    }

    /**
     * PayParts ConfirmHold.
     * <a href="https://bw.gitbooks.io/api-oc/content/confirm.html">Подтверждение платежа</a>
     *
     * @param string $orderId Уникальный номер платежа
     * @return mixed|string
     */
    public function confirmHold($orderId)
    {
        $signatureForConfirmHold = [$this->password, $this->storeId, $orderId, $this->password];

        $data = array(
            'storeIdentifier' => $this->storeId,
            'orderId' => $orderId,
            'signature' => $this->calcSignature($signatureForConfirmHold)
        );

        return json_decode($this->sendPost($data, $this->confirmHoldURL), true);

        /* Проверка временно не доступна, в связи с отсутствием реализации на стороне API
        $ResSignature = array($this->Password, $res['storeIdentifier'], $res['orderId'], $this->Password);
        if ($this->CalcSignature($ResSignature) === $res['signature']) {
            return $res;
        } else {
            return 'error';
        }*/
    }

    /**
     * PayParts CancelHold.
     * <a href="https://bw.gitbooks.io/api-oc/content/cancel.html">Отмена платежа</a>
     *
     * @param string $orderId Уникальный номер платежа
     * @param string $recipientId Идентификатор получателя, по умолчанию берется основной получатель. Установка основного получателя происходит в профиле магазина.
     * @return mixed|string
     */
    public function cancelHold($orderId, $recipientId = '')
    {

        $signatureForCancelHold = [$this->password, $this->storeId, $orderId, $this->password];

        $data = array(
            'storeId' => $this->storeId,
            'orderId' => $orderId,
            'signature' => $this->calcSignature($signatureForCancelHold)
        );
        if (!empty($recipientId)) {
            $data['recipientId'] = $recipientId;
        }

        return json_decode($this->sendPost($data, $this->cancelHoldUrl), true);

        /* Проверка временно не доступна, в связи с отсутствием реализации на стороне API
        $ResSignature = array($this->Password, $res['storeIdentifier'], $res['orderId'], $this->Password);
        if ($this->CalcSignature($ResSignature) === $res['signature']) {
            return $res;
        } else {
            return 'error';
        }*/
    }

    /**
     * PayParts getLOG. частичный лог
     *
     * @return array
     */
    public function getLOG()
    {
        return $this->LOG;
    }

    /**
     * Вычисление сигнатуры
     *
     * @param array $array
     * @return string
     */
    private function calcSignature($array)
    {
        $signature = '';
        foreach ($array as $item) {
            $signature .= $item;
        }
        return base64_encode(sha1($signature, true));

    }

    /**
     * Send POST
     *
     * @param $param
     * @param $url
     * @return mixed
     */
    private function sendPost($param, $url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json; charset=utf-8'
        ]);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);

		$result = curl_exec($ch);
		$error = curl_error($ch);
		curl_close($ch);

		if ($error) {
			throw new RuntimeException('Curl Error');
		}

		return $result;
    }

    
    /**
     * Setter for StoreId
     *
     * @param $argument
     * @throws \InvalidArgumentException
     */
    private function setStoreId($argument)
    {
        if (empty($argument)) {
            throw new InvalidArgumentException('StoreId is empty');
        }
        $this->storeId = $argument;
    }

    /**
     * Setter for Password
     * @param $argument
     * @throws \InvalidArgumentException
     */
    private function setPassword($argument)
    {
        if (empty($argument)) {
            throw new InvalidArgumentException('Password is empty');
        }
        $this->password = $argument;
    }


    /**
     * Setter for ResponseUrl
     *
     * @param $argument
     */
    private function setResponseUrl($argument)
    {
        if (!empty($argument)) {
            $this->responseUrl = $argument;
        }
    }

    /**
     * Setter for RedirectUrl
     *
     * @param $argument
     */
    private function setRedirectUrl($argument)
    {
        if (!empty($argument)) {
            $this->redirectUrl = $argument;
        }
    }

    /**
     * Setter for PartsCount
     *
     * @param $argument
     */
    private function setPartsCount($argument)
    {
        if ($argument < 1) {
            throw new InvalidArgumentException('PartsCount cannot be <1');
        }
        $this->PartsCount = $argument;
    }

    /**
     * Setter for Prefix
     *
     * @param string $argument
     */
    private function setPrefix($argument = '')
    {
        if (!empty($argument)) {
            $this->prefix = $argument;
        }
    }

    /**
     * Setter for OrderID
     *
     * @param string $argument
     */
    private function setOrderID($argument = '')
    {
        if (empty($argument)) {
            $this->orderID = strtoupper(sha1(time() . mt_rand(1, 99999)));//$this->prefix . '-' . 
        } else {
            $this->orderID = strtoupper($argument);//$this->prefix . '-' . 
        }

        $this->LOG['OrderID'] = $this->orderID;
    }

    /**
     * Setter for RecipientId
     *
     * @param string $argument
     */
    private function setRecipientId($argument = '')
    {
        if (!empty($argument)) {
            $this->recipientId = $argument;
        }
    }

    /**
     * Setter for MerchantType
     *
     * @param $argument
     */
    private function setMerchantType($argument)
    {
        if (in_array($argument, array('II', 'PP', 'PB', 'IA'))) {
            $this->MerchantType = $argument;
        } else {
            throw new InvalidArgumentException('MerchantType must be in array(\'II\', \'PP\', \'PB\', \'IA\')');
        }
    }

    /**
     * Setter for Currency
     *
     * @param string $argument
     */
    private function setCurrency($argument = '')
    {
        if (!empty($argument)) {
            if (in_array($argument, array('980', '840', '643'))) {
                $this->currency = $argument;
            } else {
                throw new InvalidArgumentException('something is wrong with Currency');
            }
        }
    }

    /**
     * Setter for ProductList
     *
     * @param $argument
     */
    private function setProductsList($argument)
    {
        if (!empty($argument) and is_array($argument)) {
           //$pp = [];
            foreach ($argument as $arr) {
                foreach ($this->keysProducts as $item) {
                    if (!array_key_exists($item, $arr)) {
                        throw new InvalidArgumentException("$item key does not exist");
                    }
                    if (empty($arr[$item])) {
                        throw new InvalidArgumentException("$item value cannot be empty");
                    }
                }
                //$pp[] = $arr;
                $this->amount += $arr['count'] * $arr['price'];
                $this->productsString .= $arr['name'] . $arr['count'] . $arr['price'] * 100;
            }
            $this->ProductsList = $argument;
        } else {
            throw new InvalidArgumentException('something is wrong');
        }
    }
}

