<?php
defined('BASEPATH') OR exit ('No direct script access allowed');

/**
 * @description 공통 모델
 */
class Common_m extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @return board data insert
	 */
	public function insert($table, $data) {
		$this->db->trans_begin();
		$this->db->insert($table, $data);
		if ($this->db->trans_status() === false) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->trans_commit();
			return true;
		}
	}

	/**
	 * @return ikey
	 */
	public function insert_ikey($table, $data) {
		$this->db->insert($table, $data);
		
		return $this->db->insert_id();
	}

	/**
	 * @description common row update
	 */
	public function update($table, $ikey, $data) {
		$this->db->where('ikey', $ikey);

		if ($this->db->update($table, $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @description common row update2
	 */
	public function update2($table, $where, $data) {
		$this->db->where($where);

		if ($this->db->update($table, $data)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @description row delete(useyn)
	 */
	public function delete($table, $data) {
		if ($data['ikey'] != '') {
			$this->db->set('useyn', 'N');
			$this->db->set('mod_ikey', $data['mod_ikey']);
			$this->db->set('mod_ip', NULL);
			$this->db->set('mod_dt', 'NOW()', false);
			$this->db->where('ikey', $data['ikey']);

			if ($this->db->update($table)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * @description row delete(useyn)
	 */
	public function delete2($table, $data) {
		$this->db->set('useyn', 'N');
		$this->db->set('mod_ikey', $data['mod_ikey']);
		$this->db->set('mod_ip', NULL);
		$this->db->set('mod_dt', 'NOW()', false);
		$this->db->where('order_code', $data['order_code']);

		if ($this->db->update($table)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * @description 조건별 column 검색
	 */
	public function get_column($table, $ikey, $column) {
		$this->db->where('ikey', $ikey);

		$query = $this->db->get($table);
		return $query->row($column);
	}

	/**
	 * @description 조건별 column 검색
	 */
	public function get_column2($table, $data, $column) {
		$this->db->where($data);

		$query = $this->db->get($table);
		return $query->row($column);
	}

	/**
	 * @description search row count
	 */
	public function get_search_count($table, $data, $where) {
		$this->db->like($data);
		$this->db->where($where);

		return $this->db->count_all_results($table);
	}

	/**
	 * @description row count all
	 */
	public function get_count($table, $where) {
		$this->db->where($where);

		return $this->db->count_all_results($table);
	}

	/**
	 * @param limit, offset
	 * @description table search all
	 */
	public function get_list($table, $limit, $start, $where) {
		$this->db->order_by('reg_dt', 'desc');
		$this->db->limit($limit, $start);
		$this->db->where($where);

		$query = $this->db->get($table);
		return $query->result();
	}

	/**
	 * @param limit, offset, search parameter
	 * @description table search
	 */
	public function get_search_list($table, $limit, $start, $data, $where) {
		$this->db->order_by('reg_dt', 'desc');
		$this->db->like($data);
		$this->db->limit($limit, $start);
		$this->db->where($where);

		$query = $this->db->get($table);
		return $query->result();
	}

	/**
	 * @description 조건별 row
	 */
	public function get_row($table, $data) {
		$this->db->where($data);

		$query = $this->db->get($table);
		return $query->row();
	}

	/**
	 * @description 조건별 row
	 */
	public function get_row_sort($table, $sort) {
		$this->db->order_by($sort);

		$query = $this->db->get($table);
		return $query->row();
	}

	/**
	 * @description 조건별 row
	 */
	public function get_row2($table, $where, $sort) {
		$this->db->where($where);
		$this->db->order_by($sort);

		$query = $this->db->get($table);
		return $query->row();
	}

	/**
	 * @description 조건별 result
	 */
	public function get_result($table, $data) {
		$this->db->where($data);

		$query = $this->db->get($table);
		return $query->result();
	}

	/**
	 * @description real delete
	 */
	public function real_del($table, $where) {
        $this->db->trans_begin();
        $this->db->where($where);
        $this->db->delete($table);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

	/**
	 * @description 조건별 result
	 */
	public function get_result2($table, $data) {
		$this->db->where($data);
		$this->db->order_by('reg_dt desc');

		$query = $this->db->get($table);
		return $query->result();
	}

	/**
	 * @description 조건별 result
	 */
	public function get_result_sort($table, $data, $sort) {
		$this->db->where($data);
		$this->db->order_by($sort);

		$query = $this->db->get($table);
		return $query->result();
	}

	/**
	 * @description 조건별 result(limit)
	 */
	public function get_limit_result($start, $limit, $table, $data) {
		$this->db->where($data);
		$this->db->order_by('reg_dt desc');

		$query = $this->db->get($table, $limit, $start);
		return $query->result();
	}
}