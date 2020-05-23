<?php
namespace Customer\Model;

use Zend\Db\Sql\Where;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;

class UserTable extends AbstractTableGateway {
	
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway) {
		$this->tableGateway	= $tableGateway;
	}
	
	public function getItem($arrParam = null, $options = null){
		
		if($options['task'] == 'user-register') {
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$select->columns(array('id', 'active_code', 'fullname', 'email'))
					   ->where->equalTo('id', $arrParam['id']);
			})->current();
		}
		
		if($options['task'] == 'store-user-info') {
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$select->columns(array('id', 'fullname', 'email', 'avatar', 'username', 'group_id', 'created','id_permission_nested'))
					   ->where->equalTo('id', $arrParam['id']);
			})->current();
		}
		
		if($options['task'] == 'user-active') {
			$result	= $this->tableGateway->select(function (Select $select) use ($arrParam){
				$select->where->equalTo('id', $arrParam['id'])
				       ->where->notEqualTo('active_code', 1)
				       ->where->equalTo('active_code', $arrParam['code']);
			})->count();
		}
	
		return $result;
	}
	
	public function saveItem($arrParam = null, $options = null){

		if($options['task'] == 'user-register') {
			
			$data	= array(
				'username'		=> $arrParam['username'],		
				'email'			=> $arrParam['email'],		
				'fullname'		=> $arrParam['fullname'],		
				'password'		=> md5($arrParam['password']),		
				'status'		=> 0,	
				'group_id'		=> 4,
				'register_time'	=> date('Y-m-d H:i:s'),	
				'register_ip'	=> $_SERVER['REMOTE_ADDR'],
				'active_code'	=> substr(md5(BOOKONLINE_KEY . time()), 8, 20),
			);

			$this->tableGateway->insert($data);
			return $this->tableGateway->getLastInsertValue();
		}
		
		if($options['task'] == 'user-active') {
			
			echo '<h3 style="color:red;font-weight:bold">' . __METHOD__ . '</h3>';
			$data	= array(
					'group_id'		=> 3,
					'status'		=> 1,
					'active_time'	=> date('Y-m-d H:i:s'),
					'active_code'	=> 1,
			);
			$this->tableGateway->update($data, array('id' => $arrParam['id'], 'active_code' => $arrParam['code']));
			
			return $this->tableGateway->getLastInsertValue();
		}
	}
}