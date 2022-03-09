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

    <h1>Valutazioni Presentazioni:</h1>
    <?php foreach($templateParams['presentazioni'] as $presentazione): ?>
      
      <h3>Presentazione: <?php echo $presentazione["CodicePresentazione"] ?></h3>
      
      <?php if($dbh -> getTutorialByCodice($presentazione["CodicePresentazione"])!=null):?>
        <h3><?php echo $dbh -> getTutorialByCodice($presentazione["CodicePresentazione"])[0]["Titolo"]?></h3>
      <?php elseif($dbh -> getArticoloByCodice($presentazione["CodicePresentazione"])!=null):?>
        <h3><?php echo $dbh -> getArticoloByCodice($presentazione["CodicePresentazione"])[0]["Titolo"]?></h3>
      <?php endif; ?>

      <?php foreach($dbh->getValutazioniByPresentazione($presentazione["CodicePresentazione"]) as $valutazione): ?>
      <h4>Utente: <?php echo $valutazione["UsernameUtente"]?></h4>
      <h4>Voto: <?php echo $valutazione["Voto"]?></h4>
      <h4>Note: <?php echo $valutazione["Note"]?></h4>
      <br>

      <?php endforeach; ?>

      
    <?php endforeach; ?>

<div class="parallax">

</div>

</body>
</html>