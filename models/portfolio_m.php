<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class portfolio_m extends MY_Model {

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
	public function create($input, $upload)
	{
		$to_insert = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['slug']),
			'description' => $input['description'],
			'content' => $input['content'],
			'url' => $input['url'],
			'thumbnail_path' => $upload['data']['path'],
			'thumbnail_id' => $upload['data']['id']
		);

		//Insert Category relation
		foreach($input['categories'] as $category){
			$this->db->insert('default_portfolio_relation', array('project_slug' => $input['slug'], 'category_slug' => $category));
		}

		return $this->db->insert('default_portfolio_base', $to_insert);
	}

	public function updateProject($id, $input, $upload)
	{
		$to_update = array(
			'name' => $input['name'],
			'slug' => $this->_check_slug($input['slug']),
			'description' => $input['description'],
			'content' => $input['content'],
			'url' => $input['url'],
			'thumbnail_path' => $upload['data']['path'],
			'thumbnail_id' => $upload['data']['id']
		);

		//delete all category records
		$this->db->delete('default_portfolio_relation', array('project_slug' => $input['slug']));
		//read records from form
		foreach($input['categories'] as $category){
			$this->db->insert('default_portfolio_relation', array('project_slug' => $input['slug'], 'category_slug' => $category));
		}


		$this->db->where('id', $id);
		return $this->db->update('default_portfolio_base', $to_update);


	}

	public function getAllProjects(){
		return $this->db->get('default_portfolio_base');
	}

	public function getProject($id){
		return $this->db->get_where('default_portfolio_base', array('id' => $id));
	}

	public function getProjectThumbId($id){
		$this->db->select('thumbnail_id');
		return $this->db->get_where('default_portfolio_base', array('id' => $id))->row();
	}

	public function getProjectSlug($id){
		$this->db->select('slug');
		return $this->db->get_where('default_portfolio_base', array('id' => $id))->row();
	}

	public function getAllCategories(){
		return $this->db->get('default_portfolio_categories');
	}

	public function getProjectCategories($id){
		$slug = $this->getProjectSlug($id)->slug;
		return $this->db->get_where('default_portfolio_relation', array('project_slug' => $slug));
	}

	public function getProjectCategoryNames($id){
		$categories = array();

		$slug = $this->getProjectSlug($id)->slug;
		$category_slugs = $this->db->get_where('default_portfolio_relation', array('project_slug' => $slug))->result();
					//var_dump($category_slugs); die;
		foreach ($category_slugs as $slug) {
			$category = $this->db->get_where('default_portfolio_categories', array('slug' => $slug->category_slug))->result();
			array_push($categories, $category);
		}

		return $categories;
	}

	public function deleteProject($id){
		$project = $this->getProject($id)->row();
		if($this->deleteCategoryRelation($project->slug)){
			return $this->db->delete('default_portfolio_base', array('id' => $id));
		}else{
			return 'Error';
		}
		
	}

	public function deleteCategoryRelation($slug){
		return $this->db->delete('default_portfolio_relation', array('project_slug' => $slug)); 
	}

	//make sure the slug is valid
	public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);

		return $slug;
	}

}
