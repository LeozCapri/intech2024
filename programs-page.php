<?php
/*
Template Name: Program
*/
get_header();

?>
<?php
// Get the current page ID
$page_id = get_the_ID();

// Get the featured image URL of the current page
$page_image_url = get_the_post_thumbnail_url($page_id, 'full');

// Define a default image URL to use if the page doesn't have a featured image
$default_image_url = 'URL_TO_DEFAULT_IMAGE_HERE';

// Use the default image URL if the page doesn't have a featured image
if (empty($page_image_url)) {
    $page_image_url = $default_image_url;
}

// Define custom CSS classes based on the current page
$page_specific_classes = array(
    'about' => 'item-1', // Replace 'about' with the slug of the page you want to apply specific styles to
    // Add more pages with their respective CSS classes
);

// Check if the current page has a specific CSS class defined
$page_class = '';
foreach ($page_specific_classes as $slug => $class) {
    if (has_category($slug, $page_id) || is_page($slug)) {
        $page_class = $class;
        break;
    }
}
?>

<style>
    .main-banner .item {
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        border-radius: 25px;
        padding: 50px 50px;
        margin-left: 130px;
    } 
</style>

<div class="main-banner <?php echo esc_attr($page_class); ?>" id="banner-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-carousel owl-banner">
                    <?php
                    // Retrieve current image URLs
                    $multiple_featured_images = get_post_meta(get_the_ID(), 'multiple_featured_images', true);

                    // Loop through each image URL and create a carousel item
                    if (!empty($multiple_featured_images)) {
                        foreach ($multiple_featured_images as $index => $image_url) {
                            ?>
                            <div class="item <?php echo esc_attr($page_class); ?>" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                                <div class="header-text">
                                    <span class="category"><?php echo get_the_title(); ?></span>
                                    <h2><?php echo get_the_title(); ?></h2>
                                    <div class="buttons">
                                        <div class="main-button">
                                            <a href="#">Program Registration Manual</a>
                                        </div>
                                        <div class="icon-button">
                                            <a href="#"><i class="fa fa-play"></i> How can I register for program</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Fallback to using the page's featured image if no multiple featured images are set
                        ?>
                        <div class="item <?php echo esc_attr($page_class); ?>" style="background-image: url('<?php echo esc_url($page_image_url); ?>');">
                            <div class="header-text">
                                <span class="category"><?php echo get_the_title(); ?></span>
                                <h2><?php echo get_the_title(); ?></h2>
                                <div class="buttons">
                                    <div class="main-button">
                                        <a href="#">Request Demo</a>
                                    </div>
                                    <div class="icon-button">
                                        <a href="#"><i class="fa fa-play"></i> How can I register for program</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="section events" id="events">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Schedule</h6>
                    <h2>Upcoming Events</h2>
                </div>
            </div>
            <?php
            // Query upcoming events
            $args = array(
                'post_type' => 'program',
                'meta_query' => array(
                    'relation' => 'OR',
                    array(
                        'key' => 'program_start_datetime',
                        'value' => date('Y-m-d\TH:i:s'),
                        'compare' => '>',
                        'type' => 'DATETIME'
                    ),
                    array(
                        'key' => 'program_start_datetime',
                        'value' => date('Y-m-d\TH:i:s'),
                        'compare' => '<=',
                        'key' => 'program_end_datetime',
                        'value' => date('Y-m-d\TH:i:s'),
                        'compare' => '>=',
                        'type' => 'DATETIME'
                    )
                ),
                'orderby' => 'meta_value',
                'order' => 'ASC',
                'posts_per_page' => 5 // Limit to 5 upcoming events
            );

            $query = new WP_Query($args);

            if ($query->have_posts()):
                while ($query->have_posts()):
                    $query->the_post();
                    ?>
                    <div class="col-lg-12 col-md-6">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="image">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>\assets\images\default-event-image.jpg"
                                                alt="Event Image">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <ul>
                                        <li>
                                            <div class="category-container">
                                                <?php
                                                $categories = get_the_terms(get_the_ID(), 'program_category');
                                                if (!empty($categories)) {
                                                    foreach ($categories as $category) {
                                                        echo '<div class="category-wrapper">';
                                                        echo '<span class="category">';
                                                        echo esc_html($category->name);
                                                        echo '</span>';
                                                        echo '</div>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <h4><?php the_title(); ?></h4>
                                        </li>
                                        <li>
                                            <span>Venue:</span>
                                            <h6><?php echo get_post_meta(get_the_ID(), 'program_venue', true); ?></h6>
                                        </li>
                                        <li>
                                            <span>Date and Time:</span>
                                            <?php
                                            $start_datetime = get_post_meta(get_the_ID(), 'program_start_datetime', true);
                                            $end_datetime = get_post_meta(get_the_ID(), 'program_end_datetime', true);

                                            if ($start_datetime && $end_datetime) {
                                                $start = date_create_from_format('Y-m-d\TH:i', $start_datetime);
                                                $end = date_create_from_format('Y-m-d\TH:i', $end_datetime);

                                                // Check if start and end dates are the same
                                                if ($start->format('Y-m-d') === $end->format('Y-m-d')) {
                                                    $format = 'F j, Y (g:i a)';
                                                    $formatted_date_time = $start->format($format) . ' - ' . $end->format('g:i a');
                                                } else {
                                                    $format = 'F j, Y (g:i a) - ';
                                                    $formatted_date_time = $start->format($format) . $end->format('F j, Y (g:i a)');
                                                }
                                                echo '<h6>' . $formatted_date_time . '</h6>';
                                            } else {
                                                echo '<h6>N/A</h6>';
                                            }
                                            ?>
                                        </li>
                                    </ul>
                                    <a href="<?php the_permalink(); ?>"><i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p>No upcoming events found.</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<div class="section events" id="events">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Schedule</h6>
                    <h2>Past Events</h2>
                </div>
            </div>
            <?php
            // Query past events
            $args = array(
                'post_type' => 'program',
                'meta_query' => array(
                    array(
                        'key' => 'program_start_datetime',
                        'value' => date('Y-m-d\TH:i:s'),
                        'compare' => '<',
                        'type' => 'DATETIME'
                    )
                ),
                'orderby' => 'meta_value',
                'order' => 'DESC', // Show most recent past events first
                'posts_per_page' => 5 // Limit to 5 past events
            );

            $query = new WP_Query($args);

            if ($query->have_posts()):
                while ($query->have_posts()):
                    $query->the_post();
                    ?>
                    <div class="col-lg-12 col-md-6">
                        <div class="item">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="image">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        <?php else: ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>\assets\images\default-event-image.jpg"
                                                alt="Event Image">
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <ul>
                                        <li>
                                            <span class="category"><?php echo get_the_category_list(', '); ?></span>
                                            <h4><?php the_title(); ?></h4>
                                        </li>
                                        <li>
                                            <span>Date and Time:</span>
                                            <?php
                                            $start_datetime = get_post_meta(get_the_ID(), 'program_start_datetime', true);
                                            $end_datetime = get_post_meta(get_the_ID(), 'program_end_datetime', true);

                                            if ($start_datetime && $end_datetime) {
                                                $start = date_create_from_format('Y-m-d\TH:i', $start_datetime);
                                                $end = date_create_from_format('Y-m-d\TH:i', $end_datetime);

                                                // Check if start and end dates are the same
                                                if ($start->format('Y-m-d') === $end->format('Y-m-d')) {
                                                    $format = 'F j, Y (g:i a)';
                                                    $formatted_date_time = $start->format($format) . ' - ' . $end->format('g:i a');
                                                } else {
                                                    $format = 'F j, Y (g:i a) - ';
                                                    $formatted_date_time = $start->format($format) . $end->format('F j, Y (g:i a)');
                                                }
                                                echo '<h6>' . $formatted_date_time . '</h6>';
                                            } else {
                                                echo '<h6>N/A</h6>';
                                            }
                                            ?>
                                        </li>
                                        <li>
                                            <span>Schedule:</span>
                                            <h6><?php echo get_post_meta(get_the_ID(), 'program_end_datetime', true); ?></h6>
                                        </li>
                                    </ul>
                                    <a href="<?php the_permalink(); ?>"><i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else:
                echo '<p style="text-align:center;">No past events found.</p>';
            endif;
            ?>
        </div>
    </div>
</div>


<style>
    #login-form {
        margin-top: 20px;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #login-submit {
        background-color: #f26722;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
    }

    #login-submit:hover {
        background-color: #e3550a;
    }
</style>


<?php

get_footer();