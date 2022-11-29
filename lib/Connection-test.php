<?php
  

add_action( 'wp', 'update_jobs_database_schedule' );
///**
// * On an early action hook, check if the hook is scheduled - if not, schedule it.
// */
function update_jobs_database_schedule() {
    if ( ! wp_next_scheduled( 'update_jobs_database_hourly_event' ) ) {
        wp_schedule_event( time(), 'hourly', 'update_jobs_database_hourly_event');
    }
}

// Force update of job database
//update_jobs_database();

add_action( 'update_jobs_database_hourly_event', 'update_jobs_database' );
/**
 * On the scheduled action hook, run a function.
 */
function update_jobs_database() {
    
    echo "Schedule Run";
}


echo "after die";

?>