<?php if (is_active_sidebar('default-sidebar')) : ?>
	<div class="col-xs-12 col-md-4">
		<aside id="sidebar">

			<?php

//			if(is_single()) {
//
//				echo '<div id="advanced_sidebar_menu-2" class="widget advanced-sidebar-menu">
//	    				<ul class="parent-sidebar-menu">';
//
//				$categories = get_categories();
//
//				foreach ($categories as $category) {
//
//					if (strtolower($category->name) != 'uncategorized') {
//						echo '<li class="page_item"><a href="'.esc_attr(get_term_link($category->slug, 'category')).'">'.$category->name.'</a></li>';
//					}
//				}
//
//				echo '	</ul>
//					</div>';
//
//			}

			if (is_home() || is_single()) {

				$blogPageId = get_option('page_for_posts');
				$parent = get_post(wp_get_post_parent_id($blogPageId));
				echo '<div id="advanced_sidebar_menu-2" class="widget advanced-sidebar-menu">
	    				<ul class="parent-sidebar-menu">
	    					<li class="page_item current_page_ancestor current_page_parent has_children">
	    						<a href="' . get_permalink($parent->ID) .'">' . $parent->post_title . '</a>
	    						<ul class="child-sidebar-menu">';
				$mypages = get_pages( array( 'child_of' => $parent->ID, 'sort_column' => 'post_order', 'sort_order' => 'desc' ) );

				foreach( $mypages as $page ) {
					?>
					<li class="page_item<?php echo ($page->ID == $blogPageId ? ' current_page_item' : null) ?>" style="<?php if ($page->post_parent !== $parent->ID) { ?>padding-left:2em;<?php } ?>"><a href="<?php echo get_page_link( $page->ID ); ?>"><?php echo $page->post_title; ?></a></li>
				<?php
				}

echo '	    						</ul>
	    					</li>';



				echo '	</ul>
					</div>';

			}

			?>

			<?php dynamic_sidebar('default-sidebar'); ?>
		</aside>
	</div>
<?php endif; ?>