<?php get_header();?>

<div class="main-banner" id="top">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="owl-carousel owl-banner">
                    <?php
                    // Retrieve the post's attached images
                    $post_id = get_the_ID();
                    $images = get_attached_media('image', $post_id);

                    // Check if there are more than one image
                    $has_multiple_images = count($images) > 1;

                    // Loop through each image and display it within the carousel
                    foreach ($images as $index => $image) {
                        $image_url = wp_get_attachment_image_url($image->ID, 'full'); // Get full-size image URL
                        $item_style = 'style="background-image: url(' . esc_url($image_url) . ');"';


                        // Get the post title
                        $post_title = get_the_title();

                        // Check if registration and volunteer options are open
                        $registration_open = get_post_meta($post_id, 'registration_open', true);
                        $volunteer_open = get_post_meta($post_id, 'volunteer_open', true);

                        ?>
                        <div class="item" <?php if ($has_multiple_images)
                            echo $item_style; ?>> 
                            <div class="header-text">
                                <span class="category"><?php echo esc_html($post_title); ?></span>
                                <?php /* Keep the part we don't use intact */ ?>
                                <h2><?php echo esc_html($post_title); ?></h2>
                                <p>Scholar is free CSS template designed by TemplateMo for online educational related
                                    websites. This layout is based on the famous Bootstrap v5.3.0 framework.</p>
                                <div class="buttons">
                                    <?php if ($registration_open): ?>
                                        <div class="main-button">
                                            <a href="/registration">Register Now</a>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($volunteer_open): ?>
                                        <div class="main-button">
                                            <a href="/volunteer">Volunteer Now</a>
                                        </div>
                                    <?php endif; ?>
                                    <div class="icon-button">
                                        <a href="#"><i class="fa fa-play"></i> What's Scholar?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
                    $title = get_the_title();
                    $content = apply_filters('the_content', get_the_content());
                    $image = get_the_post_thumbnail_url();
                    $start_datetime = get_post_meta(get_the_ID(), 'program_start_datetime', true);
                    $end_datetime = get_post_meta(get_the_ID(), 'program_end_datetime', true);

                    // Output the title
                    echo '<div class="text-center mb-5"><h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">' . $title . '</span></h1></div>';

                    // Output the image
                    if ($image) {
                        echo '<div class="text-center mb-5"><img class="img-fluid" src="' . $image . '" alt="' . $title . '" /></div>';
                    }

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