<?php




class Stock {


function user_info() {
    
    $current_user = wp_get_current_user();
    $user = $current_user->ID;
    return $user;
   }

  function first_tank() {
    global $wpdb;

    $user = $this->user_info();

    $tank_id = $wpdb->get_var("SELECT tank_id FROM user_tanks WHERE user_id = $user ORDER BY created_date limit 1 ");

    return $tank_id;
  }

  function get_tank_data($tank_id) {
  
    if( !isset($tank_id)){
           $tank_id = $this->first_tank();
      } else {
          $tank_id = $_GET['tank_id'];
    }

    $user = $this-> user_info();

    global $wpdb;     
    $tank = $wpdb->get_results("SELECT * FROM user_tanks WHERE user_id = $user AND tank_id = '$tank_id'");
    
    // echo $tank_id;
    // echo $user;
    return $tank;
  }


  function list_of_stock() {
  
    $user = $this->user_info();

    global $wpdb;     
    $livestock = $wpdb->get_results("SELECT * FROM user_tank_stock WHERE user_id = $user");
    
    foreach ($livestock as $stock){
      echo '<article class="stock-item '.$stock->stock_type.'" ">';
          echo '<i class="fas fa-arrow-circle-right"></i>';
          echo '<div class="stock-img" style="background:url('.$stock->stock_img.');"></div>';
          echo '<div class="stock-data">';
              echo '<ul>';
                  echo '<li class="name">'.$stock->stock_name.'';
                  echo '<i class="fas fa-edit edit-tank-stock"></i><i class="fas edit-tank-stock message-action fa-trash-alt" nonce="'. wp_create_nonce("ajax_form_nonce_del_stock").'" stock_id="'.$stock->stock_id.'"></i></li>';
                  echo '<li class="species">The '.$stock->stock_species.'</li>';
                  echo '<li class="age data">Age: '.$stock->stock_age.'</li>';
                  echo '<li class="status data">Status: '.$stock->stock_health.'</li>';
                  echo '<li class="sex data">Sex: '.$stock->stock_sex.'</li>';
              echo '</ul>';
          echo '</div>';
      echo '</article>';
    }
  }


  function get_tank_photos($tank_id) {
    
      $user = $this->user_info();

    global $wpdb;     
    $photos = $wpdb->get_results("SELECT * FROM user_photos WHERE user_id = $user AND ref_id = '$tank_id'");

      echo '<div class="gallery">';
      foreach($photos as $photo){
        echo '<div class="img-contain"><img src="'.$photo->photo_url.'""></div>';
      }
      echo '</div>';

      }


	

}


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
   

//set env
    $environment = set_env(); 
  if ( $environment == 'DEV') {
     $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_livestock/';
  } else {
       $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_tanks/';
  }

    $img = $_REQUEST['file'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    
    

    // $upload_dir = wp_upload_dir();
    //construct new upload dir from upload base dir and the username of the current user
    // $sourcePath = $_FILES['file']['tmp_name']; 

// move_uploaded_file($_FILES["file"]["tmp_name"], $new_file_dir.$_FILES["file"]["name"]);

  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  
  $obj_type = 'livestock';
  $hex = uni_key_gen($obj_type);
  
  $fileName = $hex.'-stock.png';
  $success =  file_put_contents($new_file_dir.$fileName, $data);

  $fileurl = $new_file_dir.$fileName;


  $user_id = $user->ID;
  $stock_name = $_REQUEST['stockname'];
  $stock_id = $hex;
  $stock_species = $_REQUEST['stockspecies'];
  $stock_type = $_REQUEST['stocktype'];
  $stock_age = $_REQUEST['sotckage'];
  $stock_health = $_REQUEST['stockhealth'];
  $stock_sex = $_REQUEST['stocksex'];
  $stock_image = $fileurl;
  

  $wpdb->insert('user_tank_stock',array(
  'user_id'=> $user_id,
  'stock_name'=> $stock_name,
  'stock_id'=> $stock_id,
  'stock_species'=> $stock_species,
  'stock_type'=> $stock_type,
  'stock_age'=> $stock_age,
  'stock_health'=> $stock_health,
  'stock_sex'=> $stock_sex,
  'stock_img' => $stock_image,
  'created_date'=> date("Y-m-d H:i:s")
)
    );


    // return false;
}




add_action('wp_ajax_del_livestock', 'del_livestock');
add_action('wp_ajax_nopriv_del_livestock', 'del_livestock');

/**
 * add_livestock
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
  
  $obj_type = 'livestock';
  $hex = uni_key_gen($obj_type);


  $user_id = $user->ID;
  $stock_id = $_REQUEST['stock_id'];

  $wpdb->delete('user_tank_stock',array(
  'user_id'=> $user_id,
  'stock_id'=> $stock_id
)
    );


    // return false;
}