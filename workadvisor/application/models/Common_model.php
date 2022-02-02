<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {
	
/*************************CheckUser*******************************/
public function checkUser($data = array()){
        $this->db->select('id');
        $this->db->from('tb_users');
        $this->db->where(array('type'=>$data['type'],'oauth_uid'=>$data['oauth_uid']));
        $query = $this->db->get();
        $check = $query->num_rows();
        if($check > 0){
            $result = $query->row_array();
            $data['modified'] = date("Y-m-d H:i:s");
            $update = $this->db->update('tb_users',$data,array('id'=>$result['id']));
            $userID = $result['id'];
        }else{
            $data['reg_date'] = date("Y-m-d H:i:s");
            $data['modified']= date("Y-m-d H:i:s");
            $insert = $this->db->insert('tb_users',$data);
            $userID = $this->db->insert_id();
        }

        return $userID?$userID:false;
    }
/*************************CheckUser*******************************/	
    /* <!--INSERT RECORD FROM SINGLE TABLE--> */

    function insertData($table, $dataInsert) {
        $this->db->insert($table, $dataInsert);
        return $this->db->insert_id();
    }

    /* <!--UPDATE RECORD FROM SINGLE TABLE--> */

    function updateFields($table, $data, $where) {
        $this->db->update($table, $data, $where);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }

    function deleteData($table,$where)
    {
        $this->db->where($where);
        $this->db->delete($table); 
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }   
    }
    
    /* ---GET SINGLE RECORD--- */
    function getsingle($table, $where = '', $fld = NULL, $order_by = '', $order = '') {

        if ($fld != NULL) {
            $this->db->select($fld);
        }
        $this->db->limit(1);

        if ($order_by != '') {
            $this->db->order_by($order_by, $order);
        }
        if ($where != '') {
            $this->db->where($where);
        }

        $q = $this->db->get($table);
        
        $num = $q->num_rows();
		// echo $this->db->last_query();
        if ($num > 0) {
            return $q->row();
        }
    }

    /* <!--Join tables get single record with using where condition--> */
    
    function GetJoinRecord($table, $field_first, $tablejointo, $field_second,$field_val='',$where="",$group_by='',$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first","inner");
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    /* <!--Join tables get single record with using where condition--> */
    
    function GetLeftJoinRecord($table, $field_first, $tablejointo, $field_second,$field_val='',$where="",$group_by='',$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first","left");
        if(!empty($where)){
            $this->db->where($where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    /* ---GET MULTIPLE RECORD--- */
    function getAllwhere($table, $where = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='',$and_where = '') {
		//$ret="Limit ".$limit." Offset ".$offset;
		//return $ret;
        $data = array();
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        }else{
            $this->db->select($select);
        }
        $this->db->from($table);
        if ($where != ''){
            $this->db->where($where);
        }
        if ($and_where != ''){
            $this->db->where($and_where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by); 
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }

        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    /* ---GET MULTIPLE RECORD--- */
    function getAll($table, $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        $data = array();
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        if($group_by !=''){
            $this->db->group_by($group_by);
        }
        $this->db->from($table);

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }


    /* <!--GET ALL COUNT FROM SINGLE TABLE--> */
    function getcount($table, $where="") {
        if(!empty($where)){
           $this->db->where($where);
        }
        $q = $this->db->count_all_results($table);
        return $q;
    }

    function getTotalsum($table, $where, $data) {
        $this->db->where($where);
        $this->db->select_sum($data);
        $q = $this->db->get($table);
        return $q->row();
    }

    
    function GetJoinRecordNew($table, $field_first, $tablejointo, $field_second, $field, $value, $field_val,$group_by='',$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        $this->db->select("$field_val");
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first");
        $this->db->where("$table.$field", "$value");
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    function GetJoinRecordThree($table, $field_first, $tablejointo, $field_second,$tablejointhree,$field_three,$table_four,$field_four,$field_val='',$where="" ,$group_by="",$order_fld='',$order_type='', $limit = '', $offset = '') {
        $data = array();
        if(!empty($field_val)){
            $this->db->select("$field_val");
        }else{
            $this->db->select("*");
        }
        $this->db->from("$table");
        $this->db->join("$tablejointo", "$tablejointo.$field_second = $table.$field_first",'inner');
        $this->db->join("$tablejointhree", "$tablejointhree.$field_three = $table_four.$field_four",'inner');
        if(!empty($where)){
            $this->db->where($where);
        }

        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }
        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
        
        if(!empty($order_fld) && !empty($order_type)){
            $this->db->order_by($order_fld, $order_type);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }

    function getAllwhereIn($table,$where = '',$column ='',$wherein = '', $order_fld = '', $order_type = '', $select = 'all', $limit = '', $offset = '',$group_by='') {
        $data = array();
        if ($order_fld != '' && $order_type != '') {
            $this->db->order_by($order_fld, $order_type);
        }
        if ($select == 'all') {
            $this->db->select('*');
        } else {
            $this->db->select($select);
        }
        $this->db->from($table);
        if ($where != '') {
            $this->db->where($where);
        }
        if ($wherein != '') {
            $this->db->where_in($column,$wherein);
        }
        if($group_by !=''){
            $this->db->group_by($group_by);
        }

        $clone_db = clone $this->db;
        $total_count = (int) $clone_db->get()->num_rows();

        if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }

        $q = $this->db->get();
        $num_rows = $q->num_rows();
        if ($num_rows > 0) {
            foreach ($q->result() as $rows) {
                $data[] = $rows;
            }
            $q->free_result();
        }
        return array('total_count' => $total_count,'result' => $data);
    }
/**************************** Custom - Query **************/
    public function custom_query($myquery){
        $query = $this->db->query($myquery);
        return $query->result_array();
    }
/****************************Join*By*Details**************/
public function get_two_table_data($data,$table1,$table2,$relation,$condition,$groupby,$order="",$by="",$limit="",$offset=""){
		 $this->db->select($data);
		$query=$this->db->from($table1);
		$this->db->join($table2, $relation , 'left');
		$query=$this->db->where($condition);
		
		if($order!="" && $by!=""){
		$this->db->order_by($order,$by);
		}
		if($groupby!=""){
		 $this->db->group_by($groupby);
        }
		if ($limit != '' && $offset != '') {
            $this->db->limit($limit, $offset);
        } else if ($limit != '') {
            $this->db->limit($limit);
        }
		
		$query=$this->db->get();
		return $query=$query->result_array();	
	}
/*******************************************/
public function getThreeTableData($data,$table1,$table2,$table3,$on,$on2,$condition,$groupby,$order,$by){
        $this->db->select($data);
		$this->db->from($table1);
		$this->db->join($table2,$on);
		$this->db->join($table3,$on2);
		$this->db->where($condition);
		if($groupby!=""){
		 	$this->db->group_by($groupby);
        }
		if($order!="" && $by!=""){
		$this->db->order_by($order,$by);
		}
		$query=$this->db->get();
		return $query->result_array();
    }
    
}