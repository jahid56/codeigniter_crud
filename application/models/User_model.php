<?php
/*
 * This file contains the Model.
 * 
 * @php version 5.6
 * @author Jahid Mahmud
 */
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public $_table;
    public $_primary_key;

    function __construct() {
        parent::__construct();
        $this->_table = 'user';
        $this->_primary_key = 'user_id';
    }

    // insert new record 
    public function create($data) {
        $this->db->insert($this->_table, $data);
        return $this->db->affected_rows();
    }

    // get the information based on filtaring
    public function getAll($count = false, $params = array(), $num = null, $offset = null) {
        $this->db->select('*')->from($this->_table);
        if (count($params)) {
            $this->db->where($params);
        }
        if ($num) {
            $this->db->limit($num, $offset);
        }
        $this->db->order_by($this->_primary_key, 'ASC');
        if ($count) {
            return $this->db->count_all_results();
        } else {
            $query = $this->db->get();
            return $query->result();
        }
    }

    //get single data
    public function get_single_data($id) {
        $this->db->select('*')->from($this->_table)->where($this->_primary_key, $id);
        $query = $this->db->get();
        return $query->row();
    }

    // update the information
    public function update($data, $id) {
        if ($this->db->update($this->_table, $data, "user_id = " . $id))
            return TRUE;
        else
            return FALSE;
    }

    // delete the information
    public function delete($user_id = 0) {
        $this->db->delete($this->_table, array($this->_primary_key => $user_id));
        return $this->db->affected_rows();
    }

}

/* End of file user_model.php */
/* Location: ./application/model/user_model.php */