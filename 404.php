<?php get_header(); ?>
<div class="visual alt" style="height: 300px;">
	<div class="bg-stretch">
		<?php if (has_post_thumbnail( get_the_ID() )) : ?>
			<?php echo preg_replace('#(width|height)=\"\d*\"\s#', "", wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'thumbnail_1440x525')); ?>
		<?php else: ?>
			<img src="<?php echo get_template_directory_uri(); ?>/images/bg_page.jpg" alt="image description" >
		<?php endif; ?>
	</div>
</div>
<div class="one-column">
    <div class="container">
        <div class="col-md-8">
            <div id="content">
                <?php get_template_part('blocks/not_found'); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>