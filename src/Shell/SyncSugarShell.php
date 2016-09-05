<?php namespace App\Shell;

use Cake\Console\Shell;
use Cake\I18n\Time;
use Cake\I18n\FrozenTime;

class SyncSugarShell extends Shell
{   public $users;
    public $sellers;
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
          56=>"6d61a2db-52c3-5ce2-e48c-577d1b7f0310",// Abarraza"5e1e75f2-1c41-e1ef-1894-57bc12453497",
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
          88=>"93cbcd18-7042-5be1-78d4-577d1d30f0ca",//Lizette Cazares"15020395-ffe9-b379-01ae-57bc1277acea",
          89=>"71959c94-4922-59ae-839a-57bc1200f81b",
          90=>"213c8e85-7e75-824f-d23b-577d1ad0650f",//Cristobal moreno"cbdcdb56-027f-1340-33ee-57bc124f273a",
          91=>"37a2c074-b38c-31be-96c6-57bc128dc2b2",
          93=>"94c86965-2ee4-812a-2739-57bc12f075f5",
          94=>"f1249da9-9958-1a2b-957c-57bc121dd283"
        );

        $this->sellers = array(
          27=>"e4066c99-230b-a3a2-2b86-57c11ccc3ff9",
          28=>"e4066c99-230b-a3a2-2b86-57c11ccc3ff9",
          20=>"e4066c99-230b-a3a2-2b86-57c11ccc3ff9",
          23=>"e4066c99-230b-a3a2-2b86-57c11ccc3ff9",
          17=>"41c72d39-60e4-2a0f-66ff-57c11d9704e3",
          9=>"bdc7f8d8-8d82-37d5-1ea2-57bc1274ebdc",
          37=>"bdc7f8d8-8d82-37d5-1ea2-57bc1274ebdc",
          38=>"bdc7f8d8-8d82-37d5-1ea2-57bc1274ebdc",
          14=>"a24fd23d-9e73-82fd-fa9e-57c120efbf78",
          30=>"a5a22a78-a1a5-9f74-de0d-57c120053790",
          4=>"f1342ba5-8ab9-65eb-5a4c-57c12063b54a",
          13=>"314a0b7c-6d9d-a061-0f6d-57c121c73d94",
          32=>"314a0b7c-6d9d-a061-0f6d-57c121c73d94",
          18=>"5bf846b9-45ff-291b-61f7-57c1213a32bf",
          31=>"6109a9e8-d47a-43b6-a662-57c1215f75b0",
          29=>"d090efd4-bd08-6908-e852-57c122c58a82",
          12=>"cc1d5a6b-0994-72f9-025b-57c122348bf0",
          16=>"ac668860-304d-2c51-f2a0-57c122bd7202",
          21=>"68c5f5c3-8afb-4c57-0736-57c122b1d159",
          24=>"68c5f5c3-8afb-4c57-0736-57c122b1d159",
          11=>"94b60886-96e6-11aa-5d85-57bc129195bd",
          39=>"2bfd252a-93da-315c-debb-57c12314cd22",
          40=>"2bfd252a-93da-315c-debb-57c12314cd22",
          15=>"8a11b684-4fc1-19ec-a72d-57c124bf72a0",
          3=>"8cfcee7a-5a6f-b57d-d638-57c1245d01c9",
          35=>"b51a7482-8a0f-63e3-a80b-57c124f424a0",
          36=>"b51a7482-8a0f-63e3-a80b-57c124f424a0",
          8=>"b51a7482-8a0f-63e3-a80b-57c124f424a0",
          1=>"72915159-d2ef-dfc3-92aa-57c1259da85a",
          41=>"72915159-d2ef-dfc3-92aa-57c1259da85a",
          25=>"46faf09f-68ee-7c88-2545-57c125cffe08",
          26=>"46faf09f-68ee-7c88-2545-57c125cffe08",
          19=>"46faf09f-68ee-7c88-2545-57c125cffe08",
          22=>"46faf09f-68ee-7c88-2545-57c125cffe08",
          43=>"3ce25248-a163-f67b-e9ca-57bc1271e54e",
          7=>"389b8a97-49c1-852f-6278-57c12661883b",
          6=>"5ec593e0-57b3-dba9-04fe-57c126954caf",
          33=>"5ec593e0-57b3-dba9-04fe-57c126954caf",
          34=>"5ec593e0-57b3-dba9-04fe-57c126954caf",
          10=>"97b5e847-8600-9b16-9cec-57c126df2915",
          2=>"aba6cc85-fbf9-316e-b749-57c127f934bd",
          42=>"aba6cc85-fbf9-316e-b749-57c127f934bd",
          5=>"a754fc18-67d3-594e-5595-57c12727be88");
  }
    /*
    Funcion man simplificada para resumir operacion de importacion
    */
    public function main() {
      $prospectos = $this->getProspectos();//1 Obtenemos datos completos a importar
      $llamadas = $this->getLlamadas();
      $session_id = $this->login();
      $this->restInsert($session_id, $prospectos);//3 Insertamos todos los datos uno por uno
    //  $this->restInsert($session_id, $llamadas);//3 Insertamos todos los datos uno por uno
    }
    function getLlamadas(){

    }
    public function getProspectoType($prospecto) {
      if (isset($prospecto->tmk_fecha_agenda)){
        return "Contacts";
      } else {
        return "Leads";
      }
    }
    public function getProspectoSource($prospecto) {
      if ($prospecto->llamada_id >= 1){
        return "CallMe";
      } else {
        return "Web Site";
      }
    }
    function callMeInsert($session_id, $rows){
      $i=1;
      $l=count($rows);
      foreach ($rows as $row) {
        $proyecto = "";
        $module_name = $this->getProspectoType($row);
        if (isset($row->proyecto->nombre)){
          $proyecto = $row->proyecto->nombre;
        }
        $row->sugar_uuid = $this->addProspecto(
          $module_name,
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
          $row->tmk_vendedor_id,
          "Web Site"
        );

        if (isset($row->compromisos)){
          foreach  ($row->compromisos as $compromiso) {
            $this->addCall(
              $session_id,
              $row->sugar_uuid,
              $compromiso->fecha,
              $compromiso->hora,
              $compromiso->comentarios,
              $row->tmk_usuario_id,
              $compromiso->created,
              $module_name);
          }
        }
        if (isset($row->tmk_fecha_agenda)){
            $this->addMeeting(
              $session_id,
              $row->sugar_uuid,
              $row->tmk_fecha_agenda,
              $row->tmk_hora_agenda,
              $row->tmk_comentarios,
              $row->tmk_vendedor_id,
              $row->created,
              $module_name);
        }
        //$this->Prospectos->save($row);
        $this->progressBar($i, $l);
        $i++;

      }
    }
    /*
    Iteracion de cada uno de los registos del cms y llamadas a la funciones
    correspondientes para insertarlos via REST en el CRM remoto.
    */
    function restInsert($session_id, $rows) {
      $i=1;
      $l=count($rows);
      debug($rows);
      foreach ($rows as $row) {
        $proyecto = "";
        $module_name = $this->getProspectoType($row);
        $source = $this->getProspectoSource($row);
        if (isset($row->proyecto->nombre)){
          $proyecto = $row->proyecto->nombre;
        }
        $ciudad = isset($row->ciudade->nombre)?$row->ciudade->nombre:"";
        $estado = isset($row->ciudade->nombre)?$row->ciudade->estado->nombre:"";
        $row->sugar_uuid = $this->addProspecto(
          $module_name,
          $session_id,
          $row->fullname,
          $row->email,
          $row->phone,
          $proyecto,
          $row->tmk_comentarios,
          $row->created->modify('-6 hour'),
          $row->modified,
          $row->sugar_uuid,
          $row->tmk_usuario_id,
          $source,
          $ciudad,
          $estado
        );

        if (isset($row->compromisos)){
          foreach  ($row->compromisos as $compromiso) {
            $this->addCall(
              $session_id,
              $row->sugar_uuid,
              $compromiso->fecha,
              $compromiso->hora,
              $compromiso->comentarios,
              $row->tmk_usuario_id,
              $compromiso->created->modify('-6 hour'),
              $module_name);
          }
        }
        if (isset($row->tmk_fecha_agenda)){
            $this->addMeeting(
              $session_id,
              $row->sugar_uuid,
              $row->tmk_fecha_agenda,
              $row->tmk_hora_agenda,
              $row->tmk_comentarios,
              $row->tmk_vendedor_id,
              $row->created->modify('-6 hour'),
              $module_name);
              $this->addOportunity(
                "Opportunities",
                $session_id,
                $proyecto,
                $row->tmk_fecha_agenda,
                "Value Proposition",
                $row->tmk_vendedor_id,
                $source,
                $row->sugar_uuid
            );
        }
        //$this->Prospectos->save($row);
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
            'Prospectos.sugar_uuid',
            'Prospectos.tmk_fecha_agenda',
            'Prospectos.tmk_hora_agenda',
            'Prospectos.tmk_usuario_id',
            'Prospectos.tmk_vendedor_id',
            'Prospectos.tmk_ciudad_id',
            'Prospectos.llamada_id',
            'Ciudades.nombre',
            'Estados.nombre'],
        'contain' => ['Proyectos', 'Compromisos', 'Ciudades', 'Ciudades.Estados'],
        //'limit' => 100,
        'order' => ['Prospectos.id' => 'DESC'],
        //'conditions' => ['Prospectos.id is'  => 34262]
      );
      if (isset($this->args[0])&& $this->args[0] == "new") {
          $query_params['conditions'] = ['Prospectos.id is'  => 34364];
      }
      $query = $this->Prospectos->find('all', $query_params);
      $rows = $query->all();
      return $rows;
    }
    /*
      Agrega un nuevo lead (Cliente potencial)
    */
    function addOportunity($module_name, $session_id, $name,$date_closed,$sale_stage, $userId, $source, $contactId) {
      //create account -------------------------------------
      $set_entry_parameters = array(
           //session id
           "session" => $session_id,
           //The name of the module from which to retrieve records.
           "module_name" => $module_name,
           //Record attributes
           "name_value_list" => array(
                array("name" => "name", "value" => $name),//como nombre del proyecto
                array("name" => "date_closed", "value" => date_format($date_closed, 'Y-m-d H:i:s')),//Fecha de la cita
                array("name" => "sales_stage", "value" => "Value Proposition"),//Etapa de la venta en 30%
                array("name" => "probability", "value" => "30"),//Etapa de la venta en 30%
                array("name" => "opportunity_type", "value" => "New Business"),// Nuevo negocio
                array("name" => "account_id", "value" => "2bb102ab-00c0-86f1-7e6a-579444f08b1a"),
                array("name" => "lead_source", "value" => $source),
           ),
      );
      //Asignacion al vendedor asignado en la cita
      if(isset($this->sellers[$userId])) {
        array_push($set_entry_parameters['name_value_list'],array(
            "name" => "assigned_user_id",
            "value" => $this->sellers[$userId]));
      }
      $set_entry_result = $this->call("set_entry", $set_entry_parameters);
      //agregar relacion con usuario o asignado a
      $this->createRelationship($session_id, $contactId, "opportunities", $set_entry_result->id, "Contacts");
    }
    /*
      Agrega un nuevo lead (Cliente potencial)
    */
    function addProspecto($module_name, $session_id, $first_name,$email1,$phone_work, $project, $comentarios, $created, $modified, $sugar_uuid,$userId, $source, $ciudad, $estado) {
      //create account -------------------------------------
      $set_entry_parameters = array(
           //session id
           "session" => $session_id,
           //The name of the module from which to retrieve records.
           "module_name" => $module_name,
           //Record attributes
           "name_value_list" => array(
                //to update a record, you will nee to pass in a record id as commented below
                //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),
                array("name" => "first_name", "value" => $first_name),
                array("name" => "email1", "value" => $email1),
                array("name" => "phone_work", "value" => $phone_work),
                array("name" => "proyecto_c", "value" => $project),
                array("name" => "description", "value" => $comentarios),
                array("name" => "date_entered", "value" => $created->format('Y-m-d H:i:s')),
                array("name" => "lead_source", "value" => $source),
                array("name" => "primary_address_city", "value" => $ciudad),
                array("name" => "primary_address_state", "value" => $estado),
           ),
      );

      if(isset($this->users[$userId])) {
        array_push($set_entry_parameters['name_value_list'],array(
            "name" => "assigned_user_id",
            "value" => $this->users[$userId]));
      }
      //debug($set_entry_parameters);exit;
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
    function  addCall($session_id, $leadId, $date, $time, $comments, $userId, $created, $module_name) {
      $date = date_format($date, 'Y-m-d');
      $date .= " " . ($time + 7). ":00:00";
      $created = date_format($created, 'Y-m-d');
      $created .= " " . ($created + 7). ":00:00";
      $status = $this->getStatus($date);
      $set_entry_parameters = array(
           //session id
           "session" => $session_id,
           //The name of the module from which to retrieve records.
           "module_name" => "Calls",
           //Record attributes
           "name_value_list" => array(
                array("name" => "name", "value" => $comments),
                array("name" => "date_start", "value" => $date),
                array("name" => "description", "value" => $comments),
                array("name" => "duration_hours", "value" => "00"),
                array("name" => "duration_minutes", "value" => 15),
                array("name" => "direction", "value" => "Saliente"),
                array("name" => "date_entered", "value" => $created),
                array("name" => "status", "value" => $status)
           ),
      );
      if(isset($this->users[$userId])) {
        array_push($set_entry_parameters['name_value_list'],array(
            "name" => "assigned_user_id",
            "value" => $this->users[$userId]));
      }
      $set_entry_result = $this->call("set_entry", $set_entry_parameters);
      //agregar relacion con usuario o asignado a
      $this->createRelationship($session_id, $leadId, "calls", $set_entry_result->id, $module_name);
    }
    public function getStatus($date){
      $status = "";
      if (date_create($date) > date_create("now")) {
        $status = "Planned";
      } else {
        $status = "Held";
      }
      return $status;
    }
    /*
    Modulo para agregar una cita con el vendedor
    */
    function  addMeeting($session_id, $leadId, $date, $time, $comments, $sellerId, $created, $module_name) {
      $date = date_format($date, 'Y-m-d');
      $date .= " " . ($time + 7). ":00:00";
      $status = $this->getStatus($date);


      $set_entry_parameters = array(
           //session id
           "session" => $session_id,

           //The name of the module from which to retrieve records.
           "module_name" => "Meetings",

           //Record attributes

           "name_value_list" => array(
                //t"2016-12-28 13:09"o update a record, you will nee to pass in a record id as commented below
                //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),

                array("name" => "name", "value" => $comments),
                array("name" => "date_start", "value" => $date),
                array("name" => "description", "value" => $comments),
                array("name" => "date_entered", "value" => date_format($created, 'Y-m-d H:i:s')),
                array("name" => "status", "value" => $status)
           ),
      );
      if(isset($this->sellers[$sellerId])) {
        array_push($set_entry_parameters['name_value_list'],array(
            "name" => "assigned_user_id",
            "value" => $this->sellers[$sellerId]));
      }
      $set_entry_result = $this->call("set_entry", $set_entry_parameters);
      //agregar relacion con usuario o asignado a
      $this->createRelationship($session_id, $leadId, "meetings", $set_entry_result->id, $module_name);
    }
    /*
    Modulo para relacionar por el momento cualquier modulo con el Modulo
    de leads.
    */
    function createRelationship($session_id, $leadId, $linked_module,  $related_id, $module_name) {
      $set_relationship_parameters = array(
          //session id
          'session' => $session_id,

          //The name of the module.
          'module_name' => $module_name,

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
