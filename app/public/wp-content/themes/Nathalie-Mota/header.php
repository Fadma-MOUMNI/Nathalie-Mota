<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('title') ?> </title>
    <?php wp_head(); ?>
</head>

<body>

    <header>
        <div class="container_header">
            <div class="container_logo_menu_hamburger">
                <a href="<?php echo get_home_url(); ?>">
                    <!--bloginfo('name') comme texte alternatif pour afficher le nom du site-->
                    <img src="<?php echo get_bloginfo('template_directory') ?>/assets/img/Logo.png" alt="<?php echo bloginfo('name'); ?>">
                </a>
                <button class="hamburger" id="hamburger-button">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                </button>
            </div>



            <nav class="nav-menu">
                <?php
                wp_nav_menu(array('theme_location' => 'main'));
                ?>
            </nav>


        </div>


    </header>