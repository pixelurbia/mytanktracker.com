<?php


class Tanks {

	function user_info() {
	 	
	 	$current_user = wp_get_current_user();
		$user = $current_user->ID;
		return $user;
	 }

	function cats() {
		global $wpdb;

		$cats = $wpdb->get_results("SELECT term_id, name FROM tt_terms");

		return $cats;
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

		global $wpdb;			
		$tank = $wpdb->get_results("SELECT * FROM user_tanks WHERE tank_id = '$tank_id'");
		
		// echo $tank_id;
		// echo $user;
		return $tank;
	}


	function list_of_tanks() {
	
		$user = $this->user_info();

		global $wpdb;			
		$tanks = $wpdb->get_results("SELECT tank_id,tank_name FROM user_tanks WHERE user_id = $user");
		
		return $tanks;
	}


	function get_tank_photos($tank_id) {
		
		global $wpdb;			
		$photos = $wpdb->get_results("SELECT * FROM user_photos WHERE ref_id = '$tank_id'");

			echo '<div class="gallery">';
			foreach($photos as $photo){
				echo '<div class="img-contain"><img src="'.$photo->photo_url.'""></div>';
			}
			echo '</div>';

     	}

	function the_tank_gallery($tank_id, $limit) { 
    	$tank_id = $_GET['tank_id'];

    	global $wpdb;     
    	$images = $wpdb->get_results("SELECT 
			tt_postmeta.post_id, 
			tt_postmeta.meta_key, 
			tt_postmeta.meta_value,
			user_photos.photo_thumb_url, 
			user_photos.photo_url, 
			user_photos.ref_id,
			user_photos.inserted_date
			FROM tt_postmeta 
			JOIN user_photos 
			ON tt_postmeta.post_id = user_photos.ref_id 
			AND tt_postmeta.meta_key = 'tt_tank_ref' 
			AND tt_postmeta.meta_value = '$tank_id'
			ORDER BY user_photos.inserted_date DESC
			LIMIT $limit
		");
    
		echo '<ul class="gallery page-gallery">';	
      	foreach ($images as $img){
        	echo '<li class="gallery-item">';
				echo '<img full="'.$img->photo_url.'" src="'.$img->photo_thumb_url.'">';
        	echo '</li>';
    	}
    	echo '</ul>';
    	echo ' <a href="/gallery?tank_id='.$tank_id.'">View All Photos</a>';
	}

	function full_gallery($tank_id, $limit) { 
    	$tank_id = $_GET['tank_id'];


    	global $wpdb;     
    	$images = $wpdb->get_results("SELECT 
			tt_postmeta.post_id, 
			tt_postmeta.meta_key, 
			tt_postmeta.meta_value,
			user_photos.photo_thumb_url, 
			user_photos.photo_url, 
			user_photos.ref_id,
			user_photos.inserted_date
			FROM tt_postmeta 
			JOIN user_photos 
			ON tt_postmeta.post_id = user_photos.ref_id 
			AND tt_postmeta.meta_key = 'tt_tank_ref' 
			AND tt_postmeta.meta_value = '$tank_id'
			ORDER BY user_photos.inserted_date DESC
			LIMIT $limit
		");
    
		echo '<ul class="gallery full-gallery">';
      	foreach ($images as $img){
        	echo '<li class="gallery-item">';
				echo '<img full="'.$img->photo_url.'" src="'.$img->photo_thumb_url.'">';
        	echo '</li>';
    	}
    	echo '</ul>';
	}

  function tank_selection(){

  	global $wpdb;
  	$user = $this->user_info();

	$tanks = $wpdb->get_results("SELECT * FROM user_tanks WHERE user_id = $user");

	foreach($tanks as $tank){

	echo '<div class="a_tank select_tank">';
	echo '<div class="content">';
		echo '<h2>';
			echo '<i class="tank_info tank_name">'. $tank->tank_name .'</i>';
		echo '</h2>';
		echo '<p>';


		echo  '<span '; 
			if (!$tank->tank_volume) {
				echo ' class="hide"';
			} 
		echo'>Volume: <i class="tank_info tank_volume">'.$tank->tank_volume.'</i> Gallons </span>';
		echo '<span' ; 
			if (!$tank->tank_dimensions){
				echo ' class="hide"';
			}
		echo'>Dimensions: <i class="tank_info tank_dimensions">'.$tank->tank_dimensions.'</i></span>';
		echo '<span' ; 
			if (!$tank->tank_model){
				echo ' class="hide"';
			}
		echo'>Model: <i class="tank_info tank_model">'.$tank->tank_model.'</i></span>';
		echo '<span' ; 
			if (!$tank->tank_make){
				echo ' class="hide"';
			}
		echo'>Make: <i class="tank_info tank_make">'.$tank->tank_make.'</i></span>';	
			echo '</p>';
			echo '<div class="tank_actions">';
				echo '<a class="tip" tip="Overview Page" href="/overview/?tank_id='.$tank->tank_id.'"><i class="fas fa-3x fa-list-alt"></i></a>';
					echo '<a class="tip" tip="Parameters" href="/fullview/?tank_id='.$tank->tank_id.'"><i class="fas fa-3x fa-flask"></i></a>';
					echo '<a class="tip" tip="Livestock" href="/stock/?tank_id='.$tank->tank_id.'"><i class="fas fa-3x fa-tint"></i></a>';
					// echo '<a  href="/equipment/?tank_id='.$tank->tank_id.'"><i class="fas fa-3x fa-bolt"></i></a>';
						echo '<a tip="Edit Tank" class="edit-tank tip">';
						echo '<i class="fas edit-tank-stock fa-3x fa-edit" ></i>';
					echo '</a>';
			echo '</div>';
			echo '<div class="tank-options">';
				echo '<form class="btn-styles" id="photo-form-'.$tank->tank_id.'" method="post">';
				echo '<input type="hidden" name="action" value="update_tank_photo">';
				echo '<input type="hidden" name="ref_id" value="'.$tank->tank_id.'">';
				echo '<input type="hidden" name="user_id" value="'.$user.'">';
				wp_nonce_field('ajax_form_nonce_photo','ajax_form_nonce_photo', true, true ); 
			echo '<a tip="Change Tank Image" class="image-change tip" >';
            	echo '<label class="tank-img" for="tank-photo-img-'.$tank->tank_id.'">';
            		echo '<i class="fas fa-3x fa-camera-retro"></i>';
            	echo '</label>';
         
            	echo '<input type="file" name="file_upload" id="tank-photo-img-'.$tank->tank_id.'" class="tank-photo-img inputfile hide" accept="image/*" />';
        		echo '</a></form>';

					echo '<a tip="Save Tank Changes" class="save-edit-tank tip btn-styles" nonce="'. wp_create_nonce("ajax_form_nonce_update_tank").'" tank_id="'. $tank->tank_id .'">';
						echo '<i class="fas edit-tank-stock fa-3x fa-save"></i>';
					echo '</a>';
					echo '<a tip="Delete Tank" class="delete-tank tip btn-styles" nonce="'. wp_create_nonce("ajax_form_nonce_del_tank").'" tank_id="'. $tank->tank_id .'">';
						echo '<i class="fas edit-tank-stock  fa-3x fa-trash-alt"></i>';
					echo '</a>';
					
				echo '</div>';
	echo '</div>';
				
			
	
		echo '<div class="shader"></div>';
		echo '<div class="tank_img" style="background:url('.$tank->tank_image.')"></div>';
	echo '</div>';

  }


	}
}


add_action('wp_ajax_add_tank', 'add_user_tank');
add_action('wp_ajax_nopriv_add_tank', 'add_user_tank');

/**
 * Add Tank
 *
 */

function add_user_tank( $file = array() ) {    

 require_once( ABSPATH . 'wp-admin/includes/admin.php' );
	  // Verify nonce
  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_name = $user->display_name;
  $user_id = $user->ID;
  $validation = $_REQUEST['verfication-username'];

 if( !isset( $_POST['ajax_form_nonce_tank'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_tank'], 'ajax_form_nonce_tank' ) ){
	} else if( !isset( $validation ) && $validation == $user_name ) 
    die( 'Ooops, something went wrong, please try again later.'.$validation );
   

	
		$upload_dir = wp_upload_dir();
		$environment = set_env(); 
	  
	  if ( $environment == 'DEV') {
     $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_tanks/';
     $new_file_url = '/wp-content/uploads/user_tanks/';
  } else {
       $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_tanks/';
       $new_file_url = '/wp-content/uploads/user_tanks/';
  }


if (!$_FILES["file"]){ 
$photo_url = ' ';
$photo_thumb_url = ' ';

} else {


  $mimeTypes = array('image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','image/gif','image/png'); //allowed file types
        if (in_array($_FILES["file"]["type"], $mimeTypes))
         {
            // var_error_log($file['type']);
            // var_error_log('valid file type');
            $action = 'tank update File upload';
            $ref_id = 0345;
            $description = 'valid file: '.$_FILES["file"]["type"];
            audit_trail($user_id, $action, $ref_id, $description);

        }
        else
         {
            // var_error_log($file['type']);
            // var_error_log('invalid file');
            $action = 'tank update File upload';
            $ref_id = 0346;
            $description = 'invalid file: '.$_FILES["file"]["type"];
            audit_trail($user_id, $action, $ref_id, $description);
            // return 'You have attempted to upload an incorrect file type, naughty.';

        }

 
			$file = $_FILES["file"];
			//tank photo resize stuff 
		 	$obj_type = 'img';
            $hex = uni_key_gen($obj_type);

            $imageData = getimagesize($file['tmp_name']);
            $extension = image_type_to_extension($imageData[2]);


            $fileName = $file['name'];
            $fileThumbName = $hex.'-thumb'.$extension; 
            $fileFullName = $hex.'-large'.$extension;
            $fileTempName = $file['tmp_name'];
            
            move_uploaded_file($fileTempName, $new_file_dir.$fileFullName);

            $ref_id = $tank_id;
            $photo_url = $new_file_url.$fileFullName;
            $photo_thumb_url = $new_file_url.$fileThumbName;

            $obj_type_new = 'user-tank-img';
            $hextwo = uni_key_gen($obj_type_new);

            //thumbnail processesing 
            $general = NEW General();
            $target_dir = $new_file_dir;
            $target = $new_file_dir.$fileThumbName;
            $load = $new_file_dir.$fileFullName;
            $size = 1024;
        
            $general->resizeImageFiles($size,$load,$target);
		
}
  //create hex unique ref key ID
  $obj_type = 'tank';
  $hex = uni_key_gen($obj_type);


  $tank_name = $_REQUEST['tankname'];
  $tank_type = $_REQUEST['tanktype'];
  $tank_volume = $_REQUEST['volume'];
  $tank_dimensions = $_REQUEST['dimensions'];
  $tank_model = $_REQUEST['model'];
  $tank_make = $_REQUEST['make'];
  $tank_image = $photo_thumb_url;
	

  $wpdb->insert('user_tanks',array(
  'user_id'=> $user_id,
  'tank_id'=> $hex,
  'tank_name'=> $tank_name,
  'tank_type'=> $tank_type,
  'tank_volume'=> $tank_volume,
  'tank_dimensions'=> $tank_dimensions,
  'tank_model'=> $tank_model,
  'tank_make'=> $tank_make,
  'tank_image'=> $tank_image,
  'created_date'=> date("Y-m-d H:i:s")
)


    );
if ($_FILES["file"]){ 
  $ref_id = $hex;
  $fileUrls = array($photo_thumb_url);
  // $cars=array("Volvo","BMW","Toyota");
  $message = $user_name.' added a new tank!';
  create_post_record($ref_id, $photo_url, $photo_thumb_url, $message);
}
    return false;
}



/**
 * Update Tank Photo
 *
 */

add_action('wp_ajax_update_tank_photo', 'update_tank_photo');
add_action('wp_ajax_nopriv_update_tank_photo', 'update_tank_photo');
function update_tank_photo() {    

 require_once( ABSPATH . 'wp-admin/includes/admin.php' );
	  
  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_id = $user->ID;


    //  function var_error_log( $object=null ){
    //     ob_start();                    // start buffer capture
    //    var_dump( $object );           // dump the values
    //     $contents = ob_get_contents(); // put the buffer into a variable
    //     ob_end_clean();                // end capture
    //     error_log( $contents );        // log contents of the result of var_dump( $object )
    // }

   // Verify nonce
 if( !isset( $_POST['ajax_form_nonce_photo'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_photo'], 'ajax_form_nonce_photo' ) )
    die( 'Ooops, something went wrong, please try again later.');


		$upload_dir = wp_upload_dir();
 		//construct new upload dir from upload base dir and the username of the current user
 		// $sourcePath = $_FILES['file']['tmp_name']; 
 	$environment = set_env(); 
	if ( $environment == 'DEV') {
     $new_file_dir = '/Users/bear/Documents/tanktracker/wp-content/uploads/user_tanks/';
     $new_file_url = '/wp-content/uploads/user_tanks/';
  } else {
       $new_file_dir = '/var/www/vhosts/mytanktracker.com/wp-content/uploads/user_tanks/';
       $new_file_url = '/wp-content/uploads/user_tanks/';
  }
     
   
    $mimeTypes = array('image/jpeg','image/pjpeg','image/jpeg','image/pjpeg','image/gif','image/png'); //allowed file types
        if (in_array($_FILES["file"]["type"], $mimeTypes))
         {
            // var_error_log($file['type']);
            // var_error_log('valid file type');
            $action = 'tank update File upload';
            $ref_id = 0345;
            $description = 'valid file: '.$_FILES["file"]["type"];
            audit_trail($user_id, $action, $ref_id, $description);
        }
        else
         {
            // var_error_log($file['type']);
            // var_error_log('invalid file');
            $action = 'tank update File upload';
            $ref_id = 0346;
            $description = 'invalid file: '.$_FILES["file"]["type"];
            audit_trail($user_id, $action, $ref_id, $description);
            return 'You have attempted to upload an incorrect file type, naughty.';

        }


 

 
			$file = $_FILES["file"];
			//tank photo resize stuff 
		 	$obj_type = 'img';
            $hex = uni_key_gen($obj_type);

            $imageData = getimagesize($file['tmp_name']);
            $extension = image_type_to_extension($imageData[2]);


            $fileName = $file['name'];
            $fileThumbName = $hex.'-thumb'.$extension; 
            $fileFullName = $hex.'-large'.$extension;
            $fileTempName = $file['tmp_name'];
            
            move_uploaded_file($fileTempName, $new_file_dir.$fileFullName);

            $ref_id = $tank_id;
            $photo_url = $new_file_url.$fileFullName;
            $photo_thumb_url = $new_file_url.$fileThumbName;

            $obj_type_new = 'user-tank-img';
            $hextwo = uni_key_gen($obj_type_new);

            //thumbnail processesing 
            $general = NEW General();
            $target_dir = $new_file_dir;
            $target = $new_file_dir.$fileThumbName;
            $load = $new_file_dir.$fileFullName;
            $size = 1024;
        
			$general->resizeImageFiles($size,$load,$target);

   // var_error_log($fileName);
   // var_error_log($fileFullName);
   // var_error_log($fileThumbName);
   // var_error_log($extension);
   // var_error_log($photo_url);
   // var_error_log($photo_thumb_url);

		// move_uploaded_file($_FILES["file"]["tmp_name"], $new_file_dir.$_FILES["file"]["name"]);
		// $fileurl = $new_file_dir.$_FILES["file"]["name"];
		// $filepath = '/wp-content/uploads/user_tanks/'.$_FILES["file"]["name"];

 
  $user_id = $user->ID;
  $tank_id = $_REQUEST['ref_id'];
  $tank_image = $photo_thumb_url;


        $obj_type_new = 'user-tank-img';
        $hextwo = uni_key_gen($obj_type_new);
  
        $wpdb->insert('user_photos',array(
        'user_id'=> $user_id,
        'photo_id'=> $hextwo,
        'ref_id'=> $tank_id,
        'photo_url'=> $photo_url,
        'photo_thumb_url'=> $photo_thumb_url,
        'inserted_date'=> date("Y-m-d H:i:s")
        ));


  $wpdb->update('user_tanks',array(
  	'tank_image'=> $tank_image,
  	'last_updated_date'=> date("Y-m-d H:i:s")
	), array(
		'user_id'=> $user_id,
		'tank_id'=> $tank_id )
    );

    return false;
}



//delete Tank
add_action("wp_ajax_del_tank", "del_tank");
add_action("wp_ajax_nopriv_del_tank", "del_tank");

function del_tank() {

if( !isset( $_POST['ajax_form_nonce_del_tank'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_del_tank'], 'ajax_form_nonce_del_tank' ) )
    die( 'Ooops, something went wrong, please try again later.' );

  global $wpdb;
  global $post;
  $user = wp_get_current_user();
  $user_id = $user->ID;
  $tank_id = $_REQUEST['tank_id'];
  $param_id = $_REQUEST['param_id'];

      function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
       var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }

// delete tank entry
  $wpdb->delete('user_tanks',array(
  'tank_id'=> $tank_id,
  'user_id'=> $user_id
)
    );

//return all post ID's for that tank ID 

  $posts_ids_del = $wpdb->get_results("SELECT post_id FROM tt_postmeta WHERE meta_value = '$tank_id' ");
	$ids = array();
  	foreach ($posts_ids_del as $post) {
	  $ids[] = "$post->post_id";

	  $action = "del_post_and_meta_data";
  	  $ref_id = $post->post_id;
  	  $description = "User deleted tank and all associated data - this is each post ";

  	  audit_trail($user_id, $action, $ref_id, $description);
  	}

  	// $output = array_map(function ($object) { return $object->name; }, $ids);
	$ids = implode(',', $ids);

  	  
  	  $wpdb->query( "DELETE FROM tt_postmeta WHERE meta_value IN($ids)");
  	  $wpdb->query( "DELETE FROM tt_posts WHERE ID IN($ids)");
  	  $wpdb->query( "DELETE FROM tt_comments WHERE comment_post_id IN($ids)");
  	  $wpdb->query( "DELETE FROM tt_term_relationships WHERE object_id IN($ids)");
  	  $wpdb->query( "DELETE FROM user_post_refs WHERE ref_id IN($ids)");
  	  $wpdb->query( "DELETE FROM user_tank_stock WHERE tank_id = '$tank_id'");
  	  $wpdb->query( "DELETE FROM user_tank_params WHERE tank_id = '$tank_id'");
  	  // wp_delete_post( int $postid, bool $force_delete = false )

  	  $action = "del_tank";
  	  $ref_id = $tank_id;
  	  $description = "User deleted tank and all associated data";

  	  audit_trail($user_id, $action, $ref_id, $description);

}

add_action('wp_ajax_update_user_tank', 'update_user_tank');
add_action('wp_ajax_nopriv_update_user_tank', 'update_user_tank');

/**
 * Update Tank
 *
 */

function update_user_tank() {    

 require_once( ABSPATH . 'wp-admin/includes/admin.php' );
	  
  global $wpdb;
  global $post;
  $user = wp_get_current_user();


   // Verify nonce
 if( !isset( $_POST['ajax_form_nonce_update_tank'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_update_tank'], 'ajax_form_nonce_update_tank' ) )
    die( 'Ooops, something went wrong, please try again later.');

 
  $user_id = $user->ID;
  $tank_name = $_REQUEST['tank_name'];
  $tank_volume = $_REQUEST['tank_volume'];
  $tank_dimensions = $_REQUEST['tank_dimensions'];
  $tank_model = $_REQUEST['tank_model'];
  $tank_make = $_REQUEST['tank_make'];
  $tank_id = $_REQUEST['tank_id'];


  $wpdb->update('user_tanks',array(
  	'tank_name'=> $tank_name,
  	'tank_volume'=> $tank_volume,
  	'tank_dimensions'=> $tank_dimensions,
  	'tank_model'=> $tank_model,
  	'tank_make'=> $tank_make,
  	'last_updated_date'=> date("Y-m-d H:i:s")
	), array(
		'user_id'=> $user_id,
		'tank_id'=> $tank_id )
    );

    return false;
}





add_action('wp_ajax_create_post_record', 'create_post_record');
add_action('wp_ajax_nopriv_create_post_record', 'create_post_record');

/**
 * Add Tank
 *
 */

function create_post_record($ref_id, $photo_url, $photo_thumb_url, $message) {    



  global $post;
  global $wpdb;
  
  require_once( ABSPATH . 'wp-admin/includes/admin.php' );
  $user = wp_get_current_user();
  $today = date("-m-d-y");   
  $tanks = $_REQUEST['tanks'];

  
    //create post
    $uid = uniqid();
    $user_id = $user->ID;
    $username = $user->user_nicename;
    $journal_content = $message;	
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


   		// var_error_log($file);
        $obj_type_new = 'user-tank-img';
        $hextwo = uni_key_gen($obj_type_new);
  
        $wpdb->insert('user_photos',array(
        'user_id'=> $user_id,
        'photo_id'=> $hextwo,
        'ref_id'=> $post_id,
        'photo_url'=> $photo_url,
        'photo_thumb_url'=> $photo_thumb_url,
        'inserted_date'=> date("Y-m-d H:i:s")
        ));



    //create tank/or livestock ref
    $meta_key = 'tt_tank_ref';
    $meta_value = $ref_id;
    add_post_meta($post_id, $meta_key, $meta_value);

 
};

// add_action('wp_ajax_del_tank', 'del_tank');
// add_action('wp_ajax_nopriv_del_tank', 'del_tank');

// /**
//  * add_livestock
//  *
//  */

// function del_tank( $file = array() ) {    

//  require_once( ABSPATH . 'wp-admin/includes/admin.php' );
//     // Verify nonce
//  if( !isset( $_POST['ajax_form_nonce_del_stock'] ) || !wp_verify_nonce( $_POST['ajax_form_nonce_del_stock'], 'ajax_form_nonce_del_stock' ) )
//     die( 'Ooops, something went wrong, please try again later.' );
   

//   global $wpdb;
//   global $post;
//   $user = wp_get_current_user();
  
//   $user_id = $user->ID;
//   $stock_id = $_REQUEST['stock_id'];

//   $wpdb->delete('user_tanks',array(
//   'user_id'=> $user_id,
//   'tank_id'=> $stock_id
// )
//     );


//     // return false;
// }




