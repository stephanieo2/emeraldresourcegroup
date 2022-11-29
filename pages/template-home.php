<?php
/*
Template Name: Home Template
*/
get_header(); ?>

<div class="visual">
	<?php while (have_posts() ): the_post(); ?>
		<?php if (has_post_thumbnail()) : ?>
		<div class="bg-stretch">
			<?php echo preg_replace('#(width|height)=\"\d*\"\s#', "", wp_get_attachment_image(get_post_thumbnail_id(), 'thumbnail_1440x900')); ?>
		</div>
		<?php endif; ?>
		<?php $sub_tilte = get_field( 'sub_tilte' ); ?>
		<?php if ($sub_tilte) : ?> 
		<div class="text-box">
			<div class="container-fluid">
				<div class="container-hold">
					<h1><?php echo $sub_tilte; ?></h1>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php $left_button_label = get_field( 'left_button_label' ); ?>
		<?php $left_button_link = get_field( 'left_button_link' ); ?>
		<?php $right_button_label = get_field( 'right_button_label' ); ?>
		<?php $right_button_link = get_field( 'right_button_link' ); ?>
		<?php if ($left_button_label || $right_button_label) : ?>
			<div class="btn-holder">
				<div class="container-fluid">
					<div class="container-hold">
						<div class="row">
							<?php if ($left_button_label) : ?>
								<div class="col-sm-6">
									<a href="<?php echo $left_button_link ; ?>" class="btn-search btn btn-default">
										<span class="icon icon-search"></span>
										<div class="text">
											<div class="text-hold">
												<?php echo $left_button_label; ?>
											</div>
										</div>
									</a>
								</div>
							<?php endif; ?>
							<?php if ($right_button_label) : ?>
								<div class="col-sm-6">
									<a href="<?php echo $right_button_link; ?>" class="btn-look btn btn-default">
										<span class="icon icon-user-approved"></span>
										<div class="text">
											<div class="text-hold">
												<?php echo $right_button_label; ?>
											</div>
										</div>
									</a>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php endwhile; ?>
</div>

<?php get_footer(); ?>