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

        <?php if (isset($templateParams['msgPresentazione'])): ?>
              <div class="alert alert-info" role="alert">
                <div class="row">
                  <div class="col-8 col-md-6">
                    <h4><?php echo ($templateParams['msgPresentazione'])?></h4>
                  </div> 
                </div>
              </div>
        <?php endif; ?>

        <?php if (isset($templateParams['msgErrore'])): ?>
                  <div class="alert alert-danger" role="alert">
                    <div class="row">
                      <div class="col-8 col-md-6">
                        <h4><?php echo ($templateParams['msgErrore'])?></h4>
                      </div> 
                    </div>
                  </div>
        <?php endif; ?>

          <h1><br><br>Inserimento delle presentazioni in una sessione</h1><br>
          
          <h4 class="mb-3">
            <form action="./insertPresentazione.php" method="post" class="row g-3">

            <div class="col-md-6">
                  <label for="inputPassword4" class="form-label">Sessione:</label>
                  <select class="form-select" name="sessione" >
                    <option value=""></option>
                    <?php foreach($templateParams['sessioni'] as $sessione): ?>
                    <option value="<?php echo $sessione['Codice']; ?>"><?php echo $sessione['Codice'] . " - " . $sessione['Titolo']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="inputPassword4" class="form-label">Presentazione:</label>
                  <select class="form-select" name="presentazione" >
                    <option value=""></option>
                    <?php foreach($templateParams['presentazioni'] as $presentazione): ?>
                    <option value="<?php echo $presentazione['Codice']; ?>"><?php echo $presentazione['Codice']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

              <div class="col-md-6">
                <br>
                <button type="submit" name="btnInserisciPresentazione" class="btn btn-primary">Inserisci</button>
              </div>
                                
              </div>
            </form>
     
    </body>
</html>