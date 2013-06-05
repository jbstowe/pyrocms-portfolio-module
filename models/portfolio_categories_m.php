<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class portfolio_categories_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		/**
		 * If the sample module's table was named "samples"
		 * then MY_Model would find it automatically. Since
		 * I named it "sample" then we just set the name here.
		 */
		$this->_table = 'portfolio_base';
	}
	
	//create a new item
	public function create($input)
	{
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['slug'])
		);

		return $this->db->insert('default_portfolio_categories', $to_insert);
	}

	public function get_all_categories()
	{
		return $this->db->get('default_portfolio_categories');
	}

	public function get_category($id)
	{
		return $this->db->get_where('default_portfolio_categories', array('id' => $id));
	}

	public function delete($id)
	{
		return $this->db->delete('default_portfolio_categories', array('id' => $id));
		
	}

	//make sure the slug is valid
	public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);

		return $slug;
	}

}
