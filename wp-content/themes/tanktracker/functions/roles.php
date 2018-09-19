<?php



    add_action('init', 'custom_roles');
    function custom_roles(){

        add_role(
            'moderator',
            __( 'Moderator' ),
            array(
                'read'         => true,  // true allows this capability
                'edit_posts'   => true,
            )
        );

        add_role(
            'basic',
            __( 'Basic User' ),
            array(
                'read'         => true,  // true allows this capability
                'edit_posts'   => true,
            )
        );

        add_role(
            'donor',
            __( 'Donor User' ),
            array(
                'read'         => true,  // true allows this capability
                'edit_posts'   => true,
            )
        );

    }


// Hijack the option, the role will follow!
add_filter('pre_option_default_role', function($default_role){
    // You can also add conditional tags here and return whatever
    return 'basic'; // This is changed
    return $default_role; // This allows default
});