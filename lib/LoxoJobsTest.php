<?php 


	

	$total_jobs = getActiveJobsCount();


	echo " Loxo API JOBS :: JOBS Count = $total_jobs";

	echo "<br><br><br>";


	$jobDes = array();

	$url="https://loxo.co/api/emerald-resource-group/jobs?per_page=".$total_jobs."&status=active";

	$curl = curl_init();

	curl_setopt($curl, CURLOPT_GET, 1);


	curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "emerald_api:orWNbGimpQnTFqvfd6xh");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    curl_close($curl);


  $obj = json_decode($result);
   	

  $curl = curl_init();

  foreach ($obj->results as $row) {
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



  echo "<br><br>Jobs:";

	echo "<br><br><br>";
  curl_close($curl);

 
  foreach ($obj->results as $row) {
   	


	 echo $row->id . " , ", $row->category->name . " , " , $row->title . " , ", $row->state_code . " , "  , $row->city . " , "   , $row->zip . " , " , $row->country_code . " , ", $row->company->name . " , "  , $row->job_type->name . " , " , $row->salary . " , ", $row->status->name . " , "  , $row->created_at . " , " , $row->updated_at . " , "  ;
   	echo "<br><br><br><br>";




   }

 	
 	echo "<br><br>Job Descriptions:";

	echo "<br><br><br>";


    foreach ($jobDes as $row) {
    	echo "$row->id  <br>";
    	echo $row->description;
    	 echo "<br><br>";

    		
   	}


    
    function getActiveJobsCount(){
      $url="https://loxo.co/api/emerald-resource-group/jobs?status=active&per_page=1";
      $curl = curl_init();



        curl_setopt($curl, CURLOPT_GET, 1);


        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "emerald_api:orWNbGimpQnTFqvfd6xh");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);
        $obj = json_decode($result);
        curl_close($curl);
        

        return $obj->total_count;
        
        
    }   






?>