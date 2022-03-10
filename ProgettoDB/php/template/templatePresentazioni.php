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

    <div class="row">

        <div class="col-md-1"></div>  
        <div class="col-md-10">

    <h1 style="margin: 40px;">Presentazioni della sessione </h1>

    <?php if (isset($templateParams['msgValutazione'])): ?>
              <div class="alert alert-info" role="alert">
                <div class="row">
                  <div class="col-8 col-md-6">
                    <h4><?php echo ($templateParams['msgValutazione'])?></h4>
                  </div> 
                </div>
              </div>
    <?php endif; ?>

    <?php if (isset($templateParams['msgErrVal'])): ?>
              <div class="alert alert-danger" role="alert">
                <div class="row">
                  <div class="col-8 col-md-6">
                    <h4><?php echo ($templateParams['msgErrVal'])?></h4>
                  </div> 
                </div>
              </div>
    <?php endif; ?>

    <?php foreach($templateParams['presentazioni'] as $presentazione): ?>

      <div class="card" style="margin-bottom: 20px;">

      <?php if($dbh->getArticoloByCodice($presentazione["Codice"])): ?>
        <?php foreach($dbh->getArticoloByCodice($presentazione["Codice"]) as $articolo): ?>
        <h5 class="card-header"><?php echo $presentazione["Codice"] . " - " . $articolo["Titolo"]?></h5>
          <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text">Orario di inizio: <?php echo $presentazione["Inizio"]?></p>
            <p class="card-text">Orario di fine: <?php echo $presentazione["Fine"]?></p>
            <p class="card-text">Numero di sequenza nella sessione: <?php echo $presentazione["NumeroSequenza"]?></p>
            <p class="card-text">Numero pagine: <?php echo $articolo["NumeroPagine"]?></p>
            <p class="card-text">Presenter: <?php echo $articolo["UsernameUtente"]?></p>
        <?php endforeach; ?>

      <?php elseif($dbh->getTutorialByCodice($presentazione["Codice"])): ?>
        <?php foreach($dbh->getTutorialByCodice($presentazione["Codice"]) as $tutorial): ?>
        <h5 class="card-header"><?php echo $presentazione["Codice"] . " - " . $tutorial["Titolo"]?></h5>
          <div class="card-body">
            <h5 class="card-title"></h5>
            <p class="card-text">Orario di inizio: <?php echo $presentazione["Inizio"]?></p>
            <p class="card-text">Orario di fine: <?php echo $presentazione["Fine"]?></p>
            <p class="card-text">Numero di sequenza nella sessione: <?php echo $presentazione["NumeroSequenza"]?></p>
            <p class="card-text">Abstract: <?php echo $tutorial["Abstract"]?></p>
            <p class="card-text">Speaker:</p>
        <?php endforeach; ?>
      <?php endif; ?>

    
        <?php if(isset($templateParams["amministratore"])): ?>

            <form method="post" action="./valutazione.php?presentazione=<?php echo $presentazione["Codice"]?>&codiceSessione=<?php echo $codiceSessione?>">

            <div class="col-md-4">
                <label for="inputEmail4" class="form-label">Voto:</label>
                <input type="text" class="form-control" id="voto" name="voto">
            </div>

            <div class="col-md-4">
                <label for="inputEmail4" class="form-label">Note:</label>
                <input type="text" class="form-control" id="note" name="note">
            </div>
              
            <div class="col-md-4">
              <br>
                <button class="btn btn-primary" type="submit" name="btnVoto">Valuta Presentazione</button>
            </div>
            </form>
        <?php endif;?>

    </div>
    </div>
    <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
        
        
 