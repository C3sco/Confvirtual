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
.parallax {
  /* The image used */
  background-image: url("../resources/imgconf2.jpg");
  opacity: 0.9;

  /* Set a specific height */
  min-height: 700px; 

  /* Create the parallax scrolling effect */
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}
.caption{
    position: absolute;
    left: 0;
    top: 50%;
    width: 100%;
    text-align: center;
    color: #000;
}
.parallax2{
    /* The image used */
        background-image: url("../resources/stats.png");
        opacity: none;
      
        /* Set a specific height */
        min-height: 400px; 
      
        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      }
.parallax3{
    /* The image used */
        background-image: url("../resources/img4.png");
        opacity: 0.9;
      
        /* Set a specific height */
        min-height: 600px; 
      
        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      }
</style>
</head>
<body>
    <ul>
        <li style="float:right"><a class="active" href="../html/paginaIniziale.html"><i class="fa fa-home"></i></a></li>
        <li><a href="../php/login.php">Login</a></li>
        <li><a href="../php/register.php">Registrazione</a></li>
        <li> <p style="color: white"><?php echo $templateParams["conferenze"][0]["NumConf"]?></p></li>
        <li> <p style="color: white"><?php echo $templateParams["conferenzeAttive"][0]["NumConfAtt"]?></p></li>
        <li> <p style="color: white"><?php echo $templateParams["utenti"][0]["NumUtenti"]?></p></li>
      </ul>

<div class="parallax">
    <div class="caption"></div>
</div>

<div id="grad1"style="text-align:center;">
     
</div>

<div class="parallax2"></div>
</div>

<div id="grad1"style="text-align:center;">
</div>

<div class="parallax3"></div>
</div>

</body>
</html>