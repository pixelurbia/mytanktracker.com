<?php

add_action('wp_enqueue_scripts', 'theme_script_enqueuer');

function theme_script_enqueuer() {

  wp_register_style('screen', get_stylesheet_directory_uri().'/stylesheets/screen.css', '', '', 'screen');
  wp_enqueue_style( 'screen' );


}
add_action('wp_head', 'tt_ajaxurl');
function tt_ajaxurl() {

    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}
	
// $result = add_role(
//     'department',
//     __( 'Department' ),
//     array(
//         'read'         => true,  // true allows this capability
//         'edit_posts'   => true,
//         'delete_posts' => false, // Use false to explicitly deny
//     )
// );
// if ( null !== $result ) {
//     echo 'Yay! New role created!';
// }
// else {
//     echo 'Oh... the department role already exists.';
// }