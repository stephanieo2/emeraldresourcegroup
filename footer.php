		</main>
		<footer id="footer">
			<div class="container-fluid">
				<div class="container-hold">
					<div class="footer-panel">
						<div class="row">
							<div class="col-lg-2 col-md-3">
								<strong class="logo"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-alt.png" alt="EmeraldResourceGroup" ></a></strong>
							</div>
                            <?php if(has_nav_menu('footer_nav'))
								wp_nav_menu( array('container_class' => 'col-lg-9 col-lg-offset-1 col-md-8',
									 'theme_location' => 'footer_nav',
									 'menu_class' => 'nav add-nav nav-justified',
									 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>') ); ?>
						</div>
					</div>
					<div class="footer-holder">
						<div class="row">
                        	<?php $linkedin_link = get_field( 'linkedin_link','option' ); ?>
                            <?php $facebook_link = get_field( 'facebook_link','option' ); ?>
                            <?php $twitter_link = get_field( 'twitter_link','option' ); ?>
							<?php $instagram_link = get_field( 'instagram_link','option' ); ?>
							<?php if ( $linkedin_link || $facebook_link || $twitter_link ) : ?>
                            <div class="col-lg-3 col-sm-3">
								<ul class="social-networks">	
                                	<?php if ( $linkedin_link ) : ?>
										<li><a target="_blank" href="<?php echo esc_url($linkedin_link); ?>"><span class="icon icon-linkedin"></span></a></li>
                                    <?php endif; ?>
                                    <?php if ( $facebook_link ) : ?>
										<li><a target="_blank" href="<?php echo esc_url($facebook_link); ?>"><span class="icon icon-facebook"></span></a></li>
                                    <?php endif; ?>
                                    <?php if ( $twitter_link ) : ?>
										<li><a target="_blank" href="<?php echo esc_url($twitter_link); ?>"><span class="icon icon-twitter"></span></a></li>
                                    <?php endif; ?>
									<?php if ( $instagram_link ) : ?>
										<li><a target="_blank" href="<?php echo esc_url($instagram_link); ?>"><span class="icon icon-instagram instagram"></span></a></li>
                                    <?php endif; ?>
								</ul>
							</div>
                            <?php endif; ?>
                            <?php $copyright = get_field( 'copyright','option' ); ?>
							<?php if ( $copyright ) : ?>
                            <div class="col-lg-5 col-lg-offset-1 col-sm-6 col-xs-7 ">
								<div class="copy">
									<?php echo $copyright; ?>
								</div>
							</div>
                            <?php endif; ?>
							<div class="col-md-3 col-sm-3 col-xs-5">
								<div class="top-box">
									<span class="text"><?php _e('Top', 'emeraldresourcegroup'); ?></span>
									<a href="#"><span class="icon icon-arrow-up"></span></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/jquery.main.js"></script>
    <?php wp_footer(); ?>
	<?php if( is_front_page() ) : ?>
	<div style="width:1400px; margin:0 auto 0 auto; text-align:center;">
	    <a href="https://www.emeraldresourcegroup.com/cleveland-it-jobs/">Cleveland IT Jobs</a> |
		<a href="https://www.emeraldresourcegroup.com/cleveland-it-staffing/">Cleveland IT Staffing</a> |
		<a href="https://www.emeraldresourcegroup.com/cleveland-software-engineer/">Cleveland IT Software Engineer</a>
	</div>
	<?php endif;?>
</body>
</html>
