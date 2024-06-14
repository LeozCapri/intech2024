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
                    array(
                        'key' => 'program_start_datetime',
                        'value' => date('Y-m-d\TH:i:s'),
                        'compare' => '>',
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