<?php
session_start();
if(isset($_POST['url']))
{
    //Get the url
    $url = $_POST['url'];
    //Break the input url in array a format
    $url_array =  explode('/',$url);
    //Check the Url is Valid or not
    if(strcmp($url_array[0],"https:")||strcmp($url_array[1],"")||strcmp($url_array[2],"github.com")||empty($url_array[3])||empty($url_array[4]))
    {
      $_SESSION['error'] = "1";
      header('Location: index.php');
      die;
    }
    //Make url for the github Api, $url_array[3] = username, $url_array[4] = repository name
    $url = "https://api.github.com/repos/".$url_array[3]."/".$url_array[4];
   
    //call the curlRequestOnGitApi function and get api Response
    $response = curlRequestOnGitApi($url);
    
    //Get total no of open issues using the $response array
    $total_issues = $response["open_issues_count"];
    $_SESSION['total_issues'] = empty($total_issues)?0:$total_issues;


    //Date and Time of 24 hours ago
    $time_last24hr = date('Y-m-d\TH:i:s.Z\Z', strtotime('-1 day', time()));
    //Make url for the github Api for last 24 hrs that return only issues updated at or after this time 
    $url = "https://api.github.com/repos/".$url_array[3]."/".$url_array[4]."/issues?since=".$time_last24hr;     
    //call the curlRequestOnGitApi function and get api Response
    $response = curlRequestOnGitApi($url);
    //Get total no of open issues that were opened in last 24 hours
    $issues_last24hr = count($response);
    $_SESSION['last24_issues'] = $issues_last24hr;


    //Date and Time 7 day ago
    $time_7daysago = date('Y-m-d\TH:i:s.Z\Z', strtotime('-7 day', time()));
    //Make url for the github Api with since parameter equal to time of 7 days ago that return only issues updated at or after this time 
    $url = "https://api.github.com/repos/".$url_array[3]."/".$url_array[4]."/issues?since=".$time_7daysago;
    //call the curlRequestOnGitApi function and get api Response
    $response = curlRequestOnGitApi($url);
    //Get total no of open issues that were opened in 7 days ago
    $issues_last7days = count($response);
    $_SESSION['last7days_issues'] =  $issues_last7days-$issues_last24hr;
    $_SESSION['morethan7days_issues'] = $total_open_issues-$issues_last7days;
    unset($_SESSION['error']);
    header('Location: index.php');
}


/**
 * Curl Function for getting the api response
 */
function curlRequestOnGitApi($url)
{
    $ch = curl_init();

    //Set the url
    curl_setopt($ch, CURLOPT_URL,$url);

    //Set the User Agent as username
    curl_setopt($ch, CURLOPT_USERAGENT, "anyusername");

    //Accept the response as json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Accept: application/json'));

    //Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute
    $result=curl_exec($ch);

    // Closing
    curl_close($ch);

    //Decode the json in array
    $new_result=json_decode($result,true);

    //Return array
    return $new_result;
}

?>