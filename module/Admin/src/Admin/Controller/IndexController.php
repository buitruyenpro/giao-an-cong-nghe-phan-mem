<?php
	
	namespace Admin\Controller;
	
	use Zendvn\Controller\ActionController;
	use Zend\Form\FormInterface;
	use Zend\Session\Container;
	use Zend\View\Model\ViewModel;
	
	use Zendvn\Paginator\Paginator as ZendvnPaginator;
	
	class IndexController extends ActionController{
		public function init(){
			
			
			// PAGINATOR
			$this->_paginator['itemCountPerPage']  = 5;
			$this->_paginator['pageRange']         = 4;
			$this->_paginator['currentPageNumber'] = $this->params()->fromRoute('page', 1);
			$this->_params['paginator']            = $this->_paginator;
			
			// OPTIONS
			$this->_options['tableName'] = 'Admin\Model\HomeworkTable';
			
			
			// DATA
			$this->_params['data']            = $this->getRequest()->getPost()->toArray();
			$this->_params['data']['nest_id'] = $this->identity()->id_permission_nested;
		}
		
		public function indexAction(){
			$total = $this->getTable()->countItemCustomer($this->_params, array('task' => 'list-item'));
			$items = $this->getTable()->listItemCustomer($this->_params, array('task' => 'list-item'));
			return new ViewModel(array(
				                     'items'     => $items,
				                     'paginator' => ZendvnPaginator::createPaginator($total, $this->_params['paginator']),
				                     'ssFilter'  => $this->_params['ssFilter'],
			                     ));
		}
		
		public function submissionAction(){
			$total = $this->getTable()->countItem($this->_params, array('task' => 'list-item'));
			$items = $this->getTable()->listItemCustomer($this->_params, array('task' => 'list-item'));
			return new ViewModel(array(
				                     'items'     => $items,
				                     'paginator' => ZendvnPaginator::createPaginator($total, $this->_params['paginator']),
				                     'ssFilter'  => $this->_params['ssFilter'],
				
			                     ));
		}
		
		
	}
