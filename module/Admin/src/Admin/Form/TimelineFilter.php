<?php
	
	namespace Admin\Form;
	
	use Zend\InputFilter\InputFilter;
	
	class TimelineFilter extends InputFilter
	{
		
		public function __construct()
		{
			// time
			$this->add(array(
				'name'     => 'time',
				'required' => true
			));
			
		}
	}