<?php

namespace Admin\Form;

use Admin\Model\CategoryTable;
use \Zend\Form\Form as Form;

class Index extends Form
{

    public function __construct()
    {
        parent::__construct();

        // FORM Attribute
        $this->setAttributes(array(
            'action' => '#',
            'method' => 'POST',
            'class' => 'form-horizontal',
            'role' => 'form',
            'name' => 'adminForm',
            'id' => 'adminForm',
            'style' => 'padding-top: 20px;',
            'enctype' => 'multipart/form-data',
        ));



        // Description
        $this->add(array(
            'name' => 'description',
            'type' => 'Textarea',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'description',
            ),
            'options' => array(
                'label' => 'Miêu tả',
                'label_attributes' => array(
                    'for' => 'description',
                    'class' => 'col-xs-3 control-label',
                ),
            ),
        ));
        // File docx,pdf,excel
        $this->add(array(
            'name' => 'file_send',
            'type' => 'File',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'file',
            ),
            'options' => array(
                'label' => 'Tệp bài đăng',
                'label_attributes' => array(
                    'for' => 'file',
                    'class' => 'col-xs-3 control-label',
                ),
            ),
        ));
    }

    public function showMessage()
    {
        $messages = $this->getMessages();

        if (empty($messages)) {
            return false;
        }

        $xhtml = '<div class="callout callout-danger">';
        foreach ($messages as $key => $msg) {
            if ($key == 'file_send') {
                $key = 'Tên giáo án';
            }
            $xhtml .= sprintf('<p><b>%s:</b> %s</p>', ucfirst($key), "Không được để trống");
        }
        $xhtml .= '</div>';
        return $xhtml;
    }
}