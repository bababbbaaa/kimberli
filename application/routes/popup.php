<?php

namespace KB\rest_server;

use KB\network\http\request;
/**
 * Add controller for saas endpoints
 */
routing::add_controller('popup', '/rest/popup/');

/**
 * @see \rest\controller\popup_controller::action_send_email()
 */
routing::add_route(request::POST, 'popup', 'send-email', 'send_email');