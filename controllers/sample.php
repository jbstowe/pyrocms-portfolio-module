<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a sample module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Sample Module
 */
class Sample extends Public_Controller
{
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model('portfolio_m');
		$this->lang->load('sample');

		$this->template
			->append_css('module::sample.css')
			->append_js('module::sample.js');
	}

	/**
	 * All items
	 */
	public function index($id = 0)
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

		// $this->template
		// 	->title($this->module_details['name'], 'the rest of the page title')
		// 	->set('items', $items)
		// 	->set('items_exist', $items_exist)
		// 	->set('pagination', $pagination)
		// 	->build('index', $data);
		var_dump($id);
		echo 'public index page';
	}
}