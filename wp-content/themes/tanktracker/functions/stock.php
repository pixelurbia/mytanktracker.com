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
      WHERE user_id = $user
      ORDER BY user_photos.inserted_date DESC
      LIMIT $limit)
      UNION
      (SELECT 
      user_photos.photo_thumb_url, 
      user_photos.photo_url, 
      user_photos.ref_id
      FROM user_photos 
      WHERE user_photos.ref_id = '$stock_id'
      AND user_id = $user
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
                  echo '<li class="name">'.$stock->stock_name.'';
                  echo '<li class="species">The '.$stock->stock_species.'</li>';
                  echo '<li class="age data">Age: '.$stock->stock_age.'</li>';
                  echo '<li class="status data">Status: '.$stock->stock_health.'</li>';
                  echo '<li class="sex data">Sex: '.$stock->stock_sex.'</li>';
                  echo '<li class="stock-action"><i class="fas larger-icon fa-edit"></i></li>';
                  echo '<li class="stock-message-action stock-action" nonce="'. wp_create_nonce("ajax_form_nonce_del_stock").'" stock_id="'.$stock->stock_id.'"><i class="fas larger-icon fa-trash-alt" ></i></li>';  
              echo '</ul>';
          echo '</div>';
      echo '</article>';
    }
    exit;
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




  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  
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
  $tank_id = $_REQUEST['tankid'];
  
if ($extension == 'plain'){
  $stock_image = '/wp-content/uploads/user_livestock/fishdefault.png';
} else {
  $stock_image = $photo_url;
}
  

  

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

  $obj_type = 'livestock-img';
  $hextwo = uni_key_gen($obj_type);

$wpdb->insert('user_photos',array(
  'user_id'=> $user_id,
  'photo_id'=> $hextwo,
  'ref_id'=> $stock_id,
  'photo_thumb_url'=> $photo_url,
  'photo_url' => $photo_url,
  'inserted_date'=> date("Y-m-d H:i:s")
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