<?php
/*
Template Name: Job Seeker Template
*/
get_header();

$searchPage = get_page_by_title('Career Search');
?>

<div class="visual alt">
	<div class="bg-stretch">
        <?php if (has_post_thumbnail( get_the_ID() )) : ?>
        <?php echo preg_replace('#(width|height)=\"\d*\"\s#', "", wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'thumbnail_1440x525')); ?>
        <?php else: ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/img02.jpg" alt="image description" >
        <?php endif; ?>
    </div>
    <div class="text-box">
		<div class="container-fluid">
			<div class="container-hold">
				<div class="search-holder">
					<strong class="heading"><span>Submit your resume</span> &amp; we’ll notify you if a position matches your skills before they’re posted. </strong>
					<div class="visible-xs">
						<?php $submitResumePage = get_page_by_title('Submit Resume'); ?>
						<a class="btn btn-default" href="<?php echo get_permalink($submitResumePage); ?>" style="max-width:300px;margin-bottom:20px;"><span class="text"><span class="text-hold">Submit Resume</span></span><span class="icon icon-arrow-right"></span></a>
					</div>
					<div class="hidden-xs">
						<?php echo do_shortcode('[gravityform id="1" name="Sidebar Form" title="false" description="false" ajax="true"]'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $get_touch_title = get_field( 'get_touch_title',get_the_ID() ); ?>
<?php $get_touch_content = get_field( 'get_touch_content',get_the_ID() ); ?>
<?php $get_touch_button_label = get_field( 'get_touch_button_label',get_the_ID() ); ?>
<?php $link = get_field( 'get_touch_button_link',get_the_ID() ); ?>
<?php if ($get_touch_title || $get_touch_content || $get_touch_button_label) : ?>
<section class="intro text-center">
	<div class="container-fluid">
		<div class="container-hold">
			<?php if($get_touch_title) echo '<h1>' .$get_touch_title .'</h1>'; ?>
			<?php if ($get_touch_content) : ?>
            <div class="text-box">
				<?php echo $get_touch_content; ?>
			</div>
            <?php endif; ?>
            <?php if ($get_touch_button_label) : ?>
			<div class="btn-hold">
				<a href="<?php echo esc_url($link); ?>" class="btn btn-default btn-lg"><span class="text"><span class="text-hold"><?php echo $get_touch_button_label; ?></span></span><span class="icon icon-arrow-right"></span></a>
			</div>
            <?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php $bg_image = get_field( 'bg_image',get_the_ID() ); ?>
<?php $positions_title = get_field( 'positions_title',get_the_ID() ); ?>
<?php $positions_description = get_field( 'positions_description',get_the_ID() ); ?>

<section class="featured">
	<div class="bg-stretch">
    	<?php if ($bg_image) : ?>
        	<?php echo preg_replace('#(width|height)=\"\d*\"\s#', "", wp_get_attachment_image($bg_image, 'thumbnail_1440x500')); ?>
        <?php else: ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/img03.jpg" alt="image description" >
        <?php endif; ?>
	</div>
	<div class="container-fluid">
		<?php
		$job_ids = array();
		if(get_field('job_ids', 'option')) {
			while(has_sub_field('job_ids', 'option')) {
				$job_ids[] = get_sub_field('job_id');
			}
		}
		$featured_jobs = getFeaturedJobs($job_ids);
		?>
    	<?php if ($positions_title || $positions_description || have_rows( 'featured_positions' )) : ?>
		<div class="col-md-6">
			<div class="block">
				<div class="block-holder">
                	<?php if ($positions_title || $positions_description) : ?>
					<div class="head">
						<?php if($positions_title) echo '<h2>'. $positions_title .'</h2>'; ?>
						<?php echo $positions_description; ?>
					</div>
                    <?php endif; ?>
                    <?php if ($featured_jobs) : ?>
					<div class="row featured-holder">
                    	<?php foreach ($featured_jobs as $featured_job) : ?>
						<div class="col-sm-4 same-height">
							<a href="/<?php echo get_page_uri($searchPage); ?>/?job_id=<?php echo $featured_job['id']; ?>" class="box">
								<?php if($featured_job['jobtitle'] || $featured_job['orddesc']) echo '<strong class="heading">'. ($featured_job['jobtitle'] ? $featured_job['jobtitle'] : $featured_job['orddesc']) .'</strong>'; ?>
								<?php if ($featured_job['workstate'] && $featured_job['workstate']) : ?>
									<?php echo $featured_job['workcity']; ?>, <?php echo $featured_job['workstate']; ?>
								<?php elseif ($featured_job['workcity'] && ! $featured_job['workstate']) : ?>
									<?php echo $featured_job['workcity']; ?>
								<?php elseif ( ! $featured_job['workcity'] && $featured_job['workstate']) : ?>
									<?php echo $featured_job['workstate']; ?>
								<?php endif; ?>

							</a>
						</div>
                        <?php endforeach; ?>
					</div>
                    <?php endif; ?>
				</div>
			</div>
		</div>
        <?php endif; ?>
		<div class="col-md-6">
			<div class="block">
				<div class="block-holder">
					<div class="head">
						<h2>Find the career you’ve been looking for.</h2>
						<p>Use our job search and find the career that matches your skills.</p>
					</div>
					<?php print_job_search_form(); ?>
									</div>
									</div>
								</div>
									</div>
</section>
<?php $posts_title = get_field( 'posts_title',get_the_ID() ); ?>
<?php $cat_id = get_field( 'choose_category',get_the_ID() ); ?>
<?php $number_posts = get_field( 'number_posts',get_the_ID() ); ?>
<section class="about text-center">
	<div class="container-fluid">
		<div class="container-hold">
			<?php if($posts_title) echo '<h1>' .$posts_title. '</h1>'; ?>
            <?php if ($cat_id) : ?>
				<?php query_posts('cat='.$cat_id.'&showposts='.$number_posts); ?>
                <?php if (have_posts()) : ?>
                <div class="article-holder">
                    <div class="row">
                    	<?php while (have_posts()): the_post(); ?>
                        <div class="col-sm-4">
                            <article class="article">
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <?php theme_the_excerpt(); ?>
                                <div class="btn-hold">
                                    <a href="<?php the_permalink(); ?>" class="btn btn-info">Learn more</a>
                                </div>
                            </article>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
            <?php endif; ?>
            <?php echo do_shortcode(get_field( 'sign_up_form',get_the_ID() )); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
