<?php
namespace Zendvn\View\Helper\Url;
use Zend\View\Helper\AbstractHelper;

class LinkLogin extends AbstractHelper {
	
	public function __invoke($options = null){
		$urlHelper	= $this->getView()->plugin('url');
		
		if(URL_FRIENDLY == true){		
			return $urlHelper('routeLogin');
		}
		
		return $urlHelper('customerRoute/default', array(
			'controller'	=> 'user',
			'action'		=> 'login',		
		));
	}
}