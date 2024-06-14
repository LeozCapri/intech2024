<?php
// Register Custom Post Type for Program
function register_program_post_type()
{
    $labels = array(
        'name' => 'Programs',
        'singular_name' => 'Program',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Program',
        'edit_item' => 'Edit Program',
        'new_item' => 'New Program',
        'view_item' => 'View Program',
        'search_items' => 'Search Programs',
        'not_found' => 'No programs found',
        'not_found_in_trash' => 'No programs found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Programs'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'program'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-calendar-alt',
        'show_in_rest' => true,
        'rest_base' => 'programs',
        'rest_controller_class' => 'WP_REST_Posts_Controller',
        'register_meta_box_cb' => 'add_program_meta_box'
    );

    register_post_type('program', $args);

    // Register Custom Taxonomy for Program Categories
    $program_category_labels = array(
        'name' => 'Program Categories',
        'singular_name' => 'Program Category',
        'search_items' => 'Search Program Categories',
        'all_items' => 'All Program Categories',
        'edit_item' => 'Edit Program Category',
        'update_item' => 'Update Program Category',
        'add_new_item' => 'Add New Program Category',
        'new_item_name' => 'New Program Category Name',
        'menu_name' => 'Program Categories',
        'view_item' => 'View Program Category',
        'popular_items' => 'Popular Program Categories',
        'separate_items_with_commas' => 'Separate program categories with commas',
        'add_or_remove_items' => 'Add or remove program categories',
        'choose_from_most_used' => 'Choose from the most used program categories',
        'not_found' => 'No program categories found'
    );

    $program_category_args = array(
        'labels' => $program_category_labels,
        'public' => true,
        'hierarchical' => true, // Change to false if you want non-hierarchical (like tags)
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'rewrite' => array('slug' => 'program-category'), // Customize slug as needed
    );

    register_taxonomy('program_category', 'program', $program_category_args);
}
add_action('init', 'register_program_post_type');

// Register rewrite rule for Program post type
function register_program_rewrite_rule() {
    add_rewrite_rule( 'programs/([^/]+)/?', 'index.php?post_type=program&name=$matches[1]', 'top' );
}
add_action( 'init', 'register_program_rewrite_rule' );

// Register template file for single Program post
function register_single_program_template() {
    add_filter( 'single_template', 'single_program_template' );
}
add_action( 'init', 'register_single_program_template' );

function single_program_template( $template ) {
    if ( is_singular( 'program' ) ) {
        $template = locate_template( 'single-program.php' );
    }
    return $template;
}

// Custom post statuses
function custom_program_post_statuses($post_statuses)
{
    $post_statuses['pending'] = array(
        'label' => _x('Pending', 'program'),
        'public' => false,
        'exclude_from_search' => true,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Pending <span class="count">(%s)</span>', 'Pending <span class="count">(%s)</span>'),
    );

    $post_statuses['draft'] = array(
        'label' => _x('Draft', 'program'),
        'public' => false,
        'exclude_from_search' => true,
        'show_in_admin_all_list' => true,
        'show_in_admin_status_list' => true,
        'label_count' => _n_noop('Draft <span class="count">(%s)</span>', 'Draft <span class="count">(%s)</span>'),
    );

    return $post_statuses;
}
add_filter('post_stati', 'custom_program_post_statuses');

// Add Custom Meta Box for Program Category
function add_program_meta_box()
{
    $post_types = array('program'); // Specify the post type(s) where the meta box should appear
    foreach ($post_types as $post_type) {
        add_meta_box(
            'program_meta_box',
            'Program Details',
            'program_meta_box_callback',
            $post_type,
            'normal',
            'default'
        );
    }
}
add_action('add_meta_boxes', 'add_program_meta_box');

// Meta Box Callback function
function program_meta_box_callback($post)
{
    wp_nonce_field('program_meta_box', 'program_meta_box_nonce');

    $program_venue = get_post_meta($post->ID, 'program_venue', true);
    $program_start_datetime = get_post_meta($post->ID, 'program_start_datetime', true);
    $program_end_datetime = get_post_meta($post->ID, 'program_end_datetime', true);
    $registration_checked = get_post_meta($post->ID, 'registration_checked', true);
    $volunteer_checked = get_post_meta($post->ID, 'volunteer_checked', true);
    $program_categories = get_post_meta($post->ID, 'program_categories', true); // Get selected program categories

    // Get all program categories
    $categories = get_terms(
        array(
            'taxonomy' => 'program_category',
            'hide_empty' => false,
        )
    );

    foreach ($categories as $category) {
        echo $category->name . '<br>'; // Prints the category name
    }
    ?>
    <label for="program_venue">Venue:</label>
    <input type="text" id="program_venue" name="program_venue" value="<?php echo esc_attr($program_venue); ?>"><br>

    <label for="program_start_datetime">Start Date and Time:</label>
    <input type="datetime-local" id="program_start_datetime" name="program_start_datetime"
        value="<?php echo esc_attr($program_start_datetime); ?>"><br>

    <label for="program_end_datetime">End Date and Time:</label>
    <input type="datetime-local" id="program_end_datetime" name="program_end_datetime"
        value="<?php echo esc_attr($program_end_datetime); ?>"><br>

    <label for="registration_checked">Registration:</label>
    <input type="checkbox" id="registration_checked" name="registration_checked" <?php checked($registration_checked, 'on'); ?>><br>

    <label for="volunteer_checked">Volunteer:</label>
    <input type="checkbox" id="volunteer_checked" name="volunteer_checked" <?php checked($volunteer_checked, 'on'); ?>><br>
    <?php
}

// Save Custom Meta Box Data
function save_program_meta_box_data($post_id)
{
    if (!isset($_POST['program_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['program_meta_box_nonce'], 'program_meta_box')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['program_venue'])) {
        update_post_meta($post_id, 'program_venue', sanitize_text_field($_POST['program_venue']));
    } else {
        delete_post_meta($post_id, 'program_venue');
    }

    if (isset($_POST['program_start_datetime'])) {
        update_post_meta($post_id, 'program_start_datetime', sanitize_text_field($_POST['program_start_datetime']));
    } else {
        delete_post_meta($post_id, 'program_start_datetime');
    }

    if (isset($_POST['program_end_datetime'])) {
        update_post_meta($post_id, 'program_end_datetime', sanitize_text_field($_POST['program_end_datetime']));
    } else {
        delete_post_meta($post_id, 'program_end_datetime');
    }

    $registration_checked = isset($_POST['registration_checked']) ? 'on' : 'off';
    update_post_meta($post_id, 'registration_checked', $registration_checked);

    $volunteer_checked = isset($_POST['volunteer_checked']) ? 'on' : 'off';
    update_post_meta($post_id, 'volunteer_checked', $volunteer_checked);

}
add_action('save_post', 'save_program_meta_box_data');


// Add custom columns to program post type
function custom_program_columns($columns)
{
    $columns = array(
        'cb' => '<input type="checkbox" />',
        'title' => 'Title',
        'program_venue' => 'Venue',
        'program_schedule' => 'Program Schedule',
        'registration_status' => 'Registration Status',
        'volunteer_status' => 'Volunteer Status',
        'publisher' => 'Publisher',
        'last_updated' => 'Last Updated',
        'registrations' => 'View Registrations', // Add this line
        'volunteers' => 'View Volunteers', // Add this line

    );
    return $columns;
}
add_filter('manage_program_posts_columns', 'custom_program_columns');

// Populate custom columns with data
function custom_program_columns_data($column, $post_id)
{
    switch ($column) {
        case 'program_venue':
            $venue = get_post_meta($post_id, 'program_venue', true);
            echo $venue ? esc_html($venue) : 'N/A';
            break;
        case 'program_schedule':
            $start_datetime = get_post_meta($post_id, 'program_start_datetime', true);
            $end_datetime = get_post_meta($post_id, 'program_end_datetime', true);
            if ($start_datetime && $end_datetime) {
                $start = date_create_from_format('Y-m-d\TH:i', $start_datetime);
                $end = date_create_from_format('Y-m-d\TH:i', $end_datetime);
                $format = ($start->format('Y-m-d') === $end->format('Y-m-d')) ? 'F j, Y (g:i a)' : 'F j, Y (g:i a - ';
                echo $start->format($format) . $end->format('g:i a)');
            } else {
                echo 'N/A';
            }
            break;
        case 'registration_status':
            $registration_checked = get_post_meta($post_id, 'registration_checked', true);
            echo $registration_checked == 'on' ? 'Open' : 'Closed';
            break;
        case 'volunteer_status':
            $volunteer_checked = get_post_meta($post_id, 'volunteer_checked', true);
            echo $volunteer_checked == 'on' ? 'Open' : 'Closed';
            break;
        case 'publisher':
            $publisher_id = get_post_field('post_author', $post_id);
            $publisher_name = get_the_author_meta('display_name', $publisher_id);
            echo esc_html($publisher_name);
            break;
        case 'last_updated':
            $last_updated = get_post_modified_time('F j, Y g:i a', false, $post_id);
            echo esc_html($last_updated);
            break;
        case 'registrations':
            global $wpdb;
            $query = $wpdb->prepare("SELECT COUNT(*) FROM program_registration WHERE program_id = %d", $post_id);
            $count = $wpdb->get_var($query);
            ?>
            <a href="<?php echo admin_url("admin.php?page=view-registrations&program_id=$post_id"); ?>" class="button">View Registrations
                (<?php echo $count; ?>)</a>
            <?php
            break;
        case 'volunteers':
            global $wpdb;
            $query = $wpdb->prepare("SELECT COUNT(*) FROM volunteer_registration WHERE program_id = %d", $post_id);
            $count = $wpdb->get_var($query);
            ?>
            <a href="<?php echo admin_url("admin.php?page=view-volunteers&program_id=$post_id"); ?>" class="button">View Volunteers
                (<?php echo $count; ?>)</a>
            <?php
            break;
        default:
            break;
    }
}

add_action('manage_program_posts_custom_column', 'custom_program_columns_data', 10, 2);

function view_registrations_page_callback()
{
    global $wpdb;
    if (isset($_GET['program_id'])) {
        $program_id = $_GET['program_id'];
        $registrations = $wpdb->get_results("SELECT * FROM program_registration WHERE program_id = $program_id");
      ?>
        <h1>Registrations for Program <?php echo $program_id;?></h1>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            tr:hover {background-color: #ddd;}
        </style>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>IC No</th>
                    <th>Email</th>
                    <th>Faculty</th>
                    <th>Course</th>
                    <th>Tel No</th>
                    <th>Updated By</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($registrations)) {?>
                    <?php foreach ($registrations as $registration) {?>
                        <tr>
                            <td><?php echo (!empty($registration->first_name))? $registration->first_name : 'No Data';?></td>
                            <td><?php echo (!empty($registration->last_name))? $registration->last_name : 'No Data';?></td>
                            <td><?php echo (!empty($registration->ic_no))? $registration->ic_no : 'No Data';?></td>
                            <td><?php echo (!empty($registration->email))? $registration->email : 'No Data';?></td>
                            <td><?php echo (!empty($registration->faculty))? $registration->faculty : 'No Data';?></td>
                            <td><?php echo (!empty($registration->course))? $registration->course : 'No Data';?></td>
                            <td><?php echo (!empty($registration->tel_no))? $registration->tel_no : 'No Data';?></td>
                            <td><?php echo (!empty($registration->updated_by))? $registration->updated_by : 'No Data';?></td>
                            <td><?php echo ($registration->attendance == 1)? 'Attended' : '<a href="'. admin_url("admin.php?page=mark-attended&registration_id={$registration->id}&program_id=$program_id"). '">Mark as Attended</a>';?></td>
                        </tr>
                    <?php }?>
                <?php } else {?>
                    <tr>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
        <?php
    }
}

function view_volunteers_page_callback()
{
    global $wpdb;
    if (isset($_GET['program_id'])) {
        $program_id = $_GET['program_id'];
        $volunteers = $wpdb->get_results("SELECT * FROM volunteer_registration WHERE program_id = $program_id");
      ?>
        <h1>Volunteers for Program <?php echo $program_id;?></h1>
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                border: 1px solid black;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            tr:hover {background-color: #ddd;}
        </style>
        <table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>IC No</th>
                    <th>Email</th>
                    <th>Faculty</th>
                    <th>Course</th>
                    <th>Tel No</th>
                    <th>Updated By</th>
                    <th>Attendance</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($volunteers)) {?>
                    <?php foreach ($volunteers as $volunteer) {?>
                        <tr>
                            <td><?php echo (!empty($volunteer->first_name))? $volunteer->first_name : 'No Data';?></td>
                            <td><?php echo (!empty($volunteer->last_name))? $volunteer->last_name : 'No Data';?></td>
                            <td><?php echo (!empty($volunteer->ic_no))? $volunteer->ic_no : 'No Data';?></td>
                            <td><?php echo (!empty($volunteer->email))? $volunteer->email : 'No Data';?></td>
                            <td><?php echo (!empty($volunteer->faculty))? $volunteer->faculty : 'No Data';?></td>
                            <td><?php echo (!empty($volunteer->course))? $volunteer->course : 'No Data';?></td>
                            <td><?php echo (!empty($volunteer->tel_no))? $volunteer->tel_no : 'No Data';?></td>
                            <td><?php echo (!empty($volunteer->updated_by))? $volunteer->updated_by : 'No Data';?></td>
                            <td><?php echo ($volunteer->attendance == 1)? 'Attended' : '<a href="'. admin_url("admin.php?page=mark-attended&volunteer_id={$volunteer->id}&program_id=$program_id"). '">Mark as Attended</a>';?></td>
                        </tr>
                    <?php }?>
                <?php } else {?>
                    <tr>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                        <td>No Data</td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
        <?php
    }
}

function add_custom_admin_pages()
{
    add_menu_page('Registrations', 'Registrations', 'manage_options', 'registrations', 'view_registrations_page_callback');
    add_submenu_page('registrations','View Registrations', 'View Registrations', 'manage_options', 'view-registrations', 'view_registrations_page_callback');
    add_submenu_page('registrations', 'View Volunteers', 'View Volunteers', 'manage_options', 'view-volunteers', 'view_volunteers_page_callback');
}
add_action('admin_menu', 'add_custom_admin_pages');