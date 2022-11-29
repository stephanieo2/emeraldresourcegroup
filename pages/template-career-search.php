<?php
/*
Template Name: Career Search Template
*/
get_header();

$rows_per_page = 20;
$current_page = (intval(get_query_var('page_num'))) ? intval(get_query_var('page_num')) : 1;

$job_id = is_numeric(get_query_var('job_id')) ? get_query_var('job_id') : false;
$categories = (array) get_query_var('categories', array());
$locations = (array) get_query_var('locations', array());
$types = (array) get_query_var('types', array());
$keywords = (array) get_query_var('keywords', array());

$searchPage = get_page_by_title('Career Search');

?>



            <!--    <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>-->
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

    <style type="text/css">
      input[type=search] {
        background-color: #fff;
        border:2px solid;
         border-color: #ccc;
         padding-left: 7px;
       }
    </style>

<!-- banner -->
<div class="visual alt">
  <div class="bg-stretch">
    <?php if (has_post_thumbnail( get_the_ID() )) : ?>
      <?php echo preg_replace('#(width|height)=\"\d*\"\s#', "", wp_get_attachment_image(get_post_thumbnail_id(get_the_ID()), 'thumbnail_1440x525')); ?>
    <?php else: ?>
      <img src="<?php echo get_template_directory_uri(); ?>/images/bg_page.jpg" alt="image description" >
    <?php endif; ?>
  </div>
</div>
  <!-- content -->
  <div class="two-columns">
    <div class="container">
      <div class="row">
        <?php get_sidebar('career-search'); ?>
        <div class="col-xs-12 col-md-8">
          <div id="">
            <?php if ( ! $job_id ) : ?>
              <?php while (have_posts()) : the_post(); ?>
                <?php the_title('<div class="title"><h1>', '</h1></div>');
                $keyword = (isset($keywords[0])) ? $keywords[0] : '';
                $location = (isset($locations[0])) ? $locations[0] : '';
                ?>

                <form method="get" action="/<?php echo get_page_uri($searchPage); ?>/" class="icl-WhatWhere icl-WhatWhere--lg">
                  <div style="padding-left: 0px;" class="col-md-5 col-sm-5 icl-WhatWhere-input--what"><div class="icl-Autocomplete">
                      <div class="icl-TextInputClearable"><div class="icl-TextInput">
                        <div class="icl-TextInput-labelWrapper">
                          <label style="font-size: 20px;" id="label-q" for="text-input-what" class="icl-TextInput-label icl-TextInput-label--whatWhere">what</label>
                          <p style="font-size: 10px;" id="text-input-what-helpText" class="icl-TextInput-helpText icl-TextInput-helpText--whatWhere">job title, keywords, or company</p>
                        </div>
                        <div class="icl-TextInput-wrapper">
                          <input type="search" aria-labelledby="label-q text-input-what-helpText" id="keywords-field" name="keywords[]" maxlength="512" placeholder="" autocomplete="off" class="icl-TextInput-control icl-TextInput-control--whatWhere" value="<?php echo $keyword; ?>">
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
                          <input  type="search" aria-labelledby="label-l text-input-where-helpText" id="locations" name="locations[]" maxlength="62" placeholder="" autocomplete="off" class="icl-TextInput-control icl-TextInput-control--whatWhere" value="<?php echo $location; ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="icl-TextInput-labelWrapper">
            <label style="font-size: 20px;" id="label-l" for="text-input-where" class="icl-TextInput-label icl-TextInput-label--whatWhere"></label>
            <p style="font-size: 10px;" id="text-input-where-helpText" class="icl-TextInput-helpText icl-TextInput-helpText--whatWhere"></p>
          </div>
                <div style="padding-top: 20px;" class="icl-WhatWhere-buttonWrapper ">
                  <button id="form-button" style="font-size: 1.5rem; padding-right: 15px; padding-left: 15px;" size="md" type="submit" class="hidden-xs icl-Button icl-Button--md icl-WhatWhere-button">Find Jobs</button>
                  <button id="form-button" style="" size="md" type="submit" class="form-control hidden-sm hidden-md hidden-lg icl-Button icl-Button--md icl-WhatWhere-button">Find Jobs</button>
                </div>
            </form>




                    <?php

                      $salary =  (isset($_GET['salary'])) ? $_GET['salary'] : '';
                      $company = (isset($_GET['company'])) ? $_GET['company'] : '';
                      $lf = (isset($_GET['lf'])) ? $_GET['lf'] : '';

                      $l = (isset($locations[0])) ? $locations[0] : '';
                      $t = (isset($types[0])) ? $types[0] : '';
                      $k = (isset($keywords[0])) ? $keywords[0] : '';




                       if ( ! empty($categories) || ! empty($locations) || ! empty($types) || ! empty($keywords) ) : ?>
                      <?php

                    if($salary){
                        //$jobs = getSalaryJobs($current_page , $rows_per_page, $keywords , $locations , $type , $salary);
                        //$jobsTotalCount = getSalaryJobsCount($keywords , $locations , $type , $salary);
                      }
                      elseif ($l && $t && $k ) {

                        $jobs = getJobsByTypes($current_page, $rows_per_page,$keywords , $locations , $types , $salary);
                        $jobsTotalCount = getJobsCount($keywords , $locations , $types);
                      }
                      elseif ($company) {

                        $jobs = getJobsByCompaines($current_page , $rows_per_page, $keywords , $company);
                        $jobsTotalCount = getCompanyJobsCount( $keywords , $company);
                        # code...
                      }elseif (isset($_GET['keywords']) && isset($_GET['locations']) && isset($_GET['types']) && isset($_GET['salary']) ) {

                        $jobs = getJobByLocationFilter($current_page , $rows_per_page, $keywords , $locations , $types , $salary );
                        $jobsTotalCount = getCountByLocationFilter($keywords , $locations , $types , $salary);

                      }
                      else{


                        if(!$t){
                          $types = NULL;
                          $jobs = getJobs($current_page, $rows_per_page, $categories, $locations, $types, $keywords);
                          $jobsTotalCount = getJobsTotalCount($categories, $locations, $types, $keywords);
                        }
                        else{

                          $jobs = getJobs($current_page, $rows_per_page, $categories, $locations, $types, $keywords);
                          $jobsTotalCount = getJobsTotalCount($categories, $locations, $types, $keywords);
                        }

                      }


                      ?>

                      <h2 id="current-job-openings" style="margin-top: 90px;">Current Job Openings:</h2>
                      <?php foreach ($jobs as $job) : ?>
                          <div class="listing-item">
                            <a class="title" href="?job_id=<?php echo $job['id']; ?>">
                              <strong><?php echo htmlspecialchars($job['orddesc']); ?></strong>
                              <?php if ($job['workcity'] || $job['workstate']) { ?>&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;
                              <?php echo htmlspecialchars($job['workcity']); ?>
                                <?php if ($job['workstate']) { ?>, <?php echo htmlspecialchars($job['workstate']); ?>
                                <?php
                                      }
                                    } ?>
                            </a>
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
                    echo '<p class="alert alert-danger">No results have been found but we have remote positions. Please fill out the form below and we will help you find the perfect role.</p>';

                    gravity_form( 4, $display_title = false, $display_description = true, $display_inactive = false, $field_values = null, $ajax = false, 0, $echo = true );

                  }
                  echo '<p id="pagination-wrapper">' . paginate_links($pagination_args) . '</p>';
                  ?>

                  <?php edit_post_link( __( 'Edit', 'emeraldresourcegroup' ), '<p>', '</p>' ); ?>
                <?php else : ?>
                <?php endif; ?>
              <?php endwhile; ?>
            <?php else : ?>
              <?php //var_dump($job); ?>
              <div class="title"><h1><?php echo htmlspecialchars($job->orddesc); ?></h1></div>
              <p class="details">
                <strong>Location:</strong> <?php echo $job->workcity . ', ' . $job->workstate; ?><br>
                <strong>Job Type:</strong> <?php echo $job->type; ?><br>
                <?php if ( $job->tarsal !== '0.00' ) : ?>
                <strong>Compensation:</strong> &dollar;<?php echo number_format($job->tarsal, 2); ?><br>
                <?php endif; ?>
               <!-- <strong>Reference Code:</strong> --> <?php //echo $job['id']; ?>
              </p>
              <?php

              if( empty($job->posdesc) || $job->posdesc == '' ){

                  $curl = curl_init();
                  $u = "https://loxo.co/api/emerald-resource-group/jobs/" . $job->id;
                  curl_setopt($curl, CURLOPT_GET, 1);
                  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                  curl_setopt($curl, CURLOPT_USERPWD, "emerald_api:orWNbGimpQnTFqvfd6xh");
                  curl_setopt($curl, CURLOPT_URL, $u);
                  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                  $result = curl_exec($curl);
                  $decode_Result = json_decode($result);

                  global $wpdb;
                  $sql = "UPDATE " . $wpdb->prefix . "api_jobs SET posdesc='" . $decode_Result->description . "' WHERE id=" . $job->id;
                  $results = $wpdb->get_results($sql);

                  $job->posdesc = $decode_Result->description;

              }

              echo wpautop('<strong>Requirements:</strong> ' . $job->posdesc);

              ?>
              <p class="row" style="margin-left:0;margin-right:0;"><a href="/submit-resume/?job_id=<?php echo $job->id; ?>" class="btn btn-default col-xs-12 col-sm-6 col-lg-4"><span class="text"><span class="text-hold">Apply Today</span></span><span class="icon icon-arrow-right"></span></a></p>

            <?php endif; ?>



          </div>
        </div>
      </div>
    </div>
  </div>

  <?php get_footer(); ?>
