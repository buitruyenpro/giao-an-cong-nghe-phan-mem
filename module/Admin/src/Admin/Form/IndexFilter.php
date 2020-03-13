<?php

namespace Admin\Form;

use Zend\InputFilter\InputFilter;

class IndexFilter extends InputFilter
{

    public function __construct($options = null)
    {
        // File
        $this->add(array(
            'name' => 'file_send',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'FileSize',
                    'options' => array(
                        'min' => '10Kb',
                        'max' => '100MB',
                    ),
                    'break_chain_on_failure' => true,
                ),
                array(
                    'name' => 'FileExtension',
                    'options' => array(
                        'extension' => array('zip', 'pdf'),
                    ),
                    'break_chain_on_failure' => true,
                ),
            ),
        ));
    }
}
