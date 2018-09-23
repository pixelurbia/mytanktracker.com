<?php




class Stock {


function user_info() {
    
    $current_user = wp_get_current_user();
    $user = $current_user->ID;
    return $user;
   }


  function the_stock_gallery($stock_id, $limit) { 
    $stock_id = $_GET['stock_id'];

    // global $wpdb;     
    // $stock_images = $wpdb->get_results("SELECT photo_url FROM user_photos WHERE user_id = $user AND ref_id = '$stock_id' LIMIT $limit");


      global $wpdb;     
      $images = $wpdb->get_results("(SELECT 
      user_photos.photo_thumb_url, 
      user_photos.photo_url, 
      user_photos.ref_id
      FROM tt_postmeta 
      JOIN user_photos 
      ON tt_postmeta.post_id = user_photos.ref_id 
      AND tt_postmeta.meta_key = 'tt_tank_ref' 
      AND tt_postmeta.meta_value = '$stock_id'
      ORDER BY user_photos.inserted_date DESC
      LIMIT $limit)
      UNION
      (SELECT 
      user_photos.photo_thumb_url, 
      user_photos.photo_url, 
      user_photos.ref_id
      FROM user_photos 
      WHERE user_photos.ref_id = '$stock_id'
      ORDER BY user_photos.inserted_date DESC
      LIMIT $limit)
    ");
    
    echo '<ul class="gallery page-gallery">';
        foreach ($images as $img){
          echo '<li class="gallery-item">';
        echo '<img full="'.$img->photo_url.'" src="'.$img->photo_thumb_url.'">';
          echo '</li>';
      }
      echo '</ul>';
      echo ' <a href="/gallery?tank_id='.$stock_id.'">View All Photos</a>';
  }

  function single_stock($stock_id) {
  
    $stock_id = $_GET['stock_id'];


    global $wpdb;     
    $stock = $wpdb->get_results("SELECT * FROM user_tank_stock WHERE stock_id = '$stock_id'");
    
    // echo $tank_id;
    // echo $user;
    return $stock;
  }
function list_of_livestock() {
  
    $user = $this->user_info();

    global $wpdb;     
    $livestock = $wpdb->get_results("SELECT * FROM user_tank_stock WHERE user_id = $user");

    return $livestock;
  }

  function tank_list_of_livestock() {
  
      $tank_id = $_REQUEST['tank_id'];


    global $wpdb;     
    $livestock = $wpdb->get_results("SELECT * FROM user_tank_stock WHERE tank_id = '$tank_id'");

     echo '<div class="tank-livestock-list">';
    foreach ($livestock as $stock){
      echo '<article class="stock-item '.$stock->stock_type.'" ">';
          echo '<a class="stock-action" href="/livestock?tank_id='.$stock->tank_id.'&stock_id='.$stock->stock_id.'"><i class="fas fa-arrow-circle-right"></i></a>';
          echo '<div class="stock-img" style="background:url('.$stock->stock_img.');"></div>';
      echo '</article>';    
      
  }
  echo '</div>';
}


  public function list_of_stock($args) {

    if (!$_REQUEST['tank_id']){
      $tank_id = $args['tank_id'];  
    } else {
      $tank_id = $_REQUEST['tank_id'];
    }
    if (!$_REQUEST['stock_type']){
      $stock_type = $args['stock_type'];  
    } else {
      $stock_type = $_REQUEST['stock_type'];
    }
    

    if ($stock_type == 'all'){
      $stockType = 'AND stock_type IS NOT NULL';
    } else {
      $stockType = 'AND stock_type ="'.$stock_type.'"';
    }


    global $wpdb;     
    $livestock = $wpdb->get_results("
      SELECT * FROM user_tank_stock 
      WHERE tank_id = '$tank_id'
      $stockType
      ");
    
    foreach ($livestock as $stock){
      echo '<article class="stock-item '.$stock->stock_type.'" ">';
          echo '<a class="stock-action" href="/livestock?tank_id='.$stock->tank_id.'&stock_id='.$stock->stock_id.'"><i class="fas fa-arrow-circle-right"></i></a>';
          echo '<div class="stock-img" style="background:url('.$stock->stock_img.');"></div>';
          echo '<div class="stock-data">';
              echo '<ul>';

                echo '<li class="';
                  if (!$stock->stock_name){
                    echo 'hide ';
                  }
                  echo 'name">Name: <span>'.$stock->stock_name.'</span></li>';
                    echo '<li class="';
                  if (!$stock->stock_species){
                    echo 'hide ';
                  }
                  echo 'species">Species: <span>'.$stock->stock_species.'</span></li>';
                    echo '<li class="';
                  if (!$stock->stock_age){
                    echo 'hide ';
                  }
                  echo 'age data">Age: <span> '.$stock->stock_age.'</span></li>';
                    echo '<li class="';
                  if (!$stock->stock_health){
                    echo 'hide ';
                  }
                  echo 'status data">Status: <span> '.$stock->stock_health.'</span></li>';
                    echo '<li class="';
                  if (!$stock->stock_sex){
                    echo 'hide ';
                  }
                  echo 'sex data">Sex: <span>'.$stock->stock_sex.'</span></li>';
                    echo '<li class="';
                  if (!$stock->stock_count){
                    echo 'hide ';
                  }
                  echo 'count data">Count: <span>'.$stock->stock_count.'</span></li>';

                  //security check only enable for users to edit their own tank stuff
                  $my_tank = this_my_tank();
                  if ($my_tank == 1){

                  echo '<a class="stock-action edit-stock"><i class="fas larger-icon fa-edit"></i></a>';
                  echo '<a class="stock-action save-tank-stock hide" nonce="'.wp_create_nonce("ajax_form_nonce_save_stock").'" stock_id="'.$stock->stock_id.'"><i class="fas save-stock larger-icon fa-save"></i></a>';
                  echo '<a class="stock-message-action del-stock stock-action hide" nonce="'.wp_create_nonce("ajax_form_nonce_del_stock").'" stock_id="'.$stock->stock_id.'"><i class="fas larger-icon fa-trash-alt" ></i></a>';  
                  echo '<form class="stock-update-img hide" id="photo-form-'.$stock->stock_id.'" method="post">';
                  echo '<input type="hidden" name="action" value="update_stock_photo">';
                  echo '<input type="hidden" name="ref_id" value="'.$stock->stock_id.'">';
                  echo '<input type="hidden" name="user_id" value="'.$user.'">';
                  wp_nonce_field('ajax_form_nonce_stock_photo','ajax_form_nonce_stock_photo', true, true ); 
                  echo '<a class="stock-action">';
                  echo '<label for="tank-photo-img-'.$stock->stock_id.'">';
                  echo '<i class="fas larger-icon fa-camera-retro"></i>';
                  echo '</label>';
                  echo '<input type="file" name="file_upload" id="tank-photo-img-'.$stock->stock_id.'" class="stock-photo-img inputfile hide" accept="image/*" />';
                  echo '</a></form>';

                    }

              echo '</ul>';
          echo '</div>';
      echo '</article>';
    }
die();
  }

}

  add_action( 'wp_ajax_list_of_stock', array( 'Stock', 'list_of_stock' ) ); 
  add_action( 'wp_ajax_nopriv_list_of_stock', array( 'Stock', 'list_of_stock' ) );

add_action('wp_ajax_add_livestock', 'add_livestock');
add_action('wp_ajax_nopriv_add_livestock', 'add_livestock');

/**
 * add_livestock
 *
 */

function add_livestock( $file = array() ) {    

 require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    // Verify nonce
 if( !isset( $_POST['ajax_form_nonce_stock'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_stock'], 'ajax_form_nonce_stock' ) )
    die( 'Ooops, something went wrong, please try again later.' );
   

  global $wpdb;
  global $post;
  $user = wp_get_current_user();

//set env
    $environment = set_env(); 
  if ( $environment == 'DEV') {
     $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_livestock/';
     $new_file_url = '/wp-content/uploads/user_livestock/';
  } else {
       $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_livestock/';
       $new_file_url = '/wp-content/uploads/user_livestock/';
  }



    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
       var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }

    var_error_log('adding new stock');

    //get blob data
    $img = $_REQUEST['file'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    // get extenstion type
    $f = finfo_open();
    $mime_type = finfo_buffer($f, $data, FILEINFO_MIME_TYPE);
    $split = explode( '/', $mime_type );
    $extension = $split[1]; 

  $obj_type = 'livestock';
  $hex = uni_key_gen($obj_type);
  // $fileName = $hex.'-stock.png';
  $fileThumbName = $hex.'-thumb.'.$extension; 
  $fileName = $hex.'-large.'.$extension;
  $photo_url = $new_file_url.$fileName;

  //put filesomewhere and rename it
  $success =  file_put_contents($new_file_dir.$fileName, $data);


  $user_id = $user->ID;
  $stock_name = $_REQUEST['stockname'];
  $stock_id = $hex;
  $stock_species = $_REQUEST['stockspecies'];
  $stock_type = $_REQUEST['stocktype'];
  $stock_age = $_REQUEST['sotckage'];
  $stock_health = $_REQUEST['stockhealth'];
  $stock_sex = $_REQUEST['stocksex'];
  $stock_count = $_REQUEST['stockcount'];
  $tank_id = $_REQUEST['tankid'];

  
if ($extension == 'plain'){
  $stock_image = '/wp-content/uploads/user_livestock/fishdefault.png';
} else {
  $stock_image = $photo_url;
}

 $success = $wpdb->insert('user_tank_stock',array(
  'user_id'=> $user_id,
    'tank_id'=> $tank_id,
    'stock_name'=> $stock_name,
    'stock_id'=> $stock_id,
    'stock_species'=> $stock_species,
    'stock_type'=> $stock_type,
    'stock_age'=> $stock_age,
    'stock_health'=> $stock_health,
    'stock_sex'=> $stock_sex,
    'stock_count'=> $stock_count,
    'stock_img' => $stock_image,
    'created_date'=> date("Y-m-d H:i:s")
)
    ); 


  $obj_type = 'livestock-img';
  $hextwo = uni_key_gen($obj_type);

$succ = $wpdb->insert('user_photos',array(
  'user_id'=> $user_id,
  'photo_id'=> $hextwo,
  'ref_id'=> $stock_id,
  'photo_thumb_url'=> $photo_url,
  'photo_url' => $photo_url,
  'inserted_date'=> date("Y-m-d H:i:s")
)
    );


// exit;
}


add_action('wp_ajax_update_user_stock', 'update_user_stock');
add_action('wp_ajax_nopriv_update_user_stock', 'update_user_stock');

/**
 * Update stock
 *
 */

function update_user_stock() {    

 require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    
  global $wpdb;
  global $post;
  $user = wp_get_current_user();


   // Verify nonce
 if( !isset( $_POST['ajax_form_nonce_save_stock'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_save_stock'], 'ajax_form_nonce_save_stock' ) )
    die( 'Ooops, something went wrong, please try again later.');

    $user_id = $user->ID;
    $stock_id = $_REQUEST['stock_id'];
    $stock_name = $_REQUEST['stock_name'];
    $stock_species = $_REQUEST['stock_species'];
    $stock_age = $_REQUEST['stock_age'];
    $stock_status = $_REQUEST['stock_status'];
    $stock_sex = $_REQUEST['stock_sex'];
    $stock_count = $_REQUEST['stock_count'];
 

  $wpdb->update('user_tank_stock',array(
    'stock_name'=>$stock_name,
    'stock_species'=>$stock_species,
    'stock_age'=>$stock_age,
    'stock_health'=>$stock_status,
    'stock_sex'=>$stock_sex,
    'stock_count'=>$stock_count,
    'last_updated_date'=> date("Y-m-d H:i:s")
  ), array(
    'user_id'=> $user_id,
    'stock_id'=> $stock_id )
    );

    return false;
}


add_action('wp_ajax_del_livestock', 'del_livestock');
add_action('wp_ajax_nopriv_del_livestock', 'del_livestock');

/**
 * del_livestock
 *
 */

function del_livestock( $file = array() ) {    



 require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    // Verify nonce
 if( !isset( $_POST['ajax_form_nonce_del_stock'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_del_stock'], 'ajax_form_nonce_del_stock' ) )
    die( 'Ooops, something went wrong, please try again later.' );
   

  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_id = $user->ID;
  $stock_id = $_REQUEST['stock_id'];

  $wpdb->delete('user_tank_stock',array(
  'user_id'=> $user_id,
  'stock_id'=> $stock_id
)
    );


 $posts_ids_del = $wpdb->get_results("SELECT post_id FROM tt_postmeta WHERE meta_value = '$stock_id' ");
  $ids = array();
    foreach ($posts_ids_del as $post) {
    $ids[] = "'".$post->post_id."',";

      $action = "del_post_and_meta_data";
      $ref_id = $post->post_id;
      $description = "User deleted stock and all associated data - this is each post ";

      audit_trail($user_id, $action, $ref_id, $description);
    }

      
      $wpdb->query( "DELETE FROM tt_postmeta WHERE meta_value IN($ids)");
      $wpdb->query( "DELETE FROM tt_posts WHERE ID IN($ids)");
      $wpdb->query( "DELETE FROM tt_comments WHERE comment_post_id IN($ids)");
      $wpdb->query( "DELETE FROM tt_term_relationships WHERE object_id IN($ids)");
      $wpdb->query( "DELETE FROM user_post_refs WHERE ref_id IN($ids)");

      $action = "del_stock";
      $ref_id = $tank_id;
      $description = "User deleted stock and all associated data";

      audit_trail($user_id, $action, $ref_id, $description);

    // return false;
}



/**
 * Update Stock Photo
 *
 */

add_action('wp_ajax_update_stock_photo', 'update_stock_photo');
add_action('wp_ajax_nopriv_update_stock_photo', 'update_stock_photo');

function update_stock_photo() {    

 require_once( ABSPATH . 'wp-admin/includes/admin.php' );
    
  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_id = $user->ID;


   // Verify nonce
 if( !isset( $_POST['ajax_form_nonce_stock_photo'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_stock_photo'], 'ajax_form_nonce_stock_photo' ) )
    die( 'Ooops, something went wrong, please try again later.');



    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
       var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }

    var_error_log('update stock image');

    $upload_dir = wp_upload_dir();
    $environment = set_env(); 

  if ( $environment == 'DEV') {
     $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_livestock/';
     $new_file_url = '/wp-content/uploads/user_livestock/';
  } else {
       $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_livestock/';
       $new_file_url = '/wp-content/uploads/user_livestock/';
  }

    $stock_id = $_REQUEST['ref_id'];
    $stock_img = $filepath;

    $file =$_FILES["file"];
   
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

            $ref_id = $stock_id;
            $photo_url = $new_file_url.$fileFullName;
            $photo_thumb_url = $new_file_url.$fileThumbName;
            var_error_log($photo_url);
            var_error_log($photo_thumb_url);

            $obj_type_new = 'user-stock-img';
            $hextwo = uni_key_gen($obj_type_new);

              
            //update stock photo
              $wpdb->update('user_tank_stock',array(
                'stock_img'=> $photo_thumb_url,
                'last_updated_date'=> date("Y-m-d H:i:s")
              ), array(
                'user_id'=> $user_id,
                'stock_id'=> $stock_id )
                );
            
            //add entry into the photo db as well so it shows up in the gallery and resize
            $wpdb->insert('user_photos',array(
              'user_id'=> $user_id,
              'photo_id'=> $hextwo,
              'ref_id'=> $stock_id,
              'photo_thumb_url'=> $photo_thumb_url,
              'photo_url' => $photo_url,
              'inserted_date'=> date("Y-m-d H:i:s")
            )
                );

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




    return false;
}
