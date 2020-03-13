<?php
	
	namespace Admin\Model;
	
	use Zend\Db\Sql\Where;
	
	use Zendvn\File\Image;
	
	use PHPImageWorkshop\ImageWorkshop;
	
	use Zendvn\File\Upload;
	
	use Zend\Db\Sql\Select;
	use Zend\Db\TableGateway\TableGateway;
	use Zend\Db\TableGateway\AbstractTableGateway;
	
	class UserTable extends AbstractTableGateway{
		
		protected $tableGateway;
		
		public function __construct(TableGateway $tableGateway){
			$this->tableGateway = $tableGateway;
		}
		
		public function getArrayUser($arrParam = null){
			$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
				$select->columns(array('id'))
					->where->equalTo('id_permission_nested', $arrParam);
			})->toArray();
			return $result;
			
		}
		
		public function countItem($arrParam = null, $showByValue = null, $options = null){
			if ($options['task'] == 'list-item'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam, $showByValue){
					$ssFilter = $arrParam['ssFilter'];
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('user.status', $status);
					}
					
					if (!empty($ssFilter['filter_group'])){
						$select->where->equalTo('user.group_id', $ssFilter['filter_group']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like('user.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('username', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('user.id', $ssFilter['filter_keyword_value'])
								->or
								->like('email', '%' . $ssFilter['filter_keyword_value'] . '%')
								->UNNEST;
						}
					}
					$select->where->equalTo('user.group_id', $showByValue);
				})->count();
				
			}
			if ($options['task'] == 'list-item-school'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam, $showByValue){
					$ssFilter = $arrParam['ssFilter'];
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('user.status', $status);
					}
					
					if (!empty($ssFilter['filter_group'])){
						$select->where->equalTo('user.group_id', $ssFilter['filter_group']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like('user.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('username', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('user.id', $ssFilter['filter_keyword_value'])
								->or
								->like('email', '%' . $ssFilter['filter_keyword_value'] . '%')
								->UNNEST;
						}
					}
					$select->where->in('id_permission_nested', $showByValue);
				})->count();
				
			}
			if ($options['task'] == 'list-item-nest'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam, $showByValue){
					$ssFilter = $arrParam['ssFilter'];
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('user.status', $status);
					}
					
					if (!empty($ssFilter['filter_group'])){
						$select->where->equalTo('user.group_id', $ssFilter['filter_group']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like('user.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('username', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('user.id', $ssFilter['filter_keyword_value'])
								->or
								->like('email', '%' . $ssFilter['filter_keyword_value'] . '%')
								->UNNEST;
						}
					}
					$select->where->equalTo('id_permission_nested', $showByValue);
				})->count();
				
			}
			if ($options['task'] == 'node_id'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$ssFilter = $arrParam['ssFilter'];
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('user.status', $status);
					}
					
					if (!empty($ssFilter['filter_group'])){
						$select->where->equalTo('user.group_id', $ssFilter['filter_group']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like('user.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('username', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('user.id', $ssFilter['filter_keyword_value'])
								->or
								->like('email', '%' . $ssFilter['filter_keyword_value'] . '%')
								->UNNEST;
						}
					}
					$select->where->equalTo('id_permission_nested', $arrParam['data']['id']);
					
				})->count();
				
			}
			return $result;
		}
		
		
		public function listItem($arrParam = null, $showByValue = null, $options = null){
			
			if ($options['task'] == 'list-item'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam, $showByValue){
					$paginator = $arrParam['paginator'];
					$ssFilter  = $arrParam['ssFilter'];
					
					$select->columns(array(
						                 'id', 'username', 'email', 'status', 'ordering', 'avatar', 'created', 'created_by', 'fullname', 'modified', 'modified_by', 'id_permission_nested'
					                 ))
					       ->join(
						       array('g' => 'group'),
						       'user.group_id = g.id',
						       array('group_name' => 'name'),
						       $select::JOIN_LEFT
					       )
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					
					if (!empty($ssFilter['order_by']) && !empty($ssFilter['order'])){
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
					}
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('user.status', $status);
					}
					
					if (!empty($ssFilter['filter_group'])){
						$select->where->equalTo('user.group_id', $ssFilter['filter_group']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like('user.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('username', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('user.id', $ssFilter['filter_keyword_value'])
								->or
								->like('email', '%' . $ssFilter['filter_keyword_value'] . '%')
								->UNNEST;
						}
					}
					$select->where->equalTo('user.group_id', $showByValue);
				});
				
				
			}
			if ($options['task'] == 'list-item-school'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam, $showByValue){
					$paginator = $arrParam['paginator'];
					$ssFilter  = $arrParam['ssFilter'];
					
					$select->columns(array(
						                 'id', 'username', 'email', 'status', 'ordering', 'avatar', 'created', 'created_by', 'fullname', 'modified', 'modified_by', 'id_permission_nested'
					                 ))
					       ->join(
						       array('g' => 'group'),
						       'user.group_id = g.id',
						       array('group_name' => 'name'),
						       $select::JOIN_LEFT
					       )
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					
					if (!empty($ssFilter['order_by']) && !empty($ssFilter['order'])){
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
					}
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('user.status', $status);
					}
					
					if (!empty($ssFilter['filter_group'])){
						$select->where->equalTo('user.group_id', $ssFilter['filter_group']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like('user.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('username', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('user.id', $ssFilter['filter_keyword_value'])
								->or
								->like('email', '%' . $ssFilter['filter_keyword_value'] . '%')
								->UNNEST;
						}
					}
					$select->where->in('id_permission_nested', $showByValue);
				});
				
				
			}
			if ($options['task'] == 'list-item-nest'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam, $showByValue){
					$paginator = $arrParam['paginator'];
					$ssFilter  = $arrParam['ssFilter'];
					
					$select->columns(array(
						                 'id', 'username', 'email', 'status', 'ordering', 'avatar', 'created', 'created_by', 'fullname', 'modified', 'modified_by', 'id_permission_nested'
					                 ))
					       ->join(
						       array('g' => 'group'),
						       'user.group_id = g.id',
						       array('group_name' => 'name'),
						       $select::JOIN_LEFT
					       )
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					
					if (!empty($ssFilter['order_by']) && !empty($ssFilter['order'])){
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
					}
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('user.status', $status);
					}
					
					if (!empty($ssFilter['filter_group'])){
						$select->where->equalTo('user.group_id', $ssFilter['filter_group']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like('user.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('username', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('user.id', $ssFilter['filter_keyword_value'])
								->or
								->like('email', '%' . $ssFilter['filter_keyword_value'] . '%')
								->UNNEST;
						}
					}
					$select->where->equalTo('id_permission_nested', $showByValue);
				});
				
				
			}
			if ($options['task'] == 'node_id'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$paginator = $arrParam['paginator'];
					$ssFilter  = $arrParam['ssFilter'];
					
					$select->columns(array(
						                 'id', 'username', 'email', 'status', 'ordering', 'avatar', 'created', 'created_by', 'fullname', 'modified', 'modified_by', 'id_permission_nested'
					                 ))
					       ->join(
						       array('g' => 'group'),
						       'user.group_id = g.id',
						       array('group_name' => 'name'),
						       $select::JOIN_LEFT
					       )
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					
					if (!empty($ssFilter['order_by']) && !empty($ssFilter['order'])){
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
					}
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('user.status', $status);
					}
					
					if (!empty($ssFilter['filter_group'])){
						$select->where->equalTo('user.group_id', $ssFilter['filter_group']);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like('user.' . $ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('username', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('user.id', $ssFilter['filter_keyword_value'])
								->or
								->like('email', '%' . $ssFilter['filter_keyword_value'] . '%')
								->UNNEST;
						}
					}
					$select->where->equalTo('id_permission_nested', $arrParam['data']['id']);
				});
				
				
			}
			
			return $result;
		}
		
		public function changeStatus($arrParam = null, $options = null){
			if ($options['task'] == 'change-status'){
				if ($arrParam['status_id'] > 0){
					$data  = array('status' => ($arrParam['status_value'] == 1) ? 0 : 1);
					$where = array('id' => $arrParam['status_id']);
					$this->tableGateway->update($data, $where);
					return true;
				}
			}
			
			if ($options['task'] == 'change-multi-status'){
				if (!empty($arrParam['cid'])){
					$data  = array('status' => $arrParam['status_value']);
					$cid   = implode(',', $arrParam['cid']);
					$where = array('id IN (' . $cid . ')');
					$this->tableGateway->update($data, $where);
					return true;
				}
			}
			
			return false;
		}
		
		public function getItem($arrParam = null, $options = null){
			
			if ($options == null){
				$dbAdapter = $this->tableGateway->getAdapter();
				
				$stmt = $dbAdapter->createStatement();
				$stmt->prepare('CALL getUserById(' . $arrParam['id'] . ')');
				$result = $stmt->execute();
				$output = $result->current();
			}
			return $output;
		}
		
		
		public function ordering($arrParam = null, $options = null){
			
			if ($options == null){
				if (!empty($arrParam['cid'])){
					foreach ($arrParam['cid'] as $id){
						$data  = array('ordering' => $arrParam['ordering'][$id]);
						$where = array('id' => $id);
						$this->tableGateway->update($data, $where);
					}
					return true;
				}
			}
			
			return false;
			
		}
		
		public function getOrdering($arrParam = null, $options = null){
			$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
				$select->columns([])
				       ->join(
					       array('g' => 'group'),
					       'user.group_id = g.id',
					       array('ordering_group' => 'ordering'),
					       $select::JOIN_RIGHT
				       )->where->equalTo('user.group_id', $arrParam);
			})->current();
			
			return $result->ordering_group;
			
		}
		
		public function getOrderingGroupByIdUser($arrParam = null, $ordering = null){
			$result = $this->tableGateway->select(function (Select $select) use ($arrParam, $ordering){
				$select->columns([])
				       ->join(
					       array('g' => 'group'),
					       'user.group_id = g.id',
					       array('ordering_group' => 'ordering'),
					       $select::JOIN_RIGHT
				       )->where->in('user.id', $arrParam);
			})->toArray();
			
			foreach ($result as $key => $value){
				if ($value['ordering_group'] < $ordering){
					return false;
					break;
				}
			}
			return true;
			
		}
		
		public function deleteItem($arrParam = null, $options = null){
			
			if ($options['task'] == 'multi-delete'){
				if (!empty($arrParam['cid'])){
					$items  = $this->listItem($arrParam['cid'], array('task' => 'list-avatar'));
					$imgObj = new Image();
					foreach ($items as $item){
						if (!empty($item['avatar'])){
							$imgObj->removeImage($item['avatar'], array('task' => 'user-avatar'));
						}
					}
					
					$where = new Where();
					$where->in('id', $arrParam['cid']);
					$this->tableGateway->delete($where);
					
					return true;
				}
			}
			return false;
		}
		
		public function saveItem($arrParam = null, $options = null, $name){
			
			if ($options['task'] == 'add-item'){
				
				$data = array(
					'username'             => $arrParam['username'],
					'email'                => $arrParam['email'],
					'password'             => md5($arrParam['password']),
					'fullname'             => $arrParam['fullname'],
					'group_id'             => $arrParam['group'],
					'active_code'          => $arrParam['active_code'],
					'id_permission_nested' => $arrParam['id_permission_nested'],
					'ordering'             => $arrParam['ordering'],
					'status'               => ($arrParam['status'] == 'active') ? 1 : 0,
					'created'              => date('Y-m-d H:i:s'),
					'created_by'           => $name
				);
				
				if (!empty($arrParam['file']['tmp_name'])){
					$imageObj       = new Image();
					$data['avatar'] = $imageObj->upload('file', array('task' => 'user-avatar'));
				}
				
				if (!empty($arrParam['sign'])){
					$config = array(
						array('HTML.AllowedElements', 'p,s,u,em,strong,span'),
						array('HTML.AllowedAttributes', 'style'),
					);
					
					$filter       = new \Zendvn\Filter\Purifier($config);
					$data['sign'] = $filter->filter($arrParam['sign']);
				}
				
				$this->tableGateway->insert($data);
				return $this->tableGateway->getLastInsertValue();
			}
			if ($options['task'] == 'edit-item'){
				
				$data = array(
					'username'    => $arrParam['username'],
					'email'       => $arrParam['email'],
					'fullname'    => $arrParam['fullname'],
					'group_id'    => $arrParam['group'],
					'ordering'    => $arrParam['ordering'],
					'status'      => ($arrParam['status'] == 'active') ? 1 : 0,
					'modified'    => date('Y-m-d H:i:s'),
					'modified_by' => $name
				);
				
				if (!empty($arrParam['password'])){
					$data['password'] = md5($arrParam['password']);
				}
				
				if (!empty($arrParam['sign'])){
					$config = array(
						array('HTML.AllowedElements', 'p,s,u,em,strong,span'),
						array('HTML.AllowedAttributes', 'style'),
					);
					
					$filter       = new \Zendvn\Filter\Purifier($config);
					$data['sign'] = $filter->filter($arrParam['sign']);
				}
				
				if (!empty($arrParam['file']['tmp_name'])){
					$imageObj       = new Image();
					$data['avatar'] = $imageObj->upload('file', array('task' => 'user-avatar'));
					$imageObj->removeImage($arrParam['avatar'], array('task' => 'user-avatar'));
				}
				// AbcD123@#$
				$this->tableGateway->update($data, array('id' => $arrParam['id']));
				return $arrParam['id'];
			}
		}
	}