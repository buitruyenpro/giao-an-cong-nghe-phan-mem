<?php

$homeRoute	= array(
		'type' => 'Zend\Mvc\Router\Http\Literal',
		'options' => array (
				'route' => '/',
				'defaults' => array (
						'__NAMESPACE__' => 'Shop\Controller',
						'controller' 	=> 'Index',
						'action' 		=> 'index' 
				) 
		) 
);

// Admin\Controller\Index - indexAction
$shopRoute	= array(
		'type' => 'Literal',
		'options' => array (
				'route' => '/shop',
				'defaults' => array (
						'__NAMESPACE__' => 'Shop\Controller',
						'controller' 	=> 'Index',
						'action' 		=> 'index' 
				)
		),
		'may_terminate' => true,
		'child_routes' => array (
				'default' => array (
						'type' 		=> 'Segment',
						'options' 	=> array (
								'route' => '/[:controller[/:action[/:id]]][/]',
								'constraints' => array (
										'controller' 	=> '[a-zA-Z][a-zA-Z0-9_-]*',
										'action' 		=> '[a-zA-Z][a-zA-Z0-9_-]*',
										'id' 			=> '[0-9]*',
								),
								'defaults' => array (
								)
						)
				),
				'category' => array (
						'type' 		=> 'Segment',
						'options' 	=> array (
								'route' => '/category/index/:id[/display/:display][/order/:order][/dir/:dir][/limit/:limit][/page/:page][/]',
								'constraints' => array (
										'id' 			=> '[0-9]*',
										'page' 			=> '[0-9]*',
										'display' 		=> 'grid|list',
										'order' 		=> 'id|name|price',
										'dir' 			=> 'ASC|DESC',
										'limit' 		=> '[0-9]*',
								),
								'defaults' => array (
										'__NAMESPACE__' => 'Shop\Controller',
										'controller' 	=> 'Category',
										'action' 		=> 'index'
								)
						)
				),
		)
);

return array(
	'router'		=> array(
			'routes' => array(
					'homeRoute'		=> $homeRoute,
					'shopRoute'	=> $shopRoute,
			),
	)
		
); 