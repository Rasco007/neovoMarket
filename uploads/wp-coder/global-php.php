<?php
defined( 'ABSPATH' ) || exit;

//esto es para cuando se apreta el boton de log out
function custom_logout_redirect() {
    return home_url(); // Ajusta esta URL
}
add_filter('woocommerce_logout_redirect', 'custom_logout_redirect');


add_action('wp_logout', function() {
    wp_redirect(home_url()); // Ajusta la URL
    exit();
});

//esto es para cuando se loguea, vaya a my-account
add_action('wp_footer', function() {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.addEventListener("user_registration_login_success", function() {
                window.location.href = "<?php echo home_url('https://neovomarket.com/my-account/'); ?>"; 
            });
        });
    </script>
    <?php
});

//forzar a subir producto
add_action('save_post_product', 'vinod_forzar_publicar_producto', 20, 3);
function vinod_forzar_publicar_producto($post_ID, $post, $update) {
    // Solo si es un vendor
    $user = get_user_by('id', $post->post_author);
    if (in_array('seller', (array) $user->roles) || in_array('vendor', (array) $user->roles)) {
        // Solo si está pendiente
        if ($post->post_status === 'pending') {
            // Cambiar el estado a publicado
            wp_update_post([
                'ID' => $post_ID,
                'post_status' => 'publish'
            ]);
        }
    }
}

//cambiar la lista de paises a ESPAÑA 
//// Restringir lista de países solo a España
add_filter('woocommerce_countries', 'vinod_solo_espana_en_dokan');
function vinod_solo_espana_en_dokan($countries) {
    return [
        'ES' => __('España', 'woocommerce')
    ];
}

// Opcional: También restringe a España en campos de dirección
add_filter('woocommerce_countries_allowed_countries', 'vinod_solo_espana_en_dokan_allowed');
function vinod_solo_espana_en_dokan_allowed($countries) {
    return [
        'ES' => __('España', 'woocommerce')
    ];
}
