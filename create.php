<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;
    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $site = isset($_POST['site']) ? $_POST['site'] : '';
    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO links VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$id, $nome, $categoria, $descricao, $site]);
    // Output message
    $msg = 'Criado com sucesso!';
}
?>
<?=template_header('Create')?>

<div class="content update">
	<h2>Create Contact</h2>
    <form action="create.php" method="post">
        <label for="id">ID</label>
        <label for="name">Nome</label>
        <input type="text" name="id" value="auto" id="id">
        <input type="text" name="name" placeholder="nome site" id="name">
        <label for="categoria">Categoria</label>
        <label for="descricao">Descrição</label>
        <input type="text" name="categoria" id="categoria"  placeholder="categoria">
        <input type="text" name="descricao" id="descricao"  placeholder="descricao">

        <label for="site">site</label>
        <label for=""></label>
        <input type="text" name="site"  id="site">
        
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>





?>