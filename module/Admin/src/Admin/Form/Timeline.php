<?php
	
	namespace Admin\Form;
	
	use \Zend\Form\Form as Form;
	use Zend\Form\Element as Element;
	
	class Timeline extends Form{
		
		public function __construct($name = null){
			parent::__construct();
			
			// FORM Attribute
			$this->setAttributes(array(
				                     'action' => '#',
				                     'method' => 'POST',
				                     'class'  => 'form-horizontal',
				                     'role'   => 'form',
				                     'name'   => 'adminForm',
				                     'id'     => 'adminForm',
				                     'style'  => 'padding-top: 20px;',
			                     ));
			
			// ID
			$this->add(array(
				           'name'       => 'id',
				           'attributes' => array(
					           'type' => 'hidden',
				           ),
			           ));
			// Time
			$this->add(array(
				           'name'       => 'time',
				           'type'       => 'date',
				           'attributes' => array(
					           'class'       => 'form-control',
					           'id'          => 'datepicker',
					           'placeholder' => 'Thời gian kết thúc',
				           ),
				           'options'    => array(
					           'label'            => 'Thời gian kết thúc',
					           'label_attributes' => array(
						           'for'   => 'time',
						           'class' => 'col-xs-3 control-label',
					           )
				           ),
			           ));
			
			
		}
		
		public function showMessage(){
			$messages = $this->getMessages();
			
			if (empty($messages)){
				return false;
			}
			
			$xhtml = '<div class="callout callout-danger">';
			foreach ($messages as $key => $msg){
				$xhtml .= sprintf('<p><b>%s:</b> %s</p>', ucfirst($key), current($msg));
			}
			$xhtml .= '</div>';
			return $xhtml;
		}
		
		
	}