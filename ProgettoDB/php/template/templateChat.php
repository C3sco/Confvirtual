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

                <h1 style="margin-bottom: 40px;">Chat Sessione</h1>

                <div class="card" style="margin-bottom: 20px;">
                    <div class="card-body">
                        <?php foreach($templateParams['messaggi'] as $messaggio): ?>
                            <p class="card-text">Utente: <?php echo $messaggio["UsernameUtente"]?></p>
                            <p class="card-text">Data: <?php echo $messaggio["DataMessaggio"]?></p>
                            <p class="card-text"> Testo: <?php echo $messaggio["TestoMessaggio"]?></p>
                            <hr>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div><br><br>
        <br><hr><br>

        <div class="row">
            <div class="col-md-1"></div>  
            <div class="col-md-10">

                <h1 style="margin-top: 40px; margin-bottom: 40px;"> Aggiungi messaggio alla chat </h1>

                <h4 class="mb-3">
                <form method="post" action="./messaggio.php?codiceSessione=<?php echo $codiceSessione?>">

                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Testo:</label>
                        <input type="text" class="form-control" id="testo" name="testo">
                    </div>

                    <div class="col-md-6"></div>

                    <div class="col-md-6"><br>
                        <button type="submit" name="btnInserisciMessaggio" class="btn btn-primary">Invia</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>