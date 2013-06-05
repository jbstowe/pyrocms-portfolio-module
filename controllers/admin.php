<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'projects';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('portfolio_m');
		$this->load->library('form_validation');
		$this->load->library('files/files');

		$this->lang->load('sample');

		//Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'slug',
				'label' => 'Slug',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'url',
				'label' => 'Live URL',
				'rules' => 'trim|max_length[100]'
			),
			array(
				'field' => 'description',
				'label' => 'Description',
				'rules' => 'required'
			),
			array(
				'field' => 'content',
				'label' => 'Content',
				'rules' => 'required'
			),
			array(
				'field' => 'categories',
				'label' => 'Categories'
			)

		);

		// We'll set the partials and metadata here since they're used everywhere
		$this->template->append_js('module::admin.js')
		 			   ->append_css('module::admin.css');
	}

	/**
	 * List all items
	 */
	public function index()
	{
		$projects = $this->portfolio_m->getAllProjects();
		

		// Build the view with sample/views/admin/items.php
		$this->template->enable_parser(true);
		$this->template
			 //->title($this->module_details['name'])
			 ->set('projects', $projects)
		   	 ->build('admin/projects');
	}


	public function create()
	{
		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if ($this->form_validation->run())
		{
			$results = Files::upload($folder_id = 1);
			// See if the model can create the record
			if ($this->portfolio_m->create($this->input->post(), $results))
			{
				// All good...
				$this->session->set_flashdata('success', lang('sample.success'));
				redirect('admin/portfolio');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('sample.error'));
				redirect('admin/sample/create');
			}
		}
		
		$sample = new stdClass;
		
		foreach ($this->item_validation_rules as $rule)
		{
			$sample->{$rule['field']} = $this->input->post($rule['field']);
		}

		//Get categories to choose from
		$categories = $this->portfolio_m->getAllCategories();	
		$categoriesArray = array();
		foreach ($categories->result() as $category) {
			$categoriesArray[$category->slug] = $category->name;
		}
		$sample->categories = $categoriesArray;

		

		// Build the view using sample/views/admin/form.php
		$this->template->append_metadata($this->load->view('fragments/wysiwyg', array(), TRUE));
		$this->template
			->title($this->module_details['name'], lang('sample.new_item'))
			->set('sample', $sample)
			->build('admin/projects/form');
	}
	
	public function edit($id = 0)
	{
		$sample = new stdClass;
		$sample->project = $this->portfolio_m->getProject($id)->row();
		//$sample = $this->portfolio_m->getProject($id);

		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if ($this->form_validation->run())
		{
			// get rid of the btnAction item that tells us which button was clicked.
			// If we don't unset it MY_Model will try to insert it
			unset($_POST['btnAction']);
			
			//Delete Image
			Files::delete_file($this->portfolio_m->getProjectThumbId($id)->thumbnail_id);
			//Upload new image
			$upload = Files::upload($folder_id = 1);


			// See if the model can create the record
			if ($this->portfolio_m->updateProject($id, $this->input->post(), $upload))
			{
				// All good...
				$this->session->set_flashdata('success', 'Updated ' . $this->input->post('name'));
				redirect('admin/portfolio');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('sample.error'));
				redirect('admin/portfolio');
			}
		}

		//Get categories to choose from
		$categories = $this->portfolio_m->getAllCategories();	
		$categoriesArray = array();
		foreach ($categories->result() as $category) {
			$categoriesArray[$category->slug] = $category->name;
		}
		$sample->categories = $categoriesArray;

		//get categories the project belongs to
		$projectCategoriesArray = array();
		foreach ($this->portfolio_m->getProjectCategories($id)->result() as $category) {
			array_push($projectCategoriesArray, $category->category_slug);
		}
		$sample->projectCategories = $projectCategoriesArray;

		// Build the view using sample/views/admin/form.php
		$this->template->append_metadata($this->load->view('fragments/wysiwyg', array(), TRUE));
		$this->template->enable_parser(true);
		$this->template
			->title($this->module_details['name'], lang('sample.edit'))
			->set('sample', $sample)
			->build('admin/projects/form');
	}
	
	public function delete($id = 0)
	{
		//make sure the button was clicked and that there is an array of ids
		// if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		// {
		// 	//pass the ids and let MY_Model delete the items
		// 	$this->sample_m->delete_many($this->input->post('action_to'));
		// }
		//elseif (is_numeric($id))
		//{
			//they just clicked the link so we'll delete that one
			
			Files::delete_file($this->portfolio_m->getProjectThumbId($id)->thumbnail_id);
			$this->portfolio_m->deleteProject($id);
		//}
		redirect('admin/portfolio');
	}
		
}
