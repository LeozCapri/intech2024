<?php
/*
Template Name: Program Registration
*/
get_header();

// Check if the user is not logged in
if (!is_user_logged_in()) {
    // Redirect to the login page
    wp_redirect(wp_login_url());
    exit;
}

// Get the current user
$current_user = wp_get_current_user();

// Extract user data
$username = $current_user->user_login;
$email = $current_user->user_email;
$user_id = $current_user->ID;
$ic_no = get_user_meta($user_id, 'ic_no', true) ?: ''; // Default to empty string if not set
$birth_date = get_user_meta($user_id, 'birth_date', true) ?: ''; // Default to empty string if not set
$faculty = get_user_meta($user_id, 'faculty', true) ?: ''; // Default to empty string if not set
$course = get_user_meta($user_id, 'course', true) ?: ''; // Default to empty string if not set
$first_name = get_user_meta($user_id, 'first_name', true) ?: '';
$last_name = get_user_meta($user_id, 'last_name', true) ?: '';

$program_slug = isset($_GET['program']) ? sanitize_text_field($_GET['program']) : '';
$program_id = '';
$program_name = '';

if (!empty($program_slug)) {
    $program = get_page_by_path($program_slug, OBJECT, 'program'); // 'program' is the custom post type
    if ($program instanceof WP_Post) {
        $program_id = $program->ID;
        $program_name = $program->post_title;

    }
}

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

<div class="contact-us section" id="register">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 align-self-center">
                <div class="section-heading">
                    <h6>Register as participant for the event</h6>
                    <p>Fill out the form below</p>
                    <br>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="contact-us-content">
                    <form id="program-registration-form" method="post">
                        <?php wp_nonce_field('program_registration', 'program_registration_nonce'); ?>
                        <input type="hidden" name="action" value="program_registration">
                        <div class="row">
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Username</a>
                                    <input type="text" name="username" id="username" class="input-field"
                                        placeholder="Please enter your username"
                                        value="<?php echo esc_attr($username); ?>" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>First Name</a>
                                    <input type="text" name="first_name" id="first_name" class="input-field"
                                        placeholder="Please enter your first name"
                                        value="<?php echo esc_attr($first_name); ?>" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Last Name</a>
                                    <input type="text" name="last_name" id="last_name" class="input-field"
                                        placeholder="Please enter your last name"
                                        value="<?php echo esc_attr($last_name); ?>" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Email</a>
                                    <input type="email" name="email" id="email" class="input-field"
                                        placeholder="Please use your organization email address"
                                        value="<?php echo esc_attr($email); ?>" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Identification Card No</a>
                                    <input type="text" name="ic_no" id="ic_no" class="input-field" placeholder="IC No"
                                        value="<?php echo esc_attr($ic_no); ?>" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Mobile Phone Number</a>
                                    <input type="text" name="tel_no" id="tel_no" class="input-field" placeholder="Your Mobile Phone Number that you use" required>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Faculty</a>
                                    <select name="faculty" id="faculty" class="input-field" required>

                                        <option value="">Select Faculty</option>
                                        <option value="FAKULTI PENGURUSAN DAN MUAMALAH">FAKULTI PENGURUSAN DAN MUAMALAH
                                        </option>
                                        <option value="FAKULTI PENGAJIAN PERADABAN ISLAM">FAKULTI PENGAJIAN PERADABAN
                                            ISLAM</option>
                                        <option value="FAKULTI MULTIMEDIA KREATIF DAN KOMPUTERAN">FAKULTI MULTIMEDIA
                                            KREATIF DAN KOMPUTERAN
                                        </option>
                                        <option value="FAKULTI PENDIDIKAN">FAKULTI PENDIDIKAN</option>
                                        <option value="FAKULTI SYARIAH DAN UNDANG-UNDANG">FAKULTI SYARIAH DAN
                                            UNDANG-UNDANG</option>
                                        <option value="FAKULTI SAINS SOSIAL">FAKULTI SAINS SOSIAL</option>
                                        <option value="INSTITUT KAJIAN HADIS & AKIDAH">INSTITUT KAJIAN HADIS & AKIDAH
                                        </option>
                                        <option value="PUSAT MATRIKULASI">PUSAT MATRIKULASI</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
                                    <a>Course (Please select faculty first)</a>
                                    <select name="course" id="course" class="input-field" required>
                                        <option value="">Select Course</option>
                                        <!-- Courses will be populated based on faculty selection -->
                                        <option value="course1" <?php selected($course, 'course1'); ?>>Please choose your faculty first</option>
                                    </select>
                                </fieldset>
                            </div>
                            <input type="hidden" name="program_id" value="<?php echo esc_attr($program_id); ?>">
                            <div class="col-lg-12">
                                <fieldset>
                                    <!-- Replace "YOUR_SITE_KEY" with your reCAPTCHA site key -->
                                    <!-- <div class="g-recaptcha" data-sitekey="6LdAK_QpAAAAABuc9oaYwsfmNj0i-HmvjRDPCB77"></div> -->
                                    <button type="submit" id="program-register-submit"
                                        class="orange-button">Register</button>
                                </fieldset>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .main-banner .item {
        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
        border-radius: 25px;
        padding: 50px 50px;
        margin-left: 130px;
    }

    #registration-form {
        margin-top: 20px;
    }

    #program-registration-form fieldset a {
        color: white;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #program-register-submit {
        background-color: #f26722;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        margin: 0 auto;
        display: block;
    }

    #program-register-submit:hover {
        background-color: #e3550a;
    }
</style>

<?php
get_footer();