<?php 


function plz_assets(){

    wp_register_style("google-font","https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700",array(),false,'all');
    wp_register_style("google-font-2","https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap",array(),false,'all');
    wp_register_style("bootstrap","https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css",array(),"5.1",'all');

    wp_enqueue_style("estilos", get_stylesheet_directory_uri()."/assets/css/style.css", array("google-font", "google-font-2","bootstrap"));

    wp_enqueue_script("yardsale-js",get_stylesheet_directory_uri()."/assets/js/script.js");
}

add_action("wp_enqueue_scripts","plz_assets");

function plz_analytics(){
    ?>
    <!-- <h1>ANALYTICS</h1> -->
    <?php
}

add_action('wp_body_open', 'plz_analytics');

function plz_theme_supports(){
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo',
    array(
        "width" => 170,
        "height" => 35,
        "flex-width" => true,
        "flex-height" => true,
    )
    );
}

add_action("after_setup_theme","plz_theme_supports");

function plz_add_menu(){
    register_nav_menus(
        array(
            'menu-principal' => "Menú principal",
            'menu-responsive' => "Menú resposive"
        )
    );
}

add_action("after_setup_theme", "plz_add_menu");

function plz_add_sidebar(){
    register_sidebar( 
        array(
            'name' => 'Pie de página',
            'id' => 'pie-de-pagina',
            'before_widget' => '',
            'after_widget' => '',
        )
    );
}

add_action("widgets_init", "plz_add_sidebar");

function plz_add_custom_post_type(){

    $labels = array(
        'name' => 'Producto',
        'singular_name' => 'Producto',
        'all_items' => 'Todos los productos',
        'add_new' => 'Añadir producto'
    );
        
    $args = array(
        'labels'             => $labels,
        'description'        => 'Productos para listar en un catálogos.',
        'public'             => true,
        'publicly_queryable' => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'producto' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail' ),
        'taxonomies'         => array('category'),
        'show_in_rest'       => true,
        'menu_icon'          => 'dashicons-cart'
    );


    register_post_type('producto',$args);
}

// add_action("init","plz_add_custom_post_type");

function plz_add_to_signin_menu(){
    $current_user = wp_get_current_user();
    $msg = is_user_logged_in()? $current_user->user_email : "Sign in";

    echo $msg;
}

add_action('plz_signin', 'plz_add_to_signin_menu');

remove_action("woocommerce_after_shop_loop_item","woocommerce_template_loop_add_to_cart",10);

function plz_add_to_cart(){
    global $product;
    ?>
    <a href="<?php echo $product->add_to_cart_url();?>" class="productos__add-to-cart">
            <img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/add-to-cart.svg" alt="agragar al carrito">
         </a>
    <?php
}

add_action("woocommerce_after_shop_loop_item","plz_add_to_cart",10);

function plz_ws_share(){
    global $product;
     ?>         <?php //Número de teléfono sin espacios ni símbolos ?>
        <a href="https://wa.me/549111111111111?text=Quisiera%20consultar%20sobre%20este%20producto: <?php echo $product->get_permalink();?>" target="_blank" class="productos__ws">
            <img src="<?php echo get_stylesheet_directory_uri();?>/assets/img/ws.svg" alt="whatsapps">
        </a>
     <?php 
}

add_action("woocommerce_after_shop_loop_item","plz_ws_share",11);