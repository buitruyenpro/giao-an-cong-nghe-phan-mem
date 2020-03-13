<?php
	
	namespace Zendvn\View\Helper;
	
	use Zend\View\Helper\AbstractHelper;
	
	class CmsLinkAdmin extends AbstractHelper{
		
		public function __invoke($options = null, $type = null){
			
			$options['controller'] = !empty($options['controller']) ? $options['controller'] : 'index';
			$options['action']     = !empty($options['action']) ? $options['action'] : 'index';
			$options['id']         = !empty($options['id']) ? $options['id'] : null;
			$options['nest']       = !empty($options['nest']) ? $options['nest'] : null;
			$options['topic']      = !empty($options['topic']) ? $options['topic'] : null;
			
			$urlPlugin = $this->getView()->plugin('url');
			if ($type == null){
				return $urlPlugin('adminRoute/default', array(
					'controller' => $options['controller'],
					'action'     => $options['action'],
					'id'         => $options['id'],
					'nest'       => $options['nest'],
					'topic'      => $options['topic'],
					'timeline'   => $options['timeline'],
				
				));
			}
			return $urlPlugin('adminRoute/nest_topic', array(
				'controller' => $options['controller'],
				'action'     => $options['action'],
				'id'         => $options['id'],
				'topic'      => $options['topic'],
			
			));
		}
	}