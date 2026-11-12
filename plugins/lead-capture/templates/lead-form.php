<?php
if (!defined('ABSPATH')) {
    exit;
}

$status = isset($_GET['lead_status'])
    ? sanitize_key(wp_unslash($_GET['lead_status']))
    : '';


//Array de mensagens
$messages = [
    'success' => [
        'title' => 'Cadastro realizado!',
        'text' => 'Seus dados foram recebidos e registrados com sucesso.'
    ],

    'empty_fields' => [
        'title' => 'Atenção!',
        'text' => 'Preencha todos os campos obrigatórios.'
    ],

    'invalid_email' => [
        'title' => 'E-mail inválido!',
        'text' => 'Informe um endereço de e-mail válido.'
    ],

    'save_error' => [
        'title' => 'Não foi possível concluir!',
        'text' => 'Não foi possível registrar seus dados. Tente novamente.'
    ]
];

?>

<div class="lead-form bg-white rounded-4 p-4 p-md-5 shadow">
    <div class="mb-4">
        <h3 class="fw-bold mb-2" style="color: #002048;">
            Solicite sua consultoria
        </h3>

        <p class="text-secondary mb-0">
            Preencha seus dados e receba atendimento personalizado
            para proteger sua casa.
        </p>
    </div>



    <?php if (isset($messages[$status])) : ?>

        <div class="modal fade" id="leadResponseModal" tabindex="-1" aria-labelledby="leadResponseModalLabel" aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="leadResponseModalLabel">
                            <?php echo esc_html($messages[$status]['title']); ?>
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>

                    </div>

                    <div class="modal-body text-center py-4">

                        <i class="bi <?php echo esc_attr($messages[$status]['icon']); ?> text-<?php echo esc_attr($messages[$status]['type']); ?> fs-1 mb-3"></i>

                        <p class="mb-0">
                            <?php echo esc_html($messages[$status]['text']); ?>
                        </p>

                    </div>

                    <div class="modal-footer justify-content-center">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Fechar
                        </button>

                    </div>

                </div>

            </div>

        </div>

    <?php endif; ?>

    <?php if (isset($messages[$status])) : ?>

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const modalElement = document.getElementById('leadResponseModal');

                const leadModal = new bootstrap.Modal(modalElement);

                leadModal.show();

                const url = new URL(window.location.href);

                url.searchParams.delete('lead_status');

                window.history.replaceState({}, document.title, url);

            });
        </script>

    <?php endif; ?>

    <!-- 1º Primeiro usamos o metodo POST -->
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST">

        <!-- Identifica qual ação do WordPress deverá processar o formulário. Usaremos o nome submit_lead para registrar essa ação no plugin. -->
        <input type="hidden" name="action" value="submit_lead">

        <!-- Gera um campo de segurança que permitirá verificar se a requisição contém um token válido. Isso ajuda a proteger o processamento contra requisições indevidas, embora não substitua outras validações. -->
        <?php wp_nonce_field('submit_lead_action', 'lead_nonce'); ?>

        <div class="mb-3">
            <label for="lead-nome" class="form-label fw-semibold">
                Nome completo
            </label>

            <input
                type="text"
                class="form-control form-control-lg"
                id="lead-nome"
                name="nome"
                placeholder="Digite seu nome completo"
                autocomplete="name"
                required>
        </div>

        <div class="mb-3">
            <label for="lead-telefone" class="form-label fw-semibold">
                Telefone / WhatsApp
            </label>

            <input
                type="tel"
                class="form-control form-control-lg"
                id="lead-telefone"
                name="telefone"
                placeholder="(99) 99999-9999"
                autocomplete="tel"
                required>
        </div>

        <div class="mb-4">
            <label for="lead-email" class="form-label fw-semibold">
                E-mail
            </label>

            <input
                type="email"
                class="form-control form-control-lg"
                id="lead-email"
                name="email"
                placeholder="voce@exemplo.com"
                autocomplete="email"
                required>
        </div>

        <button
            type="submit"
            class="btn btn-success btn-lg w-100 rounded-pill fw-semibold">
            Solicitar consultoria
        </button>

        <p class="small text-secondary mt-3 mb-0">
            Ao enviar, você poderá ser contatado para conhecer
            nossas soluções.
        </p>
    </form>
</div>