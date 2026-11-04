<?php

if (! defined('ABSPATH')) {
    exit;
}

/**
 * Registra o menu de gerenciamento de leads.
 */
function lead_register_admin_menu()
{

    add_menu_page(
        'Gerenciar Leads',
        'Leads',
        'manage_options',
        'lead-capture',
        'lead_render_admin_page',
        'dashicons-groups',
        26
    );
}

/**
 * Exibe a página administrativa.
 */

function lead_render_admin_page()
{

    // Confere se o usuário pode administrar o WordPress.
    if (! current_user_can('manage_options')) {
        wp_die('Você não tem permissão para acessar esta página.');
    }

    global $wpdb;

    $table_name = $wpdb->prefix . 'leads';

    // Busca os leads mais recentes primeiro.
    $leads = $wpdb->get_results(
        "SELECT id, nome, telefone, email, data_criacao
         FROM {$table_name}
         ORDER BY id DESC"
    );
?>

    <div class="wrap">
        <h1>Gerenciar Leads</h1>

        <p>Contatos recebidos pela landing page.</p>

        <?php if (empty($leads)) : ?>

            <p>Nenhum lead cadastrado ainda.</p>

        <?php else : ?>

            <table class="widefat striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Data do cadastro</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($leads as $lead) : ?>
                        <tr>
                            <td><?php echo esc_html($lead->id); ?></td>
                            <td><?php echo esc_html($lead->nome); ?></td>
                            <td><?php echo esc_html($lead->telefone); ?></td>
                            <td><?php echo esc_html($lead->email); ?></td>
                            <td><?php echo esc_html($lead->data_criacao); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php endif; ?>
    </div>

<?php
}


add_action(
    'admin_menu',
    'lead_register_admin_menu'
);
