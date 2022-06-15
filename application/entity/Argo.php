<?php

namespace rest\entity;

use rest\api\Okay;
use rest\validation\errors;
use rest\validation\ValidationException;

class Argo extends Okay
{

	public function __construct()
	{
		parent::__construct();
	}

	public function create($сheck, $phone)
	{
		if (null !== $this->getArgo($сheck)) {
			throw new ValidationException(errors::create(['code' => 'This check is already registered.']));

		}

		return $this->add($сheck, $phone);
	}

	public function getArgo(string $check)
	{
		$query = "SELECT сheck FROM ok_argo WHERE сheck  like '{$check}'";

		$this->db->query($query);

		return $this->db->result();
	}

	private function add($check, $phone): int
	{
		$this->db->query("INSERT INTO `ok_argo`(`сheck`, `phone`) VALUES ('$check', '$phone')");

		return $this->db->insert_id();
	}

}