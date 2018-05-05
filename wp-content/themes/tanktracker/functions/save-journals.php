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
  
  require_once( ABSPATH . 'wp-admin/includes/admin.php' );
  $user = wp_get_current_user();
  $today = date("-m-d-y");   

    /* wp_insert_attachment */

    
    $upload_dir = wp_upload_dir();
 
    move_uploaded_file($_FILES["file_upload"]["tmp_name"], $upload_dir['path'].'/'.$_FILES["file_upload"]["name"]);
    $file_name = basename($_FILES["file_upload"]["name"]);
    $fileurl = $upload_dir['path'].'/'.$file_name;

    $filetype = wp_check_filetype( basename( $fileurl ), null ); // check file tupe
    // $image_data = file_get_contents($fileurl);
    // file_put_contents($fileurl, $image_data);

    $attachment = array(
        'guid'           => $fileurl, 
        'post_mime_type' => $filetype['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
        'post_content'   => '',
        'post_status'    => 'inherit'
    );


    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
        var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }

    var_error_log( $upload_dir );
    var_error_log( $fileurl );
    var_error_log( $file_name );

    
    //create post
    $user_id = $user->ID;
    $username = $user->user_nicename;
    $journal_content = $_REQUEST['journal'];
    $journal_title = $_REQUEST['tank_name'];
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

    $attach_id = wp_insert_attachment( $attachment, $fileurl, $post_id );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $attach_id, $imagePath );
    wp_update_attachment_metadata( $attach_id, $attach_data );
    set_post_thumbnail( $post_id, $attach_id );
 
}; ?>