<?php namespace App\Shell;

use Cake\Console\Shell;

class SyncSugarShell extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Forms');
    }
    public function main()
    {

            $url = "http://52.40.51.210/service/v4_1/rest.php";
            $username = "admin";
            $password = "stusWeW2";

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

            $login_result = $this->call("login", $login_parameters, $url);





            //get session id
            $session_id = $login_result->id;
            $query_params = array(
              'fields' => ['Proyectos.nombre','Forms.referer','Forms.phone','Forms.fullname', 'Forms.id', 'Forms.email', 'Forms.sugar_uuid'],
              'contain' => ['Proyectos']
            );
            if (isset($this->args[0])&& $this->args[0] == "new") {
                $query_params['conditions'] = ['Forms.sugar_uuid is'  => null];
            }

            $query = $this->Forms->find('all', $query_params);


            $rows = $query->all();

            $i=1;
            $l=count($rows);
            foreach ($rows as $row) {
debug($row);exit;

            //create account -------------------------------------
            $set_entry_parameters = array(
                 //session id
                 "session" => $session_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "Leads",

                 //Record attributes
                 "name_value_list" => array(
                      //to update a record, you will nee to pass in a record id as commented below
                      //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),
                      array("name" => "first_name", "value" => $row->fullname),
                      array("name" => "email1", "value" => $row->email),
                      array("name" => "phone_work", "value" => $row->phone),
                      array("name" => "status", "value" => "Dead"),
                      array("name" => "lead_source", "value" => "Web Site"),
                 ),
            );
            if(!is_null($row->sugar_uuid)) {
              array_push($set_entry_parameters['name_value_list'],array("name" => "id", "value" => $row->sugar_uuid));
            }


            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $url);

            $row->sugar_uuid = $set_entry_result->id;

            $this->Forms->save($row);








            $set_entry_parameters = array(
                 //session id
                 "session" => $session_id,

                 //The name of the module from which to retrieve records.
                 "module_name" => "Calls",

                 //Record attributes
                 "name_value_list" => array(
                      //to update a record, you will nee to pass in a record id as commented below
                      //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),
                      array("name" => "name", "value" => "Llamada Ejemplo 2"),
                      array("name" => "date_start", "value" => "2016-12-28 13:09"),

                      array("name" => "duration_hours", "value" => "00"),
                      array("name" => "duration_minutes", "value" => 15),
                 ),
            );



            $set_entry_result = $this->call("set_entry", $set_entry_parameters, $url);













echo "                                                               \r";
$this->progressBar($i, $l);
$i++;

            // echo $row->fullname .', '. $row->email."\r";
//@ob_flush();
//flush();

            }
    }
    function progressBar($iteration,$total) {
      $barLength = 50;
      $decimals = 2;
      $filledLength    = round($barLength * $iteration / floatval($total));
      $percents        = round(100.00 * ($iteration / floatval($total)), $decimals);
      $bar             = "[".str_repeat('#', $filledLength) . str_repeat('-' , ($barLength - $filledLength))."]";
      echo "Progreso ". $bar." " .$percents. "% Completado[".$iteration."/".$total."]\r";
       if ($iteration == $total) {
           echo "\n";
       }
    }

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
        curl_close($curl_request);

        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();

        return $response;
    }
}
?>
