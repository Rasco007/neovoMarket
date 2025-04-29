<?php

  defined( 'ABSPATH' ) || exit;
function vinod_agregar_roles_vendedores() {
    add_role('vendedor_particular', 'Vendedor Particular', array('read' => true));
    add_role('vendedor_profesional', 'Vendedor Profesional', array('read' => true));
}
add_action('init', 'vinod_agregar_roles_vendedores');


function vinod_radio_tipo_vendedor() {
    if (is_account_page() && is_user_logged_in()) {
        ?>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const paragraphs = document.querySelectorAll('form p');
            if (paragraphs.length >= 3) {
                const radioHTML = 
                <p>
                    <label><strong>Tipo de vendedor</strong></label><br>
                    <input type="radio" name="tipo_vendedor" value="vendedor_particular" checked> Particular<br>
                    <input type="radio" name="tipo_vendedor" value="vendedor_profesional"> Profesional
                </p>;
                paragraphs[2].insertAdjacentHTML('afterend', radioHTML);
            }
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'vinod_radio_tipo_vendedor');

function vinod_guardar_tipo_de_vendedor($user_id) {
    if (isset($_POST['tipo_vendedor'])) {
        $tipo = sanitize_text_field($_POST['tipo_vendedor']);

        // Remueve los roles anteriores si son de este tipo
        $user = get_userdata($user_id);
        $user->remove_role('seller');
        $user->remove_role('vendedor_particular');
        $user->remove_role('vendedor_profesional');

        // Agrega el nuevo rol
        $user->add_role($tipo);

        // Guarda como meta para poder acceder fácilmente después
        update_user_meta($user_id, 'vendor_type', $tipo);
    }
}

add_action('dokan_store_profile_saved', 'vinod_guardar_tipo_de_vendedor');

