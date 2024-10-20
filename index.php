<?php
include('conectaBD.php');

if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['email'])) {
    header('Location: http://localhost/projeto%20api/signIn.php');
}

$sql_code = "SELECT * FROM imoveis ";
$sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
$imoveis = [];
if ($sql_query->num_rows > 0) {
    // Obtém cada linha de resultado como um array associativo
    while($row = $sql_query->fetch_assoc()) {
        $imoveis[] = $row;
    }
}

if(isset($_POST['delete'])){
    $id = $_POST['Id'];
    $sql_code = "DELETE FROM imoveis WHERE Id = $id ";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    $sql_code = "SELECT * FROM imoveis ";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    $imoveis = [];
    if ($sql_query->num_rows > 0) {
        // Obtém cada linha de resultado como um array associativo
        while($row = $sql_query->fetch_assoc()) {
            $imoveis[] = $row;
        }
    }
}

if(isset($_POST['create'])){
    $nome = $_POST['Nome'];
    $imagem = $_POST['Imagem'];
    $sql_code = "INSERT INTO imoveis (Nome, PastaImagens) VALUES ('$nome', '$imagem') ";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

    $sql_code = "SELECT * FROM imoveis ";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    $imoveis = [];
    if ($sql_query->num_rows > 0) {
        // Obtém cada linha de resultado como um array associativo
        while($row = $sql_query->fetch_assoc()) {
            $imoveis[] = $row;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imobiliaria</title>
    <script src="scripts/home.js"></script>
    <link rel="stylesheet" href="Styles/home.css">
    <link rel="stylesheet" href="Styles/index.css">
    <link rel="icon" type="image/png" href="Images/projectIcon.png">
</head>

<body class="body">

    <div class="Header">
        <div>Imobiliaria</div>
        <div class="navLinks">
            <a class="active" href="index.php">Mostruario</a>
            <a href="signIn.php">Cadastro</a>
            <?php if(isset($_SESSION['email'])) echo "<a href='perfil.php'>Perfil</a>"?>
            <a href="about.php">Sobre nós</a>
            <?php if(isset($_SESSION['email'])) echo "<a href='logout.php'>Sair</a>"?>
        </div>
    </div>
    <div class="content">
        <div class="cardList">
            <?php foreach ($imoveis as $imovel): ?>
                <div class='card'>
                    <?php if($_SESSION['id'] == 1) echo "
                    <form method='post'>
                        <input type='submit' name='delete' value='x'>
                        <input style='display:none' name='Id' value='".$imovel['Id']."'>
                    </form>"?>
                    <img class='cardImg' src="Images/casas/<?php echo $imovel['PastaImagens']?>/0.jpeg" />
                    <div class='cardTitle'><?php echo $imovel['Nome']?></div>
                    <div class='cardBtn' onclick="openModal('<?php echo $imovel['PastaImagens']?>','<?php echo $imovel['Nome']?>',)">ver mais</div>
                </div>
            <?php endforeach; ?>
            <?php if($_SESSION['id'] == 1) echo "
            <div class='card'>
                <form action='' method='POST'>
                    <h3 class='titleBottom'>Novo Imovel </h3>
                    <div class='form-group'>
                        <label for='Nome'><i class='fa fa-user' aria-hidden='true'></i></label>
                        <input class='inputNew' type='text' name='Nome' id='Nome' placeholder='Nome do Imovel' required>
                    </div><br>
                    <div class='form-group'>
                        <label for='Imagem'><i class='fa fa-envelope' aria-hidden='true'></i></label>
                        <input class='inputNew' type='text' name='Imagem' id='Imagem' placeholder='Pasta de Imagens' required>
                    </div><br>
                    <input type='submit' name='create' value='Create' class='form-submit'>
                </form>
            </div>"; ?>
        </div>
    </div>
    <div id="modal-background" class="modalBackground" onclick="closeModal()"></div>
    <div id="modal-box" class="modalBox">
        <div class="modalListImg">
            <img id="modal-img0" class="modalImg" />
            <img id="modal-img1" class="modalImg" />
            <img id="modal-img2" class="modalImg" />
            <img id="modal-img3" class="modalImg" />
        </div>
        <b id="modal-title" class="modalTitle"></b>
        <div onclick="closeModal()" class="closeModal">Fechar</div>
    </div>
</body>

</html>