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
 * @see \rest\controller\rest_controller::action_index()
 */
routing::add_route(request::GET, 'rest', '', 'index');

/**
 * @see \rest\controller\rest_controller::action_feedback()
 */
routing::add_route(request::POST, 'rest', 'feedback', 'feedback');
/**
 * @see \rest\controller\rest_controller::action_callback()
 */
routing::add_route(request::POST, 'rest', 'callback', 'callback');

/**
 * @url GET /rest/comment/add
 * @see \rest\controller\rest_controller::action_add_comment()
 */
routing::add_route(request::POST, 'rest', 'comment/add', 'add_comment');


/**
 * @see \rest\controller\rest_controller::action_coupon()
 */
routing::add_route(request::POST, 'rest', 'coupon', 'coupon');

/**
 * @see \rest\controller\rest_controller::action_argo()
 */
routing::add_route(request::GET, 'rest', 'argo', 'argo');



