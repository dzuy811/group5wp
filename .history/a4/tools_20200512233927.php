<?php
session_start();

// Define variable
$myDate=getdate(); 
$movieError = '';
$nameError = '';
$emailError = '';
$mobileError = '';
$cardError = '';
$expiryError = '';
$seatError = '';
$namePattern = "#^[a-zA-Z\,-.' ?]{1,100}$#";
$emailPattern = '#^[a-z][a-z0-9_\.]{1,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$#';
$mobilePattern = '#^(\(04\)|04|\+614)[ ]?\d{4}[ ]?\d{4}$#';
$cardPattern = '#^\d{4}[ ]?\d{4}[ ]?\d{4}[ ]?\d{2,4}[ ]?\d{0,3}?$#';
if (isset($_POST['cust']['expiry'])){
  $monthExpiry = intval(substr($_POST['cust']['expiry'], 6));
  $yearExpiry =  intval(substr($_POST['cust']['expiry'], 0, 4));
}

$currentMonth = intval(date("m")); 
$currentYear = intval(date("Y"));

//Load data from spreadsheets
$moviesObject=loadData('movieData');
$pricesObject=loadData('pricesData');

// Print Code
function printMyCode()
{
  $lines = file($_SERVER['SCRIPT_FILENAME']);
  echo "<pre class='mycode'><ol>";
  foreach ($lines as $line)
    echo '<li>' . rtrim(htmlentities($line)) . '</li>';
  echo '</ol></pre>';
}

// Print data and shape/structure of data
function preShow($arr, $returnAsString = false)
{
  $ret  = '<pre>' . print_r($arr, true) . '</pre>';
  if ($returnAsString)
    return $ret;
  else
    echo $ret;
}

// Load data from a spreadsheet
function loadData($filename)
{
  $fp = fopen($filename.'.txt', 'r');
  if (($headings = fgetcsv($fp, 0, "\t")) !== false) {
    while ($cells = fgetcsv($fp, 0, "\t")) {
      for ($x = 1; $x < count($cells); $x++)
        if ($x < count($headings) - 1) {
          $data[$cells[0]][$headings[$x]] = $cells[$x];
        } else {
          $data[$cells[0]][$headings[count($headings) - 1]][$cells[$x]] = $cells[$x + 1];
          $x += 1;
        }
    }
  }
  fclose($fp);
  return $data;
}
// write data to spreadsheet
function writeData($filename){
$fp = fopen($filename,"a");
flock($fp, LOCK_EX);
$record= processData($_SESSION['cart']);

fputcsv($fp, $record, "\t");
flock($fp, LOCK_UN);
fclose($fp);
}

// A "php multiple dimensional array to javascript object" function
function php2js( $arr, $arrName ) {
  $lineEnd="";
  echo "<script>\n";
  echo "/* Generated with A4's php2js() function */";
  echo "  var $arrName = ".json_encode($arr, JSON_PRETTY_PRINT);
  echo "</script>\n\n";
}
//


// print Movie Panel
function moviePanel($mid) { 
  global $moviesObject;
  //echo <<<"PANEL"
  echo '
  <div class="col-md-6 d-flex justify-content-center ">
  <div class="card border-info mb-3  w-100" style="max-width: 540px;">
    <div class="row no-gutters">
      <div class="col-md-5 pt-3 pb-3 pl-3">
        <img src="media/'.$moviesObject[$mid]['img'].'" class="card-img" alt="...">
      </div>
      <div class="col-md-7">
        <div class="card-body">
        <p class="card-title" style="font-size: 4vh;"> <b>'.$moviesObject[$mid]['name'] .'  '.
        $moviesObject[$mid]['rating'] .'</b></p> 
        ';
//PANEL;
foreach ( $moviesObject[$mid]['screenings'] as $day => $hour ){
  echo "<p class='card-text' style='font-size: 20px;'>$day - ".changeTime($hour)." </p>";
}
echo  ('<a href="#synopsis" class="stretched-link" id="" onclick="showDetail(\''.$mid.'\');"></a>');
echo "  </div>";
echo "</div>";
echo "  </div>";
echo "</div>";
echo "  </div>"; 
}

// print value of input MOVIE
function printValueMovie($a,$b,$c=""){
  if(isset($_POST[$a][$b])){
      if($_POST[$a][$b]!=""){
        if($b=="id"){
          global $moviesObject;
          return $moviesObject[$_POST[$a][$b]]['name'];
        }
        if($b=='hour'){
          return  changeTime($_POST[$a][$b]);
        }
        return $_POST[$a][$b];
      }
      return $c;
  }
  else{
    return $c;
  }  
}
// print value of input
function printValue($a,$b,$c=""){
   return (isset($_POST[$a][$b]) ?  $_POST[$a][$b] :$c );
}
// check this day is discount or full
function checkDiscount($day, $time){
  $type="full";
  if ($time == "T12" && $day != "SAT" && $day != "SUN") {
    $type ="disc";    
} else {
// check MON && WED
if (( $day == "MON" ||  $day == "WED") && $time != "T12") {
    $type ="disc";       
}
}
  return $type;
}

// Calculate subtotal of movie seats
function calPrice($cart){
  global $pricesObject;
  $day =$cart['movie']['day'];
  $time =$cart['movie']['hour'];
  $type= checkDiscount($day,$time);
  $total=0;
 
  foreach($cart['seats'] as $seattype => $quantity){
      $total += ($pricesObject[$type][$seattype]*$quantity);
  }
  return number_format($total,2);
}
// Calculate TAX = 1/11 subtotal
function calGST($subTotal){
  return  number_format($subTotal/11,2);
}
// calculate price of each seat type
function calAmount($day,$time,$seattype,$quantity){
  global $pricesObject;
  $total=0;
  $type= checkDiscount($day,$time);
  $total += ($pricesObject[$type][$seattype]*$quantity);
  return number_format($total,2);
}
// convert id to name of seat
function convertSeatDetail($id){
    if ($id == 'STA') {
        return 'Standard Adults';
    }
    if ($id == 'STP') {
      return 'Standard Concession';
    }
    if ($id == 'STC') {
    return 'Standard Child';
    }
    if ($id == 'FCA') {
      return 'First Class Adult';
    }
    if ($id == 'FCP') {
      return 'First Class Concession';
    }
    if ($id == 'FCC') {
      return 'First Class Child';
    }
}
// process before put into txt
function processData($cart){
  global $myDate;
  $data['Date']=$myDate['mon'].'/ '. $myDate['mday'].'/ '. $myDate['year'];
  $data['Name']=$cart['cust']['name'];
  $data['Email']=$cart['cust']['email'];
  $data['Mobile']=$cart['cust']['mobile'];
  $data['MovieID']=$cart['movie']['id'];
  $data['Day']=$cart['movie']['day'];
  $data['Hour']=$cart['movie']['hour'];
  $data['STA']=$cart['seats']['STA'];
  $data['STP']=$cart['seats']['STP'];
  $data['STC']=$cart['seats']['STC'];
  $data['FCA']=$cart['seats']['FCA'];
  $data['FCP']=$cart['seats']['FCP'];
  $data['FCC']=$cart['seats']['FCC'];
  $data['total']=$cart['total'];
  return $data;
}
// print first class tickets

function firstClassTickets($cart,$seattype="") { 
  global $moviesObject;
  echo 
  '<div id="first_class" class="container_ticket" style="padding-bottom:50px">
        <img src="media/firstclass.png" alt="Snow" style="width:100%; height:100%">
        <h1 class="movie_title" style="color:#f8dc1d;">'.$moviesObject[$cart['movie']['id']]['name'].' <br> '.$cart['movie']['day'].' - ' . changeTime($cart['movie']['hour'])   .'</h1>
        <h3 class="movie_info"> '.substr(convertSeatDetail($seattype),12).' Seat: '. substr(str_shuffle('ABCDEFGH'), 0, 1).mt_rand(0,9).'</h3>
        <br><h3 class="cus_info">'.$cart['cust']['name'].'</h3>
    </div>';

}
// print standard tickets
function standardTickets($cart,$seattype="") { 
  global $moviesObject;
  echo 
  '<div id="standard" class="container_ticket"  style="padding-bottom:50px">
        <img src="media/standard.png" alt="Snow" style="width:100%; height:100%">
        <h1 class="movie_title" style="color:#828e28;">'.$moviesObject[$cart['movie']['id']]['name'].' <br> '.$cart['movie']['day'].' - ' . changeTime($cart['movie']['hour'])   .'</h1>  
        <div class="info">
          <br><h3>'.convertSeatDetail($seattype).' Seat: '. substr(str_shuffle('IJKLMNOPQ'), 0, 1).mt_rand(10,20).'</h3>
          <br><h4>'.$cart['cust']['name'].'</h4>
        </div>
  </div>';

}
// print img bg
function printImg($movieID)
{
  if ($movieID == 'ACT') {
      return 'endgame_poster.jpg' ;
  }
  if ($movieID == 'RMC') {
    return 'topendwedding.jpg' ;
  }
  if ($movieID == 'ANM') {
    return  'dumbo_poster.jpg';
  }
  if ($movieID == 'AHF') {
    return 'thehappyprince.jpg' ;
  }
}
 















// header of page
function top_module($pageTitle)
{
  $html = <<<"OUTPUT"
  <!DOCTYPE html>
  <html lang='en'>
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>$pageTitle</title>
    <link id='stylecss1' type="text/css" rel="stylesheet" href="assets/style.css">
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Keep wireframe.css for debugging, add your css to style.css -->
    <link id='wireframecss' type="text/css" rel="stylesheet" href="../wireframe.css" disabled>
    <link id='stylecss' type="text/css" rel="stylesheet" href="../style.css">
  
    <script src='../wireframe.js'></script>
  </head>
  
  <body>
  
    <header>
      <div style="background-color: #000000;" class=" d-flex">
        <a href="index.php"><img src="media/Logo.jpg" width="75" height="75"></a>
        <p style="font-size: 3vw; color: white;">Cinemax </p>
      </div>
    </header>
  
    <!-- NAVBAR -->
    <nav class="navbar sticky-top navbar-expand-md navbar-dark " style="background-color: #000000;">
      <a class="navbar-brand" href="index.php">Cinemax</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav mx-auto ">
          <li class="nav-item">
            <a class="nav-link" href="#aboutus">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#seating">Prices</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false">
              Now Showing
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="#film">Film Showing</a>
              <a class="dropdown-item" href="#synopsis">Synopsis Area</a>
              <a class="dropdown-item" href="#Booking">Booking Area</a>
            </div>
          </li>
  
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-info" type="submit">Search</button>
        </form>
      </div>
    </nav>
OUTPUT;
  echo $html;
}
// end function top_module

// Start end_module
function end_module()
{
  $html = <<<"OUTPUT"
  <footer>
  <h3 class="text-center text-info" style="padding-top:10px; padding-bottom:10px;">CONTACT US </h3>
  <div class="container">
    <!-- UPPER FOOTER -->
    <div class="row text-white">
      <div class="col">
        <div class="">
          <p>Student: VO TRAN TRUONG DUY</p>
          <p>ID: s3818381</p>
          <p>EMAIL: s3818381@rmit.edu.vn</p>
          <p>PHONE: 0903818381</p>
        </div>

      </div>
      <div class="col">
        <div class="">
          <p>Student: NGUYEN CAT TUONG</p>
          <p>ID: s3818196</p>
          <p>EMAIL: s3818196@rmit.edu.vn</p>
          <p>PHONE: 0903818196</p>
        </div>

      </div>

      <div class="col-md-2 mb-5 d-none d-md-block">
        <p>Quick Links<p>
            <ul class="list-unstyled footer-link">
              <li><a href="#aboutus" class="text-info">About us</a></li>
              <li><a href="#seating" class="text-info">Prices</a></li>
              <li><a href="#film" class="text-info">Now Showing</a></li>

            </ul>
      </div>
    </div>
    <!-- END UPPER FOOTER -->

    <!-- LOWER FOOTER -->
    <div class="row">
      <div class="col-12 text-md-center text-left text-white">
        <p>&copy;
          Copyright &copy;
          <script>document.write(new Date().getFullYear());</script> All rights reserved | This web is made by DUY &
          TUONG <a class="text-info" href="https://s3818381.github.io/group5wp/a4/index.php" target="_blank">CINEMAX</a>
        </p>
      </div>
    </div>
  </div>
  <div><button id='toggleWireframeCSS' onclick='toggleWireframe()'>Toggle Wireframe CSS</button>
  <button id='toggleDebugModule' onclick='toggleDebugModule()'> Toggle Debug Module</button>
</div>
</footer>

<script src="assets/script.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
  integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
  integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
  crossorigin="anonymous"></script>
<script>
  $(document).ready(function () {
    $('body').scrollspy({ target: ".navbar", offset: 75 });
  });
</script>
</body>

</html>
OUTPUT;
  echo $html;
}
// change time from T to P.M

function changeTime($time){
     $newTime =intval(substr($time, 1));
     if($newTime>12){
        $newTime-=12;
     }
    return $newTime." P.M";

}