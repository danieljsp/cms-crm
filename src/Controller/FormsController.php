<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class FormsController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function index()
    {

    }

    public function update() {

      $url = "http://sugar.mesina.me/service/v4_1/rest.php";
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

      /*
      echo "<pre>";
      print_r($login_result);
      echo "</pre>";
      */

      //get session id
      $session_id = $login_result->id;

      $query = $this->Forms->find('all', [
        'fields' => ['Forms.fullname', 'Forms.id']/*,
        'conditions' => ['Forms.sugar_uuid is'  => null]*/
      ]);
      $rows = $query->all();
      //debug($row->fullname);
      foreach ($rows as $row) {

      //create account -------------------------------------
      $set_entry_parameters = array(
           //session id
           "session" => $session_id,

           //The name of the module from which to retrieve records.
           "module_name" => "Accounts",

           //Record attributes
           "name_value_list" => array(
                //to update a record, you will nee to pass in a record id as commented below
                //array("name" => "id", "value" => "9b170af9-3080-e22b-fbc1-4fea74def88f"),
                array("name" => "name", "value" => $row->fullname),
                array("name" => "email1", "value" => $row->email),
           ),
      );

      $set_entry_result = $this->call("set_entry", $set_entry_parameters, $url);

      $row->sugar_uuid = $set_entry_result->id;
      $this->Forms->save($row);
      }

    }

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
        curl_close($curl_request);

        $result = explode("\r\n\r\n", $result, 2);
        $response = json_decode($result[1]);
        ob_end_flush();

        return $response;
    }


}
