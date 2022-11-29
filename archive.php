<?php get_header(); ?>

<!-- banner -->
<div class="visual alt">
	<div class="bg-stretch">
		<?php if (has_post_thumbnail( get_the_ID() )) : ?>
			<?php echo preg_replace('#(width|height)=\"\d*\"\s#', "", wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'thumbnail_1440x525')); ?>
		<?php else: ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/bg_page.jpg" alt="image description" >
		<?php endif; ?>
	</div>
	<?php if( get_field('header_text') || get_field('display_form_or_header_text_in_header') == 'form' ) : ?>
	<div class="text-box">
		<div class="container-fluid">
			<div class="container-hold">

				<?php
				if(get_field('display_form_or_header_text_in_header') == 'form') {
				?>

				<div class="search-holder">
					<?php
						$searchPage = get_page_by_title('Career Search');
					?>
					<form action="/<?php echo get_page_uri($searchPage); ?>/" method="get" class="search-form">
						<fieldset>
							<div class="head">
								<h2 class="heading"><span>Use our job search</span> to find the career you've been looking for.</h2>
							</div>
							<div class="visible-xs">
								<?php $searchPage = get_page_by_title('Career Search'); ?>
								<a class="btn btn-default" href="<?php echo get_permalink($searchPage); ?>" style="max-width:300px;margin-bottom:20px;"><span class="text"><span class="text-hold">Search Openings</span></span><span class="icon icon-arrow-right"></span></a>
							</div>
							<div class="row hidden-xs">
								<div class="col-sm-6">
									<div class="form-group">
										<!--<select name="keywords[]" id="keywords" class="form-control">
                          <?php $jobKeywords = getJobKeywords(); ?>
                          <?php foreach ($jobKeywords as $jobKeyword) : ?>
                            <option value="<?php echo trim($jobKeyword['CODE']); ?>" ><?php echo $jobKeyword['LABEL'] . ($jobKeyword['LABEL'] == 'All' ? ' Keywords' : null); ?></option>
                          <?php endforeach; ?>
                        </select>-->
										<input type="text" name="keywords[]" id="keywords-header" class="form-control" placeholder="Search">
									</div>
									<!--<div class="form-group advanced-fields">-->
									<div class="form-group">
										<select name="categories[]" id="categories" class="form-control">
											<?php $jobCategories = getJobCategories(); ?>
											<?php foreach ($jobCategories as $jobCategory) : ?>
												<option value="<?php echo trim($jobCategory['CODE']); ?>" ><?php echo $jobCategory['LABEL']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group">
										<select name="locations[]" id="locations" class="form-control">
											<option value="">Location</option>
											<?php $jobLocations = getJobLocations(); ?>
											<?php foreach ($jobLocations as $jobLocation) : ?>
												<option value="<?php echo trim($jobLocation['CODE']); ?>" ><?php echo $jobLocation['LABEL']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<!--<div class="form-group advanced-fields">-->
									<div class="form-group">
										<select name="types[]" id="types" class="form-control">
											<?php $jobTypes = getJobTypes(); ?>
											<?php foreach ($jobTypes as $jobType) : ?>
												<option value="<?php echo trim($jobType['CODE']); ?>" ><?php echo $jobType['LABEL'] . ($jobType['LABEL'] == 'All' ? ' Types' : null); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
							<div class="row hidden-xs">
								<div class="col-sm-6">
									<!--<a href="#" class="advanced-toggle" style="color: white;">Toggle Advanced Options</a>-->
								</div>
								<div class="col-sm-6">
									<button class="btn btn-default"><span class="text"><span class="text-hold">Search openings</span></span><span class="icon icon-arrow-right"></span></button>
								</div>
							</div>
						</fieldset>
					</form>

					<?php
					}
					else {
					?>
					<div class="search-holder page-layout">
						<strong class="heading"><?php the_field('header_text'); ?></strong>
						<?php
						}
						?>

					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<!-- content -->
	<div class="two-columns">
		<div class="container">
			<div class="row">
				<?php get_sidebar(); ?>
				<div class="col-xs-12 col-md-8">
					<div id="content">
						<div <?php post_class(); ?>>
							<div class="title">
								<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
								<?php /* If this is a category archive */ if (is_category()) { ?>
									<h1><?php printf(__( 'Archive for the &#8216;%s&#8217; Category', 'emeraldresourcegroup' ), single_cat_title('', false)); ?></h1>
									<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
									<h1><?php printf(__( 'Posts Tagged &#8216;%s&#8217;', 'emeraldresourcegroup' ), single_tag_title('', false)); ?></h1>
									<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
									<h1><?php _e('Archive for', 'emeraldresourcegroup'); ?> <?php the_time('F jS, Y'); ?></h1>
									<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
									<h1><?php _e('Archive for', 'emeraldresourcegroup'); ?> <?php the_time('F, Y'); ?></h1>
									<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
									<h1><?php _e('Archive for', 'emeraldresourcegroup'); ?> <?php the_time('Y'); ?></h1>
									<?php /* If this is an author archive */ } elseif (is_author()) { ?>
									<h1><?php _e('Author Archive', 'emeraldresourcegroup'); ?></h1>
									<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
									<h1><?php _e('Blog Archives', 'emeraldresourcegroup'); ?></h1>
								<?php } ?>
							</div>
						<?php if (have_posts()) : ?>
							<?php while (have_posts()) : the_post(); ?>
								<?php get_template_part('blocks/content', get_post_type()); ?>
							<?php endwhile; ?>

							<?php get_template_part('blocks/pager'); ?>

						<?php else : ?>
							<?php get_template_part('blocks/not_found'); ?>
						<?php endif; ?>

						<?php wp_link_pages(); ?>

					</div>
				</div>
				<div class="widget gform_widget visible-xs visible-sm" style="border-top: 1px solid #E8E8E8;padding-top: 50px;margin-top: 50px;">
					<h3>Let us help you find a career you’ll love.</h3>
					<?php gravity_form('Sidebar Form', false, true, true, '200', false); ?>
				</div>
			</div>
		</div>
	</div>
	<!-- call to action -->
	<div class="cta-bg">
		<div class="container">
			<div class="row cta">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-md-7">
							<div class="text-box">
								<p><strong>Our knowledgeable consultants</strong> work hard to match professionals in the Information Technology field with opportunities that benefit both the candidate and the client.</p>
							</div>
							<button class="btn btn-default">
              <span class="text">
                <span class="text-hold">Contact a consultant today</span>
              </span>
								<span class="icon icon-arrow-right"></span>
							</button>
						</div>
						<div class="hidden-xs hidden-sm col-md-4">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php get_footer(); ?>
