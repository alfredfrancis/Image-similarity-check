<head>
   <title>Image comparison </title>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <style>
  .container {
    width:500px;
    margin: 0 auto;

  }
  </style>
</head>
<body>
  <div class="container">
    <h1>Image Similarity check</h1>
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
function compareImages($imagePathA, $imagePathB)
{
    $bim = imagecreatefromjpeg($imagePathA);
    $bimX = imagesx($bim);
    $bimY = imagesy($bim);
    $pointsX = 30*5;
    $pointsY = 30*5;
    $sizeX = round($bimX/$pointsX);
    $sizeY = round($bimY/$pointsY);
    $im = imagecreatefromjpeg($imagePathB);
    $y = 0;
    $matchcount = 0;
    $num = 0;
    for ($i=0; $i <= $pointsY; $i++)
    {
        $x = 0;
        for($n=0; $n <= $pointsX; $n++)
        {

          $rgba = imagecolorat($bim, $x, $y);
          $colorsa = imagecolorsforindex($bim, $rgba);

          $rgbb = imagecolorat($im, $x, $y);
          $colorsb = imagecolorsforindex($im, $rgbb);

          if(colorComp($colorsa['red'], $colorsb['red']) && colorComp($colorsa['green'], $colorsb['green']) && colorComp($colorsa['blue'], $colorsb['blue']))
          {
            $matchcount ++;
          }
          $x += $sizeX;
          $num++;
      }
      $y += $sizeY;
    }
    $rating = $matchcount*(100/$num);
    return $rating;
}
function colorComp($color, $c)
{
    if($color >= $c-2 && $color <= $c+2)
    {
      return true;
    }
    else
    {
      return false;
    }
}
if (isset($_POST["a"]) && !empty($_POST["b"]))
{
  echo "Image similarity scale = ".compareImages($_POST["a"], $_POST["b"])." %";
}
else{
?>
<form name="comapre" method="post"  action="main.php">
  <input type="text" class="form-control" name="a" placeholder="Path to first Image (*.jpg)" required autofocus>
  <br>
  <input type="text" class="form-control" name="b" placeholder="Path to second Image (*.jpg)" required><br>
  <input type="submit" value="Compare" class="btn btn-lg btn-primary btn-block">
</form>
<?php
}
?>
</div>
</body>
</html>
