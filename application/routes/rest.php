<?php

namespace KB\rest_server;

use KB\network\http\request;

/**
 * Add controller for main endpoints
 */
routing::add_controller('rest', '/rest/');
/**
 * @link GET /
 * @code 200
 * @see \controller\rest_controller::action_index()
 */
routing::add_route(request::GET, 'rest', '', 'index');

/**
 * @see \controller\rest_controller::action_feedback()
 */
routing::add_route(request::POST, 'rest', 'feedback', 'feedback');


/**
 * @see \controller\rest_controller::action_coupon()
 */
routing::add_route(request::POST, 'rest', 'coupon', 'coupon');



