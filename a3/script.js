//  LIST OF MOVIES
var movieList ={
    Avengers:{
        "id":"ACT",
        "name":"Avengers: Endgame",
        "rating":"PG-13",
        "description":"After the devastating events of Avengers: Infinity War (2018), the universe is in ruins due to the efforts of the Mad Titan, Thanos. With the help of remaining allies, the Avengers must assemble once more in order to undo Thanos's actions and undo the chaos to the universe, no matter what consequences may be in store, and no matter who they face...",
        "link":"https://www.youtube.com/embed/TcMBFSGVi1c",
        "schedule": [
            { "day":"WED","time":"9","period":"P.M" },
            { "day":"FRI","time":"9","period":"P.M" },
            { "day":"SAT","time":"6","period":"P.M" },
            { "day":"SUN","time":"6","period":"P.M" }
        ]
    },
    Wedding:{
        "id":"RMC",
        "name":"Top End Wedding",
        "rating":"M",
        "description":"Lauren and Ned are engaged, they are in love, and they have just ten days to find Lauren's mother who has gone AWOL somewhere in the remote far north of Australia, reunite her parents and pull off their dream wedding.",
        "link":"https://www.youtube.com/embed/uoDBvGF9pPU",
        "schedule": [
            { "day":"MON","time":"6","period":"P.M" },
            { "day":"TUE","time":"6","period":"P.M" },
            { "day":"SAT","time":"3","period":"P.M" },
            { "day":"SUN","time":"3","period":"P.M" }
        ]
    },
    Dumbo:{
        "id":"ANM",
        "name":"Dumbo",
        "rating":"PG",
        "description":"A young elephant, whose oversized ears enable him to fly, helps save a struggling circus, but when the circus plans a new venture, Dumbo and his friends discover dark secrets beneath its shiny veneer.",
        "link":"https://www.youtube.com/embed/7NiYVoqBt-8",
        "schedule": [
            { "day":"MON","time":"12","period":"P.M" },
            { "day":"TUE","time":"12","period":"P.M" },
            { "day":"WED","time":"6","period":"P.M" },
            { "day":"FRI","time":"6","period":"P.M" },
            { "day":"SAT","time":"12","period":"P.M" },
            { "day":"SUN","time":"12","period":"P.M" }
        ]
    },
    Prince:{
        "id":"AHF",
        "name":"The Happy Prince",
        "rating":"R",
        "description":"The untold story of the last days in the tragic times of Oscar Wilde, a person who observes his own failure with ironic distance and regards the difficulties that beset his life with detachment and humor.",
        "link":"https://www.youtube.com/embed/4HmN9r1Fcr8",
        "schedule": [          
            { "day":"WED","time":"12","period":"P.M" },
            { "day":"FRI","time":"12","period":"P.M" },
            { "day":"SAT","time":"9","period":"P.M" },
            { "day":"SUN","time":"9","period":"P.M" }
        ]
    }
};
// function show detail in SYNOPSIS PANEL
function showDetail(key) {
    // variables

    // Title +Rating
    document.getElementById('synopsisTitle').innerHTML= movieList[key].name  ;
    document.getElementById('synopsisRating').innerHTML= movieList[key].rating ;
    // Description + Youtube
    document.getElementById('synopsisDescription').innerHTML= movieList[key].description ;
    document.getElementById('synopsisYoutube').src= movieList[key].link ;
    // btn Group
    var newBtnGroup = '<p style="padding-right:50px;  font-size: 20px">Making a book:</p>';
    for (const i in movieList[key].schedule) {
        let dayMovie = movieList[key].schedule[i].day ;
        let timeMovie = movieList[key].schedule[i].time ;
        let periodMovie= movieList[key].schedule[i].period ;
        newBtnGroup += ' <a  class="btn btn-info mr-3" style="margin-bottom: 10px" href="#Booking">' +dayMovie +" - "+ timeMovie +" "+periodMovie + '</a>';
         
    }
    document.getElementById('sysnopisBtnGroup').innerHTML= newBtnGroup ;
}
