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

    <h1 style="margin-bottom: 40px;">Valutazioni Presentazioni</h1>

    <?php foreach($templateParams['presentazioni'] as $presentazione): ?>

      <div class="card" style="margin-bottom: 20px;">

      <?php if($dbh -> getTutorialByCodice($presentazione["CodicePresentazione"])!=null):?>
        <h5 class="card-header">Presentazione: <?php echo $presentazione["CodicePresentazione"]  . " - " . $dbh -> getTutorialByCodice($presentazione["CodicePresentazione"])[0]["Titolo"]?></h5>
      <?php elseif($dbh -> getArticoloByCodice($presentazione["CodicePresentazione"])!=null):?>
        <h5 class="card-header">Presentazione: <?php echo $presentazione["CodicePresentazione"] . " - " . $dbh -> getArticoloByCodice($presentazione["CodicePresentazione"])[0]["Titolo"]?></h5>
      <?php endif; ?>

        <div class="card-body">
          <?php foreach($dbh->getValutazioniByPresentazione($presentazione["CodicePresentazione"]) as $valutazione): ?>
          <p class="card-text">Utente: <?php echo $valutazione["UsernameUtente"]?></p>
          <p class="card-text">Voto: <?php echo $valutazione["Voto"]?></p>
          <p class="card-text"> Note: <?php echo $valutazione["Note"]?></p>
          <hr>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>