<?php
// header.php
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?></title>
    
    <?php wp_head(); ?>  <!-- Hook for WordPress to load additional scripts/styles -->
</head>
<body <?php body_class(); ?>>
    
    <header class="site-header">
        <div class="container">
            <div class="site-branding">
                <!-- Display the site title as a link to the homepage -->
                <a href="<?php echo home_url(); ?>" rel="home">
                    <h1><?php bloginfo( 'name' ); ?></h1>
                </a>
                <p><?php bloginfo( 'description' ); ?></p>
            </div>
            
            <nav class="main-navigation">
                <?php 
                    // Display WordPress navigation menu
                    wp_nav_menu( array( 
                        'theme_location' => 'primary', // 'primary' menu location
                        'menu_class' => 'menu' // Optional, styling class for the menu
                    ) ); 
                ?>
            </nav>
        </div>
    </header>

    <main id="main-content">
