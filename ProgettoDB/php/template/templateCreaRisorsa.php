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

        <?php if (isset($templateParams['msgAggiuntaRisorsa'])): ?>
              <div class="alert alert-info" role="alert">
                <div class="row">
                  <div class="col-8 col-md-6">
                    <h4><?php echo ($templateParams['msgAggiuntaRisorsa'])?></h4>
                  </div> 
                </div>
              </div>
        <?php endif; ?>

        <?php if (isset($templateParams['msgErrAggiuntaRisorsa'])): ?>
                  <div class="alert alert-danger" role="alert">
                    <div class="row">
                      <div class="col-8 col-md-6">
                        <h4><?php echo ($templateParams['msgErrAggiuntaRisorsa'])?></h4>
                      </div> 
                    </div>
                  </div>
        <?php endif; ?>

          <h1><br>Inserimento Dati</h1><br>
          
          <h4 class="mb-3">
            <form action="./creaRisorsa.php" method="post" class="row g-3">

              <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Tutorial:</label>
                  <select class="form-select" name="tutorial" >
                    <option value=""></option>
                    <?php foreach($templateParams['tutorial'] as $tutorial): ?>
                    <option value="<?php echo $tutorial['CodicePresentazione']; ?>"><?php echo $tutorial["CodicePresentazione"] . " - " . $tutorial['Titolo']; ?></option>
                    <?php endforeach; ?>
                  </select>
              </div>

              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Link:</label>
                <input type="text" class="form-control" id="link" name="link">
              </div>
              

              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Descrizione:</label>
                <input type="text" class="form-control" id="descrizione" name="descrizione">
             </div>     
             
             <div class="col-md-6">
            </div>
              <div class="col-md-6">
                <br>
                <button type="submit" name="btnInserisciRisorsa" class="btn btn-primary">Inserisci</button>
              </div>
              
                                
              </div>
            </form>
        </div>

        <br><br>
        <hr>

        <div class="row">
        
        <div class="col-md-1"></div>
        <div class="col-md-10">

        <?php if (isset($templateParams['msgModificaRisorsa'])): ?>
              <div class="alert alert-info" role="alert">
                <div class="row">
                  <div class="col-8 col-md-6">
                    <h4><?php echo ($templateParams['msgModificaRisorsa'])?></h4>
                  </div> 
                </div>
              </div>
        <?php endif; ?>

        <?php if (isset($templateParams['msgErrModificaRisorsa'])): ?>
                  <div class="alert alert-danger" role="alert">
                    <div class="row">
                      <div class="col-8 col-md-6">
                        <h4><?php echo ($templateParams['msgErrModificaRisorsa'])?></h4>
                      </div> 
                    </div>
                  </div>
        <?php endif; ?>

          <h1><br>Modifica Dati</h1><br>
          
          <h4 class="mb-3">
            <form action="./creaRisorsa.php" method="post" class="row g-3">

            <div class="col-md-6">
            <label for="inputPassword4" class="form-label">Tutorial:</label>
                  <select class="form-select" name="tutorial" >
                    <option value=""></option>
                    <?php foreach($templateParams['tutorial'] as $tutorial): ?>
                    <option value="<?php echo $tutorial['CodicePresentazione']; ?>"><?php echo $tutorial["CodicePresentazione"] . " - " . $tutorial['Titolo']; ?></option>
                    <?php endforeach; ?>
                  </select>
              </div>

              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Link:</label>
                <input type="text" class="form-control" id="link" name="link">
              </div>
              

              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Descrizione:</label>
                <input type="text" class="form-control" id="descrizione" name="descrizione">
             </div> 

             <div class="col-md-6">
            </div>
              <div class="col-md-6">
                <br>
                <button type="submit" name="btnModificaRisorsa" class="btn btn-primary">Modifica</button>
              </div>
                                
              </div>
            </form>
        </div>

        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>

