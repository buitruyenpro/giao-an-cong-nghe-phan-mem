<?php

namespace Admin\Controller;

use Zendvn\Controller\ActionController;
use Zendvn\Paginator\Paginator as ZendvnPaginator;
use Zend\Form\FormInterface;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class BookController extends ActionController
{
    public function init()
    {

        // SESSION FILTER
        $ssFilter = new Container(__CLASS__);

        $this->_params['ssFilter']['order_by'] = !empty($ssFilter->order_by) ? $ssFilter->order_by : 'id';
        $this->_params['ssFilter']['order'] = !empty($ssFilter->order) ? $ssFilter->order : 'DESC';
        $this->_params['ssFilter']['filter_status'] = $ssFilter->filter_status;
        $this->_params['ssFilter']['filter_special'] = $ssFilter->filter_special;
        $this->_params['ssFilter']['filter_category'] = $ssFilter->filter_category;
        $this->_params['ssFilter']['filter_keyword_type'] = $ssFilter->filter_keyword_type;
        $this->_params['ssFilter']['filter_keyword_value'] = $ssFilter->filter_keyword_value;

        // PAGINATOR
        $this->_paginator['itemCountPerPage'] = 3;
        $this->_paginator['pageRange'] = 4;
        $this->_paginator['currentPageNumber'] = $this->params()->fromRoute('page', 1);
        $this->_params['paginator'] = $this->_paginator;

        // OPTIONS
        $this->_options['tableName'] = 'Admin\Model\BookTable';
        $this->_options['formName'] = 'formAdminBook';

        // DATA
        $this->_params['data'] = array_merge(
            $this->getRequest()->getPost()->toArray(),
            $this->getRequest()->getFiles()->toArray()
        );
	    $this->_params['data']['id'] = $this->params('id');
    }

    public function indexAction()
    {
        $id = $this->identity()->group_id;
        $groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
        $ordering = $groupTable->getOrdering($id);
	    if ($this->params('id')) {
	    	
		    $total = $this->getTable()->countItem($this->_params, array('task' => 'list-item-id'));
		    $items = $this->getTable()->listItem($this->_params, array('task' => 'list-item-id'));
	    }
	    else {
		    $total = $this->getTable()->countItem($this->_params, array('task' => 'list-item'));
		    $items = $this->getTable()->listItem($this->_params, array('task' => 'list-item'));
	    }
        return new ViewModel(array(
            'items' => $items,
            'paginator' => ZendvnPaginator::createPaginator($total, $this->_params['paginator']),
            'ssFilter' => $this->_params['ssFilter'],
            'ordering' => $ordering,
        ));
    }

    public function filterAction()
    {
        if ($this->getRequest()->isPost()) {
            $ssFilter = new Container(__CLASS__);
            $data = $this->_params['data'];
            $ssFilter->order_by = $data['order_by'];
            $ssFilter->order = $data['order'];
            $ssFilter->filter_status = $data['filter_status'];
            $ssFilter->filter_special = $data['filter_special'];
            $ssFilter->filter_category = $data['filter_category'];
            $ssFilter->filter_keyword_type = $data['filter_keyword_type'];
            $ssFilter->filter_keyword_value = $data['filter_keyword_value'];

            $btnClear = $data['btn-clear'];

            if ($btnClear == 'btn-clear') {
                $ssFilter->offsetUnset('filter_keyword_type');
                $ssFilter->offsetUnset('filter_keyword_value');
            }
        }
        $this->goAction();
    }

    public function statusAction()
    {
        if ($this->getRequest()->isPost()) {
            $id = $this->identity()->group_id;
            $userTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
            $ordering = $userTable->getOrdering($id);
            $access = 1;
            if ($this->_params['data']['status_id'] != null) {
                $access = $this->getTable()->checkDelete([$this->_params['data']['status_id']], $ordering);
            }
            if ($access == false) {
                $message = 'Bạn không có quyền cập nhật trạng thái tài liệu này!';
                $this->flashMessenger()->addMessage($message);
                $this->goAction();
            } else {

                $flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-status'));
                if ($flagAction == true) {
                    $this->flashMessenger()->addMessage('Trạng thái của phần tử đã được cập nhật thành công!');
                }

            }
        }
        $this->goAction();
    }

    public function multiStatusAction()
    {
        $message = 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi trạng thái!';
        if ($this->getRequest()->isPost()) {
            $id = $this->identity()->group_id;
            $userTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
            $ordering = $userTable->getOrdering($id);
            $access = 1;
            if ($this->_params['data']['cid'] != null) {
                $access = $this->getTable()->checkDelete($this->_params['data']['cid'], $ordering);
            }
            if ($access == false) {
                $message = 'Bạn không có quyền xóa tài liệu này!';
                $this->flashMessenger()->addMessage($message);
                $this->goAction();
            } else {
                $flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-multi-status'));
                if ($flagAction == true) {
                    $message = 'Trạng thái của phần tử đã được cập nhật thành công!';
                }

            }
        }
        $this->flashMessenger()->addMessage($message);
        $this->goAction();
    }

    public function orderingAction()
    {
        $message = 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi thứ tự sắp xếp!';
        if ($this->getRequest()->isPost()) {
            $id = $this->identity()->group_id;
            $userTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
            $ordering = $userTable->getOrdering($id);
            $access = 1;
            if ($this->_params['data']['cid'] != null) {
                $access = $this->getTable()->checkDelete($this->_params['data']['cid'], $ordering);
            }
            if ($access == false) {
                $message = 'Bạn không có quyền xóa tài liệu này!';
                $this->goAction();
            } else {
                $flagAction = $this->getTable()->ordering($this->_params['data']);
                if ($flagAction == true) {
                    $message = 'Thứ tự sắp xếp phần tử đã được cập nhật thành công!';
                }

            }
        }
        $this->flashMessenger()->addMessage($message);
        $this->goAction();
    }

    public function deleteAction()
    {

        $id = $this->identity()->group_id;
        $userTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
        $ordering = $userTable->getOrdering($id);
        $message = 'Vui lòng chọn vào phần tử mà bạn muốn xóa!';
        if ($this->getRequest()->isPost()) {
            $access = 1;
            if ($this->_params['data']['cid'] != null) {
                $access = $this->getTable()->checkDelete($this->_params['data']['cid'], $ordering);
            }
            if ($access == false) {
                $message = 'Bạn không có quyền xóa tài liệu này!';
                $this->goAction();
            } else {
                $flagAction = $this->getTable()->deleteItem($this->_params['data'], array('task' => 'multi-delete'));
                if ($flagAction == true) {
                    $message = 'Các phần tử đã được xóa thành công!';
                }

            }
        }
        $this->flashMessenger()->addMessage($message);
        $this->goAction();
    }

    public function viewAction()
    {
        $id = $this->identity()->group_id;
        $groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
        $ordering = $groupTable->getOrdering($id);

        $this->_params['data']['id'] = $this->params('id');

        if (!empty($this->_params['data']['id'])) {
            $item = $this->getTable()->getItem($this->_params['data']);
            $levelBook = $item->level;

            if ($ordering > $levelBook) {
                $message = 'Bạn không có quyền truy cập vào tài liệu này!';
                $this->flashMessenger()->addMessage($message);
                $this->goAction();
            } else {
                return new ViewModel(array(
                    'items' => $item,
                ));
            }
        }
    }

    public function formAction()
    {

        $id = $this->identity()->group_id;
        $userTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
        $ordering = $userTable->getOrdering($id);
        $this->_params['data']['id'] = $this->params('id');
        $access = 1;
        if ($this->_params['data']['id'] != null) {
            $access = $this->getTable()->checkDelete([$this->_params['data']['id']], $ordering);
        }
        $myForm = $this->getForm();
        $task = 'add-item';
        $this->_params['data']['id'] = $this->params('id');

        if (!empty($this->_params['data']['id'])) {
            if ($access == false) {
                $message = 'Bạn không có quyền vào trang này!';
                $this->flashMessenger()->addMessage($message);
                $this->goAction();
            } else {
                $item = $this->getTable()->getItem($this->_params['data']);
                if (!empty($item)) {
                    $myForm->setInputFilter(new \Admin\Form\BookFilter(array('id' => $this->_params['data']['id'])));
                    $myForm->bind($item);
                    $task = 'edit-item';
                }

                if ($this->getRequest()->isPost()) {

                    $action = $this->_params['data']['action'];
                    $myForm->setData($this->_params['data']);

                    if ($myForm->isValid()) {
                        $this->_params['data'] = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
                        $id = $this->getTable()->saveItem($this->_params['data'], array('task' => $task), $ordering, $id, $this->identity()->fullname);
                        $this->flashMessenger()->addMessage('Dữ liệu đã được lưu thành công!');
                        if ($action == 'save-close') {
                            $this->goAction();
                        }

                        if ($action == 'save-new') {
                            $this->goAction(array('action' => 'form'));
                        }

                        if ($action == 'save') {
                            $this->goAction(array('action' => 'form', 'id' => $id));
                        }

                    }
                }
            }
        } else {

            if ($this->getRequest()->isPost()) {

                $action = $this->_params['data']['action'];
                $myForm->setData($this->_params['data']);

                if ($myForm->isValid()) {
                    $this->_params['data'] = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
                    $id = $this->getTable()->saveItem($this->_params['data'], array('task' => $task), $ordering, $id, $this->identity()->fullname);
                    $this->flashMessenger()->addMessage('Dữ liệu đã được lưu thành công!');
                    if ($action == 'save-close') {
                        $this->goAction();
                    }

                    if ($action == 'save-new') {
                        $this->goAction(array('action' => 'form'));
                    }

                    if ($action == 'save') {
                        $this->goAction(array('action' => 'form', 'id' => $id));
                    }

                }
            }
        }
        return new ViewModel(array(
            'myForm' => $myForm,
        ));
    }
}
