<?php

  defined( 'ABSPATH' ) || exit;
function vinod_mostrar_tipo_vendedor($user) {
    $tipo = get_user_meta($user->ID, 'vendor_type', true);
    echo '<h3>Tipo de Vendedor</h3>';
    echo '<p><strong>Tipo seleccionado:</strong> ' . esc_html($tipo ?: 'No seleccionado') . '</p>';
}

if (is_admin()) {
    add_action('edit_user_profile', 'vinod_mostrar_tipo_vendedor');
    add_action('show_user_profile', 'vinod_mostrar_tipo_vendedor');
}