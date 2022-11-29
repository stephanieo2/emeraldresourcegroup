<!DOCTYPE HTML>
<html <?php language_attributes(); ?> prefix="og: http://ogp.me/ns#">
	<head>
                <meta name="google-site-verification" content="zqARrdR4KZth2TKUPYUQmOmRAoVdqQ2Zbqb4Cf_0mZM" />
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0 ">
		<meta name="format-detection" content="telephone=no">

		<?php if(has_post_thumbnail()) :?>
		<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
		<meta property="og:image" content="<?php echo $url; ?>" />
		<?php endif;?>

<?php if ( isset( $_GET['job_id'] ) && is_numeric( $_GET['job_id'] ) ) : ?>
<?php
remove_action('wp_head', 'rel_canonical');
global $wpdb;
global $job;
$db = $wpdb->prefix."api_jobs";
$querystr = "
	SELECT *
	FROM $db
	WHERE id = " . (int) $_GET['job_id'];
$job = $wpdb->get_row($querystr, OBJECT);

$curl = curl_init();
$u = "https://loxo.co/api/emerald-resource-group/jobs/" . $_GET['job_id'];
curl_setopt($curl, CURLOPT_GET, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, "emerald_api:orWNbGimpQnTFqvfd6xh");
curl_setopt($curl, CURLOPT_URL, $u);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

$curl_result = curl_exec($curl);
$job_from_curl = json_decode($curl_result);

$datePosted = date('Y-m-d');

if (!is_null($job_from_curl)) {
    $jobTitle = $job_from_curl->title;
    $jobDescription = trim(preg_replace('/\n+/', ' ', $job_from_curl->description));

    if (!is_null($job) && !is_null($job->lastupdated)) {
        $lastupdated = DateTime::createFromFormat('Y-m-d H:i:s', $job->lastupdated);
        $datePosted = $lastupdated->format('Y-m-d');
    }

    $jobType = 'FULL_TIME';
    if (!is_null($job_from_curl->job_type)) {
        if (strcmp('Contract', $job_from_curl->job_type->name) == 0) {
             $jobType = 'CONTRACTOR';
        }
    }

    $workCity = $job_from_curl->city;
    $workState = $job_from_curl->state_code;
    $workZip = $job_from_curl->zip;
    $workCountry = $job_from_curl->country_code;
    if (empty($workCity) || empty($workState) || empty($workZip) || empty($workCountry)) {
        $workCity = 'Broadview Heights';
        $workState = 'OH';
        $workZip = '44147';
        $workCountry = 'US';
    }
}

?>
        <meta property="og:title" content="<?php echo htmlspecialchars($job->orddesc); ?>" />
        <title><?php echo htmlspecialchars($job->orddesc); ?> | <?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>

    <?php if (!is_null($job_from_curl)) : ?>
        <script type="application/ld+json">
            {
                "@context" : "https://schema.org/",
                "@type" : "JobPosting",
                "title" : "<?php echo htmlspecialchars($jobTitle); ?>",
                "description" : "<?php echo htmlspecialchars($jobDescription); ?>",
                "employmentType" : "<?php echo htmlspecialchars($jobType); ?>",
                "hiringOrganization": {
                    "@type": "Organization",
                    "name": "Emerald Resource Group",
                    "sameAs": "https://www.emeraldresourcegroup.com/"
                },
                "identifier": {
                    "@type": "PropertyValue",
                    "name": "Emerald Resource Group",
                    "value": "<?php echo $_GET['job_id']; ?>"
                },
                "jobLocation": {
                    "@type": "Place",
                    "address": {
                        "@type": "PostalAddress",
                        "addressLocality": "<?php echo htmlspecialchars($workCity); ?>",
                        "addressRegion": "<?php echo htmlspecialchars($workState); ?>",
                        "postalCode": "<?php echo htmlspecialchars($workZip); ?>",
                        "addressCountry": "<?php echo htmlspecialchars($workCountry); ?>"
                    }
                },
                "datePosted" : "<?php echo htmlspecialchars($datePosted); ?>"  
            }
        </script>
    <?php endif; ?>

<?php else: ?>
                <title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
<?php endif; ?>

<!--    <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>-->
		<link media="all" rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/fonts.css" >
		<link media="all" rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" >
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/style.css"  />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/theme.css"  />
		<link rel="icon" type="image/ico" href="/favicon.ico"/>

<link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/9803d0f774920a2583a276574bc635b4/styles/proctor_homepage_anNqX2hwX3BvcHVsYXJfc2VhcmNoZXNfd2l0aG91dF9yZWNlbnRfc2VhcmNoZXNfdHN0MQ-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/8a0fe5bb909f1f08f5a124d653be2acd/styles/proctor_homepage_aHBfbWVzc2FnZXNmcm9tZW1wX3YxXzA0MThfdHN0-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/b49ee258af031d33ef420ab66aa29f3f/styles/proctor_homepage_bXlpbmRqYXN4Zm9vdGVycmVzdW1lY3Rh-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/e275ab2c062ad862f94ddf7a70993c2e/styles/proctor_homepage_Y21pX2pwX3RvZy0x-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/c9aedb2754fb329b1fb827c95e0e2283/styles/proctor_homepage_anNqX2hwX2NsYXNzaWNyc3JlbW92YWxfdjFfMDUxOV90c3Q-ltr.css">


		<script type="text/javascript">
			var pathInfo = {
				base: '<?php echo get_template_directory_uri(); ?>/',
				css: 'css/',
				js: 'js/',
				swf: 'swf/',
			}
		</script>

		<?php if ( is_singular( 'post' ) ) wp_enqueue_script( 'theme-comment-reply', get_template_directory_uri()."/js/comment-reply.js" ); ?>

		<?php wp_enqueue_script( 'jquery' ); ?>
		<?php wp_head(); ?>
		<script type="text/javascript">
			if (navigator.userAgent.match(/IEMobile\/10\.0/) || navigator.userAgent.match(/MSIE 10.*Touch/)) {
				var msViewportStyle = document.createElement('style')
				msViewportStyle.appendChild(
					document.createTextNode(
						'@-ms-viewport{width:auto !important}'
					)
				)
				document.querySelector('head').appendChild(msViewportStyle)
			}
		</script>


		<script>
			function readMoreAndLess() {
			  var dots = document.getElementById("dots");
			  var moreText = document.getElementById("more");
			  var btnText = document.getElementById("myBtn");

			  if (dots.style.display === "none") {
			    dots.style.display = "inline";
			    btnText.innerHTML = "Display More >";
			    moreText.style.display = "none";
			  } else {
			    dots.style.display = "none";
			    btnText.innerHTML = "Display less";
			    moreText.style.display = "inline";
			  }
			}


			function readMoreAndLessLocation() {
			  var dots = document.getElementById("dot");
			  var moreText = document.getElementById("moreLocations");
			  var btnText = document.getElementById("myLocationsBtn");

			  if (dots.style.display === "none") {
			    dots.style.display = "inline";
			    btnText.innerHTML = "Display More >";
			    moreText.style.display = "none";
			  } else {
			    dots.style.display = "none";
			    btnText.innerHTML = "Display less";
			    moreText.style.display = "inline";
			  }
			}
		</script>

	<style>

		#more {display: none;}
		#moreLocations {display: none;}

		#form-button{
				background-color: #27ae60; border-color: #27ae60;
				box-shadow: none;
				font-weight: bolder;
				padding-left: 5px;
				padding-right: 5px;
				font-size: 1.3rem;
		}

		#form-button:hover {
			 background-color: #0E9547;
			 border-color: #0E9547;
			 box-shadow: none;
		}
		#form-button:active{

			box-shadow: none;

		}


		#keywords-field:focus{
				border-color: #27ae60;
		}
		#locations:focus {
			border-color: #27ae60;
		}
		#keywords-field{
			padding-left: 7px; color: black; background-color: white; border:2px solid; border-color: #ccc;
		}
		#locations{
			padding-left: 7px; color: black; background-color: white; border:2px solid; border-color: #ccc;
		}


	</style>

	</head>
	<body <?php body_class(); ?>>
        <div id="wrapper" <?php if (!is_active_sidebar('default-sidebar')) echo 'class="no-sidebar"'; ?>>
            <header id="header" class="header">
                <strong class="logo alignleft"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="EmeraldResourceGroup" /></a></strong>
                <?php if ( has_nav_menu('primary') ) : ?>
                <nav class="navbar navbar-default" role="navigation">
                    <div class="navbar-header">
                        <a href="#" class="toggleMenu navbar-toggle collapsed" style="display: inline-block;" id="nav-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"><div class="first hidden-xs hidden-sm">MENU</div><div><span></span></div></a>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <div class="container-fluid">
                            <?php if(has_nav_menu('primary'))
                                wp_nav_menu( array('container' => false,
                                     'theme_location' => 'primary',
                                     'menu_class' => 'nav navbar-nav nav-justified',
                                     'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                                     'walker' => new Custom_Walker_Nav_Menu) ); ?>
                            <div class="frame">
                                <div class="row">
                                    <div class="col-md-5">
	                                    <strong class="title">Career Search</strong>
	                                    <div class="hidden-xs">
                                            <?php print_job_search_form(); ?>
	                                    </div>
	                                    <div class="visible-xs">
		                                    <?php $searchPage = get_page_by_title('Career Search'); ?>
		                                    <a class="btn btn-default" href="<?php echo get_permalink($searchPage); ?>" style="max-width:300px;margin-bottom:20px;"><span class="text"><span class="text-hold">Find Jobs</span></span><span class="icon icon-arrow-right"></span></a>
	                                    </div>
                                    </div>
                                    <div class="col-lg-6 col-lg-offset-1 col-md-7 hidden-sm hidden-xs">
                                        <strong class="title">Featured positions</strong>

	                                    <?php

	                                    $job_ids = array();
	                                    if(get_field('job_ids', 'option')) {
		                                    while(has_sub_field('job_ids', 'option')) {
			                                     $job_ids[] = get_sub_field('job_id');
		                                    }
	                                    }
	                                    $featured_jobs = getFeaturedJobs($job_ids);


	                                    $searchPage = get_page_by_title('Career Search');?>
	                                    <?php if ($featured_jobs) : ?>
		                                    <div class="row featured-holder">
			                                    <?php foreach ($featured_jobs as $featured_job) : ?>
				                                    <div class="col-sm-4 same-height">
					                                    <a href="/<?php echo get_page_uri($searchPage); ?>/?job_id=<?php echo $featured_job['id']; ?>" class="box">
						                                    <?php if($featured_job['orddesc']) echo '<strong class="heading">'. htmlspecialchars($featured_job['orddesc']) .'</strong>'; ?>
						                                    <?php if ($featured_job['workstate'] && $featured_job['workstate']) : ?>
							                                    <?php echo $featured_job['workcity']; ?>, <?php echo $featured_job['workstate']; ?>
						                                    <?php elseif ($featured_job['workcity'] && ! $featured_job['workstate']) : ?>
							                                    <?php echo $featured_job['workcity']; ?>
						                                    <?php elseif ( ! $featured_job['workcity'] && $featured_job['workstate']) : ?>
							                                    <?php echo $featured_job['workstate']; ?>
						                                    <?php endif; ?>
					                                    </a>
				                                    </div>
			                                    <?php endforeach; ?>
		                                    </div>
	                                    <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                <?php endif; ?>
            </header>
            <main role="main">
