//  LIST OF MOVIES
var movieList ={
    ACT:{
        "id":"ACT",
        "name":"Avengers: Endgame",
        "rating":"PG-13",
        "description":"After the devastating events of Avengers: Infinity War (2018), the universe is in ruins due to the efforts of the Mad Titan, Thanos. With the help of remaining allies, the Avengers must assemble once more in order to undo Thanos's actions and undo the chaos to the universe, no matter what consequences may be in store, and no matter who they face...",
        "link":"https://www.youtube.com/embed/TcMBFSGVi1c",
        "schedule": [
            { "day":"WED","time":"9 P.M","period":"T21" },
            { "day":"THU","time":"9 P.M","period":"T21" },
            { "day":"FRI","time":"9 P.M","period":"T21" },
            { "day":"SAT","time":"6 P.M","period":"T18" },
            { "day":"SUN","time":"6 P.M","period":"T18" }
        ]
    },
    RMC:{
        "id":"RMC",
        "name":"Top End Wedding",
        "rating":"M",
        "description":"Lauren and Ned are engaged, they are in love, and they have just ten days to find Lauren's mother who has gone AWOL somewhere in the remote far north of Australia, reunite her parents and pull off their dream wedding.",
        "link":"https://www.youtube.com/embed/uoDBvGF9pPU",
        "schedule": [
            { "day":"MON","time":"6 P.M","period":"T18" },
            { "day":"TUE","time":"6 P.M","period":"T18" },
            { "day":"SAT","time":"3 P.M","period":"T15" },
            { "day":"SUN","time":"3 P.M","period":"T15" }
        ]
    },
    ANM:{
        "id":"ANM",
        "name":"Dumbo",
        "rating":"PG",
        "description":"A young elephant, whose oversized ears enable him to fly, helps save a struggling circus, but when the circus plans a new venture, Dumbo and his friends discover dark secrets beneath its shiny veneer.",
        "link":"https://www.youtube.com/embed/7NiYVoqBt-8",
        "schedule": [
            { "day":"MON","time":"12 P.M","period":"T12" },
            { "day":"TUE","time":"12 P.M","period":"T12" },
            { "day":"WED","time":"6 P.M","period":"T18" },
            { "day":"THU","time":"6 P.M","period":"T18" },
            { "day":"FRI","time":"6 P.M","period":"T18" },
            { "day":"SAT","time":"12 P.M","period":"T12" },
            { "day":"SUN","time":"12 P.M","period":"T12" }
        ]
    },
    AHF:{
        "id":"AHF",
        "name":"The Happy Prince",
        "rating":"R",
        "description":"The untold story of the last days in the tragic times of Oscar Wilde, a person who observes his own failure with ironic distance and regards the difficulties that beset his life with detachment and humor.",
        "link":"https://www.youtube.com/embed/4HmN9r1Fcr8",
        "schedule": [          
            { "day":"WED","time":"12 P.M","period":"T12" },
            { "day":"THU","time":"12 P.M","period":"T12" },
            { "day":"FRI","time":"12 P.M","period":"T12" },
            { "day":"SAT","time":"9 P.M","period":"T21" },
            { "day":"SUN","time":"9 P.M","period":"T21" }
        ]
    }
};
// function show detail in SYNOPSIS PANEL
function showDetail(key) {
    // variables
    let movie_id =movieList[key].id;
    let movie_name =movieList[key].name;
    // Title +Rating
    document.getElementById('synopsisTitle').innerHTML= movieList[key].name  ;
    document.getElementById('synopsisRating').innerHTML= movieList[key].rating ;
    // Description + Youtube
    document.getElementById('synopsisDescription').innerHTML= movieList[key].description ;
    document.getElementById('synopsisYoutube').src= movieList[key].link ;
    // btn Group
    var newBtnGroup = '<p style="padding-right:50px;  font-size: 20px">Making a book:</p>';
    for (const i in movieList[key].schedule) {
        let movie_day = movieList[key].schedule[i].day ;
        let movie_time = movieList[key].schedule[i].time ;
        let movie_period= movieList[key].schedule[i].period ;
        newBtnGroup += ' <a  class="btn btn-info mr-3" style="margin-bottom: 10px" onclick="showBooking(\''+movie_id +'\',\''+ movie_name +'\',\''+ movie_day +'\',\''+ movie_time +'\',\''+movie_period  + '\');" href="#Booking">' +movie_day +" - "+ movie_time +'</a>';       
    }
    document.getElementById('sysnopisBtnGroup').innerHTML= newBtnGroup ;
}

// function show detail in BOOKING FORM
function showBooking(movie_id,movie_name,movie_day,movie_time,movie_period) {
    // change the title of BOOKING FORM    
    document.getElementById('movie-title').innerHTML= movie_name;
    document.getElementById('movie-title-day').innerHTML= changeDay(movie_day);
    document.getElementById('movie-title-time').innerHTML= movie_time;
    // change the HIDDEN INPUT of BOOKING
    document.getElementById('movie-id').value= movie_id;
    document.getElementById('movie-day').value= movie_day;
    document.getElementById('movie-hour').value= movie_period;
    // add Event to Select
    addEventtoAllSelect();
}
// function change to full day
function changeDay(movie_day) {
   
    if (movie_day == 'MON') {       
        return 'MONDAY';
    }
    if (movie_day == 'TUE') {       
        return 'TUESDAY';
    }
    if (movie_day == 'WED') {       
        return 'WEDNESDAY';
    }
    if (movie_day == 'THU') {       
        return 'THURSDAY';
    }
    if (movie_day == 'FRI') {       
        return 'FRIDAY';
    }
    if (movie_day == 'SAT') {       
        return 'SATURDAY';
    }
    if (movie_day == 'SUN') {       
        return 'SUNDAY';
    }
}
// function calculate prices
function calPrice() {
    // STANDARD
    let seatsSTA= checkIsInt(document.getElementById("seats-STA").value);
    let seatsSTP= checkIsInt(document.getElementById("seats-STP").value);  
    let seatsSTC= checkIsInt(document.getElementById("seats-STC").value); 
    // FIRST CLASS  
    let seatsFCA= checkIsInt(document.getElementById("seats-FCA").value); 
    let seatsFCP= checkIsInt(document.getElementById("seats-FCP").value);
    let seatsFCC= checkIsInt(document.getElementById("seats-FCC").value);
    // Get film info
    let movie_day= document.getElementById("movie-day").value;
    let movie_hour= document.getElementById("movie-hour").value;
    // Check discount
    if (movie_hour == 'T12' && (movie_day != 'SAT' && movie_day != 'SUN')) {
        console.log('yes, at 12 pm')
    } else {
        if((movie_day == 'MON' || movie_day == 'WED') && movie_hour != 'T12' ){
            console.log('yes, MON && WED');
        }
        else{
            console.log('NO');
        }
    }
    

    //total   
    let total = seatsSTA + seatsSTP + seatsSTC + seatsFCA + seatsFCP +seatsFCC;
    document.getElementById('total').innerHTML= total;
}
// add EVENT to all SELECT
function addEventtoAllSelect() {
    x = document.querySelectorAll("select");
  for (i = 0; i < x.length; i++) {
    x[i].addEventListener("change", calPrice);
  }   
}
// check is a NUM if true return this num, else return 0
function checkIsInt(tmp) {
     return e = (Number.isInteger(parseInt(tmp))) ? parseInt(tmp) : parseInt(0);
}
