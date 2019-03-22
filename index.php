<html>
   <body>
     <h2>Fuel Calulator</h2>
     <title>FuelCalulator</title>
      <form action = "<?php $_PHP_SELF ?>" method = "GET">
         <br>Total price: <input type = "text" name = "PrixTotal" /></br>
         <br>Price per liter: <input type = "text" name = "PrixLitre" /></br>
         <br>Kilometers at the base (let 0 if you know already): <input type = "text" name = "KMmin" value="0"/></br>
         <br>Total kilometers: <input type = "text" name = "KMmax" /></br>
         <br><input type = "submit" /></br>
      </form>
      <br></br>
   </body>
</html>
<?php

//Déclaration de variable

$PrixTotal = 0;
$PrixLitre = 0;
$PrixKM = 0;
$ConsomationMoyenneAu100 = 0;
$KMmax = 0;
$KMmin = 0;
$KMTotal = 0;
$UnLitreKM = 0;
$UnKMLitre = 0;
$Litre = 0;

//Récuperation depuis les champs input

$PrixTotal = $_GET["PrixTotal"];
$PrixLitre = $_GET["PrixLitre"];
$KMmin = $_GET["KMmin"];
$KMmax = $_GET["KMmax"];

//Fonctions

function KMTotal($KMmax, $KMmin)
{
  if ($KMmin == 0)
  {
    $KMTotal = $KMmax;
  }
  else
  {
    $KMTotal = $KMmax-$KMmin;
  }
  return $KMTotal;
}

function Litre($PrixTotal, $PrixLitre)
{
  $Litre = $PrixTotal/$PrixLitre;
  return $Litre;
}

function ConsomationMoyenneAu100($Litre, $KMTotal)
{
  $ConsomationMoyenneAu100 = $Litre*100/$KMTotal;
  return $ConsomationMoyenneAu100;
}

function UnLitreKM($KMTotal, $Litre)
{
  $UnKMLitre = $KMTotal/$Litre;
  return $UnKMLitre;
}

function PrixKM($KMTotal, $PrixTotal)
{
  $PrixKM = $PrixTotal/$KMTotal;
  return $PrixKM;
}

function UnKMLitre($Litre, $KMTotal)
{
  $UnKMLitre = $Litre/$KMTotal;
  return $UnKMLitre;
}

//Appele de Fonctions

$KMTotal = KMTotal($KMmax, $KMmin);
$PrixKM = PrixKM($KMTotal, $PrixTotal);
$Litre = Litre($PrixTotal, $PrixLitre);
$ConsomationMoyenneAu100 = ConsomationMoyenneAu100($Litre, $KMTotal);
$UnLitreKM = UnLitreKM($KMTotal, $Litre);
$UnKMLitre = UnKMLitre($Litre, $KMTotal);

//Controle des champs et affiche si ils sont tous rempli

if ($PrixTotal == null)
{
  echo "Enter something in the price total case.";
}
elseif ($PrixLitre == null)
{
  echo "Enter something in the price per liter.";
}
elseif ($KMmin == null)
{
  echo "Write something in the kilometers base case (or put 0)";
}
elseif ($KMmax == null)
{
  echo "Enter the total kilometers in the case";
}
else
{
  echo "<h3>Results</h3>";
  echo "<br>By paying $PrixTotal for $PrixLitre per liter you went accross $KMTotal KM </br>";
  echo "<br>Price per kilometers : $PrixKM  </br>";
  echo "<br>Average 100 KM : $ConsomationMoyenneAu100 L </br>";
  echo "<br>Number of liters consumed : $Litre L </br>";
  echo "<br>Number of kilometers you went accros for one liter : $UnLitreKM KM </br>";
  echo "<br>Consumed liters per kilometers $UnKMLitre L </br>";
}
?>
