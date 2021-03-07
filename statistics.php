<?php
session_start();
require_once 'config.php';
//mysql_set_charset("utf8");
header('Content-Type: text/html; charset=ISO-8859-1');
if ($_SESSION['login']==1) {
    $id_user = $_SESSION['id'];
    $today = date('Y-m-d', time()); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistics v5</title>
    <!-- <script src="http://code.jquery.com/jquery-1.9.0.js"></script> -->
    <!--<script src="jquery.min.js"></script>-->
    <!--<script src="respond.min.js"></script>-->
    <script src="inc/js/jquery-1.9.1.js"></script>
    <!-- <script src="inc/js/jquery.grid-a-licious.js"></script> -->
    <script src="inc/js/masonry.pkgd.min.js"></script>



    <!-- <link rel="stylesheet" href="inc/css/todo.css" type="text/css" /> -->
    <link rel="stylesheet" href="inc/css/style.css">
    <link rel="stylesheet" href="inc/css/normalize.css">
    <link rel="stylesheet" href="inc/css/skeleton.css">
    <link rel="stylesheet" href="inc/css/icon-font.css">

<!--    <script src="inc/js/statistics.js"></script>-->
   
    <!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" /> -->
    
    
    
    
    <script src="inc/js/Chart.bundle.js"></script>
	<script src="inc/js/utils.js"></script>
    
    
    <script   src="https://code.jquery.com/jquery-3.3.1.js"   integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="   crossorigin="anonymous"></script>
    
    
    <style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
	</style>

</head>

<body>

<div class="container">


  <!-- date & menu -->
  <div class="date_menu" class="row">
		<!-- today -->
    <div id="date" class="three columns">
			<div class="sitename">Todo</div>
			<div class="number">

        <?php
        $re = mysql_query("SELECT Count(`check_value`) as todoleft FROM `todo`
left join category on category.id = todo.category
WHERE todo.user = $id_user AND category.archive = 'false' AND todo.check_value = 'false'");
    while ($tag = mysql_fetch_object($re)) {
        echo  $tag->todoleft;
    } ?>

      </div>
			<div class="description">Points</div>






		</div>
		<!-- menu / weather -->
    <div id="menu" class="three columns u-pull-right">
			<a href="today.php"><div data-icon="d" class="icon"></div></a>
      <a href="todo.php"><div style="color:black;" data-icon="o" class="icon"></div></a>
      <a href="map.php"><div data-icon="e" class="icon"></div></a>
      <a href="timeline.php"><div data-icon="f" class="icon"></div></a>
	</div>
  </div>

</div>


<section id="statistics">


<div id="container" style="
width: 90%;
position: relative;
left: 5%;
top: 100px;">
	
	
<div style="
width: 30%;
height: 50%;
position: relativ;
float: left;
">
<canvas id="myChart" style="
height: 100;
width: 100;" ></canvas>
</div>


<div style="
width: 30%;
height: 50%;
position: relativ;
float: left;
">
<canvas id="locations" style="
height: 100;
width: 100;"></canvas>
</div>

<div style="
width: 30%;
height: 50%;
position: relativ;
float: left;
">
<canvas id="activity" style="
height: 100;
width: 100;"></canvas>
</div>


<div style="
position: relative;
top: 50%;
width: 60%;
height: 20%;
">
<canvas id="month" style="
height: 80;
width: 1000;"></canvas>
</div>





<script>
    

var type = 'linear';
var canvas = document.getElementById('myChart');
var canvas_locations = document.getElementById('locations');
var canvas_activity = document.getElementById('activity');
var canvas_month = document.getElementById('month');
    

    var data_location = {
        options: {
				responsive: true,
				title: {
					display: true,
					text: 'Chart.js Line Chart - ' + type
				},
				scales: {
					xAxes: [{
						display: true,
					}],
					yAxes: [{
						display: true,
						type: 'logarithmic'
					}]
				}
			},
    labels: [],
    datasets: [
        {
            type: 'doughnut',
            fill: 'origin',
            label: "This Month",
            fill: true,
            lineTension: 0,
            backgroundColor: "rgba(64,122,241,1)",
//            borderColor: "rgba(64,122,241,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0,
            borderJoinStyle: 'miter',
//            pointBorderColor: "rgba(64,122,241,1)",
            pointBackgroundColor: "#fff",
//            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(64,122,241,1)",
            pointHoverBorderColor: "rgba(64,122,241,1)",
            pointHoverBorderWidth: 0,
            pointRadius: 0,
            pointHitRadius: 10,
            data: ["0"],
            backgroundColor: [
						"rgba(64,122,241,1)",
						"rgba(64,122,241,0.9)",
						"rgba(64,122,241,0.8)",
						"rgba(64,122,241,0.7)",
						"rgba(64,122,241,0.6)",
                        "rgba(64,122,241,0.5)",
						"rgba(64,122,241,0.4)",
						"rgba(64,122,241,0.3)",
						"rgba(64,122,241,0.2)",
						"rgba(64,122,241,0.1)",
					],
            
        }
    ]
        
    };
    
    
var data_1 = {
    options: {
				responsive: true,
				title: {
					display: true,
					text: 'Chart.js Line Chart - ' + type
				},
				scales: {
					xAxes: [{
						display: true,
					}],
					yAxes: [{
						display: true,
						type: 'logarithmic'
					}]
				}
			},
    labels: [],
    datasets: [
        {
//            type: 'bar',
            fill: 'origin',
            label: "This Month",
            fill: true,
            lineTension: 0,
            backgroundColor: "rgba(64,122,241,1)",
            borderColor: "rgba(64,122,241,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(64,122,241,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(64,122,241,1)",
            pointHoverBorderColor: "rgba(64,122,241,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 10,
            data: ["0"],
        },
        
        {
//            type: 'bar',
            fill: 'origin',
            label: "Previous Month",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(93,171,244,1)",
            borderColor: "rgba(93,171,244,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(93,171,244,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(93,171,244,1)",
            pointHoverBorderColor: "rgba(93,171,244,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 10,
            data: ["0"],
        }
    ]
    
};
    
var data_month = {
    options: {
				responsive: true,
				title: {
					display: true,
					text: 'Chart.js Line Chart - ' + type
				},
				scales: {
					xAxes: [{
						display: true,
					}],
					yAxes: [{
						display: true,
						type: 'logarithmic'
					}]
				}
			},
    labels: [],
    datasets: [
        {
            type: 'bar',
            fill: 'origin',
            label: "This Month",
            fill: true,
            lineTension: 0,
            backgroundColor: "rgba(64,122,241,1)",
            borderColor: "rgba(64,122,241,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(64,122,241,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(64,122,241,1)",
            pointHoverBorderColor: "rgba(64,122,241,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 10,
            data: ["0"],
        },
        
        {
            type: 'bar',
            fill: 'origin',
            label: "Previous Month",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(93,171,244,1)",
            borderColor: "rgba(93,171,244,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(93,171,244,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(93,171,244,1)",
            pointHoverBorderColor: "rgba(93,171,244,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 10,
            data: ["0"],
        },
        {
            type: 'line',
            fill: 'none',
            label: "Previous Month",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(93,171,244,1)",
            borderColor: "rgba(93,171,244,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(93,171,244,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(93,171,244,1)",
            pointHoverBorderColor: "rgba(93,171,244,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 10,
            data: ["0"],
        },
        {
            type: 'bar',
            fill: 'origin',
            label: "Previous Month",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(93,171,244,1)",
            borderColor: "rgba(93,171,244,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(93,171,244,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(93,171,244,1)",
            pointHoverBorderColor: "rgba(93,171,244,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 10,
            data: ["0"],
        }
    ]
    
};

    
        
function accumilate() {
    
    var new_array = [];
    
    var myarray = myLineChart.data.datasets[0].data;
myarray.reduce(function(a,b,i) { return new_array[i] = a+b; },0);
//new_array // [5, 15, 18, 20]

 myLineChart.data.datasets[0].data = new_array;
    
  myLineChart.update();
    
}

    var host = "localhost";
    var directory = "statistics";
    
function get_data() {
    
    
    $.getJSON("http://" + host + "/" + directory + "/graphing.php", function(data) {
        
//        alert(data);
        
//        $('section#statistics').append(data);
        
//        alert(data['current'][0]);
        
        
        
        // update chart!
        
        myLineChart.data.labels = data['ledgend_activity'];
        myLineChart.data.datasets[0].data = data['current'];
        myLineChart.data.datasets[1].data = data['previous'];
        
        
        location_chart.data.labels = data['ledgend_location'];
        location_chart.data.datasets[0].data = data['location_duration'];
        
        
        month_chart.data.labels = data['ledgend_date'];
        month_chart.data.datasets[0].data = data['month_run'];
        month_chart.data.datasets[1].data = data['month_bike'];
        month_chart.data.datasets[2].data = data['month_temp'];
        month_chart.data.datasets[3].data = data['month_walk'];
        
        
        myLineChart.update();
        location_chart.update();
        activity_chart.update();
        month_chart.update();
        

        
    });
}    
              

get_data();

    
    

var option = {
	showLines: false
};

    
    
    
    
    
    
    
    
    
    
    
var month_chart = new Chart (canvas_month,{
    type: 'bar',
    //fill: 'origin',
	data: data_month,
    options: {
        legend: {
            display: false,
            labels: {
                fontColor: 'rgb(255, 99, 132)'
            }
        },
        tooltips: {
        mode: 'index',
            axis: 'y'
        },
        animation: {
            duration: 300, // general animation time
            easing: 'easeInSine',
        },
        hover: {
            animationDuration: 0.1, // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 0.2, // animation duration after a resize
        plugins: {
            filler: {
                propagate: true
            }
        },
        scales: {
    xAxes: [{
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                    
                },
                display: false
            }],
    yAxes: [{
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                },
                display: false
            }]
    }
    }
    
});    
    
    
    
    
    
    
    
    
    
var activity_chart = new Chart (canvas_activity,{
    type: 'radar',
    //fill: 'origin',
	data:data_1,
    options: {
        legend: {
            display: false,
            labels: {
                fontColor: 'rgb(255, 99, 132)'
            }
        },
        tooltips: {
        mode: 'index',
            axis: 'y'
        },
        animation: {
            duration: 300, // general animation time
            easing: 'easeInSine',
        },
        hover: {
            animationDuration: 0.1, // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 0.2, // animation duration after a resize
        plugins: {
            filler: {
                propagate: true
            }
        },
        scales: {
    xAxes: [{
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                    
                },
                display: false
            }],
    yAxes: [{
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                },
                display: false
            }]
    }
    }
    
});    
    
    
    
var location_chart = new Chart (canvas_locations,{
    type: 'doughnut',
    //fill: 'origin',
	data:data_location,
    options: {
        legend: {
            display: false,
            labels: {
                fontColor: 'rgb(255, 99, 132)'
            }
        },
        tooltips: {
        mode: 'index',
            axis: 'y'
        },
        animation: {
            duration: 300, // general animation time
            easing: 'easeInSine',
        },
        hover: {
            animationDuration: 0.1, // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 0.2, // animation duration after a resize
        plugins: {
            filler: {
                propagate: true
            }
        },
        scales: {
    xAxes: [{
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                    
                },
                display: false
            }],
    yAxes: [{
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                },
                display: false
            }]
    }
    }
    
});
    

var myLineChart = new Chart (canvas,{
    type: 'bar',
    //fill: 'origin',
	data:data_1,
    options: {
        legend: {
            display: false,
            labels: {
                fontColor: 'rgb(255, 99, 132)'
            }
        },
        tooltips: {
        mode: 'index',
            axis: 'y'
        },
        animation: {
            duration: 300, // general animation time
            easing: 'easeInSine',
        },
        hover: {
            animationDuration: 0.1, // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 0.2, // animation duration after a resize
        plugins: {
            filler: {
                propagate: true
            }
        },
        scales: {
    xAxes: [{
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                    
                },
                display: true
            }],
    yAxes: [{
                gridLines: {
                    color: "rgba(0, 0, 0, 0)",
                },
                display: false
            }]
    }
    }
});
    
    
    
    
    
    
    
    
    

</script>










    </div>
</section>




</body>
</html>

<?php

} else {
    header('Location: http://'.$host.'/login.php');
}

?>
