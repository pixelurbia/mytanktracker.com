<?php

add_action('wp_ajax_add_journal', 'add_user_journal');
add_action('wp_ajax_nopriv_add_journal', 'add_user_journal');

/**
 * Add Tank
 *
 */

function add_user_journal() {    

      // Verify nonce
 if( !isset( $_POST['ajax_form_nonce_journal'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_journal'], 'ajax_form_nonce_journal' ) )
    die( 'Ooops, something went wrong, please try again later.' );
   

  global $post;
  global $wpdb;
  
  require_once( ABSPATH . 'wp-admin/includes/admin.php' );
  $user = wp_get_current_user();
  $today = date("-m-d-y");   
  $tanks = $_REQUEST['tanks'];
    /* wp_insert_attachment */


    // $attachment = array(
    //     'guid'           => $fileurl, 
    //     'post_mime_type' => $filetype['type'],
    //     'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
    //     'post_content'   => '',
    //     'post_status'    => 'inherit'
    // );


    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
        var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }


    


    
    //create post
    $uid = uniqid();
    $user_id = $user->ID;
    $username = $user->user_nicename;
    $journal_content = $_REQUEST['journal'];
    $journal_title = 'post-'.$uid;
    // $user_id = get_current_user_id();

    $createPost = array(
        'post_author' => $user_id,
        'post_content' => $journal_content,
        'post_title' => $journal_title,
        'post_status' => 'publish',
        'post_type' => 'user_journals',
        'publish' => 'comment_status'
    );

    $post_id = wp_insert_post($createPost);


    //  move_uploaded_file($_FILES["file_upload"]["tmp_name"], $upload_dir['path'].'/'.$_FILES["file_upload"]["name"]);
    // $file_name = basename($_FILES["file_upload"]["name"]);
    // $fileurl = $upload_dir['path'].'/'.$file_name;

    // $filetype = wp_check_filetype( basename( $fileurl ), null ); // check file tupe
    // $image_data = file_get_contents($fileurl);
    // file_put_contents($fileurl, $image_data);
           $environment = set_env(); 
        if ( $environment == 'DEV') {
            $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_livestock/';
            $new_file_url = '/wp-content/uploads/user_livestock/';
        } else {
            $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_livestock/';
            $new_file_url = '/wp-content/uploads/user_livestock/';
        }
    
    var_error_log($environment);
    // var_error_log($_FILES);

    function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
    }

    $file_ary = reArrayFiles($_FILES['file_upload']);

    foreach($file_ary as $file)
    {
        var_error_log($file);
        $obj_type = 'img';
        $hex = uni_key_gen($obj_type);

        $fileName = $file['name'];
        var_error_log($fileName);
        $fileName = $hex.'-'.$fileName;
        
        $fileTempName = $file['tmp_name'];
        
        var_error_log($new_file_dir);

        move_uploaded_file($fileTempName, $new_file_dir.$fileName);
    

        $ref_id = $post_id;
        $photo_url = $new_file_url.$fileName;

        $obj_type_new = 'user-jrnl-img';
        $hextwo = uni_key_gen($obj_type_new);
  

        $wpdb->insert('user_photos',array(
        'user_id'=> $user_id,
        'photo_id'=> $hextwo,
        'ref_id'=> $ref_id,
        'photo_url'=> $photo_url,
        'inserted_date'=> date("Y-m-d H:i:s")
        ));

      
  
    }



    // if ($file_name != "") {
    //     // wp_set_post_terms( $post_id, $arrayoftags);
    //     $attach_id = wp_insert_attachment( $attachment, $fileurl, $post_id );
    //     require_once( ABSPATH . 'wp-admin/includes/image.php' );
    //     $attach_data = wp_generate_attachment_metadata( $attach_id, $imagePath );
    //     wp_update_attachment_metadata( $attach_id, $attach_data );
    //     set_post_thumbnail( $post_id, $attach_id );
    // }

    foreach ($tanks as $tank){
            //create tank/or livestock ref
            $meta_key = 'tt_tank_ref';
            $meta_value = $tank;
            add_post_meta($post_id, $meta_key, $meta_value);
    }

 
}; ?>