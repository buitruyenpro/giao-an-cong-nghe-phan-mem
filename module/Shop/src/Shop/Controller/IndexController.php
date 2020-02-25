<?php
namespace Shop\Controller;

use Zendvn\Controller\ActionController;
use Zend\View\Model\ViewModel;

class IndexController extends ActionController
{
	public function init(){
		// OPTIONS
		$this->_options['tableName']	= 'Admin\Model\UserTable';
		$this->_options['formName']		= 'formAdminUser';
		
		// DATA
		$this->_params['data']	= array_merge(
				$this->getRequest()->getPost()->toArray(),
				$this->getRequest()->getFiles()->toArray()
		);
	}
	
    public function indexAction()
    {
    	
    }
}
