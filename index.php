<?php get_header(); ?>

<?php if (have_posts()) { ?>
    <?php while(have_posts()){ ?>
        <?php 
            the_post();
            the_content(); 
            ?>
    <?php } ?>
<?php } ?>

<?php get_template_part("template-parts/content", "productos"); ?>

<?php get_footer(); ?>