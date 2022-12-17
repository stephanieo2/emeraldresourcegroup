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
	              ?>
	             

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
      <?php get_sidebar('blog'); ?>
      <div class="col-xs-12 col-md-8">
        <div id="content">

          <?php while (have_posts()) : the_post(); ?>
<a href="/blog">Blog Home</a>
            <?php the_title('<div class="title"><h1>', '</h1></div>'); ?>

 <h3 class="excrpt"> <?php the_excerpt(); ?> </h3>
  
  <div class="time">

Updated: <time datetime="<?php echo get_the_modified_time('F jS, Y'); ?>" itemprop="datePublished"><?php echo get_the_modified_time('F jS, Y'); ?></time>

</div>
            <?php the_content(); ?>
 
<h2>Tags:</h2>
 <?php
$post_tags = get_the_tags();
if ( ! empty( $post_tags ) ) {
  echo '<ul class="taglist">';
  foreach( $post_tags as $post_tag ) {
    echo '<li class="btn btn-info"><a href="' . get_tag_link( $post_tag ) . '">' . $post_tag->name . '</a></li>';
  }
  echo '</ul>';
}
   ?>         
            
            <?php edit_post_link( __( 'Edit', 'emeraldresourcegroup' ) ); ?>  
          <?php endwhile; ?>

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
            <a href="/contact" class="btn btn-default" style="display:inline-block;">
              <span class="text">
                <span class="text-hold">Contact a consultant today</span>
              </span>
              <span class="icon icon-arrow-right"></span>
            </a>
          </div>
          <div class="hidden-xs hidden-sm col-md-4">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>