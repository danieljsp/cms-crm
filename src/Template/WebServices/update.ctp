<?php header("Content-type: text/xml; charset=utf-8");
$response = '<?xml version="1.0" encoding="utf-8"?>';
   $response .= '<response><status>'.$status.'</status>';
if ($status=='true') {
           $response = $response.'<sugar_uuid>'.$sugar_uuid.'</sugar_uuid></response>';
         } else {
            $response = $response.'</response>';
         }
           echo $response;
 ?>
