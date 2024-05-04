<?php
include 'functions.php';
// Connect to MySQL database
$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Número de registros a serem exibidos em cada página
$records_per_page = 5;

// Prepare a instrução SQL e obtenha registros de nossa tabela de links, LIMIT determinará a página
$stmt = $pdo->prepare('SELECT * FROM links ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();
// Busca os registros para que possamos exibi-los
$links = $stmt->fetchAll(PDO::FETCH_ASSOC);

$num_links = $pdo->query('SELECT COUNT(*) FROM links')->fetchColumn();
?>

<?=template_header('Read')?>

<div class="content read">
	<h2>LINKS</h2>
	<a href="create.php" class="create-contact">Criar Link</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Nome</td>
                <td>Categoria</td>
                <td>Descrição</td>
                <td>Site</td>
                <td></td>
                

            </tr>
        </thead>
        <tbody>
            <?php foreach ($links as $link): ?>
            <tr>
                <td><?=$link['id']?></td>
                <td><?=$link['nome']?></td>
                <td><?=$link['categoria']?></td>
                <td><?=$link['descricao']?></td>
                <td><?=$link['site']?></td>
                <td class="actions">
                    <a href="update.php?id=<?=$link['id']?>" class="edit"><i class="fas fa-pen fa-xs"></i></a>
                    <a href="delete.php?id=<?=$link['id']?>" class="trash"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
	<div class="pagination">
		<?php if ($page > 1): ?>
		<a href="read.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
		<?php endif; ?>
		<?php if ($page*$records_per_page < $num_links): ?>
		<a href="read.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
		<?php endif; ?>
	</div>
</div>

<?=template_footer()?>
