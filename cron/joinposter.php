<?php

namespace cron;
use Exception;

require_once('bootstrap.php');

$cron = new cron();

try {
	$contacts = $cron->getClients();
} catch (Exception $e) {
	$cron->printLog($e);
	$cron->logging('[error] Update joinposter: ' . $e->getMessage());

	throw $e;
}

if (0 < count($contacts)) {
	try {
		$cron->setContacts($contacts);
		return [];
	} catch (Exception $e) {
		$cron->logging('[error] Update joinposter: ' . $e->getMessage());
		throw $e;
	}
} else {
	$cron->logging('[error] Update error joinposter, not contacts');
}

return [];
