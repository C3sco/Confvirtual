<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/styleHome.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
#grad1 {
  height: 500px;
  background-color: rgb(255, 255, 255); /* For browsers that do not support gradients */
  /*background-image: linear-gradient(180deg, rgb(199, 199, 199), rgb(90, 90, 90));*/
}
</style>
</head>
<body>
    <ul>
        <li style="float:right"><a class="active" href="../html/paginaIniziale.html"><i class="fa fa-home"></i></a></li>
        <li><a href="../php/logout.php">Logout</a></li>

    </ul>

    <button type="button" class="btn btn-outline-secondary"><a class="text-reset" href="registrazioneConf.php?nome=<?php echo $nomeConf?>">Registrati alla conferenza</a></button>
    <h1>Sessioni della conferenza:</h1>
    <?php foreach($templateParams['sessione'] as $sessione): ?>
    <h3>Codice: <?php echo $sessione["Codice"]?></h3>
    <h3>Titolo: <?php echo $sessione["Titolo"]?></h3>
    <h3>NumeroPresentazioni: <?php echo $sessione["NumeroPresentazioni"]?></h3>
    <h3>Ora inizio: <?php echo $sessione["Inizio"]?></h3>
    <h3>Ora fine: <?php echo $sessione["Fine"]?></h3>
    <h3>Link: <?php echo $sessione["Link"]?></h3>

  <?php endforeach; ?>

<div class="parallax">

</div>

</body>
</html>