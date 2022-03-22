<!DOCTYPE html>
<html>
    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

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
            <li style="float:right"><a href="../php/login.php">Login</a></li>
        </ul>

        <form method="post" action="../php/register.php">
            <h3>Registrazione</h3>
            <input type="text" id="username" placeholder="Username" name="username" maxlength="50" required>
            <input type="password" id="password" placeholder="Password" name="password" required>
            <input type="text" id="nome" placeholder="Nome" name="nome" required>
            <input type="text" id="cognome" placeholder="Cognome" name="cognome" required>
            <input type="date" id="datanascita" placeholder="Data Nascita" name="datanascita" required>
            <input type="text" id="luogonascita" placeholder="Luogo Nascita" name="luogonascita" required>
            
            <label for="">Tipologia Utente:</label>
            <select style="background-color: rgba(255, 255, 255, 0.13);" class="form-select" name="tipo" >
                <option value="Utente Generico">Utente Generico</option>
                <option value="Speaker">Speaker</option>
                <option value="Presenter">Presenter</option>
                <option value="Amministratore">Amministratore</option>
            </select>
            <br>
            <button type="submit" name="register">Registrati</button>
        </form>
    </body>
</html>