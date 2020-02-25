<?php
namespace Shop\Controller;

use Zendvn\Controller\ActionController;
use Zend\Form\FormInterface;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

use Zendvn\Paginator\Paginator as ZendvnPaginator;

class BookController extends ActionController
{
	public function init(){
		
		// SESSION FILTER
		$ssFilter	= new Container(__CLASS__);
		$this->_params['ssFilter']['order_by']				= !empty($ssFilter->order_by) ? $ssFilter->order_by : 'left';
		$this->_params['ssFilter']['order']					= !empty($ssFilter->order) ? $ssFilter->order : 'ASC';
		$this->_params['ssFilter']['filter_status']			= $ssFilter->filter_status;
		$this->_params['ssFilter']['filter_level']			= $ssFilter->filter_level;
		$this->_params['ssFilter']['filter_keyword_type']	= $ssFilter->filter_keyword_type;
		$this->_params['ssFilter']['filter_keyword_value']	= $ssFilter->filter_keyword_value;
		
		// PAGINATOR
		$this->_paginator['itemCountPerPage']	= 10;
		$this->_paginator['pageRange']			= 4;
		$this->_paginator['currentPageNumber']	= $this->params()->fromRoute('page',1);
		$this->_params['paginator']				= $this->_paginator;
		
		// OPTIONS
		$this->_options['tableName']	= 'Shop\Model\BookTable';
		$this->_options['formName']		= 'formAdminCategory';
		
		// DATA
		$this->_params['data']	= array_merge(
				$this->getRequest()->getPost()->toArray(),
				$this->getRequest()->getFiles()->toArray()
		);
	}
	
    public function popupAction()
    {
		$view				= new ViewModel();
    	$data				= null;
    	$isXmlHttpRequest	= false;
    	
    	if($this->getRequest()->isXmlHttpRequest() == true){
    		$isXmlHttpRequest	= true;
    		
    		$data	= $this->getTable()->getItem($this->_params['data'], array('task' => 'book-popup'));
    		 
    	}
    	$view->setVariables(array(
    			'isXmlHttpRequest'		=> $isXmlHttpRequest,
    			'data'					=> $data
    	));
    	$view->setTerminal(true);
    	return $view;
    }
    
    
}
