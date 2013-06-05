<section class="title">
	<h4>Projects</h4>
</section>

<section class="item">
	
	<?php if (!empty($projects)): ?>
		<?php echo form_open('admin/portfolio/delete') ?>
		<table>
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th>Thumbnail</th>
					<th><?php echo lang('sample:name'); ?></th>
					<th><?php echo lang('sample:slug'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="4">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $projects->result() as $project ): ?>
				<tr>
					<td>
						<?php echo anchor('admin/portfolio/delete/'.$project->id,    lang('sample:delete'), 'class="button"'); ?>
						<?php echo anchor('admin/portfolio/edit/'.$project->id,    lang('sample:edit'), 'class="button"'); ?>	
					</td>
					<td><img src="<?php echo $project->thumbnail_path; ?>" alt="" width="100"></td>
					<td><?php echo $project->name; ?></td>
					<td><?php echo $project->slug; ?></td>			
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('edit'))); ?>
		</div>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('sample:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
</section>