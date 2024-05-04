<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {
        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
        $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
        $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $site = isset($_POST['site']) ? $_POST['site'] : '';
       
        // Update the record
        $stmt = $pdo->prepare('UPDATE links SET id = ?, nome = ?, categoria = ?, descricao = ?, site = ? WHERE id = ?');
        $stmt->execute([$id, $nome, $categoria, $descricao, $site,$_GET['id']]);
        $msg = 'Atualizado com sucesso!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM links WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $link = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$link) {
        exit('link doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>


<?=template_header('Read')?>

<div class="content update">
	<h2>Update links #<?=$link['id']?></h2>
    <form action="update.php?id=<?=$link['id']?>" method="post">
        <label for="id">ID</label>
        <label for="nome">Name</label>
        <input type="text" name="id" placeholder="1" value="<?=$link['id']?>" id="id">
        <input type="text" name="nome"  value="<?=$link['nome']?>" id="nome">
        <label for="categoria">Categoria</label>
        <label for="descricao">Descricao</label>
        <input type="text" name="categoria" placeholder="johndoe@example.com" value="<?=$link['categoria']?>" id="categoria">
        <input type="text" name="descricao" placeholder="2025550143" value="<?=$link['descricao']?>" id="descricao">
        <label for="site">Site</label>
        <label for="created">Created</label>
        <input type="text" name="site" placeholder="Employee" value="<?=$link['site']?>" id="site">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>