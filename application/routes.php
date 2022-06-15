<?php

namespace KB\rest_server;

use KB\network\http\content_type;

// Default server values for all Controller and actions if not redefined directly in controller or action
//routing::default_https_only('yes');
routing::default_allowed_content_types(content_type::JSON);

include_once 'routes/rest.php';

include_once 'routes/order.php';

include_once 'routes/cart.php';

include_once 'routes/bitrix.php';