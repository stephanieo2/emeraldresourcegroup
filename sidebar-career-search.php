<?php if (is_active_sidebar('career-search-sidebar')) : ?>
<div class="col-xs-12 col-md-4">
    <aside id="sidebar">

        <?php

//	    	if(is_single()) {

	    		echo '<div id="advanced_sidebar_menu-2" class="widget advanced-sidebar-menu">
	    				<ul class="parent-sidebar-menu">';

//              	$categories = get_categories();
//
//				foreach ($categories as $category) {
//
                        dynamic_sidebar('career-search-sidebar');
//					if (strtolower($category->name) != 'uncategorized') {
//						echo '<li class="page_item"><a href="'.esc_attr(get_term_link($category->slug, 'category')).'">'.$category->name.'</a></li>';
//					}
//				}

				echo '	</ul>
					</div>';

//	    	}

	    ?>

        <?php  ?>
    </aside>
</div>
<?php endif; ?>
