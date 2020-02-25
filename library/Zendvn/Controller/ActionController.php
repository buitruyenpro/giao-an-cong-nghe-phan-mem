<?php

namespace Zendvn\Controller;

use Zend\Mvc\MvcEvent;

use Zend\Mvc\Controller\PluginManager;

use Zend\Mvc\Controller\AbstractActionController;

class ActionController extends AbstractActionController{
	
	protected $_tableObj;
	protected $_formObj;
	protected $_params;
	protected $_options   = array('tableName', 'formName');
	protected $_paginator = array(
			'itemCountPerPage'	=> 10,
			'pageRange'			=> 4,
	);
	
	public function setPluginManager(PluginManager $plugins){
		$this->getEventManager()->attach(MvcEvent::EVENT_DISPATCH, array($this, 'onInit'), 100);
		parent::setPluginManager($plugins);
	}
	
	public function onInit(MvcEvent $e){
		
		// GET MODULE - CONTROLLER - ACTION
		$routeMatch			= $e->getRouteMatch();
		$controllerArray	= explode('\\', $routeMatch->getParam('controller'));
		
		// SET MODULE - CONTROLLER - ACTION FOR $_PARAMS
		$this->_params['module']		= strtolower($controllerArray[0]);
		$this->_params['controller']	= strtolower($controllerArray[2]);
		$this->_params['action']		= $routeMatch->getParam('action');
		
		// SET MODULE - CONTROLLER - ACTION FOR VIEW
		$viewModel				= $e->getApplication()->getMvcEvent()->getViewModel();
		$viewModel->module		= $this->_params['module'];
		$viewModel->controller	= $this->_params['controller'];
		$viewModel->action		= $this->_params['action'];

		// SET LAYOUT
		$config		= $this->getServiceLocator()->get('config');
		$this->layout($config['module_layouts'][$controllerArray[0]]);
		
		$this->init();
	}
	
	public function init(){
		echo '<h3 style="color:red;">' . __METHOD__ . '</h3>';
	}
	
	public function getTable(){
		if(empty($this->_tableObj)) {
			$this->_tableObj = $this->getServiceLocator()->get($this->_options['tableName']);
		}
		return $this->_tableObj;
	}
	
	public function getForm(){
		if(empty($this->_formObj)) {
			$this->_formObj = $this->getServiceLocator()->get('FormElementManager')->get($this->_options['formName']);
		}
		return $this->_formObj;
	}
	
	public function goAction($actionInfo = null){
		$actionInfo['controller']	= !empty($actionInfo['controller']) ? $actionInfo['controller'] : $this->_params['controller'];
		$actionInfo['action']		= !empty($actionInfo['action']) ? $actionInfo['action'] : 'index';
		$actionInfo['id']			= !empty($actionInfo['id']) ? $actionInfo['id'] : null;
		return $this->redirect()->toRoute('adminRoute/default', array(
				'controller'=> $actionInfo['controller'], 
				'action' 	=> $actionInfo['action'],
				'id' 		=> $actionInfo['id'],
		));
	}
	
	public function goError(){
		return $this->redirect()->toRoute('shopRoute/default', array(
				'controller'	=> 'notice',
				'action'		=> 'no-data',
		));
	}
	
}