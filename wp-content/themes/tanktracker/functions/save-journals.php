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
  $cats = $_REQUEST['cats'];

 

    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
       var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }


 $secure = new Security();
  $limit = $secure->limit_posting();
      var_error_log($limit);
    if ( $limit == 'no' ){
    // return 'limit';    
die('limit');
    }
    



    
    //create post
    $uid = uniqid();
    $user_id = $user->ID;
    $username = $user->user_nicename;
    $journal_content = $_REQUEST['journal'];
    $journal_title = 'post-'.$uid;
    // $user_id = get_current_user_id();
    // var_error_log($cats);

    if (count($cats) > 1) {
        array_unshift($cats,"");
        unset($cats[0]); 
    }
    

    $createPost = array(
        'post_author' => $user_id,
        'post_content' => $journal_content,
        'post_title' => $journal_title,
        'post_status' => 'publish',
        'post_type' => 'user_journals',
        'publish' => 'comment_status',
        'post_category' => $cats
    );


    $post_id = wp_insert_post($createPost);
    
    //create tank/or livestock meta key/value ref
    foreach ($tanks as $tank){        
            $meta_key = 'tt_tank_ref';
            $meta_value = $tank;
            add_post_meta($post_id, $meta_key, $meta_value);
    }


    //  move_uploaded_file($_FILES["file_upload"]["tmp_name"], $upload_dir['path'].'/'.$_FILES["file_upload"]["name"]);
    // $file_name = basename($_FILES["file_upload"]["name"]);
    // $fileurl = $upload_dir['path'].'/'.$file_name;

    // $filetype = wp_check_filetype( basename( $fileurl ), null ); // check file tupe
    // $image_data = file_get_contents($fileurl);
    // file_put_contents($fileurl, $image_data);

    //file handling 
    $environment = set_env(); 
        if ( $environment == 'DEV') {
            $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_photos/';
            $new_file_url = '/wp-content/uploads/user_photos/';
        } else {
            $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_photos/';
            $new_file_url = '/wp-content/uploads/user_photos/';
        }
    
    var_error_log($environment);

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

    foreach($file_ary as $file) {
       
    $mimeTypes = array('image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','image/gif','image/png'); 
    //allowed file types
        if (in_array($file['type'], $mimeTypes))
         {
            // var_error_log($file['type']);
            var_error_log('valid file type');
            $action = 'Journal File upload';
            $ref_id = 01;
            $description = 'valid file: '.$file['type'];
            audit_trail($user_id, $action, $ref_id, $description);

            var_error_log($file);
            $obj_type = 'img';
            $hex = uni_key_gen($obj_type);

            $imageData = getimagesize($file['tmp_name']);
            $extension = image_type_to_extension($imageData[2]);


            $fileName = $file['name'];
            var_error_log($fileName);
            $fileThumbName = $hex.'-thumb'.$extension; 
            $fileFullName = $hex.'-large'.$extension;
            $fileTempName = $file['tmp_name'];
            
            move_uploaded_file($fileTempName, $new_file_dir.$fileFullName);

            $ref_id = $post_id;
            $photo_url = $new_file_url.$fileFullName;
            $photo_thumb_url = $new_file_url.$fileThumbName;
            var_error_log($photo_url);
            var_error_log($photo_thumb_url);

            $obj_type_new = 'user-jrnl-img';
            $hextwo = uni_key_gen($obj_type_new);
  

            $wpdb->insert('user_photos',array(
            'user_id'=> $user_id,
            'photo_id'=> $hextwo,
            'ref_id'=> $ref_id,
            'photo_thumb_url'=> $photo_thumb_url,
            'photo_url'=> $photo_url,
            'inserted_date'=> date("Y-m-d H:i:s")
            ));

            //thumbnail processesing 
            $general = NEW General();
            $target_dir = $new_file_dir;
            $target = $new_file_dir.$fileThumbName;
            $load = $new_file_dir.$fileFullName;
            $size = 400;
        
            $general->resizeImageFiles($size,$load,$target);
            

            }
        else
         {
            // var_error_log($file['type']);
            var_error_log('invalid file');
            $action = 'Journal File upload';
            $ref_id = 01;
            $description = 'invalid file: '.$file['type'];
            audit_trail($user_id, $action, $ref_id, $description);
        }



    // $image = new SimpleImage();
    // $image->load($imgLoad);
    // $image->resizeToWidth($new_img_width);
    // $image->save($target_file);
    // var_error_log($target_file);
    // return $target_file; //return name of saved file in case you want to store it in you database or show confirmation message to user      
  
    }



    // if ($file_name != "") {
    //     // wp_set_post_terms( $post_id, $arrayoftags);
    //     $attach_id = wp_insert_attachment( $attachment, $fileurl, $post_id );
    //     require_once( ABSPATH . 'wp-admin/includes/image.php' );
    //     $attach_data = wp_generate_attachment_metadata( $attach_id, $imagePath );
    //     wp_update_attachment_metadata( $attach_id, $attach_data );
    //     set_post_thumbnail( $post_id, $attach_id );
    // }



 
}; ?>