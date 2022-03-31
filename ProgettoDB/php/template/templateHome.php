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
        <li style="float:right"><a href="../php/register.php">Registrazione</a></li>
        <li style="float:right"><a href="../php/login.php">Login</a></li>   
      </ul>

    <div class="container py-4">
      <header class="pb-3 mb-4 border-bottom">
      
        <span class="display-5"><b><i><center>CONFVIRTUAL</center></i></b></span>
        
      </header>

      <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
          <h1 class="display-7 fw-bold">Statistiche</h1>
          <p class="col-md-8 fs-5">Conferenze registrate: <?php echo $templateParams["conferenze"][0]["NumConf"]?></p>
          <p class="col-md-8 fs-5">Conferenze attive: <?php echo $templateParams["conferenzeAttive"][0]["NumConfAtt"]?></p>
          <p class="col-md-8 fs-5">Utenti registrati: <?php echo $templateParams["utenti"][0]["NumUtenti"]?></p>
        </div>
      </div>

      <div class="row align-items-md-stretch">
        <div class="col-md-6">
          <div class="h-100 p-5 text-white bg-dark rounded-3">
            <h2>Classifica Presenter</h2>
            <ol>
              <?php foreach($templateParams['presenter'] as $presenter): ?>
                <li><?php echo $presenter['UsernameUtente'] . " - Voto: " . $presenter['Media'];?></li> <br>
              <?php endforeach; ?>     
            </ol>
          </div>
        </div>

        <div class="col-md-6">
          <div class="h-100 p-5 bg-light border rounded-3">
            <h2>Classifica Speaker</h2>
            <ol>
              <?php foreach($templateParams['speaker'] as $speaker): ?>
                <li><?php echo $speaker['UsernameUtente'] . " - Voto: " . $speaker['Media'];?></li><br>
              <?php endforeach; ?>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <a href="../template/titolo.html">.</a>
  </body>
</html>