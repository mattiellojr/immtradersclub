<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - MY Model
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2018, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 *
 * I decided it was important to have the ACL related 
 * methods here because then I can access them from any model.
 * This has been especially useful in websites I work on.
 */

class MY_Model extends CI_Model
{
	/**
	 * ACL for a logged in user
	 * @var mixed
	 */
	public $acl = NULL;

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	// -----------------------------------------------------------------------

	/**
	 * Get all of the ACL records for a specific user
	 */
	public function acl_query( $user_id, $called_during_auth = FALSE )
	{
		// ACL table query
		$query = $this->db->select('b.action_id, b.action_code, c.category_code')
			->from( $this->db_table('acl_table') . ' a' )
			->join( $this->db_table('acl_actions_table') . ' b', 'a.action_id = b.action_id' )
			->join( $this->db_table('acl_categories_table') . ' c', 'b.category_id = c.category_id' )
			->where( 'a.user_id', $user_id )
			->get();

		/**
		 * ACL becomes an array, even if there were no results.
		 * It is this change that indicates that the query was 
		 * actually performed.
		 */
		$acl = [];

		if( $query->num_rows() > 0 )
		{
			// Add each permission to the ACL array
			foreach( $query->result() as $row )
			{
				// Permission identified by category + "." + action code
				$acl[$row->action_id] = $row->category_code . '.' . $row->action_code;
			}
		}

		if( $called_during_auth OR $user_id == config_item('auth_user_id') )
			$this->acl = $acl;

		return $acl;
	}
	
	// -----------------------------------------------------------------------

	/**
	 * Check if ACL permits user to take action.
	 *
	 * @param  string  the concatenation of ACL category 
	 *                 and action codes, joined by a period.
	 * @return bool
	 */
	public function acl_permits( $str )
	{
		list( $category_code, $action_code ) = explode( '.', $str );

		// We must have a legit category and action to proceed
		if( strlen( $category_code ) < 1 OR strlen( $action_code ) < 1 )
			return FALSE;

		// Get ACL for this user if not already available
		if( is_null( $this->acl ) )
		{
			if( $this->acl = $this->acl_query( config_item('auth_user_id') ) )
			{
				$this->load->vars( ['acl' => $this->acl] );
				$this->config->set_item( 'acl', $this->acl );
			}
		}

		if( 
			// If ACL gives permission for entire category
			in_array( $category_code . '.*', $this->acl ) OR  
			in_array( $category_code . '.all', $this->acl ) OR 

			// If ACL gives permission for specific action
			in_array( $category_code . '.' . $action_code, $this->acl )
		)
		{
			return TRUE;
		}

		return FALSE;
	}
	
	// -----------------------------------------------------------------------

	/**
	 * Check if the logged in user is a certain role or 
	 * in a comma delimited string of roles.
	 *
	 * @param  string  the role to check, or a comma delimited
	 *                 string of roles to check.
	 * @return bool
	 */
	public function is_role( $role = '' )
	{
		$auth_role = config_item('auth_role');

		if( $role != '' && ! empty( $auth_role ) )
		{
			$role_array = explode( ',', $role );

			if( in_array( $auth_role, $role_array ) )
			{
				return TRUE;
			}
		}

		return FALSE;
	}

	// -----------------------------------------------------------------------

	/**
	 * Retrieve the true name of a database table.
	 *
	 * @param  string  the alias (common name) of the table
	 *
	 * @return  string  the true name (with CI prefix) of the table
	 */
	public function db_table( $name )
	{
		$name = config_item( $name );

		return $this->db->dbprefix( $name );
	}
	

	public function select($select = "*", $where = [], $join = [], $order_by = [], $limit = []) {
		$this->db->select($select)->from($this->tbl_name);
		if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		if($join !== null) {
			foreach ($join as $key => $value) {
				$this->db->join($key, $value, "left");
			}
		}
		if($order_by !== null) {
			foreach ($order_by as $key => $value) {
				$this->db->order_by($key, $value);
			}
		}
		if($limit !== null) {
			foreach ($limit as $key => $value) {
				$this->db->limit($key, $value);
			}
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function query($query = "") {
		$query = $this->db->query($query);
		return $query;
	}

	public function count_all($where = []) {
		if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		return $this->db->count_all($this->tbl_name);
	}


	public function count_ref($where = []) {

		if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}

			$query = $this->db->get($this->tbl_name);

		return $query->num_rows();


	}

	public function count_reff($where = []) {

		if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($value);
			}
		}

			$query = $this->db->get($this->tbl_name);

		return $query->num_rows();


	}

	public function insert($data = []) {
		$data = $this->trim($data);
		if($this->db->insert($this->tbl_name, $data)) {
			return true;
		}
		return false;
	}

	public function update($data, $where) {
		$data = $this->trim($data);
		$where = $this->trim($where);
		if($this->db->where($where)->update($this->tbl_name, $data)) {
			return true;
		}
		return false;
	}

	public function delete($data = []) {
		$data = $this->trim($data);
		if($this->db->delete($this->tbl_name, $data)) {
			return true;
		}
		return false;
	}

	public function empty_table() {
		if($this->db->empty_table($this->tbl_name)) {
			return true;
		}
		return false;
	}

	public function trim($data = []) {
		foreach ($data as $key => $value) {
			$value = trim($value);
			$value = strip_tags($value);
			$value = stripslashes($value);
			$data[$key] = $value;
		}
		return $data;
	}	

	public function fetch_record($limit, $start , $where  =[] ,$join , $wherejoin) {

	     //$this->db->limit($limit, $start);
	    // $where = $this->trim($where);
       $offset = $this->uri->segment(3);
		$this->db->limit($limit, $offset);

        $this->db->select('*');
		$this->db->from($this->tbl_name);
		if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		$this->db->join($join, $wherejoin);
		$query = $this->db->get();
        

        if ( $query->num_rows() > 0) {
            
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }

   public function fetch_all_record($limit, $start , $where  =[] ) {

	   
	  //  $where = $this->trim($where);
       	//$this->db->limit($limit, $start);
       //	$offset = $this->uri->segment(3);
		$this->db->limit($limit, $start);
        $this->db->select('*');
		$this->db->from($this->tbl_name);
		//$this->db->where($where);
		if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
	
		$query = $this->db->get();
       
        if ( $query->num_rows() > 0) {
            
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }

    public function record_count($where = []) {

    	$where = $this->trim($where);
        return $this->db->where($where)->count_all($this->tbl_name);
    }

    public function select_record($limit, $start,$select = "*", $where = [], $join = []) {
    	
		$this->db->select($select)->from($this->tbl_name);
		if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
		if($join !== null) {
			foreach ($join as $key => $value) {
				$this->db->join($key, $value, "left");
			}
		}

		$query = $this->db->get();
       
        if ( $query->num_rows() > 0) {
            
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

	}
	
	public function sum($column_name,  $where = []) {
	    $this->db->select_sum($column_name);
	   if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
	    $this->db->from($this->tbl_name);
	      
		return $this->db->get()->row($column_name);

	 }
	 public function select_data($column_name,  $where = []) {
	    $this->db->select($column_name);
	   if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
	    $this->db->from($this->tbl_name);
	      
		return $this->db->get()->row($column_name);

	 }

	 public function sum_record($column_name,$column_rt,  $where = []) {
	    $this->db->select_sum($column_name);
	    $this->db->select($column_rt);
	   if($where !== null) {
			foreach ($where as $key => $value) {
				$this->db->where($key, $value);
			}
		}
	    $this->db->from($this->tbl_name);
	      
		return array($this->db->get()->row($column_name),$this->db->get()->row($column_rt));

	 }

	// -----------------------------------------------------------------------
}

/* End of file MY_Model.php */
/* Location: /community_auth/core/MY_Model.php */