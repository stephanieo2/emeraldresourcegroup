<html dir="ltr" lang="en"><head>

<?php
/*
Template Name: main search template
*/

    get_header();

?>
	

    
    <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/9803d0f774920a2583a276574bc635b4/styles/proctor_homepage_anNqX2hwX3BvcHVsYXJfc2VhcmNoZXNfd2l0aG91dF9yZWNlbnRfc2VhcmNoZXNfdHN0MQ-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/8a0fe5bb909f1f08f5a124d653be2acd/styles/proctor_homepage_aHBfbWVzc2FnZXNmcm9tZW1wX3YxXzA0MThfdHN0-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/b49ee258af031d33ef420ab66aa29f3f/styles/proctor_homepage_bXlpbmRqYXN4Zm9vdGVycmVzdW1lY3Rh-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/e275ab2c062ad862f94ddf7a70993c2e/styles/proctor_homepage_Y21pX2pwX3RvZy0x-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/c9aedb2754fb329b1fb827c95e0e2283/styles/proctor_homepage_anNqX2hwX2NsYXNzaWNyc3JlbW92YWxfdjFfMDUxOV90c3Q-ltr.css">
            <link rel="stylesheet" href="https://d3hbwax96mbv6t.cloudfront.net/hp/s/92a8d84e22abeff8f7795354ccda0ab4/styles/homepage.noproctor-ltr.css">
            

            <!--    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>-->
		<link media="all" rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/fonts.css" >
		<link media="all" rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" >
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/style.css"  />
		<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/theme.css"  />
		<link rel="icon" type="image/ico" href="/favicon.ico"/>
		
		<script type="text/javascript">
			var pathInfo = {
				base: '<?php echo get_template_directory_uri(); ?>/',
				css: 'css/',
				js: 'js/',
				swf: 'swf/',
			}
		</script>

		


</head>

    
<body>
    <!-- content -->
	<div class="two-columns">
		<div style="margin-top: 100px;" class="container">
			<div class="row">
			<div class="col-xs-1 col-md-1">
			</div>

				<div class="col-xs-12 col-md-10">
					<div id="">
						<?php if ( ! $job_id ) : ?>
							<?php while (have_posts()) : the_post(); ?>
								<?php the_title('<div class="title"><h1>', '</h1></div>'); ?>

								<form method="get" action="/for-career-candidates/career-search/" class="icl-WhatWhere icl-WhatWhere--lg">
									<div class="icl-WhatWhere-input--what"><div class="icl-Autocomplete">
										<div class="icl-TextInputClearable"><div class="icl-TextInput">
											<div class="icl-TextInput-labelWrapper">
												<label style="font-size: 20px;" id="label-q" for="text-input-what" class="icl-TextInput-label icl-TextInput-label--whatWhere">what</label>
												<p style="font-size: 10px;" id="text-input-what-helpText" class="icl-TextInput-helpText icl-TextInput-helpText--whatWhere">job title, keywords, or company</p>
											</div>
											<div class="icl-TextInput-wrapper">
												<input type="text" aria-labelledby="label-q text-input-what-helpText" id="keywords-field" name="keywords[]" maxlength="512" placeholder="" autocomplete="off" class="icl-TextInput-control icl-TextInput-control--whatWhere">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="icl-WhatWhere-input--where">
								<div class="icl-Autocomplete">
									<div class="icl-TextInputClearable">
										<div class="icl-TextInput">
											<div class="icl-TextInput-labelWrapper">
												<label style="font-size: 20px;" id="label-l" for="text-input-where" class="icl-TextInput-label icl-TextInput-label--whatWhere">where</label>
												<p style="font-size: 10px;" id="text-input-where-helpText" class="icl-TextInput-helpText icl-TextInput-helpText--whatWhere">city, province, or region</p>
											</div>
											<div class="icl-TextInput-wrapper">
												<input type="text" aria-labelledby="label-l text-input-where-helpText" id="locations" name="locations[]" maxlength="62" placeholder="" autocomplete="off" class="icl-TextInput-control icl-TextInput-control--whatWhere">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="icl-WhatWhere-buttonWrapper">
								<button size="md" type="submit" class="icl-Button icl-Button--primary icl-Button--md icl-WhatWhere-button">Find Jobs</button>
							</div>
						</form>
								<?php if ( ! empty($categories) || ! empty($locations) || ! empty($types) || ! empty($keywords) ) : ?>
									<?php $jobs = getJobs($current_page, $rows_per_page, $categories, $locations, $types, $keywords); ?>
									<?php $jobsTotalCount = getJobsTotalCount($categories, $locations, $types, $keywords); ?>
									<h2 id="current-job-openings" style="margin-top: 90px;">Current Job Openings:</h2>
									<?php foreach ($jobs as $job) : ?>
										<div class="listing-item">
											<a class="title" href="?job_id=<?php echo $job['id']; ?>"><strong><?php echo htmlspecialchars($job['orddesc']); ?></strong><?php if ($job['workcity'] || $job['workstate']) { ?>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;<?php echo htmlspecialchars($job['workcity']); ?><?php if ($job['workstate']) { ?>, <?php echo htmlspecialchars($job['workstate']); ?><?php } } ?></a>
										</div>
									<?php endforeach; ?>

									<?php
									global $wp_rewrite;

									$pagination_args = array(
										'base' => @add_query_arg('page_num','%#%'),
										'format' => '?page_num=%#%',
										'total' => ceil($jobsTotalCount/$rows_per_page),
										'current' => $current_page,
										'show_all' => false,
										'type' => 'plain',
										'prev_text' => '<span class="icon-arrow-left"></span>&nbsp;&nbsp;Previous',
										'next_text' => __('Next&nbsp;&nbsp;<span class="icon-arrow-right"></span>'),
										'add_args' => false,
									);

									if ($current_page === 1)
									{
										$start_row = 1;
									}
									else
									{
										$start_row = (($current_page - 1) * $rows_per_page) + 1;
									}
									$end_row = (($start_row + $rows_per_page) < $jobsTotalCount) ? (($start_row + $rows_per_page) - 1) : $jobsTotalCount;

									if ($jobsTotalCount > 0) {
										echo '<p style="margin-top: 50px;">Showing ' . $start_row . "&dash;" . $end_row . " of " . $jobsTotalCount . " entries.</p>";
										if ($current_page == 1) {
											echo '<script>jQuery(document).ready(function() { setTimeout(function() { jQuery("html,body").animate({ scrollTop: jQuery("#current-job-openings").offset().top - 100 }, 600) }, 500); });</script>';
										}
									}
									else {
										echo '<p class="alert alert-danger">No results found.</p>';
									}
									echo '<p id="pagination-wrapper">' . paginate_links($pagination_args) . '</p>';
									?>

									<?php edit_post_link( __( 'Edit', 'emeraldresourcegroup' ), '<p>', '</p>' ); ?>
								<?php else : ?>
								<?php endif; ?>
							<?php endwhile; ?>
						<?php else : ?>
							<?php $job = get_job_by_id($job_id); ?>
							<div class="title"><h1><?php echo htmlspecialchars($job['orddesc']); ?></h1></div>
							<p class="details">
								<strong>Location:</strong> <?php echo $job['workcity'] . ', ' . $job['workstate']; ?><br>
								<strong>Job Type:</strong> <?php echo $job['type']; ?><br>
								<?php if ( $job['tarsal'] !== '0.00' ) : ?>
								<strong>Compensation:</strong> &dollar;<?php echo number_format($job['tarsal'], 2); ?><br>
								<?php endif; ?>
								<strong>Reference Code:</strong> <?php echo $job['id']; ?>
							</p>
							<?php echo wpautop('<strong>Requirements:</strong> ' . $job['posdesc']); ?>
							<p class="row" style="margin-left:0;margin-right:0;"><a href="/submit-resume/?job_id=<?php echo $job['id']; ?>" class="btn btn-default col-xs-12 col-sm-6 col-lg-4"><span class="text"><span class="text-hold">Apply Today</span></span><span class="icon icon-arrow-right"></span></a></p>

						<?php endif; ?>



					</div>
				</div>
			</div>

			<div class="icl-Grid icl_Grid--gutters">
				<div class="icl-Grid-col icl-u-lg-offset3 icl-u-lg-span9 icl-u-lg-block icl-u-xl-offset4 icl-u-xl-span8 icl-u-xs-hide jobsearch-PostJobPromo-container">
					<div class="icl-TextPromo icl-TextPromo--icon ">
						<a href="https://www.emeraldresourcegroup.com/submit-resume/?job_id=9861" data-href="" aria-label="Post your CV" class="icl-TextPromo-link">
							<span class="icl-TextPromo-linkText">Post your CV</span>
						</a>
						<span class="icl-TextPromo-divider"> – </span>
						<span class="icl-TextPromo-text">It's only take few seconds</span>
					</div>

					<div class="icl-TextPromo icl-TextPromo--icon ">
						<a href="#" data-href="" aria-label="Post your CV" class="icl-TextPromo-link">
							<span class="icl-TextPromo-linkText">Employers: Post a job</span>
						</a>
						<span class="icl-TextPromo-divider"> – </span>
						<span class="icl-TextPromo-text">Your next hire is here</span>
					</div>

				</div>
			</div>


			


		</div>
	</div>
    
 	<div style="margin-top: 200px;" class="container"></div>

	<?php get_footer(); ?>
</body></html>
