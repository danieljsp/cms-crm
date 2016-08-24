<?php
// Create connection
$conn = new mysqli("127.0.0.1", "root", "stusWeW2", "impulsa");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username  FROM usuarios ";
$result = $conn->query($sql);


$conn->close();

$url = "http://52.40.51.210/service/v4_1/rest.php";
$username = "admin";
$password = "stusWeW2";


    //function to make cURL request
    function call($method, $parameters, $url)
    {
        ob_start();
        $curl_request = curl_init();


        curl_setopt($curl_request, CURLOPT_URL, $url);
        curl_setopt($curl_request, CURLOPT_POST, 1);
        curl_setopt($curl_request, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl_request, CURLOPT_HEADER, 1);
        curl_setopt($curl_request, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl_request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_request, CURLOPT_FOLLOWLOCATION, 0);


        $jsonEncodedData = json_encode($parameters);


        $post = array(
             "method" => $method,
             "input_type" => "JSON",
             "response_type" => "JSON",
             "rest_data" => $jsonEncodedData
        );


        curl_setopt($curl_request, CURLOPT_POSTFIELDS, $post);
        $result = curl_exec($curl_request);
  if ( $error = curl_error($curl_request) )
  {
  echo 'ERROR: ',$error;
  echo "<br />";
  echo curl_error($curl_request);
  echo "<br />";
  echo curl_errno($curl_request);
  }

        curl_close($curl_request);


        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();


        return $response;
    }


    //login ---------------------------------------------
    $login_parameters = array(
         "user_auth" => array(
              "user_name" => $username,
              "password" => md5($password),
              "version" => "1"
         ),
         "application_name" => "RestTest",
         "name_value_list" => array(),
    );


    $login_result = call("login", $login_parameters, $url);


    /*
    echo "<pre>";
    print_r($login_result);
    echo "</pre>";
    */


    //get session id
    $session_id = $login_result->id;

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
//echo "id: " . $row["username"];

    //create account -------------------------------------
    $set_entry_parameters = array(
         //session id
         "session" => $session_id,


         //The name of the module from which to retrieve records.
         "module_name" => "Users",


         //Record attributes
         "name_value_list" => array(
              //to update a record, you will nee to pass in a record id as commented below
              //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),
              array("name" => "first_name", "value" => "REAL"),
              array("name" => "last_name", "value" => "REAL"),
              array("name" => "email1", "value" => $row["username"]),
              array("name" => "user_name", "value" => $row["username"]),
              array("name" => "user_hash", "value" => md5("impulsa3000"))
         ),
    );
    $set_entry_result = call("set_entry", $set_entry_parameters, $url);
    echo $row["username"]. " - " . $set_entry_result->id . ".\n";
  }
} else {
  echo "0 results";
}



    echo "<pre>";
    //print_r($set_entry_result);
    echo "</pre>";


?>
