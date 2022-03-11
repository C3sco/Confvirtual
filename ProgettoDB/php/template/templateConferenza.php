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
        <li style="float:right"><a href="../php/paginaUtente.php"><i class="fa fa-home"></i></a></li>
        <li style="float:right"><a href="../php/logout.php">Logout</a></li>
    </ul>

    <div class="row">

        <div class="col-md-1"></div>  
        <div class="col-md-10">

    <h1 style="margin: 40px;">Sessioni giornaliere della conferenza </h1>

    <?php foreach($templateParams['sessione'] as $sessione): ?>

      <div class="card" style="margin-bottom: 20px;">
      <h5 class="card-header"><?php echo $sessione["Codice"] . " - " . $sessione["Titolo"]?></h5>
      <div class="card-body">
        <h5 class="card-title">Data: <?php echo $sessione["GiornoGiornata"]?></h5>
        <p class="card-text">Orario di inizio: <?php echo $sessione["Inizio"]?></p>
        <p class="card-text">Orario di fine: <?php echo $sessione["Fine"]?></p>
        <p class="card-text">Link alla stanza Teams: <?php echo $sessione["Link"]?></p>
        <p class="card-text">Numero Presentazioni: <?php echo $sessione["NumeroPresentazioni"]?></p>
        <a href="presentazioni.php?codiceSessione=<?php echo $sessione["Codice"]?>" class="btn btn-primary">Visualizza Presentazioni</a>
        <a href="chat.php?codiceSessione=<?php echo $sessione["Codice"]?>" class="btn btn-primary">Chat</a>
    </div>
    </div>
    <?php endforeach; ?>
    </div>
  </div>
</body>
</html>