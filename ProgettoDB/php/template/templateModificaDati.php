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
          <h1><br><br>Inserimento Dati</h1><br>
          
          <h4 class="mb-3">
            <form action="./DatiPresenter.php" method="post" class="row g-3">
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nome Uni:</label>
                <input type="text" class="form-control" id="nomeUni" name="nomeUni">
              </div>

              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nome Dipartimento:</label>
                <input type="text" class="form-control" id="nomeDipartimento" name="nomeDipartimento">
              </div>
              

              <div class="col-md-6">
                  <label for="formFile" class="form-label">Curriculum</label>
                  <input class="form-control" type="file" id="curriculum" name="curriculum">
             </div>     

              <div class="col-md-6">    
                  <label for="formFile" class="form-label">Foto</label>
                  <input class="form-control" type="file" id="foto" name="foto">
                </div>              
              

              <div class="col-md-3">
                <br>
                <button type="submit" name="btnInserisciDati" class="btn btn-primary">Inserisci</button>
              </div>
                                
              </div>
            </form>
        </div>

        <br><br>
        <hr>

        <div class="row">
        
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <h1><br>Modifica Dati</h1><br>
          
          <h4 class="mb-3">
            <form action="./DatiPresenter.php" method="post" class="row g-3">
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nome Uni:</label>
                <input type="text" class="form-control" id="nomeUni" name="nomeUni">
              </div>

              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nome Dipartimento:</label>
                <input type="text" class="form-control" id="nomeDipartimento" name="nomeDipartimento">
              </div>
              

              <div class="col-md-6">
                  <label for="formFile" class="form-label">Curriculum</label>
                  <input class="form-control" type="file" id="curriculum" name="curriculum">
             </div>     

              <div class="col-md-6">    
                  <label for="formFile" class="form-label">Foto</label>
                  <input class="form-control" type="file" id="foto" name="foto">
                </div>              
              

              <div class="col-md-3">
                <br>
                <button type="submit" name="btnModificaDati" class="btn btn-primary">Modifica</button>
              </div>
                                
              </div>
            </form>
        </div>

        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>

