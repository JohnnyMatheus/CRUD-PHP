<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Verifica se o contato existe
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
//Esta parte é semelhante ao create.php, mas em vez disso atualizamos um registro e não inserimos
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $site = isset($_POST['site']) ? $_POST['site'] : '';
       
        // Atualiza o registro
        $stmt = $pdo->prepare('UPDATE links SET id = ?, nome = ?, categoria = ?, descricao = ?, site = ? WHERE id = ?');
        $stmt->execute([$id, $nome, $categoria, $descricao, $site,$_GET['id']]);
        $msg = 'Atualizado com sucesso!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM links WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $link = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$link) {
        exit('Não existe link com esse id!');
    }
} else {
    exit('Id não especificado!');
}
?>


<?=template_header('Read')?>

<div class="content update">
	<h2>Update links #<?=$link['id']?></h2>
    <form action="update.php?id=<?=$link['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nome">Nome site</label>
        <input type="text" name="id" placeholder="1" value="<?=$link['id']?>" id="id">
        <input type="text" name="nome"  value="<?=$link['nome']?>" id="nome">
        <label for="categoria">Categoria</label>
        <label for="descricao">Descricao</label>
        <input type="text" name="categoria" value="<?=$link['categoria']?>" id="categoria">
        <input type="text" name="descricao" value="<?=$link['descricao']?>" id="descricao">
        <label for="site">Site</label>
        <label for=""></label>
        <input type="text" name="site"  value="<?=$link['site']?>" id="site">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>