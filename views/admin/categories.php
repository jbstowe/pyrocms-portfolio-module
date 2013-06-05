<section class="title">
	<h4>Categories</h4>
</section>

<section class="item">
	
	<?php if (!empty($categories)): ?>
		<?php echo form_open('admin/portfolio/categories/delete') ?>
		<table>
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th><?php echo lang('sample:name'); ?></th>
					<th><?php echo lang('sample:slug'); ?></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="3">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $categories->result() as $category ): ?>
				<tr>
					<td><?php echo anchor('admin/portfolio/categories/delete/'.$category->id,    lang('sample:delete'), 'class="button"'); ?></td>
					<td><?php echo $category->name; ?></td>
					<td><?php echo $category->slug; ?></td>			
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('sample:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
</section>