<?php
function create_dynamic_custom_taxonomies() {
    $cpts = get_option('cpts', array());

    foreach ($cpts as $cpt) {
        if (!empty($cpt['name'])) {
            $taxonomy_name = strtolower($cpt['name']) . '_genre'; // Example: 'book_genre'
            $taxonomy_label = $cpt['label'] . ' Genres'; // Example: 'Books Genres'

            $args = array(
                'hierarchical' => true,
                'labels' => array(
                    'name' => $taxonomy_label,
                    'singular_name' => 'Genre',
                    'search_items' => 'Search Genres',
                    'all_items' => 'All Genres',
                    'edit_item' => 'Edit Genre',
                    'update_item' => 'Update Genre',
                    'add_new_item' => 'Add New Genre',
                    'new_item_name' => 'New Genre Name',
                    'menu_name' => $taxonomy_label,
                ),
                'rewrite' => array( 'slug' => strtolower($taxonomy_name) ),
            );

            register_taxonomy($taxonomy_name, $cpt['name'], $args);
        }
    }
}
add_action('init', 'create_dynamic_custom_taxonomies');
?>