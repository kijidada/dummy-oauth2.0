<?php
require_once '../MyApp/models/User.php';
session_start();
if(isset($_SESSION['usr'])) {
    $user = $_SESSION['usr'];
    $data = $_SESSION['alldata'];
}
else
    header('location:/public/');  
    
?>
<html>
<head>
<style type="text/css">

#chart-container1 {
    width: 1000px;
    height: 200px !important; 
}
#chart-container2 {
    width: 1000px;
    height: 200px !important; 
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <script>
        $(document).ready(function () {
            showGraph();
        });
        function getScatterData(data){
            var scData = [];
            for (var i in data) {
                scData.push({x:data[i][0],y:data[i][3]});                       
            }
            return scData;
        }
        function getCDFData(data){
            var cdfData = [];
            var k = 0;
            while (k <= 50) {
                var pt = jQuery.grep(data, function( n, i ) {
                            return ( n[3] <= k);
                            });
                cdfData.push({x:k,y:pt.length/data.length});
                //cdfData.push(pt.length/data.length);
                k=k+1;
            }
            console.log(cdfData);
            return cdfData;
        }
        function getxAxes()
        {
            var X = [];
            var k = 0;
            while (k <= 50) {
                X.push(k);
                k=k+1;
            }
            console.log(X);
            return X;
        }

        function showGraph()
        {
                var masterData = <?php echo json_encode($data); ?>;        //$data[0] = index , $data[2] = Roll,$data[3] = Marks
                var userRoll = <?php echo json_encode($user->get_userRoll()); ?>;
                var userData = jQuery.grep(masterData, function( n, i ) {
                            return ( n[2] == userRoll);
                            });
                var studentData = jQuery.grep(masterData, function( n, i ) {
                            return ( n[2] != userRoll);
                            }); 
                var chartdata = {
                        datasets: [
                            {
                                label: 'Student Marks',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: getScatterData(studentData)
                            },
                            {
                                label: 'My Marks',
                                backgroundColor: '#ff6384',
                                borderColor: '#ff6384',
                                data: getScatterData(userData)
                            }]
                    };

                var graphTarget = $("#graphCanvas");

                var barGraph = new Chart(graphTarget, {
                        type: 'scatter',
                        data: chartdata,
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }],
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: false
						            }
					        }]
                            },
                            tooltips: {
                                // Disable the on-canvas tooltip
                                enabled: false
                            }
                        }
                    });

                    var cdfTarget = $("#cdfCanvas");
                    var lineGraph = new Chart(cdfTarget, {
                        type: 'line',
                        data: {
                                labels: getxAxes(),
                                datasets: [{
                                    label: 'CDF of Marks',
                                    backgroundColor: '#49e2ff',
                                    borderColor: '#46d5f1',
                                    data: getCDFData(masterData)
                                }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }],
                                xAxes: [{
                                    display: true,
                                    scaleLabel: {
                                        display: false
						            }
					        }]
                            },
                            tooltips: {
                                // Disable the on-canvas tooltip
                                enabled: false
                            }
                        }
                    });
        }
        </script>
</head>
<body>
        Hello <?php print $user->get_userName()?>, <br/>
        You have successfully logged in!! <br/>
        Your score is <?php print $user->get_userScore()[0] ?>/<?php print $user->get_userScore()[1] ?> <br/>

<div id="chart-container1">
        <canvas id="graphCanvas" width="800" height="200"></canvas>
</div>
<br/>
<br/>
<br/>
<div id="chart-container2">
        <canvas id="cdfCanvas" width="800" height="200"></canvas>
</div>
<br/>
<br/>
<br/>
<a href="/public/?op=logout">log out</a>
    </body>
</html>