<?php
/*
Template Name: Export Parameters table
*/

  global $wpdb;
  $wpdb->show_errors(); 

  // Grab any post values you sent with your submit function
  $tank_id = $_GET['tank_id'];
  $curuser = $_GET['curuser'];
  //$param_type = $_GET['param_type']; //AND user_tank_params.param_type = '$param_type'
  
  
// Build your query                     
$MyQuery = $wpdb->get_results("SELECT user_tank_params.created_date, user_tank_params.param_value, param_ref.param_name
            FROM user_tank_params
            INNER JOIN param_ref ON user_tank_params.param_type=param_ref.param_type 
            WHERE user_tank_params.user_id = '$curuser'
            AND user_tank_params.tank_id = '$tank_id'
            ORDER BY user_tank_params.created_date DESC");
                        

// Process report request
if (! $MyQuery) {
$Error = $wpdb->print_error();
// echo 'maybe not';
die("The following error was found: $Error");
} else {
// Prepare our csv download
// echo 'maybe?';
// Set header row values
$csv_fields=array();
$csv_fields[] = 'Created Date';
$csv_fields[] = 'Param Value';
$csv_fields[] = 'Param Name';   
$output_filename = 'Parameters_Full_View.csv';
$output_handle = @fopen( 'php://output', 'w' );
 
header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
header( 'Content-Description: File Transfer' );
header( 'Content-type: text/csv' );
header( 'Content-Disposition: attachment; filename=' . $output_filename );
header( 'Expires: 0' );
header( 'Pragma: public' ); 

// Insert header row
fputcsv( $output_handle, $csv_fields );

// Parse results to csv format
foreach ($MyQuery as $Result) {
    $leadArray = (array) $Result; // Cast the Object to an array
    // Add row to file
    fputcsv( $output_handle, $leadArray );
    }
 
// Close output file stream
 fpassthru( $output_handle ); 
exit;
}
?>