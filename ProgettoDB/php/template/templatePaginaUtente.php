<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/styleHome.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
        <li style="float:right"><a class="active" href="../html/paginaIniziale.html"><i class="fa fa-home"></i></a></li>
        <li><a href="../php/logout.php">Logout</a></li>

      </ul>

<div class="parallax">
    <h1>Conferenze</h1>
    <?php foreach($templateParams['conferenze'] as $conferenza): ?>
    <a href="conferenza.php?nome=<?php echo $conferenza["Nome"]?>"><?php echo $conferenza["Nome"]?></a>
    <h3>Acronimo: <?php echo $conferenza["Acronimo"]?></h3>
    <h3>AnnoEdizione: <?php echo $conferenza["AnnoEdizione"]?></h3>
    <h3>Logo: <?php echo $conferenza["Logo"]?></h3>
    <?php foreach($dbh->getDateConferenza($conferenza["Nome"]) as $data): ?>
    <h3>Giorno: <?php echo $data["Giorno"]?></h3>
    <?php endforeach; ?>


  <?php endforeach; ?>
</div>

</body>
</html>