<?php
$start = $_GET['start'];
$end = $_GET['end'];

if($start == "") {
    $start = date("Y-m-d");
}
if($end == "") {
    $end = date("Y-m-d");
}
?>

<html>
    <head>
        <title>Gas Prices</title>
        <script src="https://cdn.plot.ly/plotly-2.16.1.min.js"></script>
        <style type="text/css">      
            html, body, #container { 
                width: 100%; height: 100%; margin: 0; padding: 0; 
            }
        </style>
    </head>
    <body>
        <div id="container"></div>
        <script>
            // Todays date
            var today = new Date().toISOString().slice(0, 10);

            var startDate = "<?php echo $start; ?>";
            var endDate = "<?php echo $end; ?>";

            // Startzeit
            var start = new Date(startDate); // Start of day (00:00)
            start.setHours(0, 0, 0, 0);
            // Endzeit
            var end = new Date(endDate); // End of day (23:59)
            end.setHours(23, 59, 59, 999);

            // Only allow time frame of max. 1 month
            if(end-start > 2700000000) {
                alert("Please only select a time-window of 1 month or less");
            }

            var traces = [];

            var layout = {
                title: 'Gas prices - Diesel - ' + startDate + ' to ' + endDate,
                xaxis: {
                    fixedrange: true,
                    range: [start, end],
                    type: 'date'
                },
                yaxis: {
                    autorange: true,
                    type: 'linear'
                }
            };

            getPrices();

            Plotly.newPlot('container', traces, layout);

            function getPrices() {
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                    const myData = JSON.parse(this.responseText);
                    myData.forEach((item) => {
                        var time = Date.parse(item.timestamp);
                        var name = item.brand + " (" + item.street + ", " + item.city + ")";
                        if(traces.length == 0) {
                            traces.push({
                                x: [time],
                                y: [item.diesel],
                                name: name,
                                type: 'line'
                            });
                        }
                        else {
                            var newTrace = true;
                            var index = 0;
                            for(j = 0; j < traces.length; j++) {
                                if(name == traces[j].name) {
                                    newTrace = false;
                                    index = j;
                                    break;
                                }
                            }
                            if(newTrace) {
                                console.log("New Trace: " + name);
                                traces.push({
                                    x: [time],
                                    y: [item.diesel],
                                    name: name,
                                    type: 'line'
                                });
                            }
                            else {
                                traces[index].x.push(time);
                                traces[index].y.push(item.diesel);
                            }
                        }
                    });
                    Plotly.newPlot('container', traces, layout);
                }
                const link = "query.php?start="+startDate+"&end="+endDate;
                console.log(link);
                xmlhttp.open("GET", link);
                xmlhttp.send();
            }
        </script>
    </body>
</html>