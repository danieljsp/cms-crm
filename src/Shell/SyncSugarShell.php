<?php namespace App\Shell;

use Cake\Console\Shell;

class SyncSugarShell extends Shell
{   public $users;
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Prospectos');
        $this->users = array(
          1=>"69e17db7-cb18-dd7a-38cc-57bc120f3f18",
          2=>"c6d79eca-ed8c-f81e-161b-57bc12d9f75a",
          4=>"2f2f78d6-fd9e-4177-7e78-57bc12e9d683",
          5=>"8a71f840-686c-eaf7-3361-57bc12e90d5f",
          53=>"ea6756a3-d1a8-1ccb-4278-57bc12c31e50",
          57=>"51f24c52-9742-36e3-c2cb-57bc12ab424b",
          54=>"aa2ce641-9735-3c3d-b1bc-57bc128d2d5e",
          11=>"10e2ceb4-75c9-2750-53db-57bc1241f393",
          13=>"6aa0ebf7-27b5-6e59-134a-57bc12f2e989",
          14=>"c428c1cb-8eda-e1eb-5c5b-57bc124fee0b",
          29=>"381dbc4b-5197-f7ac-4580-57bc12bf85c4",
          30=>"99220457-8134-fd67-6504-57bc1209cb1a",
          55=>"f26f24b4-7208-a735-31f3-57bc12cdc0c9",
          56=>"5e1e75f2-1c41-e1ef-1894-57bc12453497",
          60=>"b5ea75e3-5963-e2c8-1969-57bc12ab027c",
          59=>"1900ac9e-7eea-2ff2-41ba-57bc12ef372d",
          61=>"730248ab-b844-5cf1-a85b-57bc127a7436",
          62=>"d13688e3-e615-b789-9755-57bc12fd74f2",
          63=>"3ce25248-a163-f67b-e9ca-57bc1271e54e",
          64=>"9acb27a9-14a9-b99a-d254-57bc12117f55",
          65=>"7a1c0c55-4fdf-22c5-b86c-57bc12da1784",
          66=>"63c24f95-9c7f-156c-8c12-57bc126358e3",
          67=>"bdc7f8d8-8d82-37d5-1ea2-57bc1274ebdc",
          68=>"6327f577-0b40-ed27-8f85-57bc12c60761",
          69=>"c0d8783c-fccc-8000-adc2-57bc12c9e5b7",
          70=>"284974c1-78bf-ed03-562a-57bc12581625",
          71=>"8832a6ee-b068-ec24-52f9-57bc1225e3b6",
          72=>"e515c090-b13b-aac2-dfeb-57bc12391703",
          73=>"49b7fe69-55d9-7815-d7d6-57bc12fffa38",
          74=>"a4b59ed2-b7bb-38e2-55e0-57bc12742754",
          75=>"94b60886-96e6-11aa-5d85-57bc129195bd",
          76=>"691ff0d7-1f4f-8767-4d0e-57bc12868e74",
          77=>"ca06abfc-784a-1da6-147d-57bc121212de",
          78=>"38ffa1ff-ff94-e45f-2dae-57bc12080ebb",
          79=>"9844ff1f-a847-e692-ad26-57bc12444d87",
          80=>"24cf0712-8bb8-9817-3a11-57bc129fafd5",
          81=>"62cabf8b-ad4e-9d5b-e246-57bc120b731d",
          82=>"bf047f53-0bb7-327f-de88-57bc12985223",
          83=>"2430edbb-c99e-a082-8ed9-57bc12da950a",
          84=>"7ec6ef1c-7ca1-7417-381d-57bc1252bb54",
          85=>"de0cd042-40a6-8fe0-afd6-57bc125e88fa",
          86=>"4bf0cff9-bad0-6e64-8134-57bc1299f26a",
          87=>"aba6be68-8b46-c66f-d2c0-57bc127cc408",
          88=>"15020395-ffe9-b379-01ae-57bc1277acea",
          89=>"71959c94-4922-59ae-839a-57bc1200f81b",
          90=>"cbdcdb56-027f-1340-33ee-57bc124f273a",
          91=>"37a2c074-b38c-31be-96c6-57bc128dc2b2",
          93=>"94c86965-2ee4-812a-2739-57bc12f075f5",
          94=>"f1249da9-9958-1a2b-957c-57bc121dd283"
        );
    }
    /*
    Funcion man simplificada para resumir operacion de importacion
    */
    public function main() {
      $rows = $this->getProspectos();//1 Obtenemos datos completos a importar
      $session_id = $this->login();//2 Nos logueamos en REST CRM
      $this->restInsert($session_id, $rows);//3 Insertamos todos los datos uno por uno
    }


    /*
    Iteracion de cada uno de los registos del cms y llamadas a la funciones
    correspondientes para insertarlos via REST en el CRM remoto.
    */
    function restInsert($session_id, $rows) {
      $i=1;
      $l=count($rows);
      foreach ($rows as $row) {
        debug($row);
        $proyecto = "";
        if (isset($row->proyecto->nombre)){
          $proyecto = $row->proyecto->nombre;
        }
        $row->sugar_uuid = $this->addLead(
          $session_id,
          $row->fullname,
          $row->email,
          $row->phone,
          $proyecto,
          $row->tmk_comentarios,
          $row->created,
          $row->modified,
          $row->sugar_uuid,
          $row->tmk_usuario_id,
          $row->tmk_vendedor_id
        );

        if (isset($row->compromisos)){
          foreach  ($row->compromisos as $compromiso) {
            $this->addCall($session_id, $row->sugar_uuid, $compromiso->fecha, $compromiso->hora, $compromiso->comentarios);
          }
        }
        $this->Prospectos->save($row);
        $this->progressBar($i, $l);
        $i++;

      }
    }
    /*
    Regresa todos los prospectos incluyendo nombre de proyecto, compromisos(llamadas)
    */
    function getProspectos() {
      $query_params = array(
        'fields' => [
            'Proyectos.nombre',
            'Prospectos.referer',
            'Prospectos.phone',
            'Prospectos.fullname',
            'Prospectos.id',
            'Prospectos.email',
            'Prospectos.tmk_comentarios',
            'Prospectos.created',
            'Prospectos.modified',
            'Prospectos.sugar_uuid'],
            'Prospectos.tmk_usuario_id',
            'Prospectos.tmk_vendedor_id'
        'contain' => ['Proyectos', 'Compromisos'],
        'conditions' => array('Prospectos.id'=> 34240)
      );
      if (isset($this->args[0])&& $this->args[0] == "new") {
          $query_params['conditions'] = ['Prospectos.sugar_uuid is'  => null];
      }
      $query = $this->Prospectos->find('all', $query_params);
      $rows = $query->all();
      return $rows;

    }
    /*
      Agrega un nuevo lead (Cliente potencial)
    */
    function addLead($session_id, $first_name,$email1,$phone_work, $project, $comentarios, $created, $modified, $sugar_uuid,$userId) {
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
                array("name" => "first_name", "value" => $first_name),
                array("name" => "email1", "value" => $email1),
                array("name" => "phone_work", "value" => $phone_work),
                array("name" => "proyecto_c", "value" => $project),
                array("name" => "description", "value" => $comentarios),
                array("name" => "date_entered", "value" => date_format($created, 'Y-m-d H:i:s')),
                array("name" => "date_modified", "value" => date_format($created, 'Y-m-d H:i:s')),
                array("name" => "lead_source", "value" => "Web Site"),
                array("name" => "assigned_user_id", "value" => (isset($this->))?:),
           ),
      );
      debug(date_format($created, 'Y-m-d H:i'));
      if(!is_null($sugar_uuid)) {
        array_push($set_entry_parameters['name_value_list'],array("name" => "id", "value" => $sugar_uuid));
      }
      $set_entry_result = $this->call("set_entry", $set_entry_parameters);
      return $set_entry_result->id;
    }

    /*
    Realiza login el el webservice del CRM y regresa el id de la session_id
    para usarlo en todas las querys edicion.
    */
    function login() {
      $username = "admin";
      $password = "stusWeW2";
      $login_parameters = array(
           "user_auth" => array(
                "user_name" => $username,
                "password" => md5($password),
                "version" => "1"
           ),
           "application_name" => "RestTest",
           "name_value_list" => array(),
      );
      $login_result = $this->call("login", $login_parameters);
      //get session id
      $session_id = $login_result->id;
      return $session_id;
    }

    /*
    Crea una llamada y la une al LEAD
    */
    function  addCall($session_id, $leadId, $date, $time, $comments) {
      $date = date_format($date, 'Y-m-d');
      $date .= " " . ($time + 6). ":00:00";
      $set_entry_parameters = array(
           //session id
           "session" => $session_id,

           //The name of the module from which to retrieve records.
           "module_name" => "Calls",

           //Record attributes

           "name_value_list" => array(
                //t"2016-12-28 13:09"o update a record, you will nee to pass in a record id as commented below
                //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),

                array("name" => "name", "value" => $comments),
                array("name" => "date_start", "value" => $date),
                array("name" => "description", "value" => $comments),
                array("name" => "duration_hours", "value" => "00"),
                array("name" => "duration_minutes", "value" => 15),
                array("name" => "direction", "value" => "Saliente"),
                array("name" => "status", "value" => "Realizada"),
                array("name" => "assigned_user_id", "value" => "6bfb92ab-8852-326c-023f-57857543e0cc"),
           ),
      );
      $set_entry_result = $this->call("set_entry", $set_entry_parameters);
      //agregar relacion con usuario o asignado a
      $this->createRelationship($session_id, $leadId, "calls", $set_entry_result->id);
    }

    /*
    Modulo para relacionar por el momento cualquier modulo con el Modulo
    de leads.
    */
    function createRelationship($session_id, $leadId, $linked_module,  $related_id) {
      $set_relationship_parameters = array(
          //session id
          'session' => $session_id,

          //The name of the module.
          'module_name' => 'Leads',

          //The ID of the specified module bean.
          'module_id' => $leadId,

          //The relationship name of the linked field from which to relate records.
          'link_field_name' => $linked_module,

          //The list of record ids to relate
          'related_ids' => array(
            $related_id
        ),
        //Whether or not to delete the relationship. 0:create, 1:delete
        'delete'=> 0,
      );
      $set_relationship_result = $this->call("set_relationship", $set_relationship_parameters);
    }
    function addApointment() {

    }
    function progressBar($iteration,$total) {
      echo "                                                               \r";
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

    function call($method, $parameters)
    {
        $url = "http://52.40.51.210/service/v4_1/rest.php";
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
