<?php    
    require_once('tools.php');
    if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
          header("Location:index.php");
    }else{
      $_SESSION['cart']['total']=calPrice($_SESSION['cart']) +calGST(calPrice($_SESSION['cart']));
      writeData('bookings.txt');
    }
    
    
    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>RECEIPT</title>           
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
      <style>
                  /* Container holding the image and the text */
                  .container_ticket {
                  position: relative;
                  text-align: center;
                  color: white;
                  }
                  /* First Class */
                  #first_class .movie_title {
                  position: absolute;
                  top: 28%;
                  left: 45%;
                  transform: translate(-50%, -50%);
                  }
                  #first_class .movie_info {
                  position: absolute;
                  top: 50%;
                  left: 32%;
                  transform: translate(-50%, -50%);
                  }
                  #first_class .cus_info {
                  position: absolute;
                  top: 50%;
                  left: 54%;
                  transform: translate(-50%, -50%);
                  }
                  /* Standard */
                  #standard .movie_title {
                  position: absolute;
                  top: 34%;
                  left: 58%;
                  transform: translate(-50%, -50%);                 
                  }
                  #standard .info {
                  position: absolute;
                  top: 56%;
                  left: 58%;
                  transform: translate(-50%, -50%);
                  }
                  footer{
                  background-color: black;
                  }
                  .parallax-div {
                  /* The image used */
                  background-image: url("media/<?= printImg($_SESSION['cart']['movie']['id'])?>");

                  /* Set a specific height */                

                  /* Create the parallax scrolling effect */
                  background-attachment: fixed;
                  background-position: center;
                  background-repeat: no-repeat;
                  background-size: cover;
                  }
            </style>
      <script>
      function printContent(el){
            var restorePage = document.body.innerHTML;
            var printContent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = restorePage;
      }
</script>
</head>
<body>
      <div class="container">
             <div class="row mb-3 mt-5 pt-5">
                  <div class="col-8"><h1 style=" color:red" >Scroll down to view TAX and Tickets</h1></div>
                  <div class="col-4">
                        <form action="index.php" method="post">
                        <input class="btn btn-lg btn-info float-right" type='submit' name='session-reset' value='Exit'></div>
                        </form>                  
            </div>
      </div>
           
      <!-- Print tax invoice -->
      <div id="tax_invoice">
            <div style="padding-top:100px">
                  <div id="tax_invoice" class="container card" style="border-color:#000000">
                        <h1 class="text-center" style="padding-top:50px; padding-bottom:20px">TAX INVOICE </h1>
                        <!-- COMPANY & CUSTOMER INFORMATION -->
                        <div class="row">
                              <div class="col-6">
                                    <div class="container">
                                          <h2 class="text-info"><i>CINEMAX</i></h2>
                                          <p> District 7, Nguyen Van Linh Street, Ho Chi Minh City.</p>
                                          <p>Tel: (+614) 1423 5234. Email: cinemax@gmail.com.</p>
                                          <p>Website: www.cinemax.com . Tax Registration Number: 00 123 456 789</p>
                                    </div>
                                    <div class="container" style="padding-top:40px">
                                          <h5 >Sold to:</h5>
                                          <p><i>Customer name: </i><?= $_SESSION['cart']['cust']['name']?></p>
                                          <p><i>Customer email: </i><?= $_SESSION['cart']['cust']['email']?></p>
                                          <p><i>Customer mobile: </i><?= $_SESSION['cart']['cust']['mobile']?></p>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div>
                                          <img src="media/Logo.jpg" width="150" height="150" style="margin-left:200px"></a>
                                    </div>
                                    <div style="padding-top:50px; margin-left:200px">
                                          <h2 class="text-danger"><b>TAX INVOICE</b></h2>
                                          <p>Date:  <?= $myDate['mon'].'/ '. $myDate['mday'].'/ '. $myDate['year']?></p>
                                          <p>Credit Terms: Credits</p>
                                          <p>Country: Australia</p>
                                    </div>
                              </div>
                        </div>
                        <!-- TABLE -->
                        <div class="container-fluid" style="padding-bottom:50px">
                              <div class="table-responsive-xl">
                                    <table class="table table-borderless ">
                                          <thead>
                                          <tr>
                                          <th scope="col" class="border border-dark">Seat Detail</th>
                                          <th scope="col" class="border border-dark">Movie</th>
                                          <th scope="col" class="border border-dark">Day - Time</th>
                                          <th scope="col" class="border border-dark">Quantity</th>
                                          <th scope="col" class="border border-dark">Amount Price</th>
                                          </tr>
                                          </thead>
                                          <tbody>
                                          <?php $count=0;
                                                foreach($_SESSION['cart']['seats'] as $seat => $quantity){
                                                if ($quantity!=0) { $count++; ?>                                     
                                                <tr>
                                                      <td class="border-left border-right border-dark"><?= convertSeatDetail($seat); ?></td>
                                                      <td class="border-right border-dark"><?= $moviesObject[$_SESSION['cart']['movie']['id']]['name'] ?></td>
                                                      <td class="border-right border-dark"><?= $_SESSION['cart']['movie']['day'].' - '.changeTime($_SESSION['cart']['movie']['hour']); ?></td>
                                                      <td class="border-right border-dark"><?= $quantity ?></td>
                                                      <td class="border-right border-dark">$<?= calAmount($_SESSION['cart']['movie']['day'],$_SESSION['cart']['movie']['hour'],$seat,$quantity);?></td>
                                                </tr>
                                          <?php }} ?>
                                                
                                                <?php for ($i=$count; $i <=9 ; $i++) { ?>
                                                      <tr>
                                                      <td class="border-left border-right border-dark"></td>
                                                      <td class="border-right border-dark"></td>
                                                      <td class="border-right border-dark"></td>
                                                      <td class="border-right border-dark"></td>
                                                      <td class="border-right border-dark"></td>
                                                      </tr>  
                                                <?php }?>                                               
                                               
                                                <tr>
                                                      <td class="border border-top-0 border-dark"></td>
                                                      <td class="border-bottom border-right border-dark"></td>
                                                      <td class="border-bottom border-right border-dark"></td>
                                                      <td class="border-bottom border-right border-dark"></td>
                                                      <td class="border-bottom border-right border-dark"></td>
                                                </tr>  
                                                <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td class="border border-dark"><b>Sub Total</b></td>
                                                      <td class="border border-dark"><b>$<?= calPrice($_SESSION['cart'])?></b></td>
                                                </tr>  
                                                <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td class="border border-dark"><b>GST</b></td>
                                                      <td class="border border-dark"><b>$<?= calGST(calPrice($_SESSION['cart']))?></b></td>
                                                </tr>  
                                                <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td class="border border-dark"><b>Invoice Total</b></td>
                                                      <td class="border border-dark"><b>$<?=calPrice($_SESSION['cart']) +calGST(calPrice($_SESSION['cart'])) ?></b></td>
                                                </tr>  
                                                <tr>
                                                      <td></td>
                                                      <td></td>
                                                      <td></td>
                                                      <td class="border border-dark"><b>Balance Total</b></td>
                                                      <td class="border border-dark text-danger"><b>$<?= $_SESSION['cart']['total'] ?></b></td>
                                                </tr>    
                                          </tbody>
                                    </table>
                              </div>
                        </div>    
                  </div>
            </div>
      </div>
      <div class="container">
      <div class="row mb-5 mt-5">
            <button class="btn btn-lg btn-info float-left" onclick="printContent('tax_invoice')">Print TAX INVOICE</button>
      </div>
      </div>
 <div class="parallax-div">                                                  
      <!-- Print tickets -->
      <div class="container">      
            <div class="row mb-3 mt-5 pt-5">
                  <div class="col-8"><h1 style=" color:red" >TICKET(S)</h1></div>
                  <div class="col-4"><button class="btn btn-lg btn-info float-right" onclick="printContent('ticket')">Print TICKET(S)</button></div>
            </div>
            <div id="ticket">
            <!-- First Class -->
            <?php 
                  foreach($_SESSION['cart']['seats'] as $seat => $quantity){
                        if ($quantity!=0) {
                              if($seat =='STA' || $seat =='STP' || $seat =='STC' ){
                                   echo' <h1 style="padding-bottom:20px; color:orange;">'.convertSeatDetail($seat).': '.$quantity.' tickets</h1>';
                                    for ($x = 0; $x < $quantity; $x++) {
                                          standardTickets($_SESSION['cart'],$seat);
                                         }                                   
                              }
                              if($seat =='FCA' || $seat =='FCP' || $seat =='FCC' ){
                                    echo' <h1 style="padding-bottom:20px; color:orange;">'.convertSeatDetail($seat).': '.$quantity.' tickets</h1>';
                                     for ($x = 0; $x < $quantity; $x++) {
                                          firstClassTickets($_SESSION['cart'],$seat);
                                          }                                   
                               }
                        }
                  }
                 // for ($x = 0; $x <= 5; $x++) {
                       // firstClassTickets($_SESSION['cart'],'FCC');
                      //}
                     // standardTickets($_SESSION['cart'],'FCC');
            ?>
            
            <!-- Standard -->
           
      </div>    
      </div>
 </div>
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
          TUONG <a class="text-info" href="https://s3818381.github.io/duywp/a2/index.html" target="_blank">CINEMAX</a>
        </p>
      </div>
    </div>
  </div> 
</footer>
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

<div id="DebugModule" style="background-color: yellow; padding: 20px">
      <div> 
            <h2>$_SESSION</h2>   <?php  preShow($_SESSION); ?> 
      </div>              
      <div> 
            <h2>$_POST</h2>   <?php preShow($_POST); ?> 
      </div>
      <div> 
            <h2>Page code:</h2>   <?php printMyCode(); ?> 
      </div>
</div> 
