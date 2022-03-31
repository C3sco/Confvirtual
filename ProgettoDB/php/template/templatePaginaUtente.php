<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
    <link rel="stylesheet" href="../css/styleHome.css">
    <link rel="stylesheet" href="../css/button.css">
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
    <li style="float:right"><a href="../php/home.php"><i class="fa fa-home"></i></a></li>
      <li style="float:right"><a href="../php/logout.php">Logout</a></li>
    </ul>

    <div class="row">
      <div class="col-md-1"></div>  
      <div class="col-md-10">

        <?php if (isset($templateParams['msg'])): ?>
          <div class="alert alert-info" role="alert">
            <div class="row">
              <div class="col-8 col-md-6">
                <h4><?php echo ($templateParams['msg'])?></h4>
              </div> 
            </div>
          </div>
        <?php endif; ?>
        <?php if (isset($templateParams['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <div class="row">
              <div class="col-8 col-md-6">
                <h4><?php echo ($templateParams['error'])?></h4>
              </div> 
            </div>
          </div>
          <?php endif; ?>

          <center>
          <div class="card" style="width: 80rem; height:12rem; margin: 10px;">
        <h2 style="margin: 20px;"><b><center>Operazioni Utente</center></b></h2>
        <h3>
        <form method="get" action="./lista.php">
             <button class="butt" style="color: black; text-decoration: none;" >&emsp; Visualizzazione e Inserimento Lista Presentazioni Favorite</a>
             </button></form>
          <br>  <br>
        </h3></div></center>
        <br>
    
        <?php if(isset($templateParams["speaker"])): ?>

          <center>
          <div class="card" style="width: 80rem; height:17rem; margin: 10px;">
          <h2 style="margin: 20px;"><b><center>Operazioni Speaker</center></b></h2>
            <par>
          
            <form method="get" action="./modificaDati.php">
             <button class="butt" style="color: black; text-decoration: none;" >&emsp; Inserimento e Modifica Dati Personali</a>
             </button></form>
             <form method="get" action="./creaRisorsa.php">
             <button class="butt" style="color: black; text-decoration: none;" >&emsp; Inserimento e Modifica Risorse Aggiuntivee</a>
             </button></form><form method="get" action="./associazioni.php">
             </par></div> </center>




        <?php elseif(isset($templateParams["amministratore"])): ?>
          <center>
          <div class="card" style="width: 80rem; height:27rem; margin: 10px;">
          <h2 style="margin: 20px;"><b><center>Operazioni Amministratore</center></b></h2>
            <par>
          
            <form method="get" action="./creaConferenza.php">
             <button class="butt" style="color: black; text-decoration: none;" >&emsp; Creazione Nuova Conferenza / Sessione</a>
             </button></form>
             <form method="get" action="./insertPresentazione.php">
             <button class="butt" style="color: black; text-decoration: none;" >&emsp; Inserimento Presentazione</a>
             </button></form><form method="get" action="./associazioni.php">
             <button class="butt" style="color: black; text-decoration: none;" >&emsp; Associazioni Relatori-Presentazioni</a>
             </button></form><form method="get" action="./visualizzaValutazioni.php">
             <button class="butt" style="color: black; text-decoration: none;" >&emsp; Visualizzazione Valutazioni Presentazione</a>
             </button></form><form method="get" action="./creaSponsor.php">
             <button class="butt" style="color: black; text-decoration: none;" >&emsp; Creazione e Associazione Sponsor</a>
             </button></form>
             
            
  <!--
              <a class="fs-4" href="./creaConferenza.php" style="color: black; text-decoration: none;" >&emsp;• Creazione Nuova Conferenza / Sessione</a><br>
              <a class="fs-4" href="./insertPresentazione.php"  style="color: black; text-decoration: none;" >&emsp;• Inserimento Presentazione</a><br>
              <a class="fs-4" href="./associazioni.php" style="color: black; text-decoration: none;" >&emsp;• Associazioni Relatori-Presentazioni</a><br>
              <a class="fs-4" href="./visualizzaValutazioni.php" style="color: black; text-decoration: none;" >&emsp;• Visualizzazione Valutazioni Presentazione</a><br>
              <a class="fs-4" href="./creaSponsor.php" style="color: black; text-decoration: none;" >&emsp;• Creazione e Associazione Sponsor</a><br>
              <br><hr><br> -->
              </par></div> </center>
              
        <?php elseif(isset($templateParams["presenter"])): ?>
          
          <center>
          <div class="card" style="width: 80rem; height:12rem; margin: 10px;">
          <h2 style="margin: 20px;"><b><center>Operazioni Presenter</center></b></h2>
          <h3>
        <button class="butt2">
          <a class="fs-4" href="./modificaDati.php" style="color: black; text-decoration: none;" >&emsp;Inserimento e Modifica Dati Personali</a>
        </button> <br>
          <br>  <br>
        </h3></div></center>
        </center>
        
        <?php endif?>
      </div>
    </div>
    <br>
              <br>
    <div class="row">
      <div class="col-md-1"></div>  
      <div class="col-md-10">
        <h1 style="margin: 20px; margin-top: 15px;"><b><center> Conferenze disponibili</center></b></h1>
      </div>
    </div>

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
                <a href="registrazioneConf.php?nome=<?php echo $conferenza["Nome"]?>" class="btn btn-outline-danger">Registrati alla conferenza</a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </body>
</html>