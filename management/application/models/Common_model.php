<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    /* <!--INSERT RECORD FROM SINGLE TABLE--> */

    function insertData($table, $dataInsert) {
        $this->db->insert($table, $dataInsert);
        return $this->db->insert_id();
    }

    /* <!--INSERT MUTLIPLE RECORDS--> */

    function insertBatch($table, $dataInsert) {
        $this->db->insert_batch($table, $dataInsert);
        return true; 
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

    /* ---GET ALL RECORDS LIKE--- */
    public function getLikeData($rowno,$rowperpage,$search="",$tableName) {
        $this->db->select('*');
        $this->db->from($tableName);
        if($search != ''){
            if($tableName == SCHOOL){
                $this->db->like('registration_id', $search);
                $this->db->or_like('name', $search);
                $this->db->or_like('email', $search);
                $this->db->or_like('students', $search);
                $this->db->or_like('contact_no', $search);
                $this->db->or_like('address', $search);
            }else{
                $this->db->like('name', $search);
                $this->db->or_like('duration', $search);
                $this->db->or_like('price', $search);
            }
        }
        $this->db->order_by('id','DESC');
        $this->db->limit($rowperpage, $rowno);  
        $query = $this->db->get();
        
        return $query->result_array();
    }


    /* ---GET ALL RECORDS LIKE COUNT--- */
    public function getrecordCount($search = '',$tableName) {
        $this->db->select('count(*) as allcount');
        $this->db->from($tableName);
        if($search != ''){
            if($tableName == SCHOOL){
                $this->db->like('registration_id', $search);
                $this->db->or_like('name', $search);
                $this->db->or_like('email', $search);
                $this->db->or_like('students', $search);
                $this->db->or_like('contact_no', $search);
                $this->db->or_like('address', $search);
            }else{
                $this->db->like('name', $search);
                $this->db->or_like('duration', $search);
                $this->db->or_like('price', $search);
            }
        }
        $query = $this->db->get();
        $this->db->order_by('id','DESC');
        $result = $query->result_array();
      
        return $result[0]['allcount'];
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
}