<?php if (isset($flash)): ?>
    <div class="alert alert-<?php echo $flash['tipo']; ?> alert-dismissible fade show" role="alert">
        <?php echo $flash['mensagem']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endif; ?>
