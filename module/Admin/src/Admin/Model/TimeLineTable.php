<?php
	
	namespace Admin\Model;
	
	use Zend\Db\Sql\Select;
	use Zend\Db\Sql\Where;
	use Zend\Db\TableGateway\AbstractTableGateway;
	use Zend\Db\TableGateway\TableGateway;
	
	class TimeLineTable extends AbstractTableGateway{
		
		protected $tableGateway;
		
		public function __construct(TableGateway $tableGateway){
			$this->tableGateway = $tableGateway;
		}
		
		public function countItem($arrParam = null, $options = null){
			if ($options['task'] == 'list-item'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$select->where->equalTo('nest_id', $arrParam['data']['id_permission_nested'])
						->and->equalTo('id_user', $arrParam['data']['id_user']);
				})->count();
			}
			if ($options['task'] == 'list-item-id'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$select->where->equalTo('id_user', $arrParam['data']['id'])->and
						->equalTo('nest_id', $arrParam['data']['nest'])->and
						->equalTo('id_homework', $arrParam['data']['topic']);
				})->count();
			}
			return $result;
		}
		
		function check_in_range($start_date, $end_date, $date_from_user){
			// Convert to timestamp
			$start_ts = strtotime($start_date);
			$end_ts   = strtotime($end_date);
			$user_ts  = strtotime($date_from_user);
			
			// Check that user date is between start & end
			return ($user_ts <= $end_ts);
		}
		
		function updateTimeline($end_date, $id){
			$data  = array(
				'end_date' => $end_date
			);
			$where = new Where();
			$where->equalTo('id', $id);
			$this->tableGateway->update($data, $where);
			return true;
		}
		
		public function getDeadLine($id_nest = null, $options = null){
			
			if ($options == null){
				$result = $this->tableGateway->select(function (Select $select) use ($id_nest){
					$select->columns(array('start_date', 'end_date'));
					$select->where->equalTo('id', $id_nest);
				})->toArray();
			}
			
			
			date_default_timezone_set("Asia/Ho_Chi_Minh");
			foreach ($result as $key => $value){
				$start_date = trim($value['start_date']);
				$end_date   = trim($value['end_date']);
				
				$date_from_user = date("Y/m/d");
				
				$flag = $this->check_in_range($start_date, $end_date, $date_from_user);
			}
			
			return $flag;
		}
		
		public function listItem($arrParam = null, $options = null){
			
			if ($options['task'] == 'list-item'){
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$paginator = $arrParam['paginator'];
					$select->columns(array(
						                 'id', 'start_date', 'end_date', 'active', 'nest_id', 'id_homework', 'id_book', 'document',
					                 ))
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					$select->where->equalTo('id_homework', $arrParam['data']['id'])
						->and->equalTo('nest_id', $arrParam['data']['id_permission_nested'])
						->and->equalTo('id_user', $arrParam['data']['id_user']);
				});
			}
			if ($options['task'] == 'list-item-id'){
				
				$result = $this->tableGateway->select(function (Select $select) use ($arrParam){
					$paginator = $arrParam['paginator'];
					$select->columns(array(
						                 'id', 'start_date', 'end_date', 'active', 'nest_id', 'id_homework', 'id_book', 'document',
					                 ))
					       ->limit($paginator['itemCountPerPage'])
					       ->offset(($paginator['currentPageNumber'] - 1) * $paginator['itemCountPerPage']);
					$select->where->equalTo('id_user', $arrParam['data']['id'])->and
						->equalTo('nest_id', $arrParam['data']['nest'])->and
						->equalTo('id_homework', $arrParam['data']['topic']);
					
				});
				
			}
			
			return $result;
		}
		
		public function saveItemBook($id = null, $arrParam = null){
			$where = new Where();
			$where->equalTo('id', $id)->and->equalTo('id_user', $arrParam[2]);
			$data = array('active' => 1, 'id_book' => $arrParam[0], 'document' => $arrParam[1]);
			$this->tableGateway->update($data, $where);
			return true;
		}
		
		public function saveItem($arrParam = null, $options = null){
			
			
			if ($options['task'] == 'add-item'){
				$data = array(
					'start_date'  => $arrParam['start_date'],
					'end_date'    => $arrParam['end_date'],
					'nest_id'     => $arrParam['nest_id'],
					'active'      => 0,
					'id_homework' => $arrParam['id_homework'],
					'id_user'     => $arrParam['id_user'],
				);
				$this->tableGateway->insert($data);
				
				return $this->tableGateway->getLastInsertValue();
			}
			
			// if ($options['task'] == 'edit-item') {
			
			//     $data = array(
			//         'start_date'  => $arrParam['start_date'],
			//         'end_date'    => $arrParam['end_date'],
			//         'nest_id'     => $arrParam['nest_id'],
			//         'active'      => 0,
			//         'id_homework' => $arrParam['id_homework'],
			//     );
			
			//     $this->tableGateway->update($data, array('id' => $arrParam['id']));
			//     return $arrParam['id'];
			// }
		}
	}