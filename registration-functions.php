<?php

// Custom registration function
function custom_registration_function()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {

        $username = sanitize_text_field($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $ic_no = sanitize_text_field($_POST['ic_no']);
        $birth_date = sanitize_text_field($_POST['birth_date']);
        $faculty = sanitize_text_field($_POST['faculty']);
        $course = sanitize_text_field($_POST['course']);

        // Validation
        $errors = [];

        if (empty($username) || empty($email) || empty($password) || empty($confirm_password) || empty($ic_no) || empty($birth_date) || empty($faculty) || empty($course)) {
            $errors[] = 'All fields are required.';
        }

        if (!is_email($email)) {
            $errors[] = 'Invalid email address.';
        }

        if (email_exists($email)) {
            $errors[] = 'Email already exists.';
        }

        if (username_exists($username)) {
            $errors[] = 'Username already exists.';
        }

        if ($password !== $confirm_password) {
            $errors[] = 'Passwords do not match.';
        }

        if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
            $errors[] = 'Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.';
        }

        if (empty($errors)) {
            // Create the user
            $user_id = wp_create_user($username, $password, $email);
            if (!is_wp_error($user_id)) {
                // Update user meta with additional information
                update_user_meta($user_id, 'ic_no', $ic_no);
                update_user_meta($user_id, 'birth_date', $birth_date);
                update_user_meta($user_id, 'faculty', $faculty);
                update_user_meta($user_id, 'course', $course);

                // Set user role to pending
                $user = new WP_User($user_id);
                $user->set_role('pending');

                // Send email notification with activation link
                $activation_link = add_query_arg(array('user_id' => $user_id), home_url('/activate-account'));
                wp_mail($email, 'User Registration Pending', "Your registration is pending approval. Click the following link to activate your account: $activation_link");

                // Redirect to a success page or display a success message
                wp_redirect(home_url('/'));
                exit;
            } else {
                $errors[] = $user_id->get_error_message();
            }
        }

        // If there are errors, set them to be displayed on the form
        if (!empty($errors)) {
            global $registration_error;
            $registration_error = implode('<br>', $errors);
        }
    }
}
add_action('init', 'custom_registration_function');

// Clear password fields after submission
function clear_password_fields($fields)
{
    if (isset($fields['user_pass'])) {
        $fields['user_pass'] = '';
    }
    if (isset($fields['confirm_password'])) {
        $fields['confirm_password'] = '';
    }
    return $fields;
}
add_filter('wp_redirect', 'clear_password_fields');

// Approve user upon admin action
function approve_user($user_id, $role)
{
    $user = new WP_User($user_id);
    if ($user->has_cap('pending')) {
        $user->remove_role('pending');
        $user->set_role($role); // Set the selected role

        // Send email notification
        $email = $user->user_email;
        $username = $user->user_login;
        wp_mail($email, 'Account Activated', "Your account has been activated.\nUsername: $username");

        // Update user status
        update_user_meta($user_id, 'status', 'Active');
    }
}

// Add a menu item in the WordPress admin menu
function add_pending_users_page()
{
    add_users_page(
        'Pending Users',
        'Pending Users',
        'manage_options',
        'pending-users',
        'pending_users_page'
    );
}
add_action('admin_menu', 'add_pending_users_page');

function pending_users_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Pending Users</h1>
        <table class="widefat">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $pending_users = get_users(array('role' => 'pending'));
                foreach ($pending_users as $user) {
                    ?>
                    <tr>
                        <td><?php echo $user->user_login; ?></td>
                        <td><?php echo $user->user_email; ?></td>
                        <td>
                            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                                <input type="hidden" name="action" value="approve_user">
                                <input type="hidden" name="user_id" value="<?php echo $user->ID; ?>">
                                <select name="role">
                                    <option value="lecturer">Lecturer</option>
                                    <option value="student">Student</option>
                                    <option value="leader">Leader</option>
                                </select>
                        </td>
                        <td>
                            <input type="submit" name="approve_user" class="button-primary" value="Approve">
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

function process_approve_user()
{
    if (isset($_POST['approve_user'])) {
        $user_id = intval($_POST['user_id']);
        $role = sanitize_text_field($_POST['role']); // Get the selected role
        approve_user($user_id, $role);
        // Redirect back to pending users page
        wp_redirect(admin_url('admin.php?page=pending-users'));
        exit;
    }
}
add_action('admin_post_approve_user', 'process_approve_user');

// Save additional user profile fields
function save_custom_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    update_user_meta($user_id, 'ic_no', sanitize_text_field($_POST['ic_no']));
    update_user_meta($user_id, 'birth_date', sanitize_text_field($_POST['birth_date']));
    update_user_meta($user_id, 'faculty', sanitize_text_field($_POST['faculty']));
    update_user_meta($user_id, 'course', sanitize_text_field($_POST['course']));
}
add_action('personal_options_update', 'save_custom_user_profile_fields');
add_action('edit_user_profile_update', 'save_custom_user_profile_fields');

// Add custom columns to user table
function custom_user_table_columns($columns)
{
    $columns['ic_no'] = 'IC No';
    $columns['birth_date'] = 'Birth Date';
    $columns['faculty'] = 'Faculty';
    $columns['course'] = 'Course';
    $columns['status'] = 'Status'; // Add status column

    return $columns;
}
add_filter('manage_users_columns', 'custom_user_table_columns');

// Display custom user data in the user table
function custom_user_table_columns_data($value, $column_name, $user_id)
{
    switch ($column_name) {
        case 'ic_no':
            return get_user_meta($user_id, 'ic_no', true);
        case 'birth_date':
            return get_user_meta($user_id, 'birth_date', true);
        case 'faculty':
            return get_user_meta($user_id, 'faculty', true);
        case 'course':
            return get_user_meta($user_id, 'course', true);
        case 'status':
            $user = new WP_User($user_id);
            if ($user->has_cap('pending')) {
                return 'Pending';
            } else {
                return 'Active';
            }
        default:
            return $value;
    }
}
add_filter('manage_users_custom_column', 'custom_user_table_columns_data', 10, 3);

// Step 3: Add custom fields to the user profile page
function add_custom_user_profile_fields($user)
{
    $ic_no = get_user_meta($user->ID, 'ic_no', true);
    $birth_date = get_user_meta($user->ID, 'birth_date', true);
    $faculty = get_user_meta($user->ID, 'faculty', true);
    $course = get_user_meta($user->ID, 'course', true);

    ?>
    <h3>Additional Information</h3>
    <table class="form-table">
        <tr>
            <th><label for="ic_no">IC No</label></th>
            <td><input type="text" name="ic_no" id="ic_no" value="<?php echo esc_attr($ic_no); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th><label for="birth_date">Birth Date</label></th>
            <td><input type="date" name="birth_date" id="birth_date" value="<?php echo esc_attr($birth_date); ?>"
                    class="regular-text" /></td>
        </tr>
        <tr>
            <th><label for="faculty">Faculty</label></th>
            <td>
                <select name="faculty" id="faculty" class="regular-text">
                    <option value="">Select Faculty</option>
                    <option value="FAKULTI PENGURUSAN DAN MUAMALAH">FAKULTI PENGURUSAN DAN MUAMALAH</option>
                    <option value="FAKULTI PENGAJIAN PERADABAN ISLAM">FAKULTI PENGAJIAN PERADABAN ISLAM</option>
                    <option value="FAKULTI MULTIMEDIA KREATIF DAN KOMPUTERAN">FAKULTI MULTIMEDIA KREATIF DAN KOMPUTERAN
                    </option>
                    <option value="FAKULTI PENDIDIKAN">FAKULTI PENDIDIKAN</option>
                    <option value="FAKULTI SYARIAH DAN UNDANG-UNDANG">FAKULTI SYARIAH DAN UNDANG-UNDANG</option>
                    <option value="FAKULTI SAINS SOSIAL">FAKULTI SAINS SOSIAL</option>
                    <option value="INSTITUT KAJIAN HADIS & AKIDAH">INSTITUT KAJIAN HADIS & AKIDAH</option>
                    <option value="PUSAT MATRIKULASI">PUSAT MATRIKULASI</option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="course">Course</label></th>
            <td>
                <select name="course" id="course" class="regular-text">
                    <option value="">Select Course</option>
                    <optgroup label="FAKULTI PENGURUSAN DAN MUAMALAH">
                        <option value="PB01 Pengurusan">PB01 Pengurusan</option>
                        <option value="PB02 Perakaunan">PB02 Perakaunan</option>
                        <option value="MG01 Pentadbiran Perniagaan (Muamalah)">MG01 Pentadbiran Perniagaan (Muamalah)
                        </option>
                        <option value="MT10 Pengurusan Sumber Manusia">MT10 Pengurusan Sumber Manusia</option>
                        <option value="MT11 Ekonomi">MT11 Ekonomi</option>
                        <option value="MT12 Kewangan Islam">MT12 Kewangan Islam</option>
                        <option value="MT13 Perakaunan">MT13 Perakaunan</option>
                        <option value="BB01 Pentadbiran Perniagaan dengan E-Dagang (Kepujian)">BB01 Pentadbiran Perniagaan
                            dengan E-Dagang (Kepujian)</option>
                        <option value="BB02 Pengurusan Sumber Insan (Kepujian)">BB02 Pengurusan Sumber Insan (Kepujian)
                        </option>
                        <option value="BB03 Ekonomi dan Kewangan (Kepujian)">BB03 Ekonomi dan Kewangan (Kepujian)</option>
                        <option value="BB04 Perakaunan (Kepujian)">BB04 Perakaunan (Kepujian)</option>
                        <option value="BB05 Kewangan Islam (Perbankan) (Kepujian)">BB05 Kewangan Islam (Perbankan)
                            (Kepujian)</option>
                        <option value="BB08 Pengurusan (Industri Halal) (Kepujian)">BB08 Pengurusan (Industri Halal)
                            (Kepujian)</option>
                        <option value="MS31 Perakaunan">MS31 Perakaunan</option>
                        <option value="MS32 Pengurusan Perniagaan">MS32 Pengurusan Perniagaan</option>
                        <option value="MS33 Perbankan Islam">MS33 Perbankan Islam</option>
                        <option value="MS34 Pengurusan Sumber Manusia">MS34 Pengurusan Sumber Manusia</option>
                        <option value="EB01 Pengurusan Masjid">EB01 Pengurusan Masjid</option>
                    </optgroup>
                    <optgroup label="FAKULTI PENGAJIAN PERADABAN ISLAM">
                        <option value="PI01 Islamiyyat">PI01 Islamiyyat</option>
                        <option value="PI02 Pengajian Bahasa Arab">PI02 Pengajian Bahasa Arab</option>
                        <option value="MT05 Usuluddin (Perbandingan Agama)">MT05 Usuluddin (Perbandingan Agama)</option>
                        <option value="MT06 Pengajian Al-Hadis">MT06 Pengajian Al-Hadis</option>
                        <option value="MT07 Pengajian Al-Quran">MT07 Pengajian Al-Quran</option>
                        <option value="MT08 Pengajian Ilmu Qiraat">MT08 Pengajian Ilmu Qiraat</option>
                        <option value="MT09 Dakwah dan Pembangunan Komuniti">MT09 Dakwah dan Pembangunan Komuniti</option>
                        <option value="MT22 Bahasa Arab untuk Tujuan Khusus">MT22 Bahasa Arab untuk Tujuan Khusus</option>
                        <option value="BI02 Al-Quran dan Al-Sunnah dengan Komunikasi (Kepujian)">BI02 Al-Quran dan Al-Sunnah
                            dengan Komunikasi (Kepujian)</option>
                        <option value="BI03 Usuluddin dengan Multimedia (Kepujian)">BI03 Usuluddin dengan Multimedia
                            (Kepujian)</option>
                        <option value="BI04 Al-Quran dan Al-Qiraat (Kepujian)">BI04 Al-Quran dan Al-Qiraat (Kepujian)
                        </option>
                        <option value="BI05 Dakwah dengan Pengurusan Sumber Insan (Kepujian)">BI05 Dakwah dengan Pengurusan
                            Sumber Insan (Kepujian)</option>
                        <option value="BI06 Pengajian Islam (Bahasa Arab dengan Multimedia) (Kepujian)">BI06 Pengajian Islam
                            (Bahasa Arab dengan Multimedia) (Kepujian)</option>
                        <option value="BC01 Pengajian Bahasa Al-Quran (Kepujian)">BC01 Pengajian Bahasa Al-Quran (Kepujian)
                        </option>
                        <option value="BC03 Pengajian Islam (Bahasa Arab Terjemahan) (Kepujian)">BC03 Pengajian Islam
                            (Bahasa Arab Terjemahan) (Kepujian)</option>
                        <option value="IS11 Pengajian Bahasa Al-Quran">IS11 Pengajian Bahasa Al-Quran</option>
                        <option value="IS13 Akidah dan Pemikiran Islam">IS13 Akidah dan Pemikiran Islam</option>
                        <option value="IS14 Al-Quran dan Al-Sunnah">IS14 Al-Quran dan Al-Sunnah</option>
                        <option value="IS15 Dakwah">IS15 Dakwah</option>
                        <option value="IS16 Tahfiz Al-Quran dan Al-Qiraat">IS16 Tahfiz Al-Quran dan Al-Qiraat</option>
                        <option value="FA01 Asasi Pengajian Islam">FA01 Asasi Pengajian Islam</option>
                    </optgroup>
                    <optgroup label="FAKULTI MULTIMEDIA KREATIF DAN KOMPUTERAN">
                        <option value="PT02 Teknologi Maklumat">PT02 Teknologi Maklumat</option>
                        <option value="MC03 Teknologi Maklumat">MC03 Teknologi Maklumat</option>
                        <option value="MT20 Sains (Multimedia Kreatif)">MT20 Sains (Multimedia Kreatif)</option>
                        <option value="MT23 Sains Teknologi Maklumat">MT23 Sains Teknologi Maklumat</option>
                        <option value="BT01 Multimedia Kreatif (Media Interaktif) (Kepujian)">BT01 Multimedia Kreatif (Media
                            Interaktif) (Kepujian)</option>
                        <option value="BT02 Teknologi Maklumat (Teknologi Rangkaian) (Kepujian)">BT02 Teknologi Maklumat
                            (Teknologi Rangkaian)(Kepujian)</option>
                        <option value="BT04 Multimedia Kreatif (Rekabentuk Digital) (kepujian)">BT04 Multimedia Kreatif
                            (Rekabentuk Digital) (kepujian)</option>
                        <option value="BT05 Sistem Maklumat (Kepujian)">BT05 Sistem Maklumat (Kepujian)</option>
                        <option value="MS36 Multimedia">MS36 Multimedia</option>
                        <option value="MS39 Sains Komputer">MS39 Sains Komputer</option>
                        <option value="FA03 Pengajian Asas Teknologi Maklumat">FA03 Pengajian Asas Teknologi Maklumat
                        </option>
                    </optgroup>
                    <optgroup label="FAKULTI PENDIDIKAN">
                        <option value="PE01 Pendidikan">PE01 Pendidikan</option>
                        <option value="MT15 Pendidikan (Pendidikan Islam)">MT15 Pendidikan (Pendidikan Islam)</option>
                        <option value="MT16 Pendidikan (Pendidikan Bahasa)">MT16 Pendidikan (Pendidikan Bahasa)</option>
                        <option value="MT17 Pendidikan (Kurikulum & Pedagogi)">MT17 Pendidikan (Kurikulum & Pedagogi)
                        </option>
                        <option value="MT18 Pendidikan (Pentadbiran Pendidikan)">MT18 Pendidikan (Pentadbiran Pendidikan)
                        </option>
                        <option value="MT19 Pendidikan (Teknologi Pendidikan)">MT19 Pendidikan (Teknologi Pendidikan)
                        </option>
                        <option
                            value="BE01 Perguruan (Kepujian) Pengajaran Bahasa Inggeris sebagai Bahasa Kedua (TESL) dengan Multimedia">
                            BE01 Perguruan (Kepujian) Pengajaran Bahasa Inggeris sebagai Bahasa Kedua (TESL) dengan
                            Multimedia</option>
                        <option value="BE02 Pendidikan Islam dengan Multimedia (Kepujian)">BE02 Pendidikan Islam dengan
                            Multimedia (Kepujian)</option>
                        <option value="BE03 Pendidikan dengan Kepujian (Pendidikan Tahfiz Al-Quran & Al-Qiraat)">BE03
                            Pendidikan dengan Kepujian (Pendidikan Tahfiz Al-Quran & Al-Qiraat)</option>
                        <option value="ES52 Perguruan (TESL)">ES52 Perguruan (TESL)</option>
                        <option value="ES53 Perguruan (Pendidikan Islam)">ES53 Perguruan (Pendidikan Islam)</option>
                    </optgroup>
                    <optgroup label="FAKULTI SYARIAH DAN UNDANG-UNDANG">
                        <option value="MG02 Syariah (Pengurusan)">MG02 Syariah (Pengurusan)</option>
                        <option value="MT21 Undang-undang Syariah">MT21 Undang-undang Syariah</option>
                        <option value="BS03 Syariah dan Undang-undang (Kepujian)">BS03 Syariah dan Undang-undang (Kepujian)
                        </option>
                        <option value="BS02 Syariah dengan Muamalat (Kepujian)">BS02 Syariah dengan Muamalat (Kepujian)
                        </option>
                        <option value="IS12 Pengajian Syariah">IS12 Pengajian Syariah</option>
                        <option value="IS18 Syariah dan Perundangan Islam">IS18 Syariah dan Perundangan Islam</option>
                        <option value="ES01 Pengurusan Zakat">ES01 Pengurusan Zakat</option>
                    </optgroup>
                    <optgroup label="FAKULTI SAINS SOSIAL">
                        <option value="MT14 Komunikasi">MT14 Komunikasi</option>
                        <option value="BC02 Komunikasi (Penyiaran) (Kepujian)">BC02 Komunikasi (Penyiaran) (Kepujian)
                        </option>
                        <option value="BB09 Bahasa Inggeris (Kepujian) dengan Komunikasi Korporat">BB09 Bahasa Inggeris
                            (Kepujian) dengan Komunikasi Korporat</option>
                        <option value="CS41 Komunikasi">CS41 Komunikasi</option>
                        <option value="LS43 Pengajian Bahasa Inggeris">LS43 Pengajian Bahasa Inggeris</option>
                        <option value="FA05 Asasi Komunikasi">FA05 Asasi Komunikasi</option>
                        <option value="FA06 Asasi Bahasa Inggeris">FA06 Asasi Bahasa Inggeris</option>
                    </optgroup>
                    <optgroup label="INSTITUT KAJIAN HADIS & AKIDAH">
                        <option value="MT04 Usuluddin dan Pemikiran Islam">MT04 Usuluddin dan Pemikiran Islam</option>
                    </optgroup>
                    <optgroup label="PUSAT MATRIKULASI">
                        <option value="FA01 Asasi Pengajian Islam">FA01 Asasi Pengajian Islam</option>
                        <option value="FA02 Asasi Pengurusan">FA02 Asasi Pengurusan</option>
                        <option value="FA03 Pengajian Asas Teknologi Maklumat">FA03 Pengajian Asas Teknologi Maklumat
                        </option>
                        <option value="FA04 Asasi Bahasa Arab">FA04 Asasi Bahasa Arab</option>
                        <option value="FA05 Asasi Komunikasi">FA05 Asasi Komunikasi</option>
                        <option value="FA06 Asasi Bahasa Inggeris">FA06 Asasi Bahasa Inggeris</option>
                    </optgroup>
                </select>


            </td>
        </tr>
    </table>
    <?php
}
add_action('show_user_profile', 'add_custom_user_profile_fields');
add_action('edit_user_profile', 'add_custom_user_profile_fields');

// Step 4: Update the custom user profile fields
function update_custom_user_profile_fields($user_id)
{
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    if (isset($_POST['ic_no'])) {
        update_user_meta($user_id, 'ic_no', sanitize_text_field($_POST['ic_no']));
    }
    if (isset($_POST['birth_date'])) {
        update_user_meta($user_id, 'birth_date', sanitize_text_field($_POST['birth_date']));
    }
    if (isset($_POST['faculty'])) {
        update_user_meta($user_id, 'faculty', sanitize_text_field($_POST['faculty']));
    }
    if (isset($_POST['course'])) {
        update_user_meta($user_id, 'course', sanitize_text_field($_POST['course']));
    }
}
add_action('personal_options_update', 'update_custom_user_profile_fields');
add_action('edit_user_profile_update', 'update_custom_user_profile_fields');

?>