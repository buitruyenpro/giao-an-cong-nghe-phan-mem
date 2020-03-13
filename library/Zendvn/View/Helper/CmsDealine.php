<?php

namespace Zendvn\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CmsDealine extends AbstractHelper
{

	protected $_data;

	public function __invoke()
	{
		echo "ăâ";
	}

	public function setData($table)
	{
		$this->_data = $table->getDeadLine(3);
		return $this->_data;
	}
}