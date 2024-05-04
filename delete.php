<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Verifica se o ID do link existe
if (isset($_GET['id'])) {
    // Selecione o registro que será excluído
    $stmt = $pdo->prepare('SELECT * FROM links WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $link = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$link) {
        exit('link doesn\'t exist with that ID!');
    }
    // Certifique-se de que o usuário confirma antes da exclusão
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM links WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'Você excluiu o link!';
        } else {
            //O usuário clicou no botão "Não", redirecionando-os de volta para a página lida
            header('Location: read.php');
            exit;
        }
    }
} else {
    exit('ID não especificado!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
	<h2>Deletar link #<?=$link['id']?></h2>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php else: ?>
	<p>Tem certeza de que deseja excluir#<?=$link['id']?>?</p>
    <div class="yesno">
        <a href="delete.php?id=<?=$link['id']?>&confirm=yes">Yes</a>
        <a href="delete.php?id=<?=$link['id']?>&confirm=no">No</a>
    </div>
    <?php endif; ?>
</div>

<?=template_footer()?>