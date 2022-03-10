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
    <h1 style="margin: 30px;">Operazioni Disponibili Speaker:</h1>
      <h3>
        <a class="mb-3" href="./modificaDati.php" style="color: black; text-decoration: none;" >&emsp;• Inserimento e Modifica Dati Personali</a> <br>
        <a class="mb-3" href="./archivio-admin-ordini.php"  style="color: black; text-decoration: none;" >&emsp;• Inserimento e Modifica Risorse Aggiuntive</a><br>
        <br>
      </h3>

  <?php elseif(isset($templateParams["amministratore"])): ?>
    <h1 style="margin: 30px;">Operazioni Disponibili Amministratore:</h1>
      <h3>
        <a class="mb-3" href="./creaConferenza.php" style="color: black; text-decoration: none;" >&emsp;• Creazione Nuova Conferenza / Sessione</a><br>
        <a class="mb-3" href="./insertPresentazione.php"  style="color: black; text-decoration: none;" >&emsp;• Inserimento Presentazione</a><br>
        <a class="mb-3" href="./associazioni.php" style="color: black; text-decoration: none;" >&emsp;• Associazioni Utenti-Presentazioni</a><br>
        <a class="mb-3" href="./visualizzaValutazioni.php" style="color: black; text-decoration: none;" >&emsp;• Visualizzazione Valutazioni Presentazione</a><br>
        <a class="mb-3" href="./creaSponsor.php" style="color: black; text-decoration: none;" >&emsp;• Creazione Sponsor</a><br>
        <br>
      </h3>

  <?php elseif(isset($templateParams["presenter"])): ?>
    <h1 style="margin: 30px;">Operazioni Disponibili Presenter:</h1>
      <h3>
        <a class="mb-3" href="./modificaDati.php" style="color: black; text-decoration: none;" >&emsp;• Inserimento e Modifica Dati Personali</a><br>
        <br>
      </h3>
  <?php endif?>
    <hr>  
    <h1 style="margin: 30px;"> Conferenze disponibili</h1>
    <div class="container">
    <div class="row">
    <?php foreach($templateParams['conferenze'] as $conferenza): ?>
      
        <div class="col-4">
          <div class="card" style="width: 25rem; margin: 10px;">
            <img src="../ImgDB/<?php echo $conferenza["Logo"]?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $conferenza["Nome"]?></h5>
              <p class="card-text">Acronimo: <?php echo $conferenza["Acronimo"]?></p>
              <p class="card-text">Giornate di svolgimento:</p>
              <?php foreach($dbh->getDateConferenza($conferenza["Acronimo"]) as $data): ?>
                <p class="card-text"><?php echo $data["Giorno"]?></p>
              <?php endforeach; ?>
              <p class="card-text">Numero di Sponsor: <?php echo $conferenza["TotaleSponsorizzazioni"]?></p>
              <a href="conferenza.php?nome=<?php echo $conferenza["Nome"]?>" class="btn btn-primary">Dettagli</a>
            </div>
          </div>
        </div>
      
    <?php endforeach; ?>
    </div>

    </div>
      
</div>

</body>
</html>