<?php
	
	namespace Admin\Controller;
	
	use Zendvn\Controller\ActionController;
	use Zendvn\Paginator\Paginator as ZendvnPaginator;
	use Zend\Form\FormInterface;
	use Zend\Session\Container;
	use Zend\View\Model\ViewModel;
	
	class TimelineController extends ActionController{
		public function init(){
			
			// SESSION FILTER
			$ssFilter = new Container(__CLASS__);
			
			// PAGINATOR
			$this->_paginator['itemCountPerPage']  = 30;
			$this->_paginator['pageRange']         = 5;
			$this->_paginator['currentPageNumber'] = $this->params()->fromRoute('page', 1);
			$this->_params['paginator']            = $this->_paginator;
			
			// OPTIONS
			$this->_options['tableName'] = 'Admin\Model\TimeLineTable';
			$this->_options['formName']  = 'formCustomerHome';
			
			// DATA
			
			// DATA
			$this->_params['data']          = array_merge($this->getRequest()->getPost()->toArray(), $this->getRequest()
			                                                                                              ->getFiles()
			                                                                                              ->toArray());
			$this->_params['data']['id']    = $this->params('id');
			$this->_params['data']['nest']  = $this->params('nest');
			$this->_params['data']['topic'] = $this->params('topic');
		}
		
		public function goAction($actionInfo = null){
			
			$actionInfo['controller'] = !empty($actionInfo['controller']) ? $actionInfo['controller'] : $this->_params['controller'];
			$actionInfo['action']     = !empty($actionInfo['action']) ? $actionInfo['action'] : 'index';
			$actionInfo['id']         = !empty($actionInfo['id']) ? $actionInfo['id'] : null;
			return $this->redirect()
			            ->toRoute('home/default', array('controller' => $actionInfo['controller'], 'action' => $actionInfo['action'], 'id' => $actionInfo['id'], 'nest' => $actionInfo['nest'], 'id_book' => $actionInfo['id_book'],));
		}
		public function goActionAdmin($actionInfo = null){
			
			$actionInfo['controller'] = !empty($actionInfo['controller']) ? $actionInfo['controller'] : $this->_params['controller'];
			$actionInfo['action']     = !empty($actionInfo['action']) ? $actionInfo['action'] : 'index';
			$actionInfo['id']         = !empty($actionInfo['id']) ? $actionInfo['id'] : null;
			$actionInfo['topic']         = !empty($actionInfo['topic']) ? $actionInfo['topic'] : null;
			$actionInfo['nest']         = !empty($actionInfo['nest']) ? $actionInfo['nest'] : null;
			return $this->redirect()
			            ->toRoute('adminRoute/default', array('controller' => $actionInfo['controller'], 'action' => $actionInfo['action'], 'id' => $actionInfo['id'], 'nest' => $actionInfo['nest'], 'topic' => $actionInfo['topic'],));
		}
		
		public function viewAction(){
			$id         = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($id);
			
			$this->_params['data']['id'] = $this->params('id');
			
			if (!empty($this->_params['data']['id'])){
				$bookTable = $this->getServiceLocator()->get('Admin\Model\BookTable');
				$item      = $bookTable->getItem($this->_params['data']);
				$levelBook = $item->level;
				
				if ($ordering > $levelBook){
					$message = 'Bạn không có quyền truy cập vào tài liệu này!';
					$this->flashMessenger()->addMessage($message);
					$this->goAction();
				}else{
					return new ViewModel(array('items' => $item,));
				}
			}
		}
		
		public function submissionAction(){
			$id         = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($id);
			
			if ($this->params('nest')){
				$total = $this->getTable()->countItem($this->_params, array('task' => 'list-item-id'));
				$items = $this->getTable()->listItem($this->_params, array('task' => 'list-item-id'));
			}else{
				$this->_params['data']['id_permission_nested'] = $this->identity()->id_permission_nested;
				$this->_params['data']['id_user']              = $this->identity()->id;
				$total                                         = $this->getTable()->countItem($this->_params, array('task' => 'list-item'));
				$items                                         = $this->getTable()->listItem($this->_params, array('task' => 'list-item'));
			}
			return new ViewModel(array('items' => $items, 'paginator' => ZendvnPaginator::createPaginator($total, $this->_params['paginator']), 'ssFilter' => $this->_params['ssFilter'], 'id' => $this->params('id'), 'topic' => $this->params('topic'), 'nest' => $this->params('nest'), 'ordering' => $ordering));
		}
		
		public function calendarAction(){
			
			$this->_options['formName'] = 'formTimeline';
			$myForm                     = $this->getForm();
			if ($this->getRequest()->isPost()){
				$myForm->setData($this->_params['data']);
				$id = $this->params('id');
				if ($myForm->isValid()){
					$this->_params['data'] = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
					$this->getTable()->updateTimeline($this->_params['data']['time'], $id);
					$this->flashMessenger()->addMessage('Đã thay đổi lịch thành công!');
					$this->goActionAdmin(array('action' => 'submission', 'id' => $this->params('timeline'),'topic' => $this->params('topic'),'nest' => $this->params('nest')));
				}
				
			}
			return new ViewModel(array('myForm' => $myForm, 'topic' => $this->params('id')));
		}
		
		public function formAction(){
			
			$flag = $this->getTable()->getDeadline($this->params('id_timeline'));
			if ($flag == false){
				
				$message = 'Đã quá hạn nộp tài liệu bạn không có quyền truy cập vào chức năng này!';
				$this->flashMessenger()->addMessage($message);
				$this->goAction(array('action' => 'submission', 'id' => $this->params('id')));
			}
			
			
			$bookTable = $this->getServiceLocator()->get('Admin\Model\BookTable');
			
			//Kiểm người dùng đã đăng nhập chưa
			$loggedStatus = $this->identity() ? true : false;
			if ($loggedStatus == false){
				$this->goLogin();
			}
			
			// Lấy Level của tài liệu
			$group_id   = $this->identity()->group_id;
			$groupTable = $this->getServiceLocator()->get('Admin\Model\UserTable');
			$ordering   = $groupTable->getOrdering($group_id);
			
			//Khơi tạo Form
			$myForm = $this->getForm();
			$task   = 'add-item';
			
			if (!empty($this->params('id_book'))){
				
				$item = $bookTable->getItemUser($this->params('id_book'));
				
				if (!empty($item)){
					
					$myForm->setInputFilter(new \Admin\Form\IndexFilter(array('id' => $this->params('id_book'))));
					$myForm->bind($item);
					$task = 'edit-item';
				}
			}
			
			if ($this->getRequest()->isPost()){
				$myForm->setData($this->_params['data']);
				
				if ($myForm->isValid()){
					
					$this->_params['data']          = $myForm->getData(FormInterface::VALUES_AS_ARRAY);
					$this->_params['data']['level'] = $ordering;
					//Thiết lập gán họ tên người dùng
					$this->_params['data']['fullName'] = $this->identity()->fullname;
					//Thiết lập gán id người dùng
					$this->_params['data']['id_user'] = $this->identity()->id;
					// Gán nhóm tổ và nhóm bài tập
					$this->_params['data']['id_nest']     = $this->params('nest');
					$this->_params['data']['id_homework'] = $this->params('id');
					$arrayResult                          = $bookTable->saveItemByUser($this->_params['data'], array('task' => $task));
					$arrayResult[]                        = $this->identity()->id;
					if ($task == 'add-item'){
						$this->flashMessenger()->addMessage('Đã nộp giáo án thành công!');
					}else{
						$this->flashMessenger()->addMessage('Đã chỉnh giáo án thành công!');
					}
					
					$timeLineTable = $this->getServiceLocator()->get('Admin\Model\TimeLineTable');
					$timeLineTable->saveItemBook($this->params('id_timeline'), $arrayResult);
					$this->goAction(array('action' => 'submission', 'id' => $this->params('id')));
				}
			}
			
			return new ViewModel(array('myForm' => $myForm, 'id_homework' => $this->params('id'),));
		}
	}
