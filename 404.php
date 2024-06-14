<?php
/*
Template Name: 404
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

?>
<div class="main-banner" id="top">
    <div class="container">
        <div class="row">
            <!-- <div class="col-lg-12">
                <div class="owl-carousel owl-banner">
                    <div class="item item-1"> -->

            <div class="header-text">
                <div class="white-text">
                    <span class="category" style="color:white;">Salam Alaikum</span>
                    <h2 style="color:white;">Already have an account?</h2>
                    <p style="color:white;">If you already have an account, please login below.</p>
                </div>
                <div class="buttons">
                    <br>
                    <div class="main-button">
                        <a href="/login">Login</a>
                    </div>
                    <br>
                    <div class="icon-button">
                        <a href="#"><i class="fa fa-play"></i>Why you should Sign Up</a>
                    </div>
                </div>
            </div>
            <!-- </div>
                </div>
            </div> -->
        </div>
    </div>
</div>

<div class="contact-us section" id="register">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 align-self-center">
                <div class="section-heading">
                    <h6>Register</h6>
                    <h2>Join Our Community</h2>
                    <h3>"Suara Mahasiswa Pemangkin Universiti"</h3>
                    <p>Fill out the form below to create an account and become a part of our university community.</p>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="contact-us-content">
                    <form id="program-registration-form" action="" method="post"
                        onsubmit="return program_validateForm()">
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
                                    <a>Faculty</a>
                                    <select name="faculty" id="faculty" class="input-field" required>
                                        <option value="">Select Faculty</option>
                                        <option value="FAKULTI PENGURUSAN DAN MUAMALAH">FAKULTI PENGURUSAN DAN MUAMALAH
                                        </option>
                                        <option value="FAKULTI PENGAJIAN PERADABAN ISLAM">FAKULTI PENGAJIAN PERADABAN
                                            ISLAM</option>
                                        <option value="FAKULTI MULTIMEDIA KREATIF DAN KOMPUTERAN">FAKULTI MULTIMEDIA
                                            KREATIF DAN KOMPUTERAN</option>
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
                                        <option value="course1" <?php selected($course, 'course1'); ?>>Course 1</option>
                                        <option value="course2" <?php selected($course, 'course2'); ?>>Course 2</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-lg-12">
                                <fieldset>
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
    #registration-form {
        margin-top: 20px;
    }

    #registration-form fieldset a {
        color: white;
    }

    .input-field {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #volunteer-register-submit {
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



    #volunteer-register-submit:hover {
        background-color: #e3550a;
    }
</style>


<?php

get_footer();