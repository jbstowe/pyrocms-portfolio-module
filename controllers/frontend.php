<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class Frontend extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('portfolio_m');
		$this->lang->load('sample');

		$this->template
			->append_css('module::sample.css')
			->append_css('module::frontend.css')
			->append_js('module::sample.js');
	}

	/**
	 * All items
	 */
	public function index()
	{
		// set the pagination limit
		// $limit = 5;
		
		// $items = $this->sample_m->limit($limit)
		// 	->offset($offset)
		// 	->get_all();
			
		// // we'll do a quick check here so we can tell tags whether there is data or not
		// $items_exist = count($items) > 0;

		// // we're using the pagination helper to do the pagination for us. Params are: (module/method, total count, limit, uri segment)
		// $pagination = create_pagination('sample', $this->sample_m->count_all(), $limit, 2);
		$projects = $this->portfolio_m->getAllProjects()->result();
		foreach($projects as $project){
			$project->categories = $this->portfolio_m->getProjectCategoryNames($project->id); 
		}

		$this->template
			->title($this->module_details['name'], 'Index')
			//->set('items', $items)
			//->set('items_exist', $items_exist)
			->set_layout('portfolio-layout.html')
			->set('projects', $projects)
			->build('frontend/projectsIndex');
	}

	public function project($id = 0){
		$project = $this->portfolio_m->getProject($id)->row();
		$categories = $this->portfolio_m->getProjectCategories($id)->result();

		$this->template
			->title($project->name)
			//->set('items', $items)
			//->set('items_exist', $items_exist)
			->set_layout('portfolio-layout.html')
			->set('project', $project)
			->build('frontend/singleProject');
	}

	// private getShortDescription($description ,$length){

	// }
}