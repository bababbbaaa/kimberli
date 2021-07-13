<?php

namespace rest\entity;

use rest\api\Okay;
use rest\validation\errors;
use rest\validation\ValidationException;
use RuntimeException;

class Argo extends Okay
{

	public function __construct()
	{
		parent::__construct();
	}

	public function create(array $data)
	{
		$сheck = $data['cupon'];

		if (null === $this->getArgo($сheck)) {
			return $this->add($сheck);
		}

		throw new RuntimeException('This check is already registered.');
	}

	public function getArgo($сheck)
	{
		$query = "SELECT сheck FROM ok_argo WHERE сheck = " . $сheck;

		$this->db->query($query);

		return $this->db->result();
	}

	private function add($сheck): int
	{
		$this->db->query("INSERT INTO `ok_argo`(`сheck`) VALUES ({$сheck})");

		return $this->db->insert_id();
	}

}