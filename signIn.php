<?php
include('conectaBD.php');

if(!isset($_SESSION)) {
    session_start();
}

if(isset($_POST['EmailN']) || isset($_POST['SenhaN'])) {

    if(strlen($_POST['EmailN']) == 0) {
        echo "Preencha seu e-mail";
    } else if(strlen($_POST['SenhaN']) == 0) {
        echo "Preencha sua senha";
    } else {
        $senha = $mysqli->real_escape_string($_POST['SenhaN']);
        $email = $mysqli->real_escape_string($_POST['EmailN']);
        if(!isset($_SESSION)) {
            session_start();
        }
        $sql_code = "SELECT * FROM usuario WHERE Email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $usuario = $sql_query->fetch_assoc();
        if(password_verify($senha, $usuario['Senha'])){
            $_SESSION['id'] = $usuario['Id'];
            $_SESSION['nome'] = $usuario['Nome'];
            $_SESSION['email'] = $usuario['Email'];
            $_SESSION['necessita'] = $usuario['Tipo'];
            $_SESSION['deAcordo'] = $usuario['Termos'];
            $_SESSION['celular'] = $usuario['Celular'];
            $_SESSION['senha'] = $senha;
            header('Location: http://localhost/projeto%20api/perfil.php');
        }
        else { echo "email ou senha incorreto";}
    }
}
if(isset($_POST['Email']) || isset($_POST['Senha'])) {

    if(strlen($_POST['Email']) == 0) {
        echo "Preencha seu e-mail";
    } else if(strlen($_POST['Senha']) == 0) {
        echo "Preencha sua senha";
    } else if(strlen($_POST['Necessita']) == 0) {
        echo "Preencha sua necessidade";
    } else if(strlen($_POST['Nome']) == 0) {
        echo "Preencha seu nome";
    } else {

        $nome = $mysqli->real_escape_string($_POST['Nome']);
        $email = $mysqli->real_escape_string($_POST['Email']);
        $necessita = $mysqli->real_escape_string($_POST['Necessita']);
        $celular = $mysqli->real_escape_string($_POST['Celular']);
        $senha = password_hash($mysqli->real_escape_string($_POST['Senha']), PASSWORD_BCRYPT);
        if($mysqli->real_escape_string($_POST['De_acordo']) == "on"){
            $deAcordo = 1;
        } else $deAcordo = 0;
        
        $sql_code = "INSERT INTO Usuario (Nome, Email, Celular, Tipo, Termos, Senha) VALUES ('$nome', '$email', '$celular', '$necessita', $deAcordo, '$senha')";
        
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        if(!isset($_SESSION)) {
            session_start();
        }

        $sql_code = "SELECT Id FROM usuario WHERE Email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $_SESSION['id'] = $sql_query->fetch_assoc()['Id'];

        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;
        $_SESSION['necessita'] = $necessita;
        $_SESSION['deAcordo'] = $deAcordo;
        $_SESSION['celular'] = $celular;
        $_SESSION['senha'] = $senha;
        header('Location: http://localhost/projeto%20api/perfil.php');
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imobiliaria</title>
    <script src="scripts/form.js"></script>
    <link rel="stylesheet" href="Styles/form.css">
    <link rel="stylesheet" href="Styles/index.css">
    <link rel="icon" type="image/png" href="Images/projectIcon.png">
</head>

<body>
    <div class="Header">
        <div>Imobiliaria</div>
        <div class="navLinks">
            <a href="index.php">Mostruario</a>
            <a class="active" href="signIn.php">Cadastro</a>
            <?php if(isset($_SESSION['email'])) echo "<a href='perfil.php'>Perfil</a>"?>
            <a href="about.php">Sobre nós</a>
            <?php if(isset($_SESSION['email'])) echo "<a href='logout.php'>Sair</a>"?>
        </div>
    </div>
    <div class="content">
        <div style="display: flex; margin-top: 20px; width: 1000px; justify-content: space-evenly;">
            <div class="contact-form">
                <h3 class="titleBottom">Cadastro </h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name"><i class="fa fa-user" aria-hidden="true"></i></label>
                        <input type="text" name="Nome" id="name" placeholder="Seu Nome" required>
                    </div><br>
                    <div class="form-group">
                        <label for="email"><i class="fa fa-envelope" aria-hidden="true"></i></label>
                        <input type="email" name="Email" id="email" placeholder="Seu Email" required>
                    </div><br>
                    <div class="form-group">
                        <label for="senha"></label>
                        <input type="password" name="Senha" id="senha" placeholder="Sua senha" required>
                    </div><br>
                    <div class="form-group">
                        <label for="celular"><i class="fa fa-phone" aria-hidden="true"></i></label>
                        <input type="phone" name="Celular" id="celular" pattern="\(\d{2}\)\s\d{4,5}-\d{4}$"
                            onkeydown="return mascaraTelefone(event)" placeholder="Seu celular" title="(xx) xxxxx-xxxx"
                            required>
                    </div><br>
                    <div class="form-group">
                        <input type="radio" id="comprador" name="Necessita" value="comprador" class="radioBtn" required>
                        <label for="comprador">Comprar</label>

                        <input type="radio" id="vendedor" name="Necessita" value="vendedor" class="radioBtn">
                        <label for="vendedor">Vender</label>
                    </div><br>
                    <div class="form-group">
                        <input type="checkbox" name="De acordo" id="agree-term" class="agree-term" required />
                        <label for="agree-term" class="label-agree-term"><span><span></span></span>Eu concordo com os <a
                                onclick="openModal()" class="term-service">termos de serviço</a></label>
                    </div><br>
                    <div class="form-group form-button">
                        <input type="submit" class="form-submit">
                        <input type="reset" class="form-submit" value="Limpar">
                    </div>
                </form>
            </div>
            <div class="contact-form" style="height: 260px;">
                <h3 class="titleBottom">Login </h3>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email"><i class="fa fa-envelope" aria-hidden="true"></i></label>
                        <input type="email" name="EmailN" id="email" placeholder="Seu Email" required>
                    </div><br>
                    <div class="form-group">
                        <label for="senha"></label>
                        <input type="password" name="SenhaN" id="senha" placeholder="Sua senha" required>
                    </div><br>
                    <div class="form-group form-button">
                        <input type="submit" class="form-submit">
                        <input type="reset" class="form-submit" value="Limpar">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="modal-background" class="modalBackground"></div>
    <div id="modal-box" class="modalBox">
        <h1 class="modalTitle">Termos de Serviço Imobiliária</h1>
        <ol class="modalContent">
            <li> O usuário concorda em cumprir todas as leis locais aplicáveis em relação à locação e compra de imóveis.
            </li>
            <li> A empresa não se responsabiliza por discrepâncias nas informações dos imóveis listados.</li>
            <li> Todos os pagamentos devem ser realizados conforme os métodos aceitos pela empresa.</li>
            <li> A violação de qualquer termo resultará na rescisão do serviço sem aviso prévio.</li>
            <li> A empresa reserva o direito de modificar os termos a qualquer momento.</li>
            <li> O uso contínuo do serviço após alterações constitui aceitação dos novos termos.</li>
            <li> A empresa não é responsável por danos indiretos ou consequentes decorrentes do uso do serviço.</li>
            <li> Informações confidenciais devem ser mantidas em sigilo, exceto quando exigido por lei.</li>
            <li> Reclamações devem ser submetidas por escrito dentro de um prazo específico após o incidente.</li>
            <li> Estes termos constituem o acordo integral entre o usuário e a empresa.</li>
        </ol>
        <div class="cardBtn" onclick="closeModal()">Li e concordo</div>
    </div>
</body>

</html>