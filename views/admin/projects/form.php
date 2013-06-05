<section class="title">
	<!-- We'll use $this->method to switch between sample.create & sample.edit -->
	<h4><?php echo lang('sample:'.$this->method); ?></h4>
</section>
<section class="item">
	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('sample:name'); ?> <span>*</span></label>
				<?php if(isset($sample->project->name)){ ?>
					<div class="input"><?php echo form_input('name', set_value('name', $sample->project->name), 'class="width-15"'); ?></div>
				<?php }elseif(isset($name)){ ?>
					<div class="input"><?php echo form_input('name', set_value('name', $name), 'class="width-15"'); ?></div>					
				<?php }else{ ?>
					<div class="input"><?php echo form_input('name', set_value('name', ''), 'class="width-15"'); ?></div>
				<?php } ?>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo lang('sample:slug'); ?> <span>*</span></label>
				<?php if(isset($slug)){ ?>
				<div class="input"><?php echo form_input('slug', set_value('slug', $slug), 'class="width-15"'); ?></div>
				<?php }else{ ?>
				<div class="input"><?php echo form_input('slug', set_value('slug', ''), 'class="width-15"'); ?></div>				
				<?php } ?>
			</li>
			
			<li class="<?php echo alternator('', 'odd'); ?>">
				<label for="url"><?php echo 'Live URL' ?></label>
				<?php if(isset($sample->project->url)){ ?>
					<div class="input"><?php echo form_input('url', set_value('url', $sample->project->url), 'class="width-15"'); ?></div>
				<?php }elseif(isset($url)){ ?>
					<div class="input"><?php echo form_input('url', set_value('url', $url), 'class="width-15"'); ?></div>				
				<?php }else{ ?>
					<div class="input"><?php echo form_input('url', set_value('url', ''), 'class="width-15"'); ?></div>
				<?php } ?>
			</li>
			
			<li class="<?php echo alternator('', 'odd'); ?>">
				<label for="description"><?php echo 'Description' ?></label>
				<?php if(isset($sample->project->description)){ ?>
					<div class="input"><?php echo form_textarea('description', set_value('description', $sample->project->description), 'class="width-15"'); ?></div>
				<?php }elseif(isset($description)){ ?>
					<div class="input"><?php echo form_textarea('description', set_value('description', $description), 'class="width-15"'); ?></div>				
				<?php }else{ ?>
					<div class="input"><?php echo form_textarea('description', set_value('description', ''), 'class="width-15"'); ?></div>
				<?php } ?>
			</li>
			
			<li class="editor" style="height:500px;">
					<label for="body"><?php echo 'Content' ?> <span>*</span></label>	
	
					<div class="edit-content">
						<?php if(isset($sample->project->description)){ ?>
							<?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' => $sample->project->content, 'rows' => 30, 'class' => 'wysiwyg-advanced')) ?>
						<?php }elseif(isset($post->description)){ ?>
							<?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'value' => $post->content, 'rows' => 30, 'class' => 'wysiwyg-advanced')) ?>
						<?php }else{ ?>
							<?php echo form_textarea(array('id' => 'content', 'name' => 'content', 'rows' => 30, 'class' => 'wysiwyg-advanced')) ?>
						<?php } ?>
					</div>
			</li>
		
			<!-- Categories-->
			<li>
				<label for="Categories">Categories</label>
				
				<div class="input">
					<?php if(isset($sample->projectCategories)){ ?>
						<?php echo form_multiselect('categories[]', $sample->categories, $sample->projectCategories) ?>
					<?php }else{ ?>
						<?php echo form_multiselect('categories[]', $sample->categories, '') ?>
					<?php } ?>
				</div>
			</li>
			
			<li>
				<label for="Thumbnail">Project Thumbnail (300x300)</label>
				<?php if(isset($sample->project->thumbnail_path)){ ?>
					<br>
					<img src="<?php echo $sample->project->thumbnail_path ?>" alt="" width="100" height="100">
					<br>
				<?php } ?>
    			<input type="file" name="userfile" />
				
			</li>
		</ul>
		</div>
		
		<div class="buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>