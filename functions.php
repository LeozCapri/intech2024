<?php

// Include registration functions
require_once get_template_directory() . '/registration-functions.php';

// Include program functions
require_once get_template_directory() . '/program-functions.php';

// Include program-registration-functions functions
require_once get_template_directory() . '/program-registration-functions.php';

// Include add-featured-image-functions.php functions
require_once get_template_directory() . '/add-featured-image-functions.php';

// Redirect users based on their roles after login
function custom_login_redirect($redirect_to, $request, $user) {
    // Check if the user is logged in
    if (isset($user->roles) && is_array($user->roles)) {
        // Redirect users with specific roles to different pages
        if (in_array('student', $user->roles)) {
            // Redirect students to the student dashboard page
            $redirect_to = '/';
        } elseif (in_array('leader', $user->roles)) {
            // Redirect leaders to the leader dashboard page
            $redirect_to = '/';
        } else {
            // Redirect other users to the default WordPress dashboard
            $redirect_to = admin_url();
        }
    }

    return $redirect_to;
}
add_filter('login_redirect', 'custom_login_redirect', 10, 3);

function register_my_menus() {
    register_nav_menus(
        array(
            'primary' => __('Primary Menu'),
            'footer' => __('Footer Menu'),
        )
    );
}
add_action('init', 'register_my_menus');

function custom_login_logo() {
    ?>
    <style type="text/css">
        /* Hide the WordPress logo */
        #login h1 a {
            display: none;
        }
        /* Add your custom logo */
        #login h1 {
            background: url('<?php echo esc_url(wp_get_attachment_image_src( '11', 'full' )[0]); ?>') no-repeat center center;
            background-size: contain;
            width: 300px; /* Adjust the width of your logo as needed */
            height: 100px; /* Adjust the height of your logo as needed */
            margin-bottom: 30px; /* Adjust the margin as needed */
        }
    </style>
    <?php
}
add_action( 'login_head', 'custom_login_logo' );

function custom_lost_password_url( $lostpassword_url, $redirect ) {
    // Change 'login' to whatever slug you want to use for your login page
    $new_lostpassword_url = home_url( '/login?action=lostpassword' );
    return $new_lostpassword_url;
}
add_filter( 'lostpassword_url', 'custom_lost_password_url', 10, 2 );

// Add capabilities for Student Role
$pending_capabilities = array(
    'read'              => true,  // Allow the user to read posts
   
);
add_role( 'pending', 'Pending', $pending_capabilities );


// Add capabilities for Student Role
$student_capabilities = array(
    'read'              => true,  // Allow the user to read posts
    'edit_posts'        => true,  // Allow the user to edit their own posts
    'upload_files'      => true,  // Allow the user to upload files
    // Add more capabilities as needed
);
add_role( 'student', 'Student', $student_capabilities );

// Add capabilities for Lecturer Role
$lecturer_capabilities = array(
    'read'              => true,      // Allow the user to read posts
    'edit_posts'        => true,      // Allow the user to edit their own posts
    'publish_posts'     => true,      // Allow the user to publish posts
    'edit_published_posts' => true,   // Allow the user to edit published posts
    // Add more capabilities as needed
);
add_role( 'lecturer', 'Lecturer', $lecturer_capabilities );

// Add capabilities for Leader Role
$leader_capabilities = array(
    'read'              => true,      // Allow the user to read posts
    'edit_others_posts' => true,      // Allow the user to edit others' posts
    'delete_posts'      => true,      // Allow the user to delete posts
    'manage_categories' => true,      // Allow the user to manage categories
    // Add more capabilities as needed
);
add_role( 'leader', 'Leader', $leader_capabilities );

// Add theme support
function your_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'your_theme_setup' );

// Register navigation menus
function your_theme_register_menus() {
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'your-theme' ),
        'footer'  => __( 'Footer Menu', 'your-theme' ),
    ) );
}
add_action( 'init', 'your_theme_register_menus' );

/**
 * Duplicate a post.
 *
 * @param int $post_id The ID of the post to duplicate.
 * @return int|WP_Error The ID of the duplicated post or WP_Error object on failure.
 */
function duplicate_post($post_id) {
    // Get the post to duplicate.
    $post = get_post($post_id);

    // Check if the post exists.
    if (!$post) {
        return new WP_Error('invalid_post', __('Invalid post ID.', 'text_domain'));
    }

    // Prepare post data for duplication.
    $post_data = array(
        'post_title'   => $post->post_title . ' (Copy)',
        'post_content' => $post->post_content,
        'post_excerpt' => $post->post_excerpt,
        'post_status'  => 'draft', // Set the status of the duplicated post.
        'post_type'    => $post->post_type,
    );

    // Insert the duplicated post.
    $duplicated_post_id = wp_insert_post($post_data);

    // Check if post duplication was successful.
    if (is_wp_error($duplicated_post_id)) {
        return $duplicated_post_id;
    }

    // Duplicate post meta.
    $post_meta = get_post_meta($post_id);
    if (!empty($post_meta)) {
        foreach ($post_meta as $meta_key => $meta_values) {
            foreach ($meta_values as $meta_value) {
                add_post_meta($duplicated_post_id, $meta_key, $meta_value);
            }
        }
    }

    // Duplicate post terms (categories, tags, etc.).
    $post_terms = wp_get_post_terms($post_id, array_keys(get_object_taxonomies($post)));
    if (!empty($post_terms)) {
        $category_ids = array();
        foreach ($post_terms as $term) {
            // Store category IDs for duplicated post.
            $category_ids[] = $term->term_id;
        }
        // Assign categories to duplicated post.
        wp_set_post_categories($duplicated_post_id, $category_ids);
    }

    // Duplicate ACF fields.
    if (function_exists('acf_copy_post')) {
        acf_copy_post($post_id, $duplicated_post_id);
    }

    // Return the ID of the duplicated post.
    return $duplicated_post_id;
}

/**
 * Add Duplicate Post link to the post row actions.
 *
 * @param array $actions An array of row action links.
 * @param WP_Post $post The post object.
 * @return array Modified array of row action links.
 */
function add_duplicate_post_link($actions, $post) {
    // Check if the user has permissions to duplicate posts.
    if (current_user_can('edit_posts')) {
        // Add Duplicate Post link to the row actions.
        $actions['duplicate_post'] = '<a href="' . esc_url(wp_nonce_url(admin_url('admin.php?action=duplicate_post&post=' . $post->ID), 'duplicate-post_' . $post->ID)) . '" title="' . __('Duplicate this item', 'text_domain') . '" rel="permalink">' . __('Duplicate', 'text_domain') . '</a>';
    }

    return $actions;
}
add_filter('post_row_actions', 'add_duplicate_post_link', 10, 2);

/**
 * Duplicate post action.
 */
function duplicate_post_action() {
    // Check if it's a duplicate post action.
    if (isset($_GET['action']) && $_GET['action'] === 'duplicate_post') {
        // Verify nonce.
        $post_id = isset($_GET['post']) ? intval($_GET['post']) : 0;
        $nonce = isset($_GET['_wpnonce']) ? $_GET['_wpnonce'] : '';
        if (!wp_verify_nonce($nonce, 'duplicate-post_' . $post_id)) {
            wp_die(__('Security check failed.', 'text_domain'));
        }

        // Check if the user has permissions to duplicate posts.
        if (!current_user_can('edit_posts')) {
            wp_die(__('You are not allowed to duplicate posts.', 'text_domain'));
        }

        // Duplicate the post.
        $duplicated_post_id = duplicate_post($post_id);

        // Redirect to the duplicated post or show an error message.
        if (!is_wp_error($duplicated_post_id)) {
            wp_safe_redirect(admin_url('post.php?action=edit&post=' . $duplicated_post_id));
            exit;
        } else {
            wp_die($duplicated_post_id->get_error_message(), __('Error', 'text_domain'));
        }
    }
}
add_action('admin_action_duplicate_post', 'duplicate_post_action');
