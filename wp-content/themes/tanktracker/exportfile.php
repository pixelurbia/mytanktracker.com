<?php
/*
Template Name: Export File Generator
*/

  global $wpdb;
  $wpdb->show_errors(); 

  
// Build your query                     
$MyQuery = $wpdb->get_results("SELECT * from event_key");
                        


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
$csv_fields[] = 'id';
$csv_fields[] = 'event_id';
$csv_fields[] = 'form_id';
$csv_fields[] = 'entry_id';
$csv_fields[] = 'user_id';
$csv_fields[] = 'event_type';
$csv_fields[] = 'event_name';
$csv_fields[] = 'alc_served';
$csv_fields[] = 'alc_who_serv';
$csv_fields[] = 'non_profit';
$csv_fields[] = 'liquor_licence';
$csv_fields[] = 'date_submited';
$csv_fields[] = 'form_page';
$csv_fields[] = 'form_name';
$csv_fields[] = 'food_permit';
$csv_fields[] = 'noise_permit';
$csv_fields[] = 'dance_permit';
$csv_fields[] = 'ems_permit';
$csv_fields[] = 'animal_permit';
$csv_fields[] = 'traffic_permit';
$csv_fields[] = 'park_permit';
$csv_fields[] = 'police_permit';
$csv_fields[] = 'fire_permit';
$csv_fields[] = 'admission';
$csv_fields[] = 'event_status';
$csv_fields[] = 'event_date';
$csv_fields[] = 'first_name';
$csv_fields[] = 'last_name';
$csv_fields[] = 'address';
$csv_fields[] = 'addresstwo';
$csv_fields[] = 'city';
$csv_fields[] = 'state';
$csv_fields[] = 'zip';
$csv_fields[] = 'location';
$csv_fields[] = 'email';
$csv_fields[] = 'phone';
$csv_fields[] = 'description';
$csv_fields[] = 'event_image';
$csv_fields[] = 'event_time_start';
$csv_fields[] = 'event_date_end';
$csv_fields[] = 'event_time_end';
$csv_fields[] = 'sponsor_name';
$csv_fields[] = 'sponsor_address';
$csv_fields[] = 'sponsor_two';
$csv_fields[] = 'sponsor_city';
$csv_fields[] = 'sponsor_state';
$csv_fields[] = 'sponsor_zip';
$csv_fields[] = 'sponsor_phone';
$csv_fields[] = 'sponsor_email';
$csv_fields[] = 'day_phone';
$csv_fields[] = 'day_contact';
$csv_fields[] = 'location_des';
$csv_fields[] = 'is_child';
$csv_fields[] = 'police_traffic';
$csv_fields[] = 'firework';
$csv_fields[] = 'large_tent';
$csv_fields[] = 'flag_event';
$csv_fields[] = 'manual_fee';
$csv_fields[] = 'amount_paid';
$csv_fields[] = 'payment_date';
$csv_fields[] = 'public_safety_permit';
$output_filename = 'All_Events_Full_View.csv';
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