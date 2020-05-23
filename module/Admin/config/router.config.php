<?php
	
	// URL: /
	// Admin\Controller\Index - indexAction
	$homeRoute = array(
		'type'    => 'Zend\Mvc\Router\Http\Literal',
		'options' => array(
			'route'    => '/',
			'defaults' => array(
				'__NAMESPACE__' => 'Admin\Controller',
				'controller'    => 'Index',
				'action'        => 'index'
			)
		)
	);
	
	$SchoolRoute = array(
		'type'    => 'Zend\Mvc\Router\Http\Literal',
		'options' => array(
			'route'    => '/school.html',
			'defaults' => array(
				'__NAMESPACE__' => 'Admin\Controller',
				'controller'    => 'School',
				'action'        => 'index'
			)
		)
	);
	$nestRoute   = array(
		'type'    => 'Zend\Mvc\Router\Http\Literal',
		'options' => array(
			'route'    => '/nest.html',
			'defaults' => array(
				'__NAMESPACE__' => 'Admin\Controller',
				'controller'    => 'nest',
				'action'        => 'index'
			)
		)
	);
	
	
	// URL: /backend/[controller/action]
	// Admin\Controller\Index - indexAction
	$adminRoute = array(
		'type'          => 'Literal',
		'options'       => array(
			'route'    => '/admin.html',
			'defaults' => array(
				'__NAMESPACE__' => 'Admin\Controller',
				'controller'    => 'Index',
				'action'        => 'index'
			)
		),
		'may_terminate' => true,
		'child_routes'  => array(
			'default'    => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/[:controller[/:action[/:id][/:nest][/:topic][/:timeline]]][/]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'         => '[0-9]*',
					),
					'defaults'    => array()
				)
			),
			'paginator'  => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/:controller/index/page[/:page][/]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'page'       => '[0-9]*'
					),
					'defaults'    => array()
				)
			),
			'nest_topic' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/[:controller[/:action[/:id][/:topic]]][/]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'page'       => '[0-9]*'
					),
					'defaults'    => array()
				)
			),
		
		)
	);
	
	// URL: /backend/[controller/action]
	// Admin\Controller\Index - indexAction
	$customerRoute = array(
		'type'          => 'Literal',
		'options'       => array(
			'route'    => '/home.html',
			'defaults' => array(
				'__NAMESPACE__' => 'Admin\Controller',
				'controller'    => 'Index',
				'action'        => 'index'
			)
		),
		'may_terminate' => true,
		'child_routes'  => array(
			'default'   => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/[:controller[/:action[/:id][/:nest][/:id_timeline][/:id_book]]][/]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
						'id'         => '[0-9]*',
					),
					'defaults'    => array()
				)
			),
			'paginator' => array(
				'type'    => 'Segment',
				'options' => array(
					'route'       => '/:controller/:action/page[/:page][/]',
					'constraints' => array(
						'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
						'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
						'page'       => '[0-9]*'
					),
					'defaults'    => array()
				)
			),
		
		)
	);
	
	return array(
		'router' => array(
			'routes' => array(
				'home'       => $customerRoute,
				'adminRoute' => $adminRoute,
				'routeHome'  => $homeRoute,
				'schoolHome' => $SchoolRoute,
				'nestHome'   => $nestRoute,
			),
		)
	
	);