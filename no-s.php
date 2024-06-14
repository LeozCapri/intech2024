<?php get_header(); ?>

<!-- Add your single post content loop here -->

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

                    // Output the title
                    echo '<div class="text-center mb-5"><h1 class="display-5 fw-bolder mb-0"><span class="text-gradient d-inline">' . $title . '</span></h1></div>';

                    // Output the content
                    echo '<div class="row gx-5 justify-content-center">';
                    echo '<div class="col-lg-11 col-xl-9 col-xxl-8">';
                    echo '<div class="card overflow-hidden shadow rounded-4 border-0 mb-5">';
                    echo '<div class="card-body p-0">';
                    echo '<div class="d-flex align-items-center">';
                    echo '<div class="p-5">';
                    echo '<div style="text-align: justify;">' . $content . '</div>';
                    if ($image) {
                        echo '<img class="img-fluid" src="' . $image . '" alt="' . $title . '" />';
                    }
                    echo '</div></div></div></div></div>'; // Closing div tags
                }
            } else {
                echo 'Post not found.';
            }
            ?>
        </div>
    </section>
</body>

<?php get_footer(); ?>