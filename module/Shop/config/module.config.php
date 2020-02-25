<?php
return array(
	'controllers'	=> array(
			'invokables' => array (
					'Shop\Controller\Index' 	=> 'Shop\Controller\IndexController',
					'Shop\Controller\Category' 	=> 'Shop\Controller\CategoryController',
					'Shop\Controller\Book' 		=> 'Shop\Controller\BookController',
					'Shop\Controller\Notice' 		=> 'Shop\Controller\NoticeController',
			)
	),
	'view_manager'	=> array(
			'doctype'					=> 'HTML5',
			'template_path_stack'		=> array(__DIR__ . '/../view'),
	),
		
); 