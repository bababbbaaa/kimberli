<?php

namespace KB\rest_server;

use KB\network\http\request;
/**
 * Add controller for saas endpoints
 */
routing::add_controller('order', '/rest/order/');

#region order

/**
 * @see \rest\controller\order_controller::action_get()
 */
routing::add_route(request::GET, 'order', '<orderId>', 'get')
	->parameter('orderId', '^[1-9]{1}[0-9]*');

/**
 * @see \rest\controller\order_controller::action_create()
 */
routing::add_route(request::POST, 'order', 'create', 'create');

/**
 * @see \rest\controller\order_controller::action_quick()
 */
routing::add_route(request::POST, 'order', 'quick', 'quick');
#endregion

#region SMS
/**
 * @see \rest\controller\order_controller::action_sms_balance()
 */
routing::add_route(request::GET, 'order', 'sms/balance', 'sms_balance');

/**
 * @see \rest\controller\order_controller::action_sms_send()
 */
routing::add_route(request::GET, 'order', 'sms/send', 'sms_send');

/**
 * @see \rest\controller\order_controller::action_sms_status
 */
routing::add_route(request::GET, 'order', 'sms/status', 'sms_status');

#endregion

/**
 * @see \rest\controller\order_controller::action_continue_shopping
 */
routing::add_route(request::GET, 'order', 'continue/shopping', 'continue_shopping');

/**
 * @see \rest\controller\order_controller::action_order_fitting
 */
routing::add_route(request::GET, 'order', 'fitting', 'order_fitting');

/**
 * @see \rest\controller\order_controller::action_initiate()
 */
routing::add_route(request::GET, 'order', 'initiate', 'initiate');
