<?php

add_action( 'wp', 'update_jobs_database_schedule' );
///**
// * On an early action hook, check if the hook is scheduled - if not, schedule it.
// */
function myprefix_custom_cron_schedule( $schedules ) {
    $schedules['every_six_hours'] = array(
        'interval' => 21600, // Every 6 hours
        'display'  => __( 'Every 6 hours' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'myprefix_custom_cron_schedule' );

///**
// * On an early action hook, check if the hook is scheduled - if not, schedule it.
// */
function update_jobs_database_schedule() {
  if ( ! wp_next_scheduled( 'update_jobs_database_daily_event' ) ) {
    wp_schedule_event( time(), 'every_six_hours', 'update_jobs_database_daily_event');
  }
}


// Force update of job database
//update_jobs_database();

add_action( 'update_jobs_database_daily_event', 'update_Api_jobs_database' );
/**
 * On the scheduled action hook, run a function.
 */
function update_Api_jobs_database() {

    global $wpdb;
    $total_page = getActiveJobsCount();
    $db = $wpdb->prefix."api_jobs";

    if($total_page > 0){
      $conn = connectToJobDatabase();
      $sql = "DELETE From $db";
      $conn->query($sql);
      $conn->close();
    } else {
      die();
    }


    $jobDes = array();
    $curl = curl_init();
    $conn = connectToJobDatabase();

    for ($j=1; $j < $total_page+1; $j++) {

      $url="https://loxo.co/api/emerald-resource-group/jobs?per_page=100&page=".$j."&status=active";
      curl_setopt($curl, CURLOPT_GET, 1);
      curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
      curl_setopt($curl, CURLOPT_USERPWD, "emerald_api:orWNbGimpQnTFqvfd6xh");
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

      $result = curl_exec($curl);
      $obj = json_decode($result);

      /*
      $z=0;
      foreach ($obj->results as $row) {

        $z= $z+1;
        $u = "https://loxo.co/api/emerald-resource-group/jobs/";
        $i = $row->id;
        $urls = $u.$i;

        curl_setopt($curl, CURLOPT_GET, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "emerald_api:orWNbGimpQnTFqvfd6xh");
        curl_setopt($curl, CURLOPT_URL, $urls);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $decode_Result = json_decode($result);
        array_push($jobDes , $decode_Result);

      }
*/
      $row = $obj->results;
      if($row){

        for($i = 0 ; $i < count($obj->results) ; $i++){

            if($row[$i]->job_type->name === "Full Time"){
              $permp = 1;
              $cont = 0;
              $typ = "Permanent";
            }else{
              $permp = 0;
              $cont = 1;
              $typ = "Contract";
            }

            if($row[$i]->status->name === "Active"){
              $sta = "Open";
            }

            if(!$row[$i]->category){
              $cate ="Null";
            }else{
              $cate = $row[$i]->category->name;
            }

            if(!$row[$i]->country_code){
              $countCode ="Null";
            } else{
              $countCode = $row[$i]->country_code;
            }

            if($jobDes[$i]){
              //$descrip = utf8_encode($jobDes[$i]->description);
              $descrip = '';
            }

            $sql = "INSERT INTO $db (id , category , jobtitle, workstate , workcity , workzip , workcountry , workcompany , type , contractpos , permposition , tarsal , orddesc , posdesc , status , owner_email , datecreated , lastupdated ) VALUES ('".$row[$i]->id."' , '".$cate."' , '".$row[$i]->title."' , '".$row[$i]->state_code."' , '".$row[$i]->city."' , '".$row[$i]->zip."' , '".$countCode."' , '".$row[$i]->company->name."' , '".$typ."' ,  '".$cont."' , '".$permp."' , '".$row[$i]->salary."' , '".$row[$i]->title."' , '".$descrip."' , '".$sta."' , '".$row[$i]->owners[0]->email."' , '".$row[$i]->created_at."' ,'".$row[$i]->updated_at."')";
            $conn->query($sql);

        }


        }

}




$conn->close();
 curl_close($curl);


}

function getActiveJobsCount(){
  $url="https://loxo.co/api/emerald-resource-group/jobs?status=active&per_page=100";
  $curl = curl_init();

  curl_setopt($curl, CURLOPT_GET, 1);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
  curl_setopt($curl, CURLOPT_USERPWD, "emerald_api:orWNbGimpQnTFqvfd6xh");

  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

  $result = curl_exec($curl);
  $obj = json_decode($result);
  curl_close($curl);

  return $obj->total_pages;

}


function getWhereClause($categories = array(), $locations = array(), $types = array(), $keywords = array())
{
  global $wpdb;

  $whereClause = '';

  $filterOnCategories = $categories != null && count($categories) > 0;

  if ($filterOnCategories)
  {
    foreach ($categories as $category) {
      if ($category === "") {
        $filterOnCategories = false;
        break;
      }
    }
  }
  if ($filterOnCategories)
  {
    $whereClause .= ' AND (';

    for ($i=0; $i < count($categories); $i++)
    {
      if ($i > 0) {
        $whereClause .= " OR ";
      }

      $category = strtoupper($categories[$i]);

      $whereClause .= " ( UPPER(category) = '" . $wpdb->_real_escape($category) . "' ) ";

    }
    $whereClause .= ") ";
  }

  $filterOnLocations = $locations != null && count($locations) > 0;
  if ($filterOnLocations)
  {

    $whereClause .= " AND ( ";

    for ($i = 0; $i < count($locations); $i++)
    {
      if ($i > 0){
        $whereClause .= " or ";
      }

      $location = trim(strtoupper($locations[$i]));

      $locationCity = null;
      $locationState = null;

      if (strlen($location)>0 && strlen($location) <=2)  {

        $locationState = $location;
        $whereClause .= " ( upper(workstate) = '" . $wpdb->_real_escape($locationState) . "' ) ";

      } else if ($location) {

        $locationState = $location;
        $whereClause .= " ( upper(workcity) = '" . $wpdb->_real_escape($locationState) . "' ) ";

      } else {
        $whereClause .= " ( 1 = 1 ) ";
      }
    }

    $whereClause .= ") ";

  }

  $filterOnTypes = $types != null && count($types) > 0;
  if ($filterOnTypes) {

    $whereClause .= " AND ( ";

    for ($i = 0; $i < count($types); $i++)
    {
      if ($i > 0){
        $whereClause .= " OR ";
      }
      $type = strtoupper($types[$i]);

      if ($type == 'ALL') {
        $type = "%";
      }

      $whereClause .= " ( upper(type) like '" . $wpdb->_real_escape($type) . "' ) ";
    }

      $whereClause .= ") ";

    }

  $filterOnKeywords = $keywords != null &&  count($keywords) > 0;
  if ($filterOnKeywords)
  {
    $whereClause .= " AND ( ";

    for ($i = 0; $i < count($keywords); $i++)
    {
      if ($i > 0){
        $whereClause .= " OR ";
      }

      $keyword = trim(strtoupper($keywords[$i]));
      $keyword = "%" . $keyword . "%";

      $whereClause .= " ( UPPER(orddesc) LIKE '" . $keyword . "' OR UPPER(posdesc) LIKE '" . $keyword . "' ) ";

    }

    $whereClause .= ") ";
  }


  return $whereClause;
}

function getFeaturedJobs($job_ids) {
  global $wpdb;
  $db = $wpdb->prefix."api_jobs";

  if (count( $job_ids )) {
    $where = '( ';

    foreach ( $job_ids as $key => $job_id ) {
      if ( $key > 0 ) {
        $where .= ' OR ';
      }
      $where .= ' id = ' . $wpdb->_real_escape( $job_id );
    }

    $where .= ' )';

    $jobs = $wpdb->get_results( 'SELECT * FROM '.$db.' WHERE status = "OPEN" AND ' . $where . ';', ARRAY_A );

    return $jobs;
  }

  return null;
}

function getJobsTotalCount($categories = array(), $locations = array(), $types = array(), $keywords = array())
{

  global $wpdb;
  $db = $wpdb->prefix."api_jobs";

  $whereClause = getWhereClause($categories, $locations, $types, $keywords);

  $count = $wpdb->get_var( 'SELECT COUNT(*) FROM '.$db.' WHERE status = "OPEN"' . $whereClause );

  return $count;
}

function getJobs($current_page = 1, $rows_per_page = 10, $categories = array(), $locations = array(), $types = array(), $keywords = array()) {
  global $wpdb;
  $db = $wpdb->prefix."api_jobs";

  if ($current_page === 1)
  {
    $start_row = 0;
    $end_row = $current_page * $rows_per_page;
  }
  else
  {
    $start_row = ($current_page - 1) * $rows_per_page;
    $end_row = $current_page * $rows_per_page;
  }

  $whereClause = getWhereClause($categories, $locations, $types, $keywords);

  $jobs = $wpdb->get_results( 'SELECT * FROM '.$db.' WHERE status = "OPEN" ' . $whereClause . ' ORDER BY datecreated DESC LIMIT ' . $start_row . ',' . $rows_per_page . ';', ARRAY_A );

  return $jobs;
}

function get_job_by_id($id) {
  global $wpdb;
  $db = $wpdb->prefix."api_jobs";
  $job = $wpdb->get_row( 'SELECT * FROM $db WHERE id = ' . (int) $id . ';', ARRAY_A );

  return $job;
}

function getJobCategories() {
  $job_categories = get_transient( 'job_categories' );
  if ( false === $job_categories ) {

    $link = connectToJobDatabase();

    $query = mssql_query('SELECT * FROM JOB_CATEGORIES');

    $job_categories = array();
    while ($row = mssql_fetch_assoc($query)) {
      $job_categories[] = $row;
    }

    mssql_free_result($query);

    set_transient( 'job_categories', $job_categories, 3600 );
  }

  return $job_categories;
}

function getJobTypes() {

  $job_types = get_transient( 'job_types' );
  if ( false === $job_types ) {

    $link = connectToJobDatabase();

    $query = mssql_query('SELECT * FROM JOB_TYPES');

    $job_types = array();
    while ($row = mssql_fetch_assoc($query)) {
      $job_types[] = $row;
    }

    mssql_free_result($query);

    set_transient( 'job_types', $job_types, 3600 );
  }

  return $job_types;
}

function getJobLocations() {

  $job_locations = get_transient( 'job_locations' );
  if ( false === $job_locations ) {

    $link = connectToJobDatabase();

    $query = mssql_query('SELECT * FROM JOB_LOCATIONS');

    $job_locations = array();
    while ($row = mssql_fetch_assoc($query)) {
      $job_locations[] = $row;
    }

    mssql_free_result($query);

    set_transient( 'job_locations', $job_locations, 3600 );
  }

  return $job_locations;
}

function getJobKeywords() {

  $job_keywords = get_transient( 'job_keywords' );
  if ( false === $job_keywords ) {

    $link = connectToJobDatabase();

    $query = mssql_query('SELECT * FROM JOB_KEYWORDS');

    $job_keywords = array();
    while ($row = mssql_fetch_assoc($query)) {
      $job_keywords[] = $row;
    }

    mssql_free_result($query);

    set_transient( 'job_keywords', $job_keywords, 3600 );
  }

  return $job_keywords;
}


function getSalaryJobs($current_page , $rows_per_page, $keywords , $locations , $type , $salary){

    global $wpdb;
    $db = $wpdb->prefix."api_jobs";


    if ($current_page === 1)
    {
      $start_row = 0;
      $end_row = $current_page * $rows_per_page;
    }
    else
    {
      $start_row = ($current_page - 1) * $rows_per_page;
      $end_row = $current_page * $rows_per_page;
    }



      $keyword = "%" . $keywords[0] . "%";
      $location = "%" . $locations[0] . "%";
      $type = "%" . $type[0] . "%";



      if (strlen($location)-2 > 0 && strlen($location)-2 <= 2)  {

        # Work state code...
        $querystr = "
                      SELECT *
                      FROM $db
                      WHERE workstate like '".$location."' AND UPPER(orddesc) LIKE '".$keyword."' AND tarsal >= '".$salary."' AND type like '".$type."' ORDER BY datecreated DESC LIMIT $start_row,$rows_per_page ";
                    $filterJobs = $wpdb->get_results($querystr , ARRAY_A);

      }
      else
       {

        # for all locations...
        $querystr = "
                      SELECT *
                      FROM $db
                      WHERE workcity like '".$location."' AND UPPER(orddesc) LIKE '".$keyword."' AND tarsal >= '".$salary."' AND type like '".$type."' ORDER BY datecreated DESC LIMIT $start_row,$rows_per_page ";
                    $filterJobs = $wpdb->get_results($querystr , ARRAY_A);
      }



  return $filterJobs;

}


function getSalaryJobsCount($keywords , $locations , $type , $salary){

    global $wpdb;
    $db = $wpdb->prefix."api_jobs";



      $keyword = "%" . $keywords[0] . "%";
      $location = "%" . $locations[0] . "%";
      $type = "%" . $type[0] . "%";



      if (strlen($location)-2 > 0 && strlen($location)-2 <= 2)  {

        # Work state code...
        $querystr = "
                      SELECT count(*)
                      FROM $db
                      WHERE workstate like '".$location."' AND UPPER(orddesc) LIKE '".$keyword."' AND tarsal >= '".$salary."' AND type like '".$type."'  ";
                    $count = $wpdb->get_var($querystr);

      }
      else
       {

        # for all locations...
        $querystr = "
                      SELECT count(*)
                      FROM $db
                      WHERE workcity like '".$location."' AND UPPER(orddesc) LIKE '".$keyword."' AND tarsal >= '".$salary."' AND type like '".$type."' ";
                    $count = $wpdb->get_var($querystr);
      }



  return $count;

}


function getJobsByTypes($current_page , $rows_per_page, $keywords , $locations , $types , $salary){

    global $wpdb;
    $db = $wpdb->prefix."api_jobs";

    if ($current_page === 1)
    {
      $start_row = 0;
      $end_row = $current_page * $rows_per_page;
    }
    else
    {
      $start_row = ($current_page - 1) * $rows_per_page;
      $end_row = $current_page * $rows_per_page;
    }

      $keyword = "%" . $keywords[0] . "%";
      $location = "%" . $locations[0] . "%";
      $type = $types[0];



      if (strlen($location)-2 > 0 && strlen($location)-2 <= 2)  {

        # Work state code...
        $querystr = "
                      SELECT *
                      FROM $db
                      WHERE workstate like '".$location."' AND UPPER(orddesc) LIKE '".$keyword."' AND type ='".$type."' AND tarsal >= '".$salary."' ORDER BY datecreated DESC LIMIT $start_row,$rows_per_page ";
                    $filterJobs = $wpdb->get_results($querystr , ARRAY_A);

                    if ($wpdb->last_error) {
            echo ' ' . $wpdb->last_error;
          }


      }
      else
       {

        # for all locations...
        $querystr = "
                      SELECT *
                      FROM $db
                      WHERE workcity like '".$location."' AND UPPER(orddesc) LIKE '".$keyword."' AND type ='".$type."' AND tarsal >= '".$salary."' ORDER BY datecreated DESC LIMIT $start_row,$rows_per_page ";
                    $filterJobs = $wpdb->get_results($querystr , ARRAY_A);

                    if ($wpdb->last_error) {
            echo '' . $wpdb->last_error;
          }


      }




  return $filterJobs;

}

function getJobByLocationFilter($current_page , $rows_per_page, $keywords , $locations , $types , $salary ){

  global $wpdb;
  $db = $wpdb->prefix."api_jobs";

    if ($current_page === 1)
    {
      $start_row = 0;
      $end_row = $current_page * $rows_per_page;
    }
    else
    {
      $start_row = ($current_page - 1) * $rows_per_page;
      $end_row = $current_page * $rows_per_page;
    }

      $keyword = "%" . $keywords[0] . "%";
      $location =  "%".$locations[0]. "%";
      $type = "%".$types[0]."%";

          $querystr = "
                        SELECT *
                        FROM $db
                        WHERE workcity like '".$location."' and orddesc LIKE '".$keyword."' and type LIKE '".$type."' ORDER BY datecreated DESC LIMIT $start_row,$rows_per_page";
                    $filterJobs = $wpdb->get_results($querystr , ARRAY_A);

                    if ($wpdb->last_error) {
            echo '' . $wpdb->last_error;
          }



    return $filterJobs;


}


function getCountByLocationFilter($keywords , $locations , $types , $salary ){


  global $wpdb;
  $db = $wpdb->prefix."api_jobs";


      $keyword = "%" . $keywords[0] . "%";
      $location =  "%".$locations[0]. "%";
      $type = "%".$types[0]."%";

          $querystr = "
                        SELECT count(*)
                        FROM $db
                        WHERE workcity like '".$location."' and orddesc LIKE '".$keyword."' and type LIKE '".$type."' ";
                    $count = $wpdb->get_var($querystr);

                    if ($wpdb->last_error) {
            echo '' . $wpdb->last_error;
          }

    return $count;


}


function getJobsByCompaines($current_page , $rows_per_page, $keywords , $company){

  global $wpdb;
  $db = $wpdb->prefix."api_jobs";

    if ($current_page === 1)
    {
      $start_row = 0;
      $end_row = $current_page * $rows_per_page;
    }
    else
    {
      $start_row = ($current_page - 1) * $rows_per_page;
      $end_row = $current_page * $rows_per_page;
    }

    $keyword = "%".$keywords[0]."%";

    $querystr = "
                      SELECT *
            FROM $db
            WHERE workcompany ='".$company."' and orddesc like '".$keyword."' ";
                    $companies = $wpdb->get_results($querystr , ARRAY_A);

                    return $companies;



}

function getCompanyJobsCount( $keywords , $company ){

  global $wpdb;
  $db = $wpdb->prefix."api_jobs";

  $keyword = "%".$keywords[0]."%";

  $querystr = "
                      SELECT count(*)
            FROM $db
            WHERE workcompany ='".$company."' and orddesc like '".$keyword."' ";
                    $count = $wpdb->get_var($querystr);


                    return $count;

}

 function connectToJobDatabase(){
    $dbHost = '127.0.0.1';
    $dbUser = 'fw6143365292';
    $dbPass = 'p7rW7u7EZcG3qwpd00YiNBlo9SvG1P';
    $dbName = 'db6532596366';

    $conn = new mysqli($dbHost, $dbUser, $dbPass , $dbName);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }


    return $conn;
}
