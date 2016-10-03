<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Network\Http\Client;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class WebservicesController extends AppController
{

  public $webList;
  public $callMe;
  public function update(){
    $this->viewBuilder()->layout('ajax');
    $this->webList = "c120c431-4400-3835-c85d-57db8981076b";
    $this->callMe = "27c720bf-3a4d-d2a8-5b85-57db890c2891";
    //svar_dump($this->request->data());
    $session_id = $this->login();
    $sugar_uuid = $this->addProspecto(
      'Leads',
      $session_id,
      $this->request->data('nombre'),
      $this->request->data('email'),
      $this->request->data('telefono'),
      $this->request->data('proyecto'),
      $this->request->data('comentarios'),
      'CallMe'
    );
    $this->set('sugar_uuid', $sugar_uuid);

  }
  public function test(){

  }
  public function automatico(){
    //$nombre, $email, $telefono, $proyecto, $comentarios, $tipo
    $http = new Client();
    $response = $http->post('http://localhost/cms-crm/webservices/update', [
      'nombre' => 'testing',
      'email' => 'danie@mesina.me',
      'telefono' => '6692130993',
      'proyecto' => 'Perla del pacifico',
      'comentarios' => 'Comentarios lorem ipsum',
      'tipo' => 'CallMe'
    ]);
    debug($response->body());exit;
  }
  function addProspecto($module_name, $session_id, $first_name,$email1,$phone_work, $project, $comentarios, $source) {
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

              array("name" => "lead_source", "value" => $source),
            //  array("name" => "primary_address_city", "value" => $ciudad),
            //  array("name" => "primary_address_state", "value" => $estado),
         )
    );


    //debug($set_entry_parameters);exit;

    $set_entry_result = $this->call("set_entry", $set_entry_parameters);
    $leadId = $set_entry_result->id;
    $listId = "";

      switch ($source) {
        case "CallMe";

          $listId = $this->callMe;
          $this->createRelationship($session_id, $leadId, "prospect_lists", $listId , $module_name);
          break;
        case "Web Site";

          $listId = $this->webList;
            $this->createRelationship($session_id, $leadId, "prospect_lists", $listId , $module_name);
          break;
        default:
          $listId = $this->webList;
          break;
      }
    //agregar relacion con lista de publico objetivo

    return $set_entry_result->id;
  }
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
