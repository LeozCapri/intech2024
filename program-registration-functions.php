<?php
// // Function to handle program registration
// function handle_program_registration() {
//     if ($_SERVER["REQUEST_METHOD"] === "POST") {
//         // Retrieve and sanitize form data
//         $username = sanitize_text_field($_POST['username']);
//         $first_name = sanitize_text_field($_POST['first_name']);
//         $last_name = sanitize_text_field($_POST['last_name']);
//         $email = sanitize_email($_POST['email']);
//         $ic_no = sanitize_text_field($_POST['ic_no']);
//         $faculty = sanitize_text_field($_POST['faculty']);
//         $course = sanitize_text_field($_POST['course']);
//         $program_id = sanitize_text_field($_POST['program_id']);

//         // Perform additional validation if needed
//         if (empty($username) || empty($first_name) || empty($last_name) || empty($email) || empty($ic_no) || empty($faculty) || empty($course) || empty($program_id)) {
//             // Handle validation errors with SweetAlert
//             echo "<script>Swal.fire({icon: 'error', title: 'Oops...', text: 'All fields are required.'});</script>";
//             exit;
//         }

//         // Check if the user with the same IC and program ID already exists
//         global $wpdb;
//         $table_name = $wpdb->prefix . 'program_registration';
//         $existing_registration = $wpdb->get_row(
//             $wpdb->prepare(
//                 "SELECT * FROM $table_name WHERE ic_no = %s AND program_id = %s",
//                 $ic_no,
//                 $program_id
//             )
//         );

//         // If an existing registration is found, handle it with SweetAlert
//         if ($existing_registration) {
//             echo "<script>Swal.fire({icon: 'error', title: 'Oops...', text: 'You have already registered for this program.'});</script>";
//             exit;
//         }

//         // Insert into database
//         $insert_result = $wpdb->insert(
//             $table_name,
//             array(
//                 'username' => $username,
//                 'first_name' => $first_name,
//                 'last_name' => $last_name,
//                 'email' => $email,
//                 'ic_no' => $ic_no,
//                 'faculty' => $faculty,
//                 'course' => $course,
//                 'program_id' => $program_id
//             )
//         );

//         if ($insert_result === false) {
//             // Handle database insertion error with SweetAlert
//             echo "<script>Swal.fire({icon: 'error', title: 'Oops...', text: 'An error occurred while processing your registration.'});</script>";
//             exit;
//         }

//         // Registration successful
//         echo "<script>Swal.fire({icon: 'success', title: 'Success', text: 'Registration successful!'});</script>";
//         exit;
//     }
// }
// add_action('init', 'handle_program_registration');

add_action('wp_ajax_program_registration', 'program_registration_callback');
add_action('wp_ajax_nopriv_program_registration', 'program_registration_callback');

function program_registration_callback() {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json(array('success' => false, 'message' => 'You must be logged in to register.'));
    }

    // Get the posted data
    $program_id = sanitize_text_field($_POST['program_id']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $ic_no = sanitize_text_field($_POST['ic_no']);
    $email = sanitize_email($_POST['email']);
    $faculty = sanitize_text_field($_POST['faculty']);
    $course = sanitize_text_field($_POST['course']);
    $tel_no = sanitize_text_field($_POST['tel_no']);
    $username = sanitize_text_field($_POST['username']);

    // Validate the data
    if (!$program_id || !$first_name || !$last_name || !$ic_no || !$email || !$faculty || !$course || !$tel_no || !$username) {
        wp_send_json(array('success' => false, 'message' => 'Please fill out all required fields.'));
    }

    // Process the registration
    global $wpdb;
    $table_name = $wpdb->prefix . 'program_registration';

    // Check if the user is already registered based on IC number and program ID
    $existing_registration = $wpdb->get_row("SELECT * FROM $table_name WHERE ic_no = '$ic_no' AND program_id = '$program_id'");

    if ($existing_registration) {
        wp_send_json(array('success' => false, 'message' => 'You have already registered for this program with this IC number.'));
    }

    $wpdb->insert(
        $table_name,
        array(
            'program_id' => $program_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'ic_no' => $ic_no,
            'email' => $email,
            'faculty' => $faculty,
            'course' => $course,
            'tel_no' => $tel_no,
            'updated_by' => $username,
        )
    );

    if ($wpdb->insert_id) {
        wp_send_json(array('success' => true, 'message' => 'Your registration has been submitted successfully.'));
    } else {
        wp_send_json(array('success' => false, 'message' => 'An error occurred while submitting your registration.'));
    }
}

add_action('wp_ajax_volunteer_registration', 'volunteer_registration_callback');
add_action('wp_ajax_nopriv_volunteer_registration', 'volunteer_registration_callback');

function volunteer_registration_callback() {
    // Check if the user is logged in
    if (!is_user_logged_in()) {
        wp_send_json(array('success' => false, 'message' => 'You must be logged in to register.'));
    }
// Extract user data
// $username = $current_user->user_login;
// $email = $current_user->user_email;
// $user_id = $current_user->ID;
// $ic_no = get_user_meta($user_id, 'ic_no', true) ?: ''; // Default to empty string if not set
// $birth_date = get_user_meta($user_id, 'birth_date', true) ?: ''; // Default to empty string if not set
// $faculty = get_user_meta($user_id, 'faculty', true) ?: ''; // Default to empty string if not set
// $course = get_user_meta($user_id, 'course', true) ?: ''; // Default to empty string if not set
// $first_name = get_user_meta($user_id, 'first_name', true) ?: '';
// $last_name = get_user_meta($user_id, 'last_name', true) ?: '';
    // Get the posted data
    $program_id = sanitize_text_field($_POST['program_id']);
    $first_name = sanitize_text_field($_POST['first_name']);
    $last_name = sanitize_text_field($_POST['last_name']);
    $ic_no = sanitize_text_field($_POST['ic_no']);
    $email = sanitize_email($_POST['email']);
    $faculty = sanitize_text_field($_POST['faculty']);
    $course = sanitize_text_field($_POST['course']);
    $tel_no = sanitize_text_field($_POST['tel_no']);
    $username = sanitize_text_field($_POST['username']);

    // Validate the data
    if (!$program_id || !$first_name || !$last_name || !$ic_no || !$email || !$faculty || !$course || !$tel_no || !$username) {
        wp_send_json(array('success' => false, 'message' => 'Please fill out all required fields.'));
    }

    // Process the registration
    global $wpdb;
    $table_name = $wpdb->prefix . 'volunteer_registration';

    // Check if the user is already registered based on IC number and program ID
    $existing_registration = $wpdb->get_row("SELECT * FROM $table_name WHERE ic_no = '$ic_no' AND program_id = '$program_id'");

    if ($existing_registration) {
        wp_send_json(array('success' => false, 'message' => 'You have already registered for this program with this IC number.'));
    }

    $wpdb->insert(
        $table_name,
        array(
            'program_id' => $program_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'ic_no' => $ic_no,
            'email' => $email,
            'faculty' => $faculty,
            'course' => $course,
            'tel_no' => $tel_no,
            'updated_by' => $username,
            
        )
    );

    if ($wpdb->insert_id) {
        wp_send_json(array('success' => true, 'message' => 'Your registration has been submitted successfully.'));
    } else {
        wp_send_json(array('success' => false, 'message' => 'An error occurred while submitting your registration.'));
    }
}