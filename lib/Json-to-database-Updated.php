<?php 


  
$total_jobs = getActiveJobsCount();
$jobDes = array();

$curl = curl_init();

  $url="https://loxo.co/api/emerald-resource-group/jobs?per_page=".$total_jobs."&status=active";
  

  curl_setopt($curl, CURLOPT_GET, 1);
  curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "emerald_api:orWNbGimpQnTFqvfd6xh");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);
    

     $obj = json_decode($result);
    
  curl_close($curl);
  


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

  curl_close($curl);
    


    $row = $obj->results;


    $conn = connectToJobDatabase();
    


    $sql = "DELETE From erg_api_jobs";

    if ($conn->query($sql) === TRUE) {
            echo "Record Deleted<br>";
        } 
    else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }



    for($i = 0 ; $i < $total_jobs ; $i++){
        echo "<br> $i <>" ;
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
  
        }
        else{
          $cate = $row[$i]->category->name;
          
        }


        if(!$row[$i]->country_code){
          $countCode ="Null";
          
        }
        else{
          $countCode = $row[$i]->country_code;
          
        }


        $sql = "INSERT INTO erg_api_jobs (id , category , jobtitle, workstate , workcity , workzip , workcountry , workcompany , type , contractpos , permposition , tarsal , orddesc , status , owner_email , datecreated , lastupdated ) VALUES ('".$row[$i]->id."' , '".$cate."' , '".$row[$i]->title."' , '".$row[$i]->state_code."' , '".$row[$i]->city."' , '".$row[$i]->zip."' , '".$countCode."' , '".$row[$i]->company->name."' , '".$typ."' ,  '".$cont."' , '".$permp."' , '".$row[$i]->salary."' , '".$row[$i]->title."' , '".$sta."' , '".$row[$i]->owners[0]->email."' , '".$row[$i]->created_at."' ,'".$row[$i]->updated_at."')";


      


        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    

    }


    

    for($i = 0 ; $i < $total_jobs ; $i++){
      echo "<br> <br>";
      $descrip = utf8_encode($jobDes[$i]->description);
      $sql = "UPDATE erg_api_jobs SET posdesc ='".$descrip."' WHERE id='".$jobDes[$i]->id."' ";

      if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    

    }



    $conn->close();

    echo "<br> after conn <>" ;
 

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

  
    function connectToJobDatabase(){
    $dbHost = 'localhost';
    $dbUser = 'erg';
    $dbPass = 'LC0jeax.C0edRed';
    $dbName = 'erg';

    $conn = new mysqli($dbHost, $dbUser, $dbPass , $dbName);

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    } 


    return $conn;
}





?>
