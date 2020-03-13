<?php
	
	namespace Admin\Controller;
	
	use Zendvn\Controller\ActionController;
	use Zend\Form\FormInterface;
	use Zend\Session\Container;
	use Zend\View\Model\ViewModel;
	
	use Zendvn\Paginator\Paginator as ZendvnPaginator;
	use Zendvn\System\Info;
	
	class UserController extends ActionController{
		public function init(){
			
			// SESSION FILTER
			$ssFilter = new Container(__CLASS__);
			
			$this->_params['ssFilter']['order_by']             = !empty($ssFilter->order_by) ? $ssFilter->order_by : 'id';
			$this->_params['ssFilter']['order']                = !empty($ssFilter->order) ? $ssFilter->order : 'DESC';
			$this->_params['ssFilter']['filter_status']        = $ssFilter->filter_status;
			$this->_params['ssFilter']['filter_group']         = $ssFilter->filter_group;
			$this->_params['ssFilter']['filter_keyword_type']  = $ssFilter->filter_keyword_type;
			$this->_params['ssFilter']['filter_keyword_value'] = $ssFilter->filter_keyword_value;
			
			// PAGINATOR
			$this->_paginator['itemCountPerPage']  = 5;
			$this->_paginator['pageRange']         = 4;
			$this->_paginator['currentPageNumber'] = $this->params()->fromRoute('page', 1);
			$this->_params['paginator']            = $this->_paginator;
			
			// OPTIONS
			$this->_options['tableName'] = 'Admin\Model\UserTable';
			$this->_options['formName']  = 'formAdminUser';
			
			
			// DATA
			$this->_params['data'] = array_merge($this->getRequest()->getPost()->toArray(), $this->getRequest()->getFiles()->toArray());
			
			if ($this->params('id') != 'main' && $this->params('id') && $this->params('topic')){
				$ssFilter->id    = $this->params('id');
				$ssFilter->topic = $this->params('topic');
			}
			if ($this->params('id') == 'main'){
				$ssFilter->id = null;
			}
			$this->_params['data']['id'] = $ssFilter->id;
			//Save ordering
			$id         = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($id);
			$infoObj    = new Info();
			$infoObj->storeOrdering($ordering);
			
		}
		
		public function indexAction(){
			if ($this->_params['data']['id']){
				$total = $this->getTable()->countItem($this->_params, null, array('task' => 'node_id'));
				$items = $this->getTable()->listItem($this->_params, null, array('task' => 'node_id'));
			}else{
				$id         = $this->identity()->group_id;
				$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
				$ordering   = $groupTable->getOrdering($id);
				if ($ordering == 1 || $ordering == 2){
					if ($ordering == 1){
						$ordering = 2;
					}else{
						if ($ordering == 2){
							$ordering = 3;
						}
					}
					$total = $this->getTable()->countItem($this->_params, $ordering, array('task' => 'list-item'));
					$items = $this->getTable()->listItem($this->_params, $ordering, array('task' => 'list-item'));
				}else{
					if ($ordering == 3){
						$this->_params['data']['id'] = $this->identity()->id_permission_nested;
						$nodeTable                   = $this->getServiceLocator()->get('Admin\Model\NestedPermissionTable');
						$categoryInfo                = $nodeTable->getNodeInfo($this->_params['data']);
						$arrayIdNest                 = $nodeTable->listNodes($categoryInfo, array('task' => 'list-branch-nest'));
						
						$total = $this->getTable()->countItem($this->_params, $arrayIdNest, array('task' => 'list-item-school'));
						$items = $this->getTable()->listItem($this->_params, $arrayIdNest, array('task' => 'list-item-school'));
					}else{
						
						$total = $this->getTable()->countItem($this->_params, $this->identity()->id_permission_nested, array('task' => 'list-item-nest'));
						$items = $this->getTable()->listItem($this->_params, $this->identity()->id_permission_nested, array('task' => 'list-item-nest'));
					}
				}
			}
			
			$slbGroup = $this->getServiceLocator()->get('Admin\Model\GroupTable')->itemInSelectbox();
			return new ViewModel(array('items' => $items, 'paginator' => ZendvnPaginator::createPaginator($total, $this->_params['paginator']), 'ssFilter' => $this->_params['ssFilter'], 'slbGroup' => $slbGroup, 'topic' => $this->params('topic')));
		}
		
		public
		function filterAction(){
			if ($this->getRequest()->isPost()){
				$ssFilter                       = new Container(__CLASS__);
				$data                           = $this->_params['data'];
				$ssFilter->order_by             = $data['order_by'];
				$ssFilter->order                = $data['order'];
				$ssFilter->filter_status        = $data['filter_status'];
				$ssFilter->filter_group         = $data['filter_group'];
				$ssFilter->filter_keyword_type  = $data['filter_keyword_type'];
				$ssFilter->filter_keyword_value = $data['filter_keyword_value'];
				
				$btnClear = $data['btn-clear'];
				
				if ($btnClear == 'btn-clear'){
					$ssFilter->offsetUnset('filter_keyword_type');
					$ssFilter->offsetUnset('filter_keyword_value');
				}
			}
			if ($this->params('id') != 'main' && $this->params('id') && $this->params('topic')){
				$actionInfo = ['id' => $ssFilter->id, 'topic' => $ssFilter->topic];
			}else{
				$actionInfo = ['id' => 'main'];
			}
			$this->goAction($actionInfo);
		}
		
		public
		function statusAction(){
			
			if ($this->getRequest()->isPost()){
				$id         = $this->identity()->group_id;
				$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
				$ordering   = $groupTable->getOrdering($id);
				$access     = $this->getTable()->getOrderingGroupByIdUser([$this->_params['data']['status_id']], $ordering);
				if ($access == false){
					$message = 'Bạn không có quyền cập nhật trạng thái chức vụ này!';
					$this->flashMessenger()->addMessage($message);
					$this->goAction();
				}else{
					$flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-status'));
					if ($flagAction == true){
						$this->flashMessenger()->addMessage('Trạng thái của phần tử đã được cập nhật thành công!');
					}
				}
			}
			$this->goAction();
		}
		
		public
		function multiStatusAction(){
			$message = 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi trạng thái!';
			if ($this->getRequest()->isPost()){
				$id         = $this->identity()->group_id;
				$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
				$ordering   = $groupTable->getOrdering($id);
				$access     = $this->getTable()->getOrderingGroupByIdUser($this->_params['data']['cid'], $ordering);
				if ($access == false){
					$message = 'Bạn không có quyền cập nhật trạng thái chức vụ này!';
					$this->goAction();
				}else{
					$flagAction = $this->getTable()->changeStatus($this->_params['data'], array('task' => 'change-multi-status'));
					if ($flagAction == true){
						$message = 'Trạng thái của phần tử đã được cập nhật thành công!';
					}
				}
			}
			$this->flashMessenger()->addMessage($message);
			$this->goAction();
		}
		
		public
		function orderingAction(){
			$message = 'Vui lòng chọn vào phần tử mà bạn muốn thay đổi thứ tự sắp xếp!';
			if ($this->getRequest()->isPost()){
				$id         = $this->identity()->group_id;
				$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
				$ordering   = $groupTable->getOrdering($id);
				$access     = $this->getTable()->getOrderingGroupByIdUser($this->_params['data']['cid'], $ordering);
				
				if ($access == false){
					$message = 'Bạn không có quyền cập nhật vị trí chức vụ này!';
					$this->goAction();
					
				}else{
					$flagAction = $this->getTable()->ordering($this->_params['data']);
					if ($flagAction == true){
						$message = 'Thứ tự sắp xếp phần tử đã được cập nhật thành công!';
					}
				}
			}
			$this->flashMessenger()->addMessage($message);
			$this->goAction();
		}
		
		public
		function deleteAction(){
			
			
			$message = 'Vui lòng chọn vào phần tử mà bạn muốn xóa!';
			if ($this->getRequest()->isPost()){
				$id         = $this->identity()->group_id;
				$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
				$ordering   = $groupTable->getOrdering($id);
				$access     = $this->getTable()->getOrderingGroupByIdUser($this->_params['data']['cid'], $ordering);
				if ($access == false){
					$message = 'Bạn không có quyền xóa chức vụ này!';
					$this->goAction();
				}else{
					$flagAction = $this->getTable()->deleteItem($this->_params['data'], array('task' => 'multi-delete'));
					if ($flagAction == true){
						$message = 'Các phần tử đã được xóa thành công!';
					}
				}
			}
			$this->flashMessenger()->addMessage($message);
			$this->goAction();
		}
		
		public
		function formAction(){
			
			$myForm                      = $this->getForm();
			$task                        = 'add-item';
			$this->_params['data']['id'] = $this->params('id');
			$id                          = $this->identity()->group_id;
			$groupTable                  = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering                    = $groupTable->getOrdering($id);
			
			if (!empty($this->_params['data']['id'])){
				$access = $this->getTable()->getOrderingGroupByIdUser([$this->_params['data']['id']], $ordering);
				if ($access == false){
					$message = 'Bạn không có quyền sửa người dùng này!';
					$this->flashMessenger()->addMessage($message);
					$this->goAction();
				}else{
					$item = $this->getTable()->getItem($this->_params['data']);
					if (!empty($item)){
						$myForm->setInputFilter(new \Admin\Form\UserFilter(array('id' => $this->_params['data']['id']), $ordering));
						$myForm->setData($item);
						$task = 'edit-item';
						if ($this->getRequest()->isPost()){
							$action = $this->_params['data']['action'];
							$myForm->setData($this->_params['data']);
							
							if ($myForm->isValid()){
								
								$this->_params['data'] = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
								if ($ordering == 4){
									$this->_params['data']['id_permission_nested'] = $this->identity()->id_permission_nested;
									$this->_params['data']['group']                = 5;
									$this->_params['data']['active_code']          = 1;
								}else{
									if ($ordering == 1){
										$this->_params['data']['id_permission_nested'] = 1;
										$this->_params['data']['group']                = 2;
										$this->_params['data']['active_code']          = 1;
									}else{
										if ($ordering == 2){
											$this->_params['data']['group']       = 3;
											$this->_params['data']['active_code'] = 1;
										}else{
											$this->_params['data']['active_code'] = 1;
										}
									}
								}
								$id = $this->getTable()->saveItem($this->_params['data'], array('task' => $task), $this->identity()->fullname);
								$this->flashMessenger()->addMessage('Dữ liệu đã được lưu thành công!');
								if ($action == 'save-close'){
									$this->goAction();
								}
								if ($action == 'save-new'){
									$this->goAction(array('action' => 'form'));
								}
								if ($action == 'save'){
									$this->goAction(array('action' => 'form', 'id' => $id));
								}
							}
						}
					}
					
				}
				
			}else{
				
				if ($this->getRequest()->isPost()){
					$action = $this->_params['data']['action'];
					$myForm->setData($this->_params['data']);
					
					if ($myForm->isValid()){
						$this->_params['data'] = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
						if ($ordering == 4){
							$this->_params['data']['id_permission_nested'] = $this->identity()->id_permission_nested;
							$this->_params['data']['group']                = 5;
							$this->_params['data']['active_code']          = 1;
						}else{
							if ($ordering == 1){
								$this->_params['data']['id_permission_nested'] = 1;
								$this->_params['data']['group']                = 2;
								$this->_params['data']['active_code']          = 1;
							}else{
								if ($ordering == 2){
									$this->_params['data']['group']       = 3;
									$this->_params['data']['active_code'] = 1;
								}else{
									if ($ordering == 3){
										$this->_params['data']['id_permission_nested'] = $this->_params['data']['nest'];
										$this->_params['data']['group']                = 4;
										$this->_params['data']['active_code']          = 1;
									}
								}
							}
						}
						$id = $this->getTable()->saveItem($this->_params['data'], array('task' => $task), $this->identity()->fullname);
						$this->flashMessenger()->addMessage('Dữ liệu đã được lưu thành công!');
						if ($action == 'save-close'){
							$this->goAction();
						}
						if ($action == 'save-new'){
							$this->goAction(array('action' => 'form'));
						}
						if ($action == 'save'){
							$this->goAction(array('action' => 'form', 'id' => $id));
						}
					}
					
				}
			}
			
			return new ViewModel(array('myForm' => $myForm, 'ordering' => $ordering));
		}
	}
