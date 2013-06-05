<div class="full-content">
	<div class="content singleProject">
		<h1><?php echo $project->name; ?></h1>
		<p>
			<?php echo $project->content; ?>
		</p>
		<?php if(isset($project->url) && $project->url != ''){ ?>
			<a href="<?php echo $project->url; ?>" class="btn btn-success">Live Site</a>
		<?php } ?>
	</div>
</div>