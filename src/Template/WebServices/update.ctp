<?php header("Content-type: text/xml; charset=utf-8");
$response = '<?xml version="1.0" encoding="utf-8"?>';
   $response .= '<response><status>true</status>';

           $response = $response.'<sugar_uuid>'.$sugar_uuid.'</sugar_uuid></response>';
           echo $response;
 ?>
