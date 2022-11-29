<?php get_header(); ?>

<div class="two-columns">
    <div class="container-fluid">
        <div class="col-md-8">
            <div id="content">
                <?php if (have_posts()) : ?>
            
                <div <?php post_class(); ?>>
                    <div class="title">
                        <h1><?php printf( __( 'Search Results for: %s', 'emeraldresourcegroup' ), '<span>' . get_search_query() . '</span>'); ?></h1>
                    </div>
                </div>
            
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('blocks/content', get_post_type()); ?>
                <?php endwhile; ?>
                <?php gravity_form('Sidebar Form', false, false, true, '200', false); ?>
                
                <?php get_template_part('blocks/pager'); ?>
                
                <?php else : ?>
                    <?php get_template_part('blocks/not_found'); ?>
                <?php endif; ?>
                
            </div>
        </div>
    	<?php get_sidebar(); ?>
    </div>
</div>

<?php get_footer(); ?>