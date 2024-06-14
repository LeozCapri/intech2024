<?php
// Add meta box for multiple featured images
function add_multiple_featured_images_meta_box() {
    add_meta_box(
        'multiple-featured-images-meta-box',
        'Multiple Featured Images',
        'render_multiple_featured_images_meta_box',
        'page', // Change this to the post type where you want to add multiple featured images
        'normal',
        'default'
    );
    add_meta_box(
        'multiple-featured-images-meta-box',
        'Multiple Featured Images',
        'render_multiple_featured_images_meta_box',
        'program', // Change this to the post type where you want to add multiple featured images
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_multiple_featured_images_meta_box');

// Render meta box for multiple featured images
function render_multiple_featured_images_meta_box($post) {
    // Retrieve current image URLs
    $multiple_featured_images = get_post_meta($post->ID, 'multiple_featured_images', true);

    // Display input fields for each image URL
    ?>
    <div id="multiple-featured-images-container">
        <?php
        if (!empty($multiple_featured_images)) {
            foreach ($multiple_featured_images as $index => $image_url) {
                ?>
                <div class="featured-image-container">
                    <img class="featured-image" src="<?php echo esc_url($image_url); ?>" />
                    <input type="hidden" name="multiple_featured_images[]" value="<?php echo esc_attr($image_url); ?>" />
                    <button type="button" class="button button-secondary remove-featured-image">Remove Image</button>
                </div>
                <?php
            }
        }
        ?>
    </div>
    <p>
        <input type="button" id="add_new_featured_image_button" class="button" value="Add New Image">
    </p>
    <?php
}

// Save multiple featured images
function save_multiple_featured_images($post_id) {
    if (isset($_POST['multiple_featured_images'])) {
        $images = array_map('sanitize_text_field', $_POST['multiple_featured_images']);
        update_post_meta($post_id, 'multiple_featured_images', $images);
    }
}
add_action('save_post', 'save_multiple_featured_images');

// Enqueue scripts and styles for multiple featured images meta box
function enqueue_multiple_featured_images_scripts($hook) {
    global $post;
    if (($hook == 'post-new.php' || $hook == 'post.php') && $post->post_type == 'page') {
        wp_enqueue_media();
        wp_enqueue_script('multiple-featured-images-script', get_template_directory_uri() . '/multiple-featured-images.js', array('jquery'), '1.0', true);
    }
    if (($hook == 'post-new.php' || $hook == 'post.php') && $post->post_type == 'program') {
        wp_enqueue_media();
        wp_enqueue_script('multiple-featured-images-script', get_template_directory_uri() . '/multiple-featured-images.js', array('jquery'), '1.0', true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_multiple_featured_images_scripts');



?>
