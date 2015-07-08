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
  First image:<br>
  <input type="text" name="a">
  <br>
  Second image:<br>
  <input type="text" name="b"><br>
  <input type="submit">
</form>
<?php
}
?>
