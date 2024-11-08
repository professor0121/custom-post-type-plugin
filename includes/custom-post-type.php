<?php
function create_dynamic_custom_post_type() {
    // Get the array of custom post types
    $cpts = get_option('cpts', array());

    // Loop through each CPT and register it
    foreach ($cpts as $cpt) {
        if (!empty($cpt['name']) && !empty($cpt['label'])) {
            $args = array(
                'public' => true,
                'label'  => $cpt['label'],
                'supports' => array( 'title', 'editor', 'thumbnail' ),
                'menu_icon' => !empty($cpt['icon']) ? $cpt['icon'] : 'dashicons-admin-post',
                'rewrite' => array( 'slug' => strtolower($cpt['name']) ),
            );
            register_post_type($cpt['name'], $args);
        }
    }
}
add_action('init', 'create_dynamic_custom_post_type');
?>