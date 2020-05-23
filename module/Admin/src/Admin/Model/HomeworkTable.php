<?php
	
	namespace Admin\Model;
	
	use Zend\Db\Sql\Where;
	
	use Zend\Db\Sql\Select;
	use Zend\Db\TableGateway\TableGateway;
	use Zend\Db\TableGateway\AbstractTableGateway;
	
	class HomeworkTable extends AbstractTableGateway{
		
		protected $tableGateway;
		
		
		public function __construct(TableGateway $tableGateway){
			$this->tableGateway = $tableGateway;
		}
		
		public function itemInSelectbox($arrParam = null, $options = null){
			if ($options == null){
				$items  = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$select->columns(array('id', 'name'))
					       ->order('ordering DESC');
				});
				$result = array();
				if (!empty($items)){
					foreach ($items as $item){
						$result[$item->id] = $item->name;
					}
				}
			}
			if ($options['task'] == 'form-user'){
				$items  = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$select->columns(array('id', 'name'))
					       ->order('ordering DESC')
						->where->equalTo('status', 1);
				});
				$result = array();
				if (!empty($items)){
					foreach ($items as $item){
						$result[$item->id] = $item->name;
					}
				}
			}
			return $result;
		}
		
		
		public function countItem($arrParam = null, $options = null){
			if ($options['task'] == 'list-item'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$ssFilter = $arrParam['ssFilter'];
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('status', $status);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like($ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('name', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('id', $ssFilter['filter_keyword_value'])
								->UNNEST;
						}
					}
					$select->where->equalTo('nest_id', $arrParam['data']['nest_id']);
					
				})->count();
				
			}
			if ($options['task'] == 'list-item-id'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$ssFilter = $arrParam['ssFilter'];
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('status', $status);
					}
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like($ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('name', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('id', $ssFilter['filter_keyword_value'])
								->UNNEST;
						}
					}
					$select->where->equalTo('nest_id', $arrParam['data']['id']);
				})->count();
				
			}
			return $result;
		}
		
		public function listItem($arrParam = null, $options = null){
			
			if ($options['task'] == 'list-item'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$paginator = $arrParam['paginator'];
					$ssFilter  = $arrParam['ssFilter'];
					
					$select->columns(array(
						                 'id', 'name', 'status', 'ordering', 'created', 'created_by', 'modified', 'modified_by', 'week', 'time', 'nest_id'
					                 ))
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					
					if (!empty($ssFilter['order_by']) && !empty($ssFilter['order'])){
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
					}
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('status', $status);
					}
					
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like($ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('name', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('id', $ssFilter['filter_keyword_value'])
								->UNNEST;
						}
					}
					$select->where->equalTo('nest_id', $arrParam['data']['nest_id']);
					
				});
				
			}
			if ($options['task'] == 'list-item-id'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$paginator = $arrParam['paginator'];
					$ssFilter  = $arrParam['ssFilter'];
					
					$select->columns(array(
						                 'id', 'name', 'status', 'ordering', 'created', 'created_by', 'modified', 'modified_by', 'week', 'time', 'nest_id'
					                 ))
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					
					if (!empty($ssFilter['order_by']) && !empty($ssFilter['order'])){
						$select->order(array($ssFilter['order_by'] . ' ' . $ssFilter['order']));
					}
					
					if (!empty($ssFilter['filter_status'])){
						$status = ($ssFilter['filter_status'] == 'active') ? 1 : 0;
						$select->where->equalTo('status', $status);
					}
					
					
					if (!empty($ssFilter['filter_keyword_type']) && !empty($ssFilter['filter_keyword_value'])){
						if ($ssFilter['filter_keyword_type'] != 'all'){
							$select->where->like($ssFilter['filter_keyword_type'], '%' . $ssFilter['filter_keyword_value'] . '%');
						}else{
							$select->where->NEST
								->like('name', '%' . $ssFilter['filter_keyword_value'] . '%')
								->or
								->equalTo('id', $ssFilter['filter_keyword_value'])
								->UNNEST;
						}
					}
					$select->where->equalTo('nest_id', $arrParam['data']['id']);
					
				});
				
				
			}
			
			return $result;
		}
		
		public function listItemCustomer($arrParam = null, $options = null){
			
			if ($options['task'] == 'list-item'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$paginator = $arrParam['paginator'];
					$select->columns(array(
						                 'id', 'name', 'status', 'created', 'created_by', 'week', 'time', 'description'
					                 ))
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage'])
						->where->equalTo('nest_id', $arrParam['data']['nest_id']);
				});
				
			}
			
			return $result;
		}
		
		public function countItemCustomer($arrParam = null, $options = null){
			
			if ($options['task'] == 'list-item'){
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$select->where->equalTo('nest_id', $arrParam['data']['nest_id']);
				})->count();
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
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$select->columns(array('id', 'name', 'ordering', 'status', 'week', 'time'));
					$select->where->equalTo('id', $arrParam['id']);
				})->current();
			}
			
			return $result;
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
		
		public function deleteItem($arrParam = null, $options = null){
			
			if ($options['task'] == 'multi-delete'){
				if (!empty($arrParam['cid'])){
					$where = new Where();
					$where->in('id', $arrParam['cid']);
					$this->tableGateway->delete($where);
					return true;
				}
			}
			return false;
		}
		
		
		public function createDate($data, $i, &$dateArray, $week){
			$dateArray[$data] = date('Y-m-d', strtotime($data . ' + 7 days'));
			if ($i == $week){
				return $dateArray;
			}
			$i++;
			$this->createDate(date('Y-m-d', strtotime($data . ' + 7 days')), $i, $dateArray, $week);
			
		}
		
		public function saveItem($arrParam = null, $options = null){
			
			if ($options['task'] == 'add-item'){
				$data = array(
					'name'        => $arrParam['name'],
					'ordering'    => $arrParam['ordering'],
					'status'      => ($arrParam['status'] == 'active') ? 1 : 0,
					'created'     => date('Y-m-d H:i:s'),
					'time'        => $arrParam['time'],
					'week'        => $arrParam['week'],
					'description' => $arrParam['description'],
					'nest_id'     => $arrParam['id_permission_nested'],
					'created_by'  => $arrParam['created_by'],
				);
				
				$dateArray = [];
				$this->createDate(date('Y-m-d', strtotime($data['time'])), 1, $dateArray, $data['week']);
				$results = [];
				$this->tableGateway->insert($data);
				$results[] = $this->tableGateway->getLastInsertValue();
				$results[] = $dateArray;
				return $results;
			}
			if ($options['task'] == 'edit-item'){
				$data = array(
					'name'        => $arrParam['name'],
					'ordering'    => $arrParam['ordering'],
					'status'      => ($arrParam['status'] == 'active') ? 1 : 0,
					'modified'    => date('Y-m-d H:i:s'),
					'time'        => $arrParam['time'],
					'week'        => $arrParam['week'],
					'description' => $arrParam['description'],
					'nest_id'     => $arrParam['id_permission_nested'],
					'created_by'  => $arrParam['created_by'],
				);
				
				$this->tableGateway->update($data, array('id' => $arrParam['id']));
				return $arrParam['id'];
			}
		}
	}