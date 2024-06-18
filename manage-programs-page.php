<?php
/*
Template Name: Manage Programs
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
                            <div class="item <?php echo esc_attr($page_class); ?>"
                                style="background-image: url('<?php echo esc_url($image_url); ?>');">
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
                        <div class="item <?php echo esc_attr($page_class); ?>"
                            style="background-image: url('<?php echo esc_url($page_image_url); ?>');">
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
            <!-- <div class="col-lg-12 text-center">
                <div class="section-heading">
                    <h6>Schedule</h6>
                    <h2>Upcoming Events</h2>
                </div>
            </div> -->
            <?php
            $args = array(
                'post_type' => 'program', // Replace with your custom post type
                'posts_per_page' => -1, // Display all programs
            );
            $programs = new WP_Query($args);

            if ($programs->have_posts()) {
                ?>
                <div class="row">
                    <div class="col-lg-12 col-md-10 col-sm-8">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Title</th>
                                        <th class="text-center align-middle">Venue</th>
                                        <th class="text-center align-middle">Program Schedule</th>
                                        <th class="text-center align-middle">Registration Status</th>
                                        <th class="text-center align-middle">Volunteer Status</th>
                                        <th class="text-center align-middle">Publisher</th>
                                        <th class="text-center align-middle">Last Updated</th>
                                        <th class="text-center align-middle">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($programs->have_posts()):
                                        $programs->the_post(); ?>
                                        <tr>
                                            <td class="text-center align-middle"><?php the_title(); ?></td>
                                            <td class="text-center align-middle">
                                                <?php custom_program_columns_data('program_venue', get_the_ID()); ?></td>
                                            <td class="text-center align-middle">
                                                <?php custom_program_columns_data('program_schedule', get_the_ID()); ?></td>
                                            <td class="text-center align-middle">
                                                <?php custom_program_columns_data('registration_status', get_the_ID()); ?></td>
                                            <td class="text-center align-middle">
                                                <?php custom_program_columns_data('volunteer_status', get_the_ID()); ?></td>
                                            <td class="text-center align-middle">
                                                <?php custom_program_columns_data('publisher', get_the_ID()); ?></td>
                                            <td class="text-center align-middle">
                                                <?php custom_program_columns_data('last_updated', get_the_ID()); ?></td>
                                            <td class="text-center align-middle">
                                                <div class="actions">
                                                    <a href="<?php echo get_the_permalink() ?>?action=edit">Edit</a>
                                                    <br>
                                                    <a href="<?php echo get_the_permalink() ?>?action=delete">Delete</a>
                                                    <br>
                                                    <a href="<?php echo get_the_permalink() ?>?action=view-registrations">Registrations</a>
                                                    <br>
                                                    <a href="<?php echo get_the_permalink() ?>?action=view-volunteers">Volunteers</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php
                wp_reset_postdata();
            } else {
                echo 'No programs found.';
            }
            ?>
        </div>
    </div>
</div>

<style>

</style>


<?php

get_footer();