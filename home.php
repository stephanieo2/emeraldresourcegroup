<?php get_header(); ?>

<!-- banner -->
<div class="visual alt">
	<div class="bg-stretch">
		<?php if (has_post_thumbnail( get_option( 'page_for_posts' ) )) : ?>
			<?php echo preg_replace('#(width|height)=\"\d*\"\s#', "", wp_get_attachment_image(get_post_thumbnail_id(get_option( 'page_for_posts' )), 'thumbnail_1440x525')); ?>
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
					
						print_job_search_form();

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
				<?php get_sidebar('blog'); ?>
				<div class="col-xs-12 col-md-8">
					<div id="content">
						<div class="title"><h1>Blog</h1></div>
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
					<div class="widget gform_widget visible-xs visible-sm" style="border-top: 1px solid #E8E8E8;padding-top: 50px;margin-top: 50px;">
						<h3>Let us help you find a career you’ll love.</h3>
						<?php gravity_form('Sidebar Form', false, true, true, '200', false); ?>
					</div>
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