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
 * @see \rest\controller\rest_controller::action_check_session()
 */
routing::add_route(request::GET, 'rest', 'check_session', 'check_session');
/**
 * @see \rest\controller\rest_controller::action_set_session()
 */
routing::add_route(request::PATCH, 'rest', 'set_session', 'set_session');

/**
 * @see \rest\controller\rest_controller::action_argo()
 */
routing::add_route(request::POST, 'rest', 'argo', 'argo');

/**
 * @see \rest\controller\rest_controller::action_vacancy()
 */
routing::add_route(request::POST, 'rest', 'vacancy', 'vacancy');

/**
 * @see \rest\controller\rest_controller::action_wishlist()
 */
routing::add_route(request::GET, 'rest', 'wishlist', 'wishlist');
/**
 * @see \rest\controller\rest_controller::action_bar_kimberli()
 */
routing::add_route(request::POST, 'rest', 'bar_kimberli', 'bar_kimberli');

/**
 * @see \rest\controller\rest_controller::action_welcome_to_boutique()
 */
routing::add_route(request::POST, 'rest', 'welcome-to-the-boutique', 'welcome_to_boutique');






