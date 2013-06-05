<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Portfolio extends Module {

	public $version = '2.1';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Portfolio'
			),
			'description' => array(
				'en' => 'Portfolio Module'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'skip_xss' => 1,
			'menu' => 'content', // You can also place modules in their top level menu. For example try: 'menu' => 'Sample',
			'sections' => array(
				'projects' => array(
					'name' 	=> 'sample:projects', // These are translated from your language file
					'uri' 	=> 'admin/portfolio',
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'sample:create',
								'uri' 	=> 'admin/portfolio/create',
								'class' => 'add'
								)
							)
						),
				'categories' => array(
					'name' 	=> 'sample:categories', // These are translated from your language file
					'uri' 	=> 'admin/portfolio/categories',
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'sample:create',
								'uri' 	=> 'admin/portfolio/categories/create',
								'class' => 'add'
								)
							)
						),
				)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('portfolio_base');
		$this->dbforge->drop_table('portfolio_categories');
		$this->dbforge->drop_table('portfolio_relation');
		$this->db->delete('settings', array('module' => 'sample'));

		$portfolio_base = array(
                        'id' => array(
									  'type' => 'INT',
									  'constraint' => '11',
									  'auto_increment' => TRUE
									  ),
                        'slug' => array(
										'type' => 'VARCHAR',
										'constraint' => '100',
										'unique' => true
										),
						'name' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
						'content' => array(
										'type' => 'TEXT',
										'constraint' => '65535'
										),
						'description' => array(
										'type' => 'TEXT',
										'constraint' => '1000'
										),
						'url' => array(
										'type' => 'VARCHAR',
										'constraint' => '100',
										'null' => TRUE,
										),
						'client' => array(
										'type' => 'VARCHAR',
										'constraint' => '100',
										'null' => TRUE,
										),
						'category_id' => array(
										'type' => 'VARCHAR',
										'constraint' => '100',
										'null' => TRUE,
										),
						'thumbnail_id' => array(
										'type' => 'VARCHAR',
										'constraint' => '100',
										'null' => TRUE,
										),
						'thumbnail_path' => array(
										'type' => 'VARCHAR',
										'constraint' => '200',
										'null' => TRUE,
										)
						);

		// $portfolio_categories = array(
		// 							'category_id' => array(
		// 								'type' => 'INT',
		// 								'constraint' => '11'
		// 								),
		// 							'category_title' => array(
		// 								'type' => 'VARCHAR',
		// 								'constraint' => '100'
		// 								)
		// 						);

		$sample_setting = array(
			'slug' => 'sample_setting',
			'title' => 'Sample Setting',
			'description' => 'A Yes or No option for the Sample module',
			'`default`' => '1',
			'`value`' => '1',
			'type' => 'select',
			'`options`' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'sample'
		);


		// Create the portfolio categories table.
		$this->install_tables(array(
			'portfolio_categories' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true, 'key' => true),
				'name' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true)
			)
		));

		// Create the portfolio categories table.
		$this->install_tables(array(
			'portfolio_relation' => array(
				'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
				'project_slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false,'key' => true),
				'category_slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false,'key' => true)
			)
		));


		$this->dbforge->add_field($portfolio_base);
		//$this->dbforge->add_field($portfolio_categories);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('category_id', TRUE);

		if($this->dbforge->create_table('portfolio_base') AND
		   $this->db->insert('settings', $sample_setting) AND
		   is_dir($this->upload_path.'sample') OR @mkdir($this->upload_path.'sample',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('portfolio_base');
		$this->dbforge->drop_table('portfolio_categories');
		$this->dbforge->drop_table('portfolio_relation');
		$this->db->delete('settings', array('module' => 'sample'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */
