<?php
namespace KB\rest_server;

use KB\network\http\request;
/**
 * Add controller for saas endpoints
 */
routing::add_controller('bitrix', '/rest/bitrix/');

/**
 * @see \controller\bitrix_controller::action_profile()
 */
routing::add_route(request::GET, 'bitrix', 'profile', 'profile');


