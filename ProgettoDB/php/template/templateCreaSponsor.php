<!DOCTYPE html>
<html>
<head>

<link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/carousel/">

<!-- Bootstrap core CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  
<!-- icone-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="../css/styleHome.css">

<style>
#grad1 {
  height: 500px;
  background-color: rgb(255, 255, 255); /* For browsers that do not support gradients */
  /*background-image: linear-gradient(180deg, rgb(199, 199, 199), rgb(90, 90, 90));*/
}
</style>

</head>
<body>
    <ul>
        <li><a href="../php/logout.php">Logout</a></li>

    </ul>
    <div class="row">
        
        <div class="col-md-1"></div>
        <div class="col-md-10">
          <h1><br><br>Inserimento Sponsor</h1><br>
          
            <form action="./creaSponsor.php" method="post" class="row g-3">
              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome">
              </div>

              <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Importo:</label>
                <input type="text" class="form-control" id="importo" name="importo">
              </div>
              
              <div class="col-md-6">
                  <label for="formFile" class="form-label">Logo:</label>
                  <input class="form-control" type="file" id="logo" name="logo">
             </div>     
              <div class="col-md-6"></div> 
              <div class="col-md-6">
                <br>
                <button type="submit" name="btnInserisciSponsor" class="btn btn-primary">Aggiungi</button>
              </div>
                                
              </div>
            </form>
        </div>
        <br><br>
        <hr>

        <div class="row">
        
        <div class="col-md-1"></div>
        <div class="col-md-10">

          <h1><br>Associazione Conferenza - Sponsor</h1><br>
          
          <h4 class="mb-3">
            <form action="./creaSponsor.php" method="post" class="row g-3">

            <div class="col-md-6">
                  <label for="inputPassword4" class="form-label">Conferenza:</label>
                  <select class="form-select" name="conferenza" >
                    <option value=""></option>
                    <?php foreach($templateParams['conferenze'] as $conferenza): ?>
                    <option value="<?php echo $conferenza['Nome']; ?>"><?php echo $conferenza['Nome']?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-6">
                  <label for="inputPassword4" class="form-label">Sponsor:</label>
                  <select class="form-select" name="nome" >
                    <option value=""></option>
                    <?php foreach($templateParams['sponsor'] as $sponsor): ?>
                    <option value="<?php echo $sponsor['Nome']; ?>"><?php echo $sponsor['Nome']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

              <div class="col-md-6">
                <br>
                <button type="submit" name="btnAssociaSponsor" class="btn btn-primary">Associa</button>
              </div>
                                
              </div>
            </form>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>

