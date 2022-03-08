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

    <button type="button" class="btn btn-outline-secondary"><a class="text-reset" href="registrazioneConf.php?nome=<?php echo $nomeConf?>">Registrati alla conferenza</a></button>
    <h1>Sessioni giornaliere della conferenza:</h1>
    <?php foreach($templateParams['sessione'] as $sessione): ?>
      <h3>Data: <?php echo $sessione["GiornoGiornata"]?></h3>
      <h3>Codice: <?php echo $sessione["Codice"]?></h3>
      <h3>Titolo: <?php echo $sessione["Titolo"]?></h3>
      <h3>Numero Presentazioni: <?php echo $sessione["NumeroPresentazioni"]?></h3>
      <h3>Orario di inizio: <?php echo $sessione["Inizio"]?></h3>
      <h3>Orario di fine: <?php echo $sessione["Fine"]?></h3>
      <h3>Link alla stanza Teams: <?php echo $sessione["Link"]?></h3>
      <br/>
      <h1>Presentazioni della sessione:</h1>
      <?php foreach($dbh->getPresentazioniBySessione($sessione["Codice"]) as $presentazione): ?>
        <h3>Codice: <?php echo $presentazione["Codice"]?></h3>
        <h3>Orario di inizio: <?php echo $presentazione["Inizio"]?></h3>
        <h3>Orario di fine: <?php echo $presentazione["Fine"]?></h3>
        <h3>Numero di sequenza nella sessione: <?php echo $presentazione["NumeroSequenza"]?></h3>
        
        <?php if(isset($templateParams["amministratore"])): ?>

        <form method="post" action="./valutazione.php?presentazione=<?php echo $presentazione["Codice"]?>&nome=<?php echo $nomeConf?>">
      
            <input type="text" id="voto" placeholder="Voto" name="voto">
            <input type="text" id="note" placeholder="Note" name="note">

            <button type="submit" name="btnVoto">Valuta Presentazione</button>
        </form>
        <?php endif;?>
        <h3>------------------------</h3>
      <?php endforeach; ?>
      <h3>----------------------------------------------------------------</h3>
      <br/>
    <?php endforeach; ?>

<div class="parallax">

</div>

</body>
</html>