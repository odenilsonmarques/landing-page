<?php

/**
 * Plugin Name: Lead Capture
 * Description: Plugin para captação e gerenciamento de leads.
 * Version: 1.0.0
 * Author: Odenilson
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Registra o shortcode do formulário de leads.
 */
function lead_form_shortcode()
{
    ob_start();

    $template = plugin_dir_path(__FILE__) . 'templates/lead-form.php';

    if (file_exists($template)) {
        include $template;
    }

    return ob_get_clean();
}

add_shortcode('lead_form', 'lead_form_shortcode');




/**
 * Processa o envio do formulário de leads.
 */
function process_lead_form()
{

    // Verifica se a requisição utiliza o método POST.
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        wp_die('Método de requisição inválido.');
    }

    // Verifica o token de segurança do formulário.
    check_admin_referer(
        'submit_lead_action',
        'lead_nonce'
    );

    // Recupera e sanitiza os dados enviados.
    $nome = isset($_POST['nome'])
        ? sanitize_text_field(wp_unslash($_POST['nome']))
        : '';

    $telefone = isset($_POST['telefone'])
        ? sanitize_text_field(wp_unslash($_POST['telefone']))
        : '';

    $email = isset($_POST['email'])
        ? trim(wp_unslash($_POST['email']))
        : '';

    // Valida os campos obrigatórios.
    if (empty($nome) || empty($telefone) || empty($email)) {
        // wp_die('Preencha todos os campos obrigatórios.');
        $redirect_url = wp_get_referer() ?: home_url('/');
        $redirect_url = wp_validate_redirect($redirect_url, home_url('/'));

        wp_safe_redirect(
            add_query_arg('lead_status', 'empty_fields', $redirect_url)
        );

        exit;
    }

    if (! is_email($email)) {
        // wp_die('Informe um endereço de e-mail válido.');
        $redirect_url = wp_get_referer() ?: home_url('/');
        $redirect_url = wp_validate_redirect($redirect_url, home_url('/'));

        wp_safe_redirect(
            add_query_arg('lead_status', 'invalid_email', $redirect_url)
        );

        exit;
    }

    // Obtém acesso ao banco de dados do WordPress.
    global $wpdb;

    // Nome da tabela criada pelo plugin.
    $table_name = $wpdb->prefix . 'leads';

    // Insere o lead na tabela.
    $resultado = $wpdb->insert(
        $table_name,
        array(
            'nome'     => $nome,
            'telefone' => $telefone,
            'email'    => $email,
        ),
        array(
            '%s',
            '%s',
            '%s',
        )
    );

    // Verifica se a inserção foi realizada.
    if (false === $resultado) {
        error_log('Lead Capture: erro ao salvar lead. ' . $wpdb->last_error);

        // wp_die('Não foi possível registrar seus dados. Tente novamente.');
        $redirect_url = wp_get_referer() ?: home_url('/');
        $redirect_url = wp_validate_redirect($redirect_url, home_url('/'));

        wp_safe_redirect(
            add_query_arg('lead_status', 'save_error', $redirect_url)
        );

        exit;
    }

    // Confirma o cadastro.
    // wp_die('Lead cadastrado com sucesso!');
    $redirect_url = wp_get_referer();

    if (!$redirect_url) {
        $redirect_url = home_url('/');
    }

    $redirect_url = wp_validate_redirect($redirect_url, home_url('/'));

    wp_safe_redirect(
        add_query_arg('lead_status', 'success', $redirect_url)
    );

    exit;
}

// Registra a ação para visitantes não autenticados.
add_action('admin_post_nopriv_submit_lead', 'process_lead_form');

// Registra a ação para usuários autenticados.
add_action('admin_post_submit_lead', 'process_lead_form');





/**
 * Cria a tabela de leads durante a ativação do plugin.
 */
function lead_create_table()
{

    global $wpdb;

    // Prefixo das tabelas do WordPress.
    $table_name = $wpdb->prefix . 'leads';

    // Charset e collation utilizados pelo banco do WordPress.
    $charset_collate = $wpdb->get_charset_collate();

    // Estrutura da tabela.
    $sql = "CREATE TABLE {$table_name} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        nome VARCHAR(255) NOT NULL,
        telefone VARCHAR(30) NOT NULL,
        email VARCHAR(255) NOT NULL,
        data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
    ) {$charset_collate};";

    // Disponibiliza a função dbDelta do WordPress.
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';

    // Cria a tabela ou atualiza sua estrutura.
    dbDelta($sql);
}

// Executa a criação quando o plugin é ativado.
register_activation_hook(
    __FILE__,
    'lead_create_table'
);



require_once plugin_dir_path(__FILE__) . 'includes/leads-admin.php';
