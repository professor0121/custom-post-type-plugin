<?php
/*
Plugin Name: Custom Post Type & Taxonomy Plugin
Description: A plugin to create custom post types and taxonomies dynamically.
Version: 1.0
Author: Your Name
*/

// Include necessary files
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-post-type.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/custom-taxonomies.php';

// Add menu item for settings page
function cpt_taxonomy_plugin_menu() {
    add_menu_page(
        'Custom Post Types',           // Page title
        'CPT Settings',                // Menu title
        'manage_options',              // Capability required
        'cpt-settings',                // Menu slug
        'cpt_taxonomy_plugin_settings_page', // Function to display settings page
        'dashicons-businessperson',        // Icon for the menu
        20                             // Position in the menu
    );
}
add_action('admin_menu', 'cpt_taxonomy_plugin_menu');

// Create the settings page form for multiple CPTs
function cpt_taxonomy_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Create Custom Post Types</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('cpt-settings-group'); // Register the settings group
            do_settings_sections('cpt-settings');  // Display the settings section
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Custom Post Types</th>
                    <td>
                        <div id="cpt-fields">
                            <?php
                            $cpts = get_option('cpts', array()); // Get stored CPTs data
                            foreach ($cpts as $index => $cpt) {
                                ?>
                                <div class="cpt-item">
                                    <h3>CPT <?php echo $index + 1; ?></h3>
                                    <label>Post Type Name</label>
                                    <input type="text" name="cpts[<?php echo $index; ?>][name]" value="<?php echo esc_attr($cpt['name']); ?>" />
                                    
                                    <label>Label</label>
                                    <input type="text" name="cpts[<?php echo $index; ?>][label]" value="<?php echo esc_attr($cpt['label']); ?>" />
                                    
                                    <label>Menu Icon</label>
                                    <input type="text" name="cpts[<?php echo $index; ?>][icon]" value="<?php echo esc_attr($cpt['icon']); ?>" />
                                    
                                    <button type="button" class="remove-cpt-button">Remove</button>
                                </div>
                            <?php } ?>
                        </div>
                        <button type="button" id="add-cpt-button">Add Another CPT</button>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>

    <script>
    document.getElementById('add-cpt-button').addEventListener('click', function() {
        var cptFields = document.getElementById('cpt-fields');
        var newCptIndex = cptFields.children.length;
        var newCpt = `
            <div class="cpt-item">
                <h3>CPT ${newCptIndex + 1}</h3>
                <label>Post Type Name</label>
                <input type="text" name="cpts[${newCptIndex}][name]" />
                
                <label>Label</label>
                <input type="text" name="cpts[${newCptIndex}][label]" />
                
                <label>Menu Icon</label>
                <input type="text" name="cpts[${newCptIndex}][icon]" />
                
                <button type="button" class="remove-cpt-button">Remove</button>
            </div>
        `;
        cptFields.insertAdjacentHTML('beforeend', newCpt);
    });

    document.addEventListener('click', function(event) {
        if (event.target && event.target.classList.contains('remove-cpt-button')) {
            event.target.closest('.cpt-item').remove();
        }
    });
    </script>
    <?php
}

// Register the settings for multiple CPTs
function cpt_taxonomy_plugin_register_settings() {
    register_setting('cpt-settings-group', 'cpts'); // Save as an array
}
add_action('admin_init', 'cpt_taxonomy_plugin_register_settings');

// Enqueue styles and scripts
function cpt_taxonomy_plugin_enqueue_scripts() {
    wp_enqueue_style( 'cpt-taxonomy-style', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
    wp_enqueue_script( 'cpt-taxonomy-script', plugin_dir_url( __FILE__ ) . 'assets/js/script.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'cpt_taxonomy_plugin_enqueue_scripts' );

// Create a custom admin page to display custom post types
function show_cpt_on_plugin_page() {
    // Only show this in the admin area
    // $args = array(
    //     'post_type' => 'your_custom_post_type', // Replace with your custom post type name
    //     'posts_per_page' => 5, // Limit to 5 posts (you can adjust this)
    // );


    $args = array(
        'post_type' => 'your_custom_post_type',
        'posts_per_page' => 10,
        // If filtering by taxonomy, ensure it’s correctly set
        'tax_query' => array(
            array(
                'taxonomy' => 'category', // Replace with your taxonomy
                'field'    => 'slug',
                'terms'    => 'your-term', // Replace with the term
            ),
        ),
    );
    
    
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        echo '<div class="cpt-list">';
        while ($query->have_posts()) : $query->the_post();
            echo '<div class="cpt-item">';
            echo '<h2>' . get_the_title() . '</h2>';
            echo '<p>' . get_the_excerpt() . '</p>';
            echo '</div>';
        endwhile;
        wp_reset_postdata();
        echo '</div>';
    else :
        echo 'No custom posts found';
    endif;
}

// Add a menu item to the admin sidebar
function add_plugin_menu() {
    add_menu_page(
        'Custom Post Types Display', // Page title
        'CPT Display',               // Menu title
        'manage_options',            // Capability
        'cpts_display_page',         // Menu slug
        'show_cpt_on_plugin_page'    // Callback function to display content
    );
}
add_action('admin_menu', 'add_plugin_menu');




?>