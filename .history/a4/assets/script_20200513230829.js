
var movieList = {
    ACT: {
        id: "ACT",
        name: "Avengers: Endgame",
        rating: "PG-13",
        description:
            "After the devastating events of Avengers: Infinity War (2018), the universe is in ruins due to the efforts of the Mad Titan, Thanos. With the help of remaining allies, the Avengers must assemble once more in order to undo Thanos's actions and undo the chaos to the universe, no matter what consequences may be in store, and no matter who they face...",
        link: "https://www.youtube.com/embed/TcMBFSGVi1c",
        schedule: [
            { day: "WED", time: "9 P.M", period: "T21" },
            { day: "THU", time: "9 P.M", period: "T21" },
            { day: "FRI", time: "9 P.M", period: "T21" },
            { day: "SAT", time: "6 P.M", period: "T18" },
            { day: "SUN", time: "6 P.M", period: "T18" },
        ],
    },
    RMC: {
        id: "RMC",
        name: "Top End Wedding",
        rating: "M",
        description:
            "Lauren and Ned are engaged, they are in love, and they have just ten days to find Lauren's mother who has gone AWOL somewhere in the remote far north of Australia, reunite her parents and pull off their dream wedding.",
        link: "https://www.youtube.com/embed/uoDBvGF9pPU",
        schedule: [
            { day: "MON", time: "6 P.M", period: "T18" },
            { day: "TUE", time: "6 P.M", period: "T18" },
            { day: "SAT", time: "3 P.M", period: "T15" },
            { day: "SUN", time: "3 P.M", period: "T15" },
        ],
    },
    ANM: {
        id: "ANM",
        name: "Dumbo",
        rating: "PG",
        description:
            "A young elephant, whose oversized ears enable him to fly, helps save a struggling circus, but when the circus plans a new venture, Dumbo and his friends discover dark secrets beneath its shiny veneer.",
        link: "https://www.youtube.com/embed/7NiYVoqBt-8",
        schedule: [
            { day: "MON", time: "12 P.M", period: "T12" },
            { day: "TUE", time: "12 P.M", period: "T12" },
            { day: "WED", time: "6 P.M", period: "T18" },
            { day: "THU", time: "6 P.M", period: "T18" },
            { day: "FRI", time: "6 P.M", period: "T18" },
            { day: "SAT", time: "12 P.M", period: "T12" },
            { day: "SUN", time: "12 P.M", period: "T12" },
        ],
    },
    AHF: {
        id: "AHF",
        name: "The Happy Prince",
        rating: "R",
        description:
            "The untold story of the last days in the tragic times of Oscar Wilde, a person who observes his own failure with ironic distance and regards the difficulties that beset his life with detachment and humor.",
        link: "https://www.youtube.com/embed/4HmN9r1Fcr8",
        schedule: [
            { day: "WED", time: "12 P.M", period: "T12" },
            { day: "THU", time: "12 P.M", period: "T12" },
            { day: "FRI", time: "12 P.M", period: "T12" },
            { day: "SAT", time: "9 P.M", period: "T21" },
            { day: "SUN", time: "9 P.M", period: "T21" },
        ],
    },
};


// function show detail in SYNOPSIS PANEL
function showDetail(key) {
     resetForm();    
    // variables
    let movie_id = movieList[key].id;
    let movie_name = movieList[key].name;
    // Title +Rating
    document.getElementById("synopsisTitle").innerHTML = movieList[key].name;
    document.getElementById("synopsisRating").innerHTML = movieList[key].rating;
    // Description + Youtube
    document.getElementById("synopsisDescription").innerHTML =
        movieList[key].description;
    document.getElementById("synopsisYoutube").src = movieList[key].link;
    // btn Group
    var newBtnGroup =
        '<p style="padding-right:50px;  font-size: 20px">Making a book:</p>';
    for (const i in movieList[key].schedule) {
        let movie_day = movieList[key].schedule[i].day;
        let movie_time = movieList[key].schedule[i].time;
        let movie_period = movieList[key].schedule[i].period;
        newBtnGroup +=
            ' <a  class="btn btn-info mr-3" style="margin-bottom: 10px" onclick="showBooking(\'' +
            movie_id +
            "','" +
            movie_name +
            "','" +
            movie_day +
            "','" +
            movie_time +
            "','" +
            movie_period +
            '\');checkMovie();" href="#Booking">' +
            movie_day +
            " - " +
            movie_time +
            "</a>";
    }
    document.getElementById("synopsisBtnGroup").innerHTML = newBtnGroup;
}


// function show detail in BOOKING FORM
function showBooking(movie_id,movie_name,movie_day,movie_time,movie_period) {
    resetForm();
    // change the title of BOOKING FORM
    document.getElementById("movie-title").innerHTML = movie_name;
    document.getElementById("movie-title-day").innerHTML = changeDay(movie_day);
    document.getElementById("movie-title-time").innerHTML = movie_time;
    // change the HIDDEN INPUT of BOOKING
    document.getElementById("movie-id").value = movie_id;
    document.getElementById("movie-day").value = movie_day;
    document.getElementById("movie-hour").value = movie_period;
    // add Event to Select
    addEventToAllSelect();
    // remove disable button
    //document.getElementById("submit_button").removeAttribute("disabled");
}


// function change to full day
function changeDay(movie_day) {
    if (movie_day == "MON") {
        return "MONDAY";
    }
    if (movie_day == "TUE") {
        return "TUESDAY";
    }
    if (movie_day == "WED") {
        return "WEDNESDAY";
    }
    if (movie_day == "THU") {
        return "THURSDAY";
    }
    if (movie_day == "FRI") {
        return "FRIDAY";
    }
    if (movie_day == "SAT") {
        return "SATURDAY";
    }
    if (movie_day == "SUN") {
        return "SUNDAY";
    }
}


// function calculate prices
function calPrice() {
    // STANDARD
    let seatsSTA = checkIsInt(document.getElementById("seats-STA").value);
    let seatsSTP = checkIsInt(document.getElementById("seats-STP").value);
    let seatsSTC = checkIsInt(document.getElementById("seats-STC").value);
    // FIRST CLASS
    let seatsFCA = checkIsInt(document.getElementById("seats-FCA").value);
    let seatsFCP = checkIsInt(document.getElementById("seats-FCP").value);
    let seatsFCC = checkIsInt(document.getElementById("seats-FCC").value);
    // Get film info
    let movie_day = document.getElementById("movie-day").value;
    let movie_hour = document.getElementById("movie-hour").value;
    //total
    let total =
        seatsSTA * 19.8 +
        seatsSTP * 17.5 +
        seatsSTC * 15.3 +
        seatsFCA * 30.0 +
        seatsFCP * 27.0 +
        seatsFCC * 24.0;
    let total_discounted =
        seatsSTA * 14.0 +
        seatsSTP * 12.5 +
        seatsSTC * 11.0 +
        seatsFCA * 24.0 +
        seatsFCP * 22.5 +
        seatsFCC * 21.0;
    document.getElementById("total").innerHTML = "$" + total.toFixed(2);
    document.getElementById("totalInput").value = total.toFixed(2) ;
    // Check discount
    // Check T12
    if (movie_hour == "T12" && movie_day != "SAT" && movie_day != "SUN") {
        document.getElementById("total-discounted").innerHTML =
            "$" + total_discounted.toFixed(2);
        document.getElementById("note").innerHTML = "Discount at 12pm on weekdays";
        document.getElementById("total").style.textDecoration = "line-through";
        document.getElementById("totalInput").value = total_discounted.toFixed(2) ;
        
    } else {
        // check MON && WED
        if ((movie_day == "MON" || movie_day == "WED") && movie_hour != "T12") {
            document.getElementById("total-discounted").innerHTML =
                "$" + total_discounted.toFixed(2);
            document.getElementById("totalInput").value = total_discounted.toFixed(2) ;
            document.getElementById("note").innerHTML =
                "Discount for All day Monday and Wednesday";
            document.getElementById("total").style.textDecoration = "line-through";           
        }
    }
}
// reset form Function
function resetForm() {
    document.getElementById("booking-form").reset();
    document.getElementById("total").innerHTML = "";
    document.getElementById("note").innerHTML="";
    document.getElementById("total-discounted").innerHTML ="";
    // reset title
    document.getElementById("movie-title").innerHTML = "MOVIE TITLE";
    document.getElementById("movie-title-day").innerHTML = "DAY";
    document.getElementById("movie-title-time").innerHTML = "TIME";
    // reset color
    var id_form = ["cust-name", "cust-mobile", "cust-card", "cust-email", "cust-expiry"];
    // Check if ALL inputs are CORRECT
    for (var i = 0; i < id_form.length; i++) {
        document.getElementById(id_form[i]).style.border = "1px solid black";
        document.getElementById(id_form[i]).style.background = "white";
    }
    //document.getElementById("submit_button").setAttribute("disabled", true);
}

// add EVENT to all SELECT
function addEventToAllSelect() {    
    x = document.querySelectorAll("select");
    for (i = 0; i < x.length; i++) {
        x[i].addEventListener("change", calPrice);
    }
}
document.getElementById('session_reset').addEventListener("change", calPrice);

// check is a NUM if true return this num, else return 0
function checkIsInt(tmp) {
    return (e = Number.isInteger(parseInt(tmp)) ? parseInt(tmp) : parseInt(0));
}

// check if the movie is chosen or not
function checkMovie() {    
     movieError = document.getElementById("movieError");
     movieError.style.display ='none';  
   
}

// check the INPUT of right booking form by RegEx
// function checkInput(val) {
//     name = document.getElementById(val).value;
//     id_val = document.getElementById(val);
//     // Get pattern from Name
//     if (val == "cust-name")
//         var patt = /^[a-zA-Z\,-.' ?]{1,100}$/;

//     // Get pattern from Email
//     if (val == "cust-email")
//         var patt = /^[a-z][a-z0-9_\.]{1,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/;

//     // Get pattern from Mobile
//     if (val == "cust-mobile")
//         var patt = /^(\(04\)|04|\+614)[ ]?\d{4}[ ]?\d{4}$/;

//     // Get pattern from Card
//     if (val == "cust-card")
//         var patt = /^\d{4}[ ]?\d{4}[ ]?\d{4}[ ]?\d{1,4}[ ]?\d{0,3}?$/;

//     // Check the value by regEx
//     if (!patt.test(name)) {
//         id_val.style.border = "2px solid red";
//         id_val.style.background = "rgb(255, 238, 238)";
//         // id_val.classList.add("invalid");
//         // id_val.classList.remove("valid");
//     } else {
//         // id_val.classList.add("valid");
//         // id_val.classList.remove("invalid");
//         id_val.style.border = "2px solid green";
//         id_val.style.background = "#FFFFFF";
//     }
// }


// Check the EXPIRY INPUT of right booking form 
// function checkExpiry() {
//     // Get month and year from USERS
//     var id_expiry = document.getElementById("cust-expiry");
//     var expiry = document.getElementById("cust-expiry").value;
//     var year = parseInt(expiry.substring(0, 4));
//     var month = parseInt(expiry.substring(5));
//     // Get CURRENT time
//     var current_time = new Date();
//     // Check the expiry and current time
//     if (year > current_time.getFullYear()) {
//         id_expiry.style.border = "2px solid green";
//         id_expiry.style.background = "#FFFFFF";
//     }
//     if (year < current_time.getFullYear()) {
//         id_expiry.style.border = "2px solid red";
//         id_expiry.style.background = "rgb(255, 238, 238)";
//     }
//     if (year == current_time.getFullYear()) {
//         if (month >= (current_time.getMonth() + 1)) {
//             id_expiry.style.border = "2px solid green";
//             id_expiry.style.background = "#FFFFFF";
//         } else {
//             id_expiry.style.border = "2px solid red";
//             id_expiry.style.background = "rgb(255, 238, 238)";
//         }
//     }
// }


// Enabled the button if requirements are ALL correct
// function enableButton() {
    
//     var count = 0;
//     var id_form = ["cust-name", "cust-mobile", "cust-card", "cust-email", "cust-expiry"];
//     // Check if ALL inputs are CORRECT
//     for (var i = 0; i < id_form.length; i++) {
//         if (document.getElementById(id_form[i]).style.border == "2px solid green") {
//             count += 1;
//         } else {
//             count = 0;
//         }
//     };
//     // Check whether movie is chosen or not   
//     if(document.getElementById('movie-id').value ==""){
//         count=0;
//     } else {
//         count+=1;
//     }
//     // Check whether seat is chosen or not
//     var countSeats = 0;
//     var id_Seats = ["seats-STA", "seats-STP", "seats-STC", "seats-FCA","seats-FCP", "seats-FCC"];
//     // Check if ALL inputs are CORRECT
//     for (var j = 0; j < id_Seats.length; j++) {        
//         if(document.getElementById(id_Seats[j]).value !=""){
//             countSeats+=1;            
//         }       
//     };
   
    
    
//     // Enabled the submit button. If not, remain disabled  
//     if (count == 6 && countSeats >= 1) {
//         document.getElementById("submit_button").removeAttribute("disabled");
//     } else {
//         if (!document.getElementById("submit_button").hasAttribute("disabled")) {
//             document.getElementById("submit_button").setAttribute("disabled", true);
//         }
//     }
// }

// Toggle Debug Module
function toggleDebugModule(){
    // get references to DebugModule  
    let dmd = document.getElementById("DebugModule");    
    // toggle style.display state of div
    if (dmd.style.display == "none") {
        dmd.style.display = "block";      
    } else{
        dmd.style.display = "none";      
    }
    
   
  }


