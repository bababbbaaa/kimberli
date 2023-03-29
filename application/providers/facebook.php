<?php
namespace rest\providers;

use rest\api\Bug;
use rest\api\Okay;
use FacebookAds\Api;
use FacebookAds\Object\ServerSide\CustomData;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use FacebookAds\Http\Exception\RequestException;

use rest\api\Order;
use rest\api\Users;

use RuntimeException;

class facebook extends Okay
{
	private $pixel_id = 757934748071157;
	private $access_token = '';//'EAAETgJrZAs4kBAIMZBTIXBPhqqmz0Vk3PRntmYBPoeR5d9NM3ZATp6VlX4bTHIO2qmygug9ABzzPZAUSuKJWJtn6IBNB4kXQUt8Hw6ArUM7uWx5UD7xKfA7N5xftlgvKYNlBmsxMOrfhp1o7YKEGMZCjoBo97fbdRqjG2xpBz7Wu4BMbngbz0';

	/**
	 * facebook constructor.
	 */
	public function __construct()
	{
		parent::__construct();

        $this->access_token = $this->settings->facebook_token;
	}

	/**
	 * @param array $data
	 */
	public static final function send(array $data = [])
	{
		$send  = new self();

		try {
			return ['traceId' => $send->getEventParameters($data)];
		} catch (\Throwable $e) {
			Bug::addException($e);
		}

		return ['traceId' =>''];
	}

	/**
	 * @param array $data
	 * @return array|string|null
	 */
	public function getEventParameters(array $data)
	{
		if (empty($data)) {
			RuntimeException('Facebook Event Parameters can not be empty');
		}

		$route = $data['event'] ??  null;

		$facebook_pixel_event_params = null;

		$event_name = 'ViewContent';
		$event_id = $this->generateEventId();

		switch ($route) {
			case 'Purchase':
			case 'quickOrder':
			case 'Fitting':
				$event_name = $route;

				$contents = [];
				$content_ids = [];
				$value = 0;
				$num_items = 0;

				$currency = $data['currency'] ?? 'UAH';

					$order = new Order();

					$order_info = $order->get($data['orderId']);

					if ($order_info) {
						$order_products = $order->getOrderProducts($order_info->id);

						foreach ($order_products as $product) {
							$content_ids[] = (string) $product->product_id;
							$num_items += $product->amount;
							$contents[] = [
								'id'       => $product->product_id,
								'quantity' => $product->amount,
							];
						}

						$value = $order_info->total_price;
					}

				$facebook_pixel_event_params = [
					'event_name'    => $event_name,
					'content_ids'   => $content_ids,
					'content_type'  => 'product',
					'contents'      => $contents,
					'content_name'  => 'new_order',
					'currency'      => $currency,
					'num_items'     => $num_items,
					'value'         => $value,
					'event_id'      => $event_id,
					'url' 			=> $data['url'] ?? '',
				];

				break;
			case 'AddToCart':

				$event_name = 'AddToCart';
				$currency = $data['currency'] ?? 'UAH';
				$contents = [];
				$content_ids = [];

				foreach ($data['cart']->purchases  as $purchase) {
					$content_ids[] = (string) $purchase->variant->sku;
					$contents[] = [
						'id'       => $purchase->variant->sku,
						'quantity' => $purchase->amount
					];
				}

				$facebook_pixel_event_params = array(
					'event_name'    => $event_name,
					'content_ids'   => $content_ids,
					'content_name'  => 'view_cart',
					'content_type'  => 'product',
					'contents'      => $contents,
					'currency'      => $currency,
					'value'         => $data['cart']->total_price,
					'num_items'     => $data['cart']->total_products,
					'event_id'      => $event_id,
					'url'			=> $data['url'] ?? '',
				);

				break;
			case 'ViewProduct':

				$event_name = 'ViewContent';
				$product = $data['product'];
				$category = $data['category'];

					$facebook_pixel_event_params = array(
						'event_name'       => $event_name,
						'content_ids'      => array((string)$product->variant->sku),
						'content_name'     => 'view_product',
						'content_type'     => 'product',
						'currency'         => $data['currency'] ?? 'UAH',
						'value'            => $product->variant->price,
						'event_id'         => $event_id,
						'product'		   => $product->name,
						'product_group'    => $category->name,
						'url'			=> $data['url'] ?? '',
					);

				break;
			case 'InitiateCheckout':

				$event_name = 'InitiateCheckout';
				$contents = [];
				$content_ids = [];

				foreach ($data['cart']->purchases  as $purchase) {
					$content_ids[] = (string) $purchase->variant->sku;
					$contents[] = [
						'id'       => $purchase->variant->sku,
						'quantity' => $purchase->amount
					];
				}

				$facebook_pixel_event_params = [
					'event_name'    => $event_name,
					'content_name'  => 'InitiateCheckout',
					'content_ids'   => $content_ids,
					'content_type'  => 'product',
					'contents'      => $contents,
					'currency'      => $data['currency'] ?? 'UAH',
					'num_items'     => $data['cart']->total_products,
					'value'         => $data['cart']->total_price,
					'event_id'      => $event_id,
					'url'			=> $data['url'] ?? '',
				];

			break;
			case 'AddToWishlist':
			$event_name = 'AddToWishlist';


				$contents[] = $data['contents'];
				$content_ids = $data['contents']['id'];
				$value = $data['contents']['quantity'];

				$facebook_pixel_event_params = array(
					'event_name'    => $event_name,
					'content_name'  => 'AddToWishlist',
					'content_ids'   => $content_ids,
					'content_type'  => 'product',
					'contents'      => $contents,
					'currency'      => $data['currency'] ?? 'UAH',
					'value'         => $value,
					'num_items'     => 1,
					'event_id'      => $event_id,
					'url'			=> $data['url'] ?? '',
				);

			break;

			case 'contact':
				$event_name = 'Contact';

				$facebook_pixel_event_params = [
					'event_name' => $event_name,
					'event_id'   => $event_id,
					'url' 			=> 'contacts',
				];

				break;

			case 'pageView':
				$event_name = 'PageView';

				$facebook_pixel_event_params = [
					'event_name' => $event_name,
					'event_id'   => $event_id,
					'url' 			=> 'catalog/kabluchki',
				];

				break;
		}


		return $this->trackPixel($facebook_pixel_event_params, $event_name, $event_id);

		if ($facebook_pixel_event_params) {
			return addslashes(json_encode($facebook_pixel_event_params));
		} else {
			return $facebook_pixel_event_params;
		}
	}

	/**
	 * @return array
	 */
	protected function getPii(): array
	{
		$facebook_pixel_pii = [];

		$users = new Users();

			if ($users->isLogged() && $user = $users->get($_SESSION['user_id'])) {

				$customer_id = $user->id;
				$email = $user->email;
				$firstname = $user->name;
				$telephone = $user->phone;
				$ip = $user->lastIp;
			}  else {
				$customer_id = '';
				$email = '';
				$firstname = '';
				$telephone = '';
				$ip = '';
			}

			if ($email) {
				$facebook_pixel_pii['em'] = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');;
			}

			if ($firstname) {
				$facebook_pixel_pii['fn'] = htmlspecialchars($firstname, ENT_QUOTES, 'UTF-8');
			}

			if ($telephone) {
				$facebook_pixel_pii['ph'] = htmlspecialchars($telephone, ENT_QUOTES, 'UTF-8');
			}

			if ($customer_id) {
				$facebook_pixel_pii['external_id'] = (string) $customer_id;
			}

			if ($ip) {
				$facebook_pixel_pii['user_ip'] = $ip;
			}

		return $facebook_pixel_pii;
	}

	/**
	 * @param $server_event_params
	 * @param $event_name
	 * @param $event_id
	 */
	public function trackPixel($server_event_params, $event_name, $event_id)
	{

		if ($event_name == 'Purchase' && empty($server_event_params['content_ids'])) {
			return;
		}

		$user_pii_data = $this->getPii();

		try {
			$user_data = (new UserData())
				->setClientIpAddress($_SERVER['REMOTE_ADDR'])
				->setClientUserAgent($_SERVER['HTTP_USER_AGENT']);
				//->setFbp('757934748071157')
				//->setFbc('PageView');


			if ($user_pii_data) {
				if (!empty($user_pii_data['em'])) {
					$user_data->setEmail($user_pii_data['em']);
				}

				if (!empty($user_pii_data['fn'])) {
					$user_data->setFirstName($user_pii_data['fn']);
				}

				if (!empty($user_pii_data['ln'])) {
					$user_data->setLastName($user_pii_data['ln']);
				}

				if (!empty($user_pii_data['ph'])) {
					$user_data->setPhone($user_pii_data['ph']);
				}

				if (!empty($user_pii_data['external_id'])) {
					$user_data->setExternalId($user_pii_data['external_id']);
				}
			}

			$event = (new Event())
				->setEventName($event_name)
				->setEventTime(time())
				->setEventId($event_id)
				->setEventSourceUrl('https://kimberli.ua/' . $server_event_params['url'] ?? '')
				->setUserData($user_data)
				->setCustomData(new CustomData());

			$custom_data = $event->getCustomData();

			if (!empty($server_event_params['currency'])) {
				$custom_data->setCurrency($server_event_params['currency']);
			}

			if (!empty($server_event_params['value'])) {
				$custom_data->setValue($server_event_params['value']);
			}

			if (!empty($server_event_params['content_ids'])) {
				$custom_data->setContentIds($server_event_params['content_ids']);
			}

			if (!empty($server_event_params['content_type'])) {
				$custom_data->setContentType($server_event_params['content_type']);
			}

		} catch (\Exception $ex) {
			throw new RuntimeException($ex);
		}

		$api = Api::init(null, null, $this->access_token, false);

		$async_request = (new EventRequest($this->pixel_id))
			->setEvents(array($event));

		try {
			return $async_request->execute()->getFbTraceId();
		} catch (\Throwable $e) {
			throw new RuntimeException($e->getMessage());
		}
	}

	/**
	 * Creates a new guid v4 - via https://stackoverflow.com/a/15875555
	 * @return string A 36 character string containing dashes.
	 */
	public function generateEventId() {
		$data = openssl_random_pseudo_bytes(16);

		$data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
		$data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

		return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
	}

	/**
	 * @param $string
	 * @return string
	 */
	public function formatString($string) {
		return trim(strip_tags(html_entity_decode(html_entity_decode($string), ENT_QUOTES | ENT_COMPAT, 'UTF-8')));
	}

}