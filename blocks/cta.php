
<?php

/**
 * Testimonial Block Template.
 *
 * @param    array        $block      The block settings and attributes.
 * @param    string       $content    The block inner HTML (empty).
 * @param    bool         $is_preview True during AJAX preview.
 * @param    (int|string) $post_id    The post ID this block is saved to.
 */
 
// Create id attribute allowing for custom "anchor" value.
$id = 'cta-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'cta';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$heading             = get_field('heading');
$description             = get_field('description');
$button_text           = get_field('button_text');
$cta_image            = get_field('cta_image') ?: 295;
$button_url = get_field('button_url');
 


?>


<aside>

<div class="cta-bg">
  <div class="cta-container">
    <div class="row">
      <div class="col-sm-12">
        <div class="row">
          <div class="col-md-12">
            <div class="text-box">

                       <?php 
            $image = get_field('cta_image');
            if( !empty( $cta_image ) ): ?>
                <img src="<?php echo esc_url($cta_image['url']); ?>" alt="<?php echo esc_attr($cta_image['alt']); ?>" />
            <?php endif; ?>
     
     
              <h2><?php echo $heading; ?></h2> 
              <p><?php echo $description; ?></p>
            </div>
            <a href="<?php echo $button_url; ?>" class="btn btn-default" style="display:inline-block;">
              <span class="text">
                <span class="text-hold"><?php echo $button_text; ?></span>
              </span>
              <span class="icon icon-arrow-right"></span>
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</aside>