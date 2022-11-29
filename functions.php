<?php

//Staging restrictions
if (file_exists(sys_get_temp_dir().'/staging-restrictions.php')) {
	define('STAGING_RESTRICTIONS', true);
	require_once sys_get_temp_dir().'/staging-restrictions.php';
}

include( get_template_directory() .'/classes.php' );
include( get_template_directory() .'/widgets.php' );

add_action('themecheck_checks_loaded', 'theme_disable_cheks');
function theme_disable_cheks() {
	$disabled_checks = array('TagCheck');
	global $themechecks;
	foreach ($themechecks as $key => $check) {
		if (is_object($check) && in_array(get_class($check), $disabled_checks)) {
			unset($themechecks[$key]);
		}
	}
}

add_theme_support( 'automatic-feed-links' );

if ( ! isset( $content_width ) ) $content_width = 900;

remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

add_action( 'after_setup_theme', 'theme_localization' );
function theme_localization () {
	load_theme_textdomain( 'emeraldresourcegroup', get_template_directory() . '/languages' );
}


if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'id' => 'default-sidebar',
		'name' => __('Default Sidebar', 'emeraldresourcegroup'),
		'before_widget' => '<div class="widget %2$s" id="%1$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 50, 50, true ); // Normal post thumbnails
	add_image_size( 'thumbnail_1440x900', 1440, 900, true );
	add_image_size( 'thumbnail_1440x525', 1440, 525, true );
	add_image_size( 'thumbnail_1440x500', 1440, 500, true );
}

register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'emeraldresourcegroup' ),
) );
register_nav_menus( array(
	'social_nav' => __( 'Social Navigation', 'emeraldresourcegroup' ),
) );
register_nav_menus( array(
	'footer_nav' => __( 'Footer Navigation', 'emeraldresourcegroup' ),
) );


//Add [email]...[/email] shortcode
function shortcode_email($atts, $content) {
	$result = '';
	for ($i=0; $i<strlen($content); $i++) {
		$result .= '&#'.ord($content{$i}).';';
	}
	return $result;
}
add_shortcode('email', 'shortcode_email');

//Register tag [template-url]
function filter_template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');

//Register tag [site-url]
function filter_site_url($text) {
	return str_replace('[site-url]',get_bloginfo('url'), $text);
}
add_filter('the_content', 'filter_site_url');
add_filter('get_the_content', 'filter_site_url');
add_filter('widget_text', 'filter_site_url');

//Replace standard wp menu classes
function change_menu_classes($css_classes) {
	return str_replace(array('current-menu-item', 'current-menu-parent', 'current-menu-ancestor'), 'active', $css_classes);
}
add_filter('nav_menu_css_class', 'change_menu_classes');

//Replace standard wp body classes and post classes
function theme_body_class($classes) {
	if (is_array($classes)) {
		foreach ($classes as $key => $class) {
			$classes[$key] = 'body-class-' . $classes[$key];
		}
	}

	return $classes;
}
add_filter('body_class', 'theme_body_class', 9999);

function theme_post_class($classes) {
	if (is_array($classes)) {
		foreach ($classes as $key => $class) {
			$classes[$key] = 'post-class-' . $classes[$key];
		}
	}

	return $classes;
}
add_filter('post_class', 'theme_post_class', 9999);

//Allow tags in category description
$filters = array('pre_term_description', 'pre_link_description', 'pre_link_notes', 'pre_user_description');
foreach ( $filters as $filter ) {
    remove_filter($filter, 'wp_filter_kses');
}


//Make wp admin menu html valid
function wp_admin_bar_valid_search_menu( $wp_admin_bar ) {
	if ( is_admin() )
		return;

	$form  = '<form action="' . esc_url( home_url( '/' ) ) . '" method="get" id="adminbarsearch"><div>';
	$form .= '<input class="adminbar-input" name="s" id="adminbar-search" tabindex="10" type="text" value="" maxlength="150" />';
	$form .= '<input type="submit" class="adminbar-button" value="' . __('Search', 'emeraldresourcegroup') . '"/>';
	$form .= '</div></form>';

	$wp_admin_bar->add_menu( array(
		'parent' => 'top-secondary',
		'id'     => 'search',
		'title'  => $form,
		'meta'   => array(
			'class'    => 'admin-bar-search',
			'tabindex' => -1,
		)
	) );
}

function fix_admin_menu_search() {
	remove_action( 'admin_bar_menu', 'wp_admin_bar_search_menu', 4 );
	add_action( 'admin_bar_menu', 'wp_admin_bar_valid_search_menu', 4 );
}

add_action( 'add_admin_bar_menus', 'fix_admin_menu_search' );

//Disable comments on pages by default
function theme_page_comment_status($post_ID, $post, $update) {
	if (!$update) {
		remove_action('save_post_page', 'theme_page_comment_status', 10);
		wp_update_post(array(
			'ID' => $post->ID,
			'comment_status' => 'closed',
		));
		add_action('save_post_page', 'theme_page_comment_status', 10, 3);
	}
}
add_action('save_post_page', 'theme_page_comment_status', 10, 3);

//custom excerpt
function theme_the_excerpt() {
	global $post;

	if (trim($post->post_excerpt)) {
		the_excerpt();
	} elseif (strpos($post->post_content, '<!--more-->') !== false) {
		the_content();
	} else {
		the_excerpt();
	}
}

/* advanced custom fields settings*/

//theme options tab in appearance
if(function_exists('acf_add_options_sub_page')) {
	acf_add_options_sub_page(array(
		'title' => 'Theme Options',
		'parent' => 'themes.php',
	));
}

//acf theme functions placeholders
if(!class_exists('acf') && !is_admin()) {
	function get_field_reference( $field_name, $post_id ) {return '';}
	function get_field_objects( $post_id = false, $options = array() ) {return false;}
	function get_fields( $post_id = false) {return false;}
	function get_field( $field_key, $post_id = false, $format_value = true )  {return false;}
	function get_field_object( $field_key, $post_id = false, $options = array() ) {return false;}
	function the_field( $field_name, $post_id = false ) {}
	function have_rows( $field_name, $post_id = false ) {return false;}
	function the_row() {}
	function reset_rows( $hard_reset = false ) {}
	function has_sub_field( $field_name, $post_id = false ) {return false;}
	function get_sub_field( $field_name ) {return false;}
	function the_sub_field($field_name) {}
	function get_sub_field_object( $child_name ) {return false;}
	function acf_get_child_field_from_parent_field( $child_name, $parent ) {return false;}
	function register_field_group( $array ) {}
	function get_row_layout() {return false;}
	function acf_form_head() {}
	function acf_form( $options = array() ) {}
	function update_field( $field_key, $value, $post_id = false ) {return false;}
	function delete_field( $field_name, $post_id ) {}
	function create_field( $field ) {}
	function reset_the_repeater_field() {}
	function the_repeater_field($field_name, $post_id = false) {return false;}
	function the_flexible_field($field_name, $post_id = false) {return false;}
	function acf_filter_post_id( $post_id ) {return $post_id;}
}

require_once('lib/jobs-database.php');

function print_job_search_form() {
	$searchPage = get_page_by_title('Career Search');
	?>

	<form method="get" action="/<?php echo get_page_uri($searchPage); ?>/" class="icl-WhatWhere icl-WhatWhere--lg">
                  <div style="padding-left: 0px;" class="col-md-5 col-sm-5 icl-WhatWhere-input--what"><div class="icl-Autocomplete">
	                    <div class="icl-TextInputClearable"><div class="icl-TextInput">
	                      <div class="icl-TextInput-labelWrapper">
	                        <label style="font-size: 20px;" id="label-q" for="text-input-what" class="icl-TextInput-label icl-TextInput-label--whatWhere">what</label>
	                        <p style="font-size: 10px;" id="text-input-what-helpText" class="icl-TextInput-helpText icl-TextInput-helpText--whatWhere">job title, keywords, or company</p>
	                      </div>
	                      <div class="icl-TextInput-wrapper">
	                        <input type="search" aria-labelledby="label-q text-input-what-helpText" id="keywords-field" name="keywords[]" maxlength="512" placeholder="" autocomplete="off" class="icl-TextInput-control icl-TextInput-control--whatWhere">
	                      </div>
	                    </div>
	                  </div>
	                </div>
	              </div>
	              <div style="padding-left: 0px;" class="col-md-5 col-sm-5 icl-WhatWhere-input--where">
	                <div class="icl-Autocomplete">
	                  <div class="icl-TextInputClearable">
	                    <div class="icl-TextInput">
	                      <div class="icl-TextInput-labelWrapper">
	                        <label style="font-size: 20px;" id="label-l" for="text-input-where" class="icl-TextInput-label icl-TextInput-label--whatWhere">where</label>
	                        <p style="font-size: 10px;" id="text-input-where-helpText" class="icl-TextInput-helpText icl-TextInput-helpText--whatWhere">city, province, or region</p>
	                      </div>
	                      <div class="icl-TextInput-wrapper">
	                        <input  type="search" aria-labelledby="label-l text-input-where-helpText" id="locations" name="locations[]" maxlength="62" placeholder="" autocomplete="off" class="icl-TextInput-control icl-TextInput-control--whatWhere">
	                      </div>
	                    </div>
	                  </div>
	                </div>
	              </div>

	              <div class="icl-TextInput-labelWrapper">
						<label style="font-size: 20px;" id="label-l" for="text-input-where" class="icl-TextInput-label icl-TextInput-label--whatWhere"></label>
						<p style="font-size: 10px;" id="text-input-where-helpText" class="icl-TextInput-helpText icl-TextInput-helpText--whatWhere"></p>
					</div>
	              <div style="padding-top: 20px;" class="icl-WhatWhere-buttonWrapper">
	                <button id="form-button" size="md" type="submit" class="hidden-xs icl-Button icl-Button--md icl-WhatWhere-button">Find Jobs</button>
                  	<button id="form-button" size="md" type="submit" class="form-control hidden-sm hidden-md hidden-lg icl-Button icl-Button--md icl-WhatWhere-button">Find Jobs</button>
	              </div>
            </form>
	<?php
}



add_filter( 'gform_notification_4', 'change_notification_email', 10, 3 );

function change_notification_email( $notification, $form, $entry) {
	global $wpdb;
	$db = $wpdb->prefix."api_jobs";

	$to_email = '';

    //There is no concept of admin notifications anymore, so we will need to target notifications based on other criteria, such as nam
 		if ( isset( $_GET['job_id'] ) && is_numeric( $_GET['job_id'] ) ){

                    
                    $querystr = "
                      SELECT *
                      FROM $db
                      WHERE id = " . (int) $_GET['job_id'];
                    $job = $wpdb->get_row($querystr, OBJECT);
                    $to_email = $job->owner_email;
                }


 		if (!$to_email) {
 			die();
 		}

        // toType can be routing or email
        $notification['toType'] = 'email';
        $notification['to'] = $to_email;



    return $notification;
}


function getJobsCount($keywords , $locations , $types , $salary){

	global $wpdb;

	$location = (isset($locations[0])) ? $locations[0] : '';
	$type = (isset($types[0])) ? $types[0] : '';
	$keyword = (isset($keywords[0])) ? $keywords[0] : '';
	$db = $wpdb->prefix."api_jobs";


	if(!$keyword){

		if(strlen($location) > 2){

				$querystr = "
                      SELECT COUNT(*)
                      FROM $db
                      WHERE type ='".$type."' AND workcity='".$location."' AND tarsal >= '".$salary."' ";
					  $count = $wpdb->get_var($querystr);


	                  return $count;
			}
			else if(strlen($location) > 0 && strlen($location)<= 2 )
			{

				$querystr = "
                      SELECT COUNT(*)
                      FROM $db
                      WHERE type ='".$type."' AND workstate='".$location."' AND tarsal >= '".$salary."' ";
					  $count = $wpdb->get_var($querystr);

	                  return $count;
	              }
			else
			{

				$querystr = "
                      SELECT COUNT(*)
                      FROM $db
                      WHERE type ='".$type."' AND tarsal >= '".$salary."' ";
					  $count = $wpdb->get_var($querystr);

	                  return $count;
	              }

	}
	else{

		$keyword = "%" . $keyword . "%";


		if(strlen($location) > 2){
			$querystr = "
	                      SELECT count(*)
	                      FROM $db
	                      WHERE type ='".$type."' AND workcity='".$location."' AND UPPER(orddesc) LIKE '".$keyword."' AND tarsal >= '".$salary."'";
	                    $count = $wpdb->get_var($querystr);

	                    return $count;
	    }
	    elseif (strlen($location) > 0 && strlen($location) <=2 )
	    {
	    	$querystr = "
	                      SELECT count(*)
	                      FROM $db
	                      WHERE type ='".$type."' AND workstate='".$location."' AND UPPER(orddesc) LIKE '".$keyword."' AND tarsal >= '".$salary."'  ";
	                    $count = $wpdb->get_var($querystr);



	                    return $count;
	    }
	    else{
	    	$querystr = "
	                      SELECT COUNT(*)
	                      FROM $db
	                      WHERE type ='".$type."' AND UPPER(orddesc) LIKE '".$keyword."' AND tarsal >= '".$salary."'  ";
	                    $count = $wpdb->get_var($querystr);






	                    return $count;
	    }
	}





}


function secondry_search_sidebar($keywords,$locations , $type , $salary){

	$Ptype = array("Permanent");

	$Ctype = array("Contract");






			$permanentJobCount = getJobsCount($keywords , $locations , $Ptype , $salary);
			$contractJobCount  = getJobsCount($keywords , $locations , $Ctype , $salary);



if ($type) {

	if ($type == "Permanent") {
		$type = "Full-Time";
	}

	?>
	<div>
		<h5>Job-Type</h5>
		<span class="rbLabel"><?php echo $type; ?></span>
		<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keywords[0] ?>&amp;locations%5B%5D=<?= $locations[0] ?>&amp;salary=<?= $salary ?>&lf=1" title="Cancel Filter">
			<span class="rbCount">(x)</span>
		</a>
	</div>


	<?php

}
else{

	?>
	<div>
		<h5>Job-Type</h5>
	<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keywords[0] ?>&amp;types=Permanent&amp;locations%5B%5D=<?= $locations[0] ?>&amp;salary=<?= $salary ?>&lf=1" title="Full-Time">
		<span class="rbLabel">Full-Time</span>
		<span class="rbCount">( <?php echo $permanentJobCount; ?>)</span>
	</a>
	<br/>
	<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keywords[0] ?>&amp;types=Contract&amp;locations%5B%5D=<?= $locations[0] ?>&amp;salary=<?= $salary ?>&lf=1" title="Contract">
		<span class="rbLabel">Contract</span>
		<span class="rbCount">( <?php echo $contractJobCount; ?>)</span>
	</a>
	</div>


	<?php

}


}

function getSalaryCount($keyword , $location , $salary , $type){

	global $wpdb;

	$type = "%".$type."%";
	$db = $wpdb->prefix."api_jobs";


	if(strlen($location)-2 > 2){
		$querystr = "
                      SELECT COUNT(*)
                      FROM $db
                      WHERE UPPER(orddesc) LIKE '".$keyword."' AND workcity LIKE '".$location."' AND tarsal >='".$salary."' AND type LIKE '".$type."'";
                    $count = $wpdb->get_var($querystr);

                    return $count;
    }
    elseif (strlen($location)-2 > 0 && strlen($location)-2 <=2 )
    {
    	$querystr = "
                      SELECT COUNT(*)
                      FROM $db
                      WHERE UPPER(orddesc) LIKE '".$keyword."' AND workstate LIKE '".$location."' AND tarsal >='".$salary."' AND type LIKE '".$type."'";
                    $count = $wpdb->get_var($querystr);



                    return $count;
    }
    else{
    	$querystr = "
                      SELECT COUNT(*)
                      FROM $db
                      WHERE UPPER(orddesc) LIKE '".$keyword."' AND tarsal >='".$salary."' AND type LIKE '".$type."'";
                    $count = $wpdb->get_var($querystr);




                    return $count;
    }




}

function salaryJobsFilter($keywords , $locations , $types , $salary){


	global $wpdb;

	$fiftyThousand = 50000;
	$seventyThousand = 70000;
	$ninetyThousand = 90000;
	$hundredThousand = 100000;

	$location = (isset($locations[0])) ? $locations[0] : '';
	$type = $types;
	$keyword = (isset($keywords[0])) ? $keywords[0] : '';


	$kw = "%" . $keyword . "%";
	$loc = "%" . $location . "%";




	$fiftyplus = getSalaryCount($kw , $loc , $fiftyThousand ,$type);
	$seventyplus = getSalaryCount($kw , $loc , $seventyThousand , $type);
	$nintyplus = getSalaryCount($kw , $loc , $ninetyThousand , $type);
	$hundredplus = getSalaryCount($kw , $loc , $hundredThousand ,$type);





if ($salary) {

	?>
	<div>
		<h5>Salary</h5>
		<span class="rbLabel"><?php echo "$" . $salary . "+"; ?></span>
		<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=<?= $location ?>&types=<?= $type ?>&lf=1" title="Cancel Filter">
			<span class="rbCount">(x)</span>
		</a>
	</div>


	<?php

}
else{

	?>
	<div>
		<h5>Salary</h5>
		<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=<?= $location ?>&salary=50000&types=<?= $type ?>&lf=1" title="Fifty Thousand">
		<span class="rbLabel">$50,000+  </span>
		<span class="rbCount">( <?php echo $fiftyplus;  ?>) <?php echo "<br>"; ?></span>
	</a>

	<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=<?= $location ?>&salary=70000&types=<?= $type ?>&lf=1" title="Seventy Thousand">
		<span class="rbLabel">$70,000+  </span>
		<span class="rbCount">( <?php  echo $seventyplus; ?>)<?php echo "<br>"; ?></span>
	</a>

	<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=<?= $location ?>&salary=90000&types=<?= $type ?>&lf=1" title="Ninty Thousand">
		<span class="rbLabel">$90,000+  </span>
		<span class="rbCount">( <?php  echo $nintyplus;?>)<?php echo "<br>"; ?></span>
	</a>

	<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=<?= $location ?>&salary=100000&types=<?= $type ?>&lf=1" title="One Hundred Thousand">
		<span class="rbLabel">$100,000+  </span>
		<span class="rbCount">( <?php echo $hundredplus; ?>)<?php echo "<br>"; ?></span>
	</a>

	</div>

	<?php

}


}



function getCompaniesByLocation($locations){

	global $wpdb;

	$location = $locations[0];
	$db = $wpdb->prefix."api_jobs";



	if(strlen($location) > 0 && strlen($location) <=2){

		$querystr = "
                      SELECT workcompany
						FROM $db
						WHERE workstate ='".$location."'
						GROUP BY workcompany" ;
                    $companies = $wpdb->get_results($querystr);


                    return $companies;


	}
	elseif (strlen($location) > 2){
		$querystr = "
                       SELECT workcompany
						FROM $db
						WHERE workcity ='".$location."'
						GROUP BY workcompany" ;
                    $companies = $wpdb->get_results($querystr);
                    return $companies;
	}
	else{

		$querystr = "
                       SELECT workcompany
						FROM $db
						GROUP BY workcompany" ;
                    $companies = $wpdb->get_results($querystr);
                    return $companies;
	}


}

function getCompaniesbyKeywords($companies , $keywords){

	global $wpdb;

	$companyData = array();
	$db = $wpdb->prefix."api_jobs";



if ($keywords[0]) {
	$keyword = "%".$keywords[0]."%";


for ($i=0; $i < sizeof($companies); $i++)
{
	$querystr = "
		      SELECT workcompany
				FROM $db
				WHERE workcompany ='".$companies[$i]->workcompany."' and orddesc LIKE '".$keyword."'
				GROUP BY workcompany ";

	    $com = $wpdb->get_var($querystr);

	    if($com)
	    array_push($companyData, $com);

}

return $companyData;

}else{


	for ($i=0; $i < sizeof($companies) ; $i++)
{
	$querystr = "
		      SELECT workcompany
				FROM $db
				WHERE workcompany ='".$companies[$i]->workcompany."'
				GROUP BY workcompany ";

	    $com = $wpdb->get_var($querystr);

	    if($com)
	    array_push($companyData, $com);

}

return $companyData;


}



}



function companiesFilter($keywords , $locations){

global $wpdb;

$companyDataCount = array();

	$companies =getCompaniesByLocation($locations);

	$companies = getCompaniesbyKeywords($companies , $keywords);
	$db = $wpdb->prefix."api_jobs";



if ($keywords[0]) {
	$keyword = "%".$keywords[0]."%";
	for ($i=0; $i < sizeof($companies) ; $i++)
                    {

						$querystr = "
	                      SELECT COUNT(orddesc)
	                      FROM $db
	                      WHERE workcompany = '".$companies[$i]."' and orddesc LIKE '".$keyword."' ";
                    $count = $wpdb->get_var($querystr);


                    array_push($companyDataCount, $count);

                     }


}
else{
	for ($i=0; $i < sizeof($companies) ; $i++)
                    {

						$querystr = "
	                      SELECT COUNT(orddesc)
	                      FROM $db
	                      WHERE workcompany = '".$companies[$i]."' ";
                    $count = $wpdb->get_var($querystr);


                    array_push($companyDataCount, $count);

                     }
}



                     $keyword =  $keywords[0];


                    ?>
	<div>
		<h5>Company</h5>
		<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&company=<?= $companies[0] ?>" title="">
		<span class="rbLabel"><?php echo $companies[0]; ?>  </span>
		<span style="color: grey;" class="rbCount">(<?php echo $companyDataCount[0]; ?>)</span>
		<span style="color: grey;" id="dots">...</span>
	</a>




	</div>

	<div id="more">

		<?php

			for ($i=1; $i < sizeof($companies) ; $i++)
                {

                	?>

                	<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&company=<?= $companies[$i] ?>" title="">
						<span class="rbLabel"><?php echo $companies[$i]; ?>  </span>
						<span style="color: grey;" class="rbCount">(<?php echo $companyDataCount[$i]; ?>) <?php echo "<br>"; ?></span>
					</a>

                	<?php

                }

		  ?>

	</div>

	<button class="btn btn-link" type="button" onclick="readMoreAndLess()" id="myBtn">Display More > </button>

	<?php

}



function getCitiesByLocations($locations , $type , $salary){

	global $wpdb;

	$type = "%".$type."%";

	$location = (isset($locations[0])) ? $locations[0] : '';
	$db = $wpdb->prefix."api_jobs";


		if(strlen($location) > 0 && strlen($location) <= 2){

			$querystr = "
                      SELECT workcity
                      FROM $db
                      where workstate = '".$location."' AND type LIKE '".$type."' AND tarsal >= '".$salary."'
                      GROUP BY workcity" ;
                    $cities = $wpdb->get_results($querystr);
                    return $cities;


		}
		elseif (strlen($location) > 2)
		{
			$querystr = "
                      SELECT workcity
                      FROM $db
                      where workcity = '".$location."' AND type LIKE '".$type."' AND tarsal >= '".$salary."'
                      GROUP BY workcity" ;
                    $cities = $wpdb->get_results($querystr);
                    return $cities;
		}
		else
		{
			$querystr = "
                      SELECT workcity
                      FROM $db
                      where type LIKE '".$type."' AND tarsal >= '".$salary."'
                      GROUP BY workcity" ;
                    $cities = $wpdb->get_results($querystr);
                    return $cities;

		}




}


function getCitiesByKeywords($cities , $keywords){

		global $wpdb;

	$companyData = array();
	$db = $wpdb->prefix."api_jobs";
	$keyword = (isset($keywords[0])) ? $keywords[0] : '';



if ($keyword) {
	$keyword = "%".$keyword."%";


for ($i=0; $i < sizeof($cities) ; $i++)
{
	$querystr = "
		      SELECT workcity
				FROM $db
				WHERE workcity ='".$cities[$i]->workcity."' and orddesc LIKE '".$keyword."'
				GROUP BY workcity ";

	    $com = $wpdb->get_var($querystr);

	    if($com)
	    array_push($companyData, $com);

}

return $companyData;

}
else
{


for ($i=0; $i < sizeof($cities) ; $i++)
{
	$querystr = "
		      SELECT workcity
				FROM $db
				WHERE workcity ='".$cities[$i]->workcity."'
				GROUP BY workcity ";

	    $com = $wpdb->get_var($querystr);

	    if($com)
	    array_push($companyData, $com);

}

return $companyData;


}



}


function locationsFilter($keywords , $locations , $lf , $type , $salary){

global $wpdb;
$db = $wpdb->prefix."api_jobs";



		$companyDataCount = array();

					$cities = getCitiesByLocations($locations , $type , $salary);
					$cities = getCitiesByKeywords($cities , $keywords);



					$keyword = (isset($keywords[0])) ? "%".$keywords[0]."%" : '';
					$ty = "%".$type."%";

					for ($i=0; $i < sizeof($cities) ; $i++)
                    {

						$querystr = "
	                      SELECT COUNT(orddesc)
	                      FROM $db
	                      WHERE workcity = '".$cities[$i]."' and orddesc LIKE '".$keyword."' and type LIKE '".$ty."' AND tarsal >= '".$salary."' ";
                    $count = $wpdb->get_var($querystr);


                    array_push($companyDataCount, $count);

                     }



                    $keyword = (isset($keywords[0])) ? $keywords[0] : '';








                     if(sizeof($cities) === 1){


                     	if($lf == 1){

                     		?>

						<div>
							<h5>Location</h5>
							<span class="rbLabel"><?php echo $cities[0]; ?>  </span>

							<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=&types=<?= $type ?>&salary=<?= $salary ?>&lf=0" title="Cancel Filter">
							<span>[x]</span>
							</a>
						</div>

						<?php


                     	}
                     	else{

						?>

						<div>
							<h5>Location</h5>
							<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=<?= $cities[0] ?>&types=<?= $type ?>&salary=<?= $salary ?>&lf=1" title="City">
							<span class="rbLabel"><?php echo $cities[0]; ?>  </span>
							<span style="color: grey;" class="rbCount">(<?php echo $companyDataCount[0]; ?>)</span>
							</a>
						</div>

						<?php

                     	}


                     }
                     else{

                     	?>

						<div>
							<h5>Location</h5>
							<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=<?= $cities[0] ?>&types=<?= $type ?>&salary=<?= $salary ?>&lf=1" title="City">
							<span class="rbLabel"><?php echo $cities[0]; ?>  </span>
							<span style="color: grey;" class="rbCount">(<?php echo $companyDataCount[0]; ?>)</span>
							<span style="color: grey;" id="dot">...</span>
						</a>




						</div>

						<div id="moreLocations">

							<?php

								for ($i=1; $i < sizeof($cities) ; $i++)
					                {

					                	?>

					                	<a rel="nofollow" href="/<?php echo get_page_uri($searchPage); ?>?keywords%5B%5D=<?= $keyword ?>&locations%5B%5D=<?= $cities[$i] ?>&types=<?= $type ?>&salary=<?= $salary ?>&lf=1" title="City">
											<span class="rbLabel"><?php echo $cities[$i]; ?>  </span>
											<span style="color: grey;" class="rbCount">(<?php echo $companyDataCount[$i]; ?>) <?php echo "<br>"; ?></span>
										</a>

					                	<?php

					                }

							  ?>

						</div>

						<button class="btn btn-link" type="button" onclick="readMoreAndLessLocation()" id="myLocationsBtn">Display More > </button>

						<?php

					}


}




// Register Sidebar
function career_search_sidebar() {

	$args = array(
		'id'            => 'career-search-sidebar',
		'name'          => 'Career Search Sidebar',
	);
	register_sidebar( $args );

}

// Hook into the 'widgets_init' action
add_action( 'widgets_init', 'career_search_sidebar' );




// Allow job_id parameter to be ready from $_GET
function add_query_vars_filter( $vars ){
	$vars[] = "job_id";
	$vars[] = "categories";
	$vars[] = "locations";
	$vars[] = "types";
	$vars[] = "keywords";
	$vars[] = "page_num";
	return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );








// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

// Creating the widget
class wpb_widget extends WP_Widget {

function __construct() {
parent::__construct(

// Base ID of your widget
'wpb_widget',

// Widget name will appear in UI
__('WPBeginner Widget', 'wpb_widget_domain'),

// Widget description
array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), )
);
}



// Creating widget front-end

public function widget( $args, $instance , $keywords = "" , $locations = "" , $types = "") {

  if (! isset($_GET['job_id'])) {

      global $locfil;
      $title = apply_filters( 'widget_title', $instance['title'] );

      // before and after widget arguments are defined by themes
      echo $args['before_widget'];
      if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];

      // This is where you run the code and display the output
      echo "<br>";
      //if ( isset( $_GET['keywords']) || isset( $_GET['locations']) || isset( $_GET['types']) || isset($_GET['salary'])  ){

		$locations = (isset($_GET['locations'])) ? $_GET['locations'] : '';
		$types = (isset($_GET['types'])) ? $_GET['types'] : '';
		$keywords = (isset($_GET['keywords'])) ? $_GET['keywords'] : '';
		$salary = (isset($_GET['salary'])) ? $_GET['salary'] : '';
		$lf = (isset($_GET['lf'])) ? $_GET['lf'] : '';

		secondry_search_sidebar($keywords , $locations , $types , $salary);
		echo "<br><br>";
		salaryJobsFilter($keywords , $locations , $types , $salary);
		//echo "<br><br>";
		//companiesFilter($keywords , $locations);
		echo "<br><br>";
		locationsFilter($keywords , $locations , $lf , $types , $salary);

      //}else{
		//secondry_search_sidebar($keywords,$locations, $types, $salary);
		//echo "<br><br>";
		//salaryJobsFilter($keywords , $locations , $types , $salary);
		//echo "<br><br>";
		//companiesFilter($keywords , $locations);
		//echo "<br><br>";
		//locationsFilter($keywords , $locations , $lf , $types , $salary);
      //}

      echo $args['after_widget'];

  }
}





// Widget Backend
public function form( $instance ) {
if ( isset( $instance[ 'title' ] ) ) {
$title = $instance[ 'title' ];
}
else {
$title = __( 'New title', 'wpb_widget_domain' );
}
// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<?php
}

// Updating widget replacing old instances with new
public function update( $new_instance, $old_instance ) {
$instance = array();
$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
return $instance;
}
} // Class wpb_widget ends here
