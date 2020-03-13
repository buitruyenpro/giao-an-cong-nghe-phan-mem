<?php

namespace Zendvn\Model\Entity;

use Zend\Json\Json;

class Book
{

	public $id;
	public $description;
	public $status;
	public $ordering;
	public $created;
	public $created_by;
	public $modified;
	public $modified_by;
	public $category_id;
	public $document;
	public $user_id;
	public $id_homework;
	public $id_nest;
	public $level;


	public function exchangeArray($data)
	{
		$this->id			= (!empty($data['id'])) ? $data['id'] : null;
		$this->description	= (!empty($data['description'])) ? $data['description'] : null;
		$this->status		= (!empty($data['status'])) ? $data['status'] : 0;
		$this->ordering		= (!empty($data['ordering'])) ? $data['ordering'] : null;
		$this->created		= (!empty($data['created'])) ? $data['created'] : null;
		$this->created_by	= (!empty($data['created_by'])) ? $data['created_by'] : null;
		$this->modified		= (!empty($data['modified'])) ? $data['modified'] : null;
		$this->modified_by	= (!empty($data['modified_by'])) ? $data['modified_by'] : null;
		$this->document	    = (!empty($data['document'])) ? $data['document'] : null;

		$this->document	    = (!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->document	    = (!empty($data['id_homework'])) ? $data['id_homework'] : null;
		$this->document	    = (!empty($data['id_nest'])) ? $data['id_nest'] : null;
		$this->document	    = (!empty($data['level'])) ? $data['level'] : null;
	}

	public function getArrayCopy()
	{
		$result = get_object_vars($this);
		$result['status']	= ($result['status'] == 1) ? 'active' : 'inactive';
		$result['special']	= ($result['special'] == 1) ? 'yes' : 'no';


		return $result;
	}
}