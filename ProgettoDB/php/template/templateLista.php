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

        <?php if (isset($templateParams['msgLista'])): ?>
          <div class="alert alert-info" role="alert">
            <div class="row">
              <div class="col-8 col-md-6">
                <h4><?php echo ($templateParams['msgLista'])?></h4>
              </div> 
            </div>
          </div>
        <?php endif; ?>

        <?php if (isset($templateParams['msgErroreLista'])): ?>
          <div class="alert alert-danger" role="alert">
            <div class="row">
              <div class="col-8 col-md-6">
                <h4><?php echo ($templateParams['msgErroreLista'])?></h4>
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

        <h1 style="margin: 40px;">Lista presentazioni favorite </h1>

        <div class="card" style="width: 18rem;">
          <ul class="list-group list-group-flush">
            <?php foreach($templateParams['lista'] as $lista): ?>
              <?php if($dbh->getArticoloByCodice($lista["CodicePresentazione"])): ?>
                  <?php foreach($dbh->getArticoloByCodice($lista["CodicePresentazione"]) as $articolo): ?>
                  <li class="list-group-item"><?php echo $lista["CodicePresentazione"] . " - " . $articolo["Titolo"]?></li>
              <?php endforeach; ?>
              <?php elseif($dbh->getTutorialByCodice($lista["CodicePresentazione"])): ?>
                  <?php foreach($dbh->getTutorialByCodice($lista["CodicePresentazione"]) as $tutorial): ?>
                  <li class="list-group-item"><?php echo $lista["CodicePresentazione"] . " - " . $tutorial["Titolo"]?></li>
              <?php endforeach; ?>
              <?php endif; ?>   
            <?php endforeach; ?>
          </ul>
        </div><br><br>
      </div>
    </div>

    <br><br><hr><br>

    <div class="row">
      <div class="col-md-1"></div>  
      <div class="col-md-10">

        <h1 style="margin: 40px;"> Aggiungi presentazione alla lista </h1>

        <h4 class="mb-3">
        <form action="./lista.php" method="post" class="row g-3">

          <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Presentazione:</label>
            <select class="form-select" name="presentazione" >
              <option value=""></option>
              <?php foreach($templateParams['presentazioni'] as $presentazione): ?>
                <?php if($dbh->getArticoloByCodice($presentazione["Codice"])): ?>
                    <?php foreach($dbh->getArticoloByCodice($presentazione["Codice"]) as $articolo): ?>
                      <option value="<?php echo $presentazione['Codice']; ?>"><?php echo $presentazione['Codice'] . " - " . $articolo["Titolo"]?></option>
                    <?php endforeach; ?>
                  <?php elseif($dbh->getTutorialByCodice($presentazione["Codice"])): ?>
                    <?php foreach($dbh->getTutorialByCodice($presentazione["Codice"]) as $tutorial): ?>
                      <option value="<?php echo $presentazione['Codice']; ?>"><?php echo $presentazione['Codice']  . " - " . $tutorial["Titolo"]?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>   
                <?php endforeach; ?>
              </select>
          </div>

          <div class="col-md-6"></div>
          
          <div class="col-md-6"><br>
            <button type="submit" name="btnInserisciLista" class="btn btn-primary">Inserisci</button>
          </div>
        
        </form>                   
      </div>
    </div>
  </body>
</html>
        
        
 