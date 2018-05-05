<?php
/*
Template Name: stock
*/
// header('Content-Type: text/xml');
?>




<?php 

       echo '<p>';
echo '&ltNikuDataBus xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="../xsd/nikuxog_project.xsd"&gt;<br>';
echo '&ltHeader action="write" externalSource="NIKU" objectType="project" version="14.3.0.298"/&gt;<br>';
echo '&ltProjects&gt;<br>';
echo '&ltProject name="No Travel" projectID="10083426"&gt;<br>';
echo '&ltResources&gt;<br>';

         global $wpdb;
         // global $date;
         $ids = $wpdb->get_results("SELECT user FROM cerntest");

         foreach($ids as $id){
            // var_dump($id);
                $id = $id->user;
                echo '&ltResource resourceID="'.$id.'"&gt;<br>';
                echo '&ltAllocCurve&gt;<br>';
              
         
                // echo $id;
                $params = $wpdb->get_results("SELECT * FROM cerntest WHERE user = '$id'");
                foreach($params as $param){

                        echo '&ltSegment finish="'.$param->end.'" start="'.$param->start.'" sum="'.$param->percent.'"&gt;<br>';
                    // echo $param->end;
                    // echo $param->start;
                    // echo $param->percent;

                        
         };
       

        echo '&lt/AllocCurve&gt;<br>';
        echo '&ltCustomInformation&gt;<br>';
         echo '&ltColumnValue name="partition_code"&gt;NIKU.ROOT&lt/ColumnValue&gt;<br>';
        echo '&lt/CustomInformation&gt;<br>';
        echo '&ltSkillAssocs/&gt;<br>';
      echo '&lt/Resource&gt;<br>';

                    };      


//     echo'</Resources>';
//   echo'</Project>';
//  echo'</Projects>';
// echo'</NikuDataBus>';
     echo '</p>';


                        ?>
            