<?php




class Stock {


function user_info() {
    
    $current_user = wp_get_current_user();
    $user = $current_user->ID;
    return $user;
   }


  function the_stock_gallery($stock_id, $limit) { 
    $stock_id = $_GET['stock_id'];
    $user = $this-> user_info();

    global $wpdb;     
    $stock_images = $wpdb->get_results("SELECT photo_url FROM user_photos WHERE user_id = $user AND ref_id = '$stock_id' LIMIT $limit");
    
    echo '<ul class="gallery page-gallery">';
      foreach ($stock_images as $imgs){
        echo '<li class="gallery-item">';
          echo '<img src="'.$imgs->photo_url.'">';
        echo '</li>';
    }
    echo '</ul>';
    echo ' <a href="">View All Photos</a>';
  }

  function single_stock($stock_id) {
  
    $stock_id = $_GET['stock_id'];

    $user = $this-> user_info();

    global $wpdb;     
    $stock = $wpdb->get_results("SELECT * FROM user_tank_stock WHERE user_id = $user AND stock_id = '$stock_id'");
    
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

  function list_of_stock($tank_id) {


    global $wpdb;     
    $livestock = $wpdb->get_results("SELECT * FROM user_tank_stock WHERE tank_id = '$tank_id'");
    
    foreach ($livestock as $stock){
      echo '<article class="stock-item '.$stock->stock_type.'" ">';
          echo '<a class="arrow" href="/livestock?tank_id='.$stock->tank_id.'&stock_id='.$stock->stock_id.'"><i class="fas fa-arrow-circle-right"></i></a>';
          echo '<div class="stock-img" style="background:url('.$stock->stock_img.');">';
          echo '<div class="stock-actions"><a class="edit-tank-stock"><i class="fas larger-icon fa-edit"></i></a>';
          echo '<a class="stock-message-action" nonce="'. wp_create_nonce("ajax_form_nonce_del_stock").'" stock_id="'.$stock->stock_id.'"><i class="fas larger-icon fa-trash-alt" ></i></a></div>';  
          echo '</div>';
          echo '<div class="stock-data">';
              echo '<ul>';
                  echo '<li class="name">'.$stock->stock_name.'';
                  echo '<li class="species">The '.$stock->stock_species.'</li>';
                  echo '<li class="age data">Age: '.$stock->stock_age.'</li>';
                  echo '<li class="status data">Status: '.$stock->stock_health.'</li>';
                  echo '<li class="sex data">Sex: '.$stock->stock_sex.'</li>';
              echo '</ul>';
          echo '</div>';
      echo '</article>';
    }
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
     $new_file_url = '/wp-content/uploads/user_livestock/';
  } else {
       $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_livestock/';
       $new_file_url = '/wp-content/uploads/user_livestock/';
  }


//I am sending a blob file this time not a base64 but I can
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

  $fileurl = $new_file_url.$fileName;


  $user_id = $user->ID;
  $stock_name = $_REQUEST['stockname'];
  $stock_id = $hex;
  $stock_species = $_REQUEST['stockspecies'];
  $stock_type = $_REQUEST['stocktype'];
  $stock_age = $_REQUEST['sotckage'];
  $stock_health = $_REQUEST['stockhealth'];
  $stock_sex = $_REQUEST['stocksex'];
  $tank_id = $_REQUEST['tankid'];
  $stock_image = $fileurl;
  

  $wpdb->insert('user_tank_stock',array(
  'user_id'=> $user_id,
  'tank_id'=> $tank_id,
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