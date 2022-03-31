<!DOCTYPE html>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <meta charset="utf-8">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/styleHome.css">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>

    <body>
        <ul>
            <li style="float:right"><a href="../php/home.php"><i class="fa fa-home"></i></a></li>
            <li style="float:right"><a href="../php/register.php">Registrazione</a></li>
        </ul>

        <?php if (isset($templateParams['errorelogin'])): ?>
          <div class="alert alert-danger" role="alert">
            <div class="row">
              <div class="col-8 col-md-6">
                <h4><?php echo ($templateParams['errorelogin'])?></h4>
              </div> 
            </div>
          </div>
        <?php endif; ?>

        <form method="post" action="../php/login.php">
            <h3>Login</h3>

            <input type="text" placeholder="Username" name="username" id="username">
            <input type="password" placeholder="Password" name="password" id="password">

            <button type="submit" name="login">Accedi</button>
        </form>
    </body>
</html>