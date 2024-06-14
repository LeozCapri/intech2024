<?php get_header();

// Fetch the images from the post
$post_id = get_the_ID();
$images = get_attached_media('image', $post_id);
$image_urls = array();
foreach ($images as $image) {
    $image_urls[] = wp_get_attachment_url($image->ID);
}
?>
<div class="main-banner" id="top">
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
                            <div class="item" style="background-image: url('<?php echo esc_url($image_url); ?>');">
                                <div class="header-text">
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
                                    <h2><?php echo get_the_title(); ?></h2>
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
                                        echo '<p><strong>Date and Time:</strong> ' . $formatted_date_time . '</p>';
                                    } else {
                                        echo '<p><strong>Date and Time:</strong> N/A</p>';
                                    }
                                    ?>
                                    <div class="buttons">
                                        <?php
                                        // Check registration and volunteer status
                                        $registration_checked = get_post_meta($post_id, 'registration_checked', true);
                                        $volunteer_checked = get_post_meta($post_id, 'volunteer_checked', true);
                                        $program_slug = get_post_field('post_name', $post_id);

                                        // Display buttons based on status
                                        if ($registration_checked == 'on' && $volunteer_checked == 'on') {
                                            // Both registration and volunteer are open
                                            echo '<div class="main-button">';
                                            echo '<a href="/program-registration?program=' . $program_slug . '">Register Now</a>';
                                            echo '</div>';
                                            echo '<div class="main-button">';
                                            echo '<a href="/volunteer-registration?program=' . $program_slug . '">Volunteer Now</a>';
                                            echo '</div>';
                                        } elseif ($registration_checked == 'on') {
                                            // Only registration is open
                                            echo '<div class="main-button">';
                                            echo '<a href="/program-registration?program=' . $program_slug . '">Register Now</a>';
                                            echo '</div>';
                                        } elseif ($volunteer_checked == 'on') {
                                            // Only volunteer is open
                                            echo '<div class="main-button">';
                                            echo '<a href="/volunteer-registration?program=' . $program_slug . '">Volunteer Now</a>';
                                            echo '</div>';
                                        }
                                        ?>
                                        <div class="main-button">
                                            <a href="#">Registration Manual</a>
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
                            style="background-image: url('<?php echo esc_url($image_url); ?>');">
                            <div class="header-text">
                                <span class="category"><?php echo get_the_category()[0]->name; ?></span>
                                <h2><?php echo get_the_title(); ?></h2>
                                <?php
                                $start_date = date('F j, Y', strtotime($start_datetime));
                                $end_date = date('F j, Y', strtotime($end_datetime));
                                $start_time = date('g:i a', strtotime($start_datetime));
                                $end_time = date('g:i a', strtotime($end_datetime));

                                if ($start_date == $end_date) {
                                    echo '<p><strong>Date:</strong> ' . $start_date . '</p>';
                                } else {
                                    echo '<p><strong>Start Date and Time:</strong> ' . $start_date . ' ' . $start_time . '</p>';
                                    echo '<p><strong>End Date and Time:</strong> ' . $end_date . ' ' . $end_time . '</p>';
                                }
                                ?>
                                <div class="buttons">
                                    <?php
                                    // Check registration and volunteer status
                                    $registration_checked = get_post_meta($post_id, 'registration_checked', true);
                                    $volunteer_checked = get_post_meta($post_id, 'volunteer_checked', true);

                                    // Get program slug
                                    $program_slug = get_post_field('post_name', $post_id);

                                    // Display buttons based on status
                                    if ($registration_checked == 'on' && $volunteer_checked == 'on') {
                                        // Both registration and volunteer are open
                                        echo '<div class="main-button">';
                                        echo '<a href="/program-registration?program=' . $program_slug . '">Register Now</a>';
                                        echo '</div>';
                                        echo '<div class="main-button">';
                                        echo '<a href="/volunteer-registration?program=' . $program_slug . '">Volunteer Now</a>';
                                        echo '</div>';
                                    } elseif ($registration_checked == 'on') {
                                        // Only registration is open
                                        echo '<div class="main-button">';
                                        echo '<a href="/program-registration?program=' . $program_slug . '">Register Now</a>';
                                        echo '</div>';
                                    } elseif ($volunteer_checked == 'on') {
                                        // Only volunteer is open
                                        echo '<div class="main-button">';
                                        echo '<a href="/volunteer-registration?program=' . $program_slug . '">Volunteer Now</a>';
                                        echo '</div>';
                                    }
                                    ?>
                                    <div class="main-button">
                                        <a href="#">Registration Manual</a>
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


<body class="d-flex flex-column h-100">
    <section class="py-5" id="project-detail">
        <div class="container px-5 mb-5">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    $content = apply_filters('the_content', get_the_content());
                    $start_datetime = get_post_meta(get_the_ID(), 'program_start_datetime', true);
                    $end_datetime = get_post_meta(get_the_ID(), 'program_end_datetime', true);

                    // Output program details
                    echo '<div class="row gx-5 justify-content-center">';
                    echo '<div class="col-lg-11 col-xl-9 col-xxl-8">';
                    echo '<div class="card overflow-hidden shadow rounded-4 border-0 mb-5">';
                    echo '<div class="card-body p-0">';
                    echo '<div class="p-5">';
                    // Output program start and end datetime
                    echo '<p><strong>Start Date and Time:</strong> ' . date('F j, Y g:i a', strtotime($start_datetime)) . '</p>';
                    echo '<p><strong>End Date and Time:</strong> ' . date('F j, Y g:i a', strtotime($end_datetime)) . '</p>';
                    echo '</div>';
                    echo '<div class="p-5" style="text-align: justify;">' . $content . '</div>';
                    echo '</div></div></div></div>'; // Closing div tags
                }
            } else {
                echo 'Program not found.';
            }
            ?>
        </div>
    </section>
</body>

<script>
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            items: 1, // Number of items to display
            loop: true, // Loop through items
            nav: true, // Show navigation
            dots: true, // Show dots navigation
            autoplay: true, // Enable autoplay
            autoplayTimeout: 5000, // Autoplay interval in milliseconds
            autoplayHoverPause: true // Pause on hover
        });
    });
</script>



<?php get_footer(); ?>

<style>
    .main-banner .item {
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        border-radius: 25px;
        padding: 50px 50px;
        margin-left: 130px;
    }

    .bi.bi-box-arrow-in-up-right {
        font-size: 20px;
    }

    .bi.bi-box-arrow-in-up-right {
        top: 0;
        right: 0;
        padding: 10px;
        text-align: end;
    }
</style>