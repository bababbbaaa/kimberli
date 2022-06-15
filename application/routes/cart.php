<?php
namespace KB\rest_server;

use KB\network\http\request;
/**
 * Add controller for saas endpoints
 */
routing::add_controller('cart', '/rest/cart/');

/**
 * @see \rest\controller\cart_controller::action_add()
 */
routing::add_route(request::GET, 'cart', 'add', 'add');