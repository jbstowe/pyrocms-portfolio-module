<div class="full-content">
	<div class="content projectsIndex">
		<?php foreach($projects as $project) { ?>
			<div class="project clearfix">
				<img src="<?php echo $project->thumbnail_path ?>" alt="" width="250">
				<h1><?php echo $project->name; ?></h1>
				<p><?php echo $project->description ?></p>
				<a href="portfolio/<?php echo $project->id ?>" class="btn btn-info">Read More</a>
				<?php foreach($project->categories as $category){ ?>
					<?php echo $category[0]->name; ?>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</div>