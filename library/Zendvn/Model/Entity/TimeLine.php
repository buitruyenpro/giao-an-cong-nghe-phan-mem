<?php

namespace Zendvn\Model\Entity;

class TimeLine
{

	public $id;
	public $start_date;
	public $end_date;
	public $nest_id;
	public $active;
	public  $id_homework;
	public $id_book;
	public $document;

	public function exchangeArray($data)
	{
		$this->document    = (!empty($data['document'])) ? $data['document'] : null;
		$this->id          = (!empty($data['id'])) ? $data['id'] : null;
		$this->id_book     = (!empty($data['id_book'])) ? $data['id_book'] : null;
		$this->start_date  = (!empty($data['start_date'])) ? $data['start_date'] : null;
		$this->end_date    = (!empty($data['end_date'])) ? $data['end_date'] : 0;
		$this->nest_id     = (!empty($data['nest_id'])) ? $data['nest_id'] : null;
		$this->active      = (!empty($data['active'])) ? $data['active'] : null;
		$this->id_homework = (!empty($data['id_homework'])) ? $data['id_homework'] : null;
	}

	public function getArrayCopy()
	{
		$result = get_object_vars($this);
		return $result;
	}
}