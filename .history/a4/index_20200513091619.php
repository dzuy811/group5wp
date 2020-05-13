<?php
 require_once 'tools.php';
 top_module('index');
 // Form Validation
 if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['session-reset'])) {
          unset($_SESSION['cart']);
      }
      else{      
      if(!empty($_POST)) {
        // false when there is NO error found
        $foundErrors = false;
        // Remove unnecessary tags
        $_POST['cust']['name'] = strip_tags($_POST['cust']['name']);
        $_POST['cust']['email'] = strip_tags($_POST['cust']['email']);
        $_POST['cust']['mobile'] = strip_tags($_POST['cust']['mobile']);
        $_POST['cust']['card'] = strip_tags($_POST['cust']['card']);
        $_POST['cust']['expiry'] = strip_tags($_POST['cust']['expiry']);
        // Check movie
        if ($_POST['movie']['id'] == '') {
          $movieError = ' <span id="movieError" style="color:red; font-size:20px" ><i>Please choose a movie and suitable time!</i></span>';
          $foundErrors = true;
        }

        // Check name
        if (empty($_POST['cust']['name'])) {
          $nameError = ' <span style="color:red">Cannot be blank</span>';
          $foundErrors = true;
        } else {
            if (!preg_match($namePattern, $_POST['cust']['name'])) {
              $nameError = ' <span style="color:red">Your name is invalid. Try again!</span>';
              $foundErrors = true;
            }
        }
        // Check email
        if (empty($_POST['cust']['email'])) {
          $emailError = ' <span style="color:red">Cannot be blank</span>';          
          $foundErrors = true;
        } else {
            // if (!preg_match($emailPattern, $_POST['cust']['email'])) {
            //   $emailError = ' <span style="color:red">Your email is invalid. Try again!</span>';
            //   $foundErrors = true;
            // } else {
            //   $foundErrors = false;
            // }
            if(!filter_var($_POST['cust']['email'], FILTER_VALIDATE_EMAIL)) {
              $emailError = ' <span style="color:red">Your email is invalid. Try again!</span>';
              $foundErrors = true;
            }
        }
        // Check mobile
        if (empty($_POST['cust']['mobile'])) {
            $mobileError = ' <span style="color:red">Cannot be blank</span>';            
            $foundErrors = true;
        } else {
            if (!preg_match($mobilePattern, $_POST['cust']['mobile'])) {
              $mobileError = ' <span style="color:red">Your mobile number is invalid. Try again!</span>';
              $foundErrors = true;
            }
        }
        // Check card
        if (empty($_POST['cust']['card'])) {
            $cardError = ' <span style="color:red">Cannot be blank</span>';
            $foundErrors = true;
        } else {
            if (!preg_match($cardPattern, $_POST['cust']['card'])) {
              $cardError = ' <span style="color:red">Your credit card is invalid. Try again!</span>';
              $foundErrors = true;
            } 
        }
        // Check expiry
        if (empty($_POST['cust']['expiry'])) {
            $expiryError = ' <span style="color:red">Cannot be blank</span>';
            $foundErrors = true;
        } else {
            if ($yearExpiry < $currentYear) {
              $expiryError = ' <span style="color:red">The credit card is out of date!</span>';
              $foundErrors = true;
            } 
            if ($yearExpiry == $currentYear) {
              if ($monthExpiry - $currentMonth < 1) {
                $expiryError = ' <span style="color:red">The credit card is out of date!</span>';
                $foundErrors = true;
              } 
            }             
        }
        // Check seat
        if ($foundErrors) {
          $seatError = ' <span style="color:red; font-size:20px">Select the seat again!</span>';
        }
        $countSeats = 0;
        foreach ($_POST['seats'] as $key => $value) {
          if (intval($value) != 0) {
            $countSeats += 1;
          }
        }
        if ($countSeats == 0) {
          $seatError = ' <span style="color:red; font-size:20px">Cannot be blank</span>';
          $foundErrors = true;
        }
      }

      if ($foundErrors == false) {
        $_SESSION['cart'] = $_POST;
        header("Location: receipt.php");
      }
      
    }
  }
    
?>


  <main>
    <video no-controls autoplay loop muted width="100%">
      <source src="media/FullHD.mp4" type="video/mp4">
    </video>
    <!-- ABOUT US -->
    <article id="aboutus" class="container-fluid text-white " style="padding-top:40px;">
      <h2 class="demoFont text-info text-center" style="padding: 30px;">About Us:</h2>
      <div class="row align-items-center content">
        <div class="col-md-6  order-1">
          <img src="media/dolbycinema.jpg" alt="" class="img-fluid" style="padding-bottom:30px">
        </div>
        <div class="col-md-6 order-2 order-md-2">
          <div class="row justify-content-center">
            <div class="col-10  blurb mb-5 mb-md-0 text-dark">
              <p class="lead "><b>Welcome to our theater, where you can enjoy and deep in an overwhelming
                  quality of the footage and sound.
                  Why? Because now, after the evolution of upgrading the theater, all customers could enjoy all the
                  technology of 3D Dolby Vision projection and Dolby Atmos sound:</b>
                <ul>
                  <li>
                    Powered by dual-laser projection technology and engineered for a consistent experience, Dolby
                    Vision lets you see more of the story.

                  </li>
                  <li>
                    Moving audio could flow all around you, even from above and behind, put you at the center of
                    the story.
                  </li>
                </ul>
              </p>
            </div>
          </div>
        </div>
      </div>
    </article>
    <!-- END ABOUT US -->

    <!--SEATS  -->

    <article id="" class="container-fluid pt-5 pb-5" style="background-color: black">
      <div class="d-flex flex-row">
        <div class="col-5 d-flex justify-content-center">
          <div class="card" style="width: 30rem;">
            <img src="media/seat3.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text" style="font-size: 2vw; text-align: center;">Standard Seating</p>
            </div>
          </div>
        </div>
        <div class="col-2 d-flex align-items-center" style="padding: 0px 0px;">

          <div class=" glow ">OUR NEW SEATS</div>

        </div>
        <div class="col-5 d-flex justify-content-center">
          <div class="card" style="width: 30rem;">
            <img src="media/seat4.jpg" class="card-img-top" alt="...">
            <div class="card-body">
              <p class="card-text" style="font-size: 2vw; text-align: center;">First Class Seating</p>
            </div>
          </div>
        </div>
      </div>
    </article>
    <!-- END SEATS -->

    <!-- Seating Prices -->
    <article>
      <div id="seating" class="container-fluid parallax-div">
        <h1 class="text-center demoFont" style="padding-top:100px">Seating Prices:</h1>
        <hr class="style-white style-white:before">
        <div class="table-responsive-xl">
          <table class="table ">
            <caption class="text-white bg-dark"><i>* Weekday afternoons at 12 pm (ie weekday matinée sessions,
                Monday - Friday) and all day on Mondays and Wednesdays.</i></caption>
            <thead>
              <tr>
                <th scope="col" class="table-light">SEAT TYPE</th>
                <th scope="col" class="text-center table-light">Standard Adult</th>
                <th scope="col" class="text-center table-light">Standard Concession</th>
                <th scope="col" class="text-center table-light">Standard Child</th>
                <th scope="col" class="table-primary text-center">First Class Adult</th>
                <th scope="col" class="table-primary text-center">First Class Concession</th>
                <th scope="col" class="table-primary text-center">First Class Child</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" class="table-light">SEAT CODE</th>
                <td class="text-center table-light">STA</td>
                <td class="text-center table-light">STP</td>
                <td class="text-center table-light">STC</td>
                <td class="table-primary text-center">FCA</td>
                <td class="table-primary text-center">FCP</td>
                <td class="table-primary text-center">FCC</td>
              </tr>
              <tr>
                <th scope="row" class="table-light">NORMAL TIMES</th>
                <td class="text-center table-light">19.80</td>
                <td class="text-center table-light">17.50</td>
                <td class="text-center table-light">15.30</td>
                <td class="table-primary text-center">30.00</td>
                <td class="table-primary text-center">27.00</td>
                <td class="table-primary text-center">24.00</td>
              </tr>
              <tr>
                <th scope="row" class="table-warning"><i>SPEACIAL TIMES *</i></th>
                <td class="table-warning text-center"><i>14.00</i></td>
                <td class="table-warning text-center"><i>12.50</i></td>
                <td class="table-warning text-center"><i>11.00</i></td>
                <td class="table-warning text-center"><i>24.00</i></td>
                <td class="table-warning text-center"><i>22.50</i></td>
                <td class="table-warning text-center"><i>21.00</i></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </article>
    <!-- END SEATING PRICES -->

    <!-- NOW SHOWING -->
    <article id="film" class="container-fluid" style="background-color: #f3f3f3;">
      <div class="demoFont text-info" style=" text-align: center; padding-top: 70px;">Film Showing:</div>
      <hr class="style-two style-two:before">      
      <div class="card-desk">
        <div class="row row-cols-1 row-cols-md-2 ">         
          <?php 
          foreach($moviesObject as $id => $movie){
            moviePanel($id);
           } 
           ?>
           </div>       
      </div>
    </article>
    <!-- END NOW SHOWING -->

    <!-- SYNOPSIS PANEL -->
    <article id="synopsis" style="padding-top:20px; padding-bottom: 80px; background-color: #352f2f;">
      <h1 class="demoFont text-info text-center" style="padding-top:50px; padding-bottom:20px"> Synopsis Panel: </h1>
      <div class="container card bg-light " id="synopsisPanel" style="border-color:#000000">
      <div class="card-body ">
          <!-- SYNOPSIS TITLE -->
          <div class="row">
            <div class="col-6">
              <h1 id="synopsisTitle" class="text-monospace font-weight-bold">Avengers: Endgame</h1>
            </div>
            <div class="col-6">
              <h1 id="synopsisRating" class="text-monospace font-weight-bold">PG-13</h1>
            </div>
          </div>
          <!-- DESCRIPTION -->
          <hr class="style">
          <div class="row">
            <div class="col-md-6" style="padding-right:50px; padding-top: 20px">
              <p class="font-weight-bold" style="font-size: 25px">Plot description:</p>
              <p id="synopsisDescription" class="demoFont3" style="font-size: 18px; text-align: justify;">After the
                devastating events of Avengers: Infinity War
                (2018),
                the universe is in
                ruins due to the efforts of the Mad Titan, Thanos. With the help of remaining allies, the Avengers must
                assemble once more in order to undo Thanos's actions and undo the chaos to the universe, no matter what
                consequences may be in store, and no matter who they face...</p>
            </div>
            <div class="col-md-6 row justify-content-center ">
              <iframe id="synopsisYoutube" width="560" height="315" src="https://www.youtube.com/embed/TcMBFSGVi1c"
                frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen style="margin-left: 50px; padding-top: 20px"></iframe>
            </div>
            <div style="padding-top:30px">
              <div id="synopsisBtnGroup" class="" data-toggle="buttons">
                <p style="padding-right:50px;  font-size: 20px">Making a book:</p>
                <a class="btn btn-info mr-3" style="margin-bottom: 10px"
                  onclick="showBooking('ACT','Avengers: Endgame','WED','9 P.M','T21');checkMovie();" href="#Booking"> WED - 9 P.M
                </a>
                <a class="btn btn-info mr-3" style="margin-bottom: 10px"
                  onclick="showBooking('ACT','Avengers: Endgame','THU','9 P.M','T21');checkMovie();" href="#Booking"> THU - 9 P.M
                </a>
                <a class="btn btn-info mr-3" style="margin-bottom: 10px"
                  onclick="showBooking('ACT','Avengers: Endgame','FRI','9 P.M','T21');checkMovie();" href="#Booking"> FRI - 9 P.M
                </a>
                <a class="btn btn-info mr-3" style="margin-bottom: 10px"
                  onclick="showBooking('ACT','Avengers: Endgame','SAT','6 P.M','T18');checkMovie();" href="#Booking"> SAT - 6 P.M
                </a>
                <a class="btn btn-info mr-3" style="margin-bottom: 10px"
                  onclick="showBooking('ACT','Avengers: Endgame','SUN','6 P.M','T18');checkMovie();" href="#Booking"> SUN - 6 P.M
                </a>
              </div>
            </div>
          </div>
        </div>     
      </div>
    </article>
    <!-- END SYNOPSIS PANEL  -->

    <!-- Booking Area -->
    <article id="Booking" style="padding-top:50px; padding-bottom: 50px;">
      <!-- <form action=""> -->
      <form action="index.php#Booking" method="POST" name="BookingForm" id="booking-form">
        <h1 class="demoFont text-info text-center" style="padding-top:50px; padding-bottom:20px"> Booking Area: </h1>
        <div class="container card bg-light " style="border-color:#000000">
          <!-- BOOKING TITLE -->
          <div class="row">
            <div class=" col-sm-12 col-md-6">
              <h1 id="movie-title" class="text-monospace text-danger font-weight-bold mt-3 ml-5"><?php echo printValueMovie('movie','id','MOVIE TITLE'); ?></h1>
            </div>
            <div class="col-sm-12 col-md-3">
              <h1 id="movie-title-day" class="text-monospace text-danger font-weight-bold mt-3 ml-5">  <?php echo printValueMovie('movie','day','DAY'); ?></h1>
            </div>
            <div class="col-sm-12 col-md-3">
              <h1 id="movie-title-time" class="text-monospace text-danger font-weight-bold mt-3 ml-5"> <?php echo printValueMovie('movie','hour','TIME'); ?></h1>
            </div>
          </div>
          <!--END  BOOKING TITLE -->

          <!-- HIDDEN INPUT of BOOKING  -->
          <input type="text" id="movie-id"   value="<?php echo printValue('movie','id'); ?>" name="movie[id]" class="d-none" >
          <input type="text" id="movie-day" value="<?php echo printValue('movie','day'); ?>" name="movie[day]" class="d-none">
          <input type="text" id="movie-hour" value="<?php echo printValue('movie','hour'); ?>" name="movie[hour]" class="d-none">
       
          <!-- END HIDDEN INPUT of BOOKING  -->
          <div class="card-body">
            <div>
              <div class="row">
                <!-- LEFT BOOKING FORM -->
                <div class="col-md-6"><?= $seatError ?>
                  <div class="card container mb-3" style="border-color:#000000">
                    <p style="font-size: 175%;"><b>Standard</b></p>
                    <div class="form-group">
                      <!-- Standard -->
                      <!-- STANDARD Chair Adults -->
                      <div class="row mb-3">
                        <div class="col d-flex align-item-center  justify-content-end">
                          <label for="seats-STA" style="font-size: 150%;">Adults</label>
                        </div>
                        <div class="col d-flex justify-content-center">
                          <select name="seats[STA]" id="seats-STA" class="btn btn-info dropdown-toggle " <?php if(isset($_POST['movie']['id'])&& $_POST['movie']['id']!=""){ echo 'onchange="calPrice();"';} ?>>
                            <option value="0">Please Select</option>
                            <?php for ($i=1; $i <=10 ; $i++) { ?>
                              # code...
                            <?}?>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                      </div>
                      <!--STANDARD ChairsConcession -->
                      <div class="row mb-3">
                        <div class="col d-flex align-item-center  justify-content-end">

                          <label class="" for="seats-STP" style="font-size: 150%;">Concession</label>
                        </div>
                        <div class="col d-flex justify-content-center">
                          <select name="seats[STP]" id="seats-STP" class="btn btn-info dropdown-toggle" <?php if(isset($_POST['movie']['id'])&& $_POST['movie']['id']!=""){ echo 'onchange="calPrice();"';} ?>>
                            <option value="0">Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                      </div>
                      <!--STANDARD Chairs Children -->
                      <div class="row mb-3">
                        <div class="col d-flex align-item-center  justify-content-end">
                          <label class="" for="seats-STC" style="font-size: 150%;">Children</label>
                        </div>
                        <div class="col d-flex justify-content-center">
                          <select name="seats[STC]" id="seats-STC" class="btn btn-info dropdown-toggle" <?php if(isset($_POST['movie']['id'])&& $_POST['movie']['id']!=""){ echo 'onchange="calPrice();"';} ?>>
                            <option value="0">Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>
                  <div class="card container" style="border-color:#000000">
                    <p style="font-size: 175%;"><b>First Class</b></p>
                    <div class="form-group">
                      <!--FIRST Chair Adults -->
                      <div class="row mb-3">
                        <div class="col d-flex align-item-center  justify-content-end">
                          <label for="seats-FCA" style="font-size: 150%;">Adults</label>
                        </div>
                        <div class="col d-flex justify-content-center">
                          <select name="seats[FCA]" id="seats-FCA" class="btn btn-info dropdown-toggle" <?php if(isset($_POST['movie']['id'])&& $_POST['movie']['id']!=""){ echo 'onchange="calPrice();"';} ?>>
                            <option value="0">Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                      </div>
                      <!--FIRST ChairsConcession -->
                      <div class="row mb-3">
                        <div class="col d-flex align-item-center  justify-content-end">

                          <label class="" for="seats-FCP" style="font-size: 150%;">Concession</label>
                        </div>
                        <div class="col d-flex justify-content-center">
                          <select name="seats[FCP]" id="seats-FCP" class="btn btn-info dropdown-toggle" <?php if(isset($_POST['movie']['id'])&& $_POST['movie']['id']!=""){ echo 'onchange="calPrice();"';} ?>>
                            <option value="0">Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                      </div>
                      <!--FIRST Chairs Children -->
                      <div class="row mb-3">
                        <div class="col d-flex align-item-center  justify-content-end">
                          <label class="" for="seats-FCC" style="font-size: 150%;">Children</label>
                        </div>
                        <div class="col d-flex justify-content-center">
                          <select name="seats[FCC]" id="seats-FCC" class="btn btn-info dropdown-toggle" <?php if(isset($_POST['movie']['id'])&& $_POST['movie']['id']!=""){ echo 'onchange="calPrice();"';} ?>>
                            <option value="0">Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <!-- END LEFT BOOKING FORM -->

                <!-- RIGHT BOOKING FORM -->
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                  <div class="form-group" ><?= $movieError ?>
                    <div class="form-group row" style="padding-top: 20px">
                      <label for="cust-name" class="col-sm-3 col-form-label">Name</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="cust[name]" id="cust-name" placeholder="Name" value="<?php echo printValue('cust','name'); ?>"><?= $nameError ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="cust-email" class="col-sm-3 col-form-label">Email</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="cust[email]" id="cust-email" placeholder="Email" value="<?php echo printValue('cust','email'); ?>"><?= $emailError ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="cust-mobile" class="col-sm-3 col-form-label">Mobile</label>
                      <div class="col-sm-9">
                        <input type="tel" class="form-control" name="cust[mobile]" id="cust-mobile" placeholder="Mobile" value="<?php echo printValue('cust','mobile'); ?>"><?= $mobileError ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="cust-card" class="col-sm-3 col-form-label">Credit Card</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="cust[card]" id="cust-card"
                          placeholder="Credit Card" value="<?php echo printValue('cust','card'); ?>"><?= $cardError ?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="cust-expiry" class="col-sm-3 col-form-label">Expiry</label>
                      <div class="col-sm-9">
                        <input type="Month" class="form-control" name="cust[expiry]" id="cust-expiry" value="<?php echo printValue('cust','expiry'); ?>"><?= $expiryError ?>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END RIGHT BOOKING FORM -->


              </div>
              <!-- SUBMIT BTN -->
              <div style="padding-top: 20px">
                <div class="row">
                  <div class="col-md-2 d-flex align-content-center  justify-content-sm-start justify-content-md-end ">
                    <p style="font-size: 30px;">Total:</p>                    
                  </div>
                  <div class="col-md-4">
                    <div
                      style="border-style: dashed; border-color: #17a2b8 ; height: 100%; border-radius: 35%; background-color: white;"
                      class="d-flex align-content-center justify-content-center">
                      <p id="total" style="font-size: 30px;" class="pr-3"></p>
                      <p id="total-discounted" style="font-size: 30px; color: tomato;"></p>
                    </div>
                  </div>
                  <div class="col-md-5 d-flex align-self-center justify-content-center">
                    <p id="note" style="font-size: 120%; color: tomato;"></p>
                  </div>
                  <div class="col-md-1  d-flex align-self-center justify-content-end">
                    <input id="submit_button" class="btn btn-info" type="submit" value="Order">
                  </div>
                </div>
              </div>
              <!-- END SUBMIT BTN -->
            </div>
          </div>
        </div>
      </form>
    </article>

  </main>

 <?php
  end_module();
 ?>
 <div id="DebugModule">
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