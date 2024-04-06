<footer>

    <?php
    // Affichage du menu footer déclaré dans functions.php et puis dans wp
    wp_nav_menu(array('theme_location' => 'footer'));
    ?>

</footer>


<?php
get_template_part('template-parts/modal/contact');
?>


<?php wp_footer(); ?>

</body>

</html>