<?php
namespace Shop;

use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
    	$eventManager			= $e->getApplication()->getEventManager();
    	$moduleRouteListener	= new ModuleRouteListener();
    	$moduleRouteListener->attach ( $eventManager );
	}
	
	public function getFormElementConfig() {
		return array (
				'factories' => array(
//     					'formAdminGroup'	=> function($sm){
//     						$myForm	= new \Admin\Form\Group();
//     						$myForm->setInputFilter(new \Admin\Form\GroupFilter());
//     						return $myForm;
//     					},
    			),
    	);
    }
    
    public function getConfig()
    {
        return array_merge(
    			require_once __DIR__ . '/config/module.config.php',
    			require_once __DIR__ . '/config/router.config.php'
    	);
    }

    public function getAutoloaderConfig()
    {
        return array(
        		'Zend\Loader\ClassMapAutoloader'	=> array(
        				__DIR__ . '/autoload_classmap.php'
        		),
	            'Zend\Loader\StandardAutoloader' => array(
	                'namespaces' => array(
	                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
	                ),
	            ),
        );
    }
	
	public function getServiceConfig(){
		return array(
				'factories'	=> array(
						'Shop\Model\CategoryTable'	=> function ($sm) {
							$tableGateway	= $sm->get('CategoryTableGateway');
							return new \Shop\Model\CategoryTable($tableGateway);
						},
						'Shop\Model\BookTable'	=> function ($sm) {
							$tableGateway	= $sm->get('BookTableGateway');
							return new \Shop\Model\BookTable($tableGateway);
						},
						'Shop\Model\SliderTable'	=> function ($sm) {
							$tableGateway	= $sm->get('SliderTableGateway');
							return new \Shop\Model\SliderTable($tableGateway);
						},
				),
		);
	}

	public function getViewHelperConfig(){
		return array(
				'invokables'	=> array(
						'blkFacebook'		=> '\Block\BlkFacebook',
						'cmsBreadcrumb'		=> '\Zendvn\View\Helper\CmsBreadcrumb',
						'cmsSummary'		=> '\Zendvn\View\Helper\CmsSummary', 
						'cmsChangeDisplay'		=> '\Zendvn\View\Helper\CmsChangeDisplay', 
				),
				'factories'	=> array(
					'blkCategory'		=> function($sm){
						$helper	= new \Block\BlkCategory();
						$helper->setData($sm->getServiceLocator()->get('Shop\Model\CategoryTable'));
						return $helper;
					},
					'blkSpecial'		=> function($sm){
						$helper	= new \Block\BlkSpecial();
						$helper->setData($sm->getServiceLocator()->get('Shop\Model\BookTable'));
						return $helper;
					},
					'blkSlider'			=> function($sm){
						$helper	= new \Block\BlkSlider();
						$helper->setData($sm->getServiceLocator()->get('Shop\Model\SliderTable'));
						return $helper;
					},
					'blkNewBook'		=> function($sm){
						$helper	= new \Block\BlkNewBook();
						$helper->setData($sm->getServiceLocator()->get('Shop\Model\BookTable'));
						return $helper;
					},
				),
		);
	}

}