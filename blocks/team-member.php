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
$id = 'testimonial-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'team-member';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}

// Load values and assign defaults.
$staffname             = get_field('staffname');
$jobtitle             = get_field('jobtitle');
$specialties           = get_field('specialties');
$email             = get_field('email') ?: 'email contact';
$staffimage            = get_field('staffimage') ?: 295;
$linkedin = get_field('linkedin');
$phone       = get_field('phone');
$bio       = get_field('bio');


?>




<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
<div class="teammember col-lg-12 col-md-12 col-sm-12">
<article itemscope itemtype ="https://schema.org/Person">

        <div class="col-xs-12 col-md-9">
            
             <h2 itemprop="name"><?php echo $staffname; ?></h2>

             <h3 itemprop="JobTitle"><?php echo $jobtitle; ?></h3>

            <?php 
            $image = get_field('specialties');
            if( !empty( $specialties ) ): ?>  
              <h4> Specialties: <?php echo $specialties; ?></h4>
            <?php endif; ?>

             <h3 style="display: none;" itemprop="worksFor">Emerald Resource Group</h3>
             <?php echo $bio; ?>&nbsp;

             
        </div>

                <div class="col-xs-12 col-md-3 testimonial-image">
            <?php 
            $image = get_field('staffimage');
            if( !empty( $staffimage ) ): ?>
                <img itemprop="image" style="width: 100%" src="<?php echo esc_url($staffimage['url']); ?>" alt="<?php echo esc_attr($staffimage['alt']); ?>" />
            <?php endif; ?>


            <?php 
            $image = get_field('linkedin');
            if( !empty( $linkedin ) ): ?>       
            <a class="btn btn-default" itemprop="sameAs" href="<?php echo $linkedin; ?>" target=_blank><span class="text"><span class="text-hold">LinkedIn</span><span class="icon icon-arrow-right"></span></span></a> 
            <?php endif; ?>

            <?php 
            $image = get_field('email');
            if( !empty( $email ) ): ?>  
               <a class="btn btn-default" itemprop="email" href="mailto:<?php echo $email; ?>" target=_blank><span class="text">
                <span class="text-hold">Email</span>
              </span><span class="icon icon-arrow-right"></span></a> 
              <?php endif; ?>

            <?php 
            $image = get_field('phone');
            if( !empty( $phone ) ): ?>  
             <a class="btn btn-default" itemprop="telephone" content="+<?php echo $phone; ?>" href="tel:+<?php echo $phone; ?>" target=_blank><span class="text"><span class="text-hold"> Phone</span><span class="icon icon-arrow-right"></span></span></a>
             <?php endif; ?>
            

        </div>

    </article>

</div>
    <style type="text/css">
        #<?php echo $id; ?> {
            background: <?php echo $background_color; ?>;
            color: <?php echo $text_color; ?>;
        }
    </style>
</div>