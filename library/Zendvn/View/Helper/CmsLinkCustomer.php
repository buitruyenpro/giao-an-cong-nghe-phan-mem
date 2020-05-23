<?php

namespace Zendvn\View\Helper;

use Zend\View\Helper\AbstractHelper;

class CmsLinkCustomer extends AbstractHelper
{

	public function __invoke($options = null)
	{

		$options['controller'] = !empty($options['controller']) ? $options['controller'] : 'index';
		$options['action']     = !empty($options['action']) ? $options['action'] : 'index';
		$options['id']         = !empty($options['id']) ? $options['id'] : null;
		$options['nest']       = !empty($options['nest']) ? $options['nest'] : null;

		$urlPlugin = $this->getView()->plugin('url');
		return $urlPlugin('home/default', array(
			'controller' 	=> $options['controller'],
			'action'     	=> $options['action'],
			'id'         	=> $options['id'],
			'nest'       	=> $options['nest'],
			'id_timeline'   => $options['id_timeline'],
		));
	}
}