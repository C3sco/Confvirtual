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
        <li><a href="../php/logout.php">Logout</a></li>

      </ul>

<div class="parallax">
  
  <?php if(isset($templateParams["speaker"])): ?>
    <h1>Operazioni Disponibili Speaker:</h1>
      <h3>
        <a class="mb-3" href="./modificaDati.php" style="color: black; text-decoration: none;" >• Inserimento e Modifica Dati Personali</a>
        <a class="mb-3" href="./archivio-admin-ordini.php"  style="color: black; text-decoration: none;" >&emsp;• Inserimento e Modifica Risorse Aggiuntive</a>
      </h3>

  <?php elseif(isset($templateParams["amministratore"])): ?>
    <h1>Operazioni Disponibili Amministratore:</h1>
      <h3>
        <a class="mb-3" href="./archivio-modifica-art.php" style="color: black; text-decoration: none;" >• Creazione Nuova Conferenza</a>
        <a class="mb-3" href="./archivio-inserimentoArt.php"  style="color: black; text-decoration: none;" >&emsp;• Creazione Nuova Sessione</a>
        <a class="mb-3" href="./archivio-admin-ordini.php"  style="color: black; text-decoration: none;" >&emsp;• Inserimento Presentazione</a>
        <a class="mb-3" href="./archivio-Ordini.php" style="color: black; text-decoration: none;" >&emsp;• Associazione Speaker-Presentazione Tutorial</a>
        <a class="mb-3" href="./archivio-Ordini.php" style="color: black; text-decoration: none;" >&emsp;• Associazione Presenter-Presentazione Articolo</a>
        <a class="mb-3" href="./archivio-Ordini.php" style="color: black; text-decoration: none;" >&emsp;• Inserimento Valutazioni Presentazione</a>
        <a class="mb-3" href="./archivio-Ordini.php" style="color: black; text-decoration: none;" >&emsp;• Visualizzazione Valutazioni Presentazione</a>
        <a class="mb-3" href="./archivio-Ordini.php" style="color: black; text-decoration: none;" >&emsp;• Inserimento Sponsor</a>
        <br>
      </h3>

  <?php elseif(isset($templateParams["presenter"])): ?>
    <h1>Operazioni Disponibili Presenter:</h1>
      <h3>
        <a class="mb-3" href="./DatiPresenter.php" style="color: black; text-decoration: none;" >• Inserimento Dati Personali</a>
        <a class="mb-3" href="./archivio-inserimentoArt.php"  style="color: black; text-decoration: none;" >&emsp;• Modifica Dati Personali</a>

      </h3>
  <?php endif?>
          
    <h1>Conferenze disponibili</h1>
    <?php foreach($templateParams['conferenze'] as $conferenza): ?>
      <a href="conferenza.php?nome=<?php echo $conferenza["Nome"]?>"><?php echo $conferenza["Nome"]?></a>
      <h3>Acronimo: <?php echo $conferenza["Acronimo"]?></h3>
      <h3>Logo: <?php echo $conferenza["Logo"]?></h3>
      <h3>Giornate di svolgimento:</h3>
      <?php foreach($dbh->getDateConferenza($conferenza["Nome"]) as $data): ?>
        <h3><?php echo $data["Giorno"]?></h3>
      <?php endforeach; ?>
      <br/>
    <?php endforeach; ?>
</div>

</body>
</html>