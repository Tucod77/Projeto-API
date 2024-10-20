<?php
include('conectaBD.php');

if(!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="Styles/index.css">
    <link rel="stylesheet" href="Styles/about.css">
    <link rel="icon" type="image/png" href="Images/projectIcon.png">
</head>
<body>
    <div class="Header">
        <div>Imobiliaria</div>
        <div class="navLinks">
            <a href="index.php">Mostruario</a>
            <a href="signIn.php">Cadastro</a>
            <?php if(isset($_SESSION['email'])) echo "<a href='perfil.php'>Perfil</a>"?>
            <a class="active" href="about.php">Sobre nós</a>
            <?php if(isset($_SESSION['email'])) echo "<a href='logout.php'>Sair</a>"?>
        </div>
    </div>
    <div class="content">
        <div class="about">
        <img class="bannerImg" src="Images/heroBanner.jpg" />
        <div class="bannerMsg">
            <b>Uma imobiliaria que busca tirar nota máxima neste trabalho.</b>
        </div>
        <div class="aboutUs">
            <img class="aboutUsImg" src="Images/eu.jpg" />
            <div class="aboutUsMsg">
                <b class="aboutUsTitle">Sobre nós</b>
                <div class="aboutUsBody">Bem-vindo à Imobiliária desenvolvida por Arthur Pacheco Alberge,
                    aqui os nossos imóveis são tão bons que até parecem mentira! Fundada por um estudante 
                    visionário que percebeu que o mercado imobiliário estava muito sério, decidimos 
                    adicionar um pouco de diversão à busca pelo lar perfeito.
                    <br/>
                    <br/>
                    Nossa fundador é estudante de Fundamentos de Programação Web, especialista 
                    em propriedades imaginárias, mestre em negociações hipotéticas e consultor 
                    financeiro de Monopoly. Garanto que você encontre a casa dos seus sonhos - 
                    mesmo que ela só exista nos seus sonhos!
                </div>
            </div>
        </div>
</div>
    </div>
    
</body>
</html>