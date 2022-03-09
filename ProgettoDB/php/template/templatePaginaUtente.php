<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
        <link rel="stylesheet" href="../css/styleHome.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
  <!-- icone-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
        <a class="mb-3" href="./creaConferenza.php" style="color: black; text-decoration: none;" >• Creazione Nuova Conferenza / Sessione</a>
        <a class="mb-3" href="./insertPresentazione.php"  style="color: black; text-decoration: none;" >&emsp;• Inserimento Presentazione</a>
        <a class="mb-3" href="./associazioni.php" style="color: black; text-decoration: none;" >&emsp;• Associazioni Utenti-Presentazioni</a>
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
      
        <br>
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