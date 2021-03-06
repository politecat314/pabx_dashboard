<?php include 'include.php'; ?>

<html>

<head>




    <title>Phone Calls Dashboard</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">


    <style>
        .jumbotron {
            padding-top: 20px !important;
            padding-bottom: 20px !important;
            margin-bottom: 0rem;
        }
    </style>


<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <h1 class="display-4">Phone Calls Dashboard</h1>
                    <p class="lead">
                        <?php
                        echo "Total calls: " . (count($csv));
                        ?>
                        </br>
                        Full dataset contains
                        <span id='min_date' class="text-info font-weight-bold"><?php echo $min_date ?></span> to <span id='max_date' class="text-info font-weight-bold"><?php echo $max_date ?></span>
                    </p>

                </div>
                <div class="col">

                    <div class="form-group row">
                        <label for="example-date-input" class="col-2 col-form-label">Start</label>
                        <div class="col-10">
                            <input class="form-control" type="date" id="startdate" name="startdate" value=<?php echo $startdatephp ?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="example-date-input" class="col-2 col-form-label">End</label>
                        <div class="col-10">
                            <input class="form-control" type="date" id="enddate" name="enddate" value=<?php echo $enddatephp ?>>
                        </div>
                    </div>


                </div>

            </div>


        </div>
    </div>

    <nav id="top_navbar" class="navbar navbar-expand-lg navbar-dark sticky-top" style="background-color:#34495E">
        <div class="container">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link" href="department.php">Department</a>
                    <!-- <a class="nav-item nav-link" href="rawdata.php">Raw-data</a> -->

                </div>
            </div>
        </div>
    </nav>


    <div class="container" style="padding-top:2rem">
        <div class="row">
            <canvas id="callsPerDayChart" width="400" height="150"></canvas>
        </div>
    </div>
    <hr>


    <div class="container" style="padding-top: 1rem">
        <div class="row">
            <div class="col">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Phone call status (overall)</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">ANSWERED</th>
                            <td><?php echo $disposition["ANSWERED"]; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">NO ANSWER</th>
                            <td><?php echo $disposition["NO ANSWER"]; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">BUSY</th>
                            <td><?php echo $disposition["BUSY"]; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">FAILED</th>
                            <td><?php echo $disposition["FAILED"]; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col">
                <canvas id="donutDisposition" height="150"></canvas>
            </div>



        </div>
        <hr>
        <div class="row">


            <div class="col">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Phone call statistics (overall)</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Incoming</th>
                            <td>
                                <div class="dropdown show">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo array_sum($userfield['Inbound']); ?>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="pointer-events: none;">
                                        <div class="dropdown-item">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>ANSWERED</td>
                                                        <td><?php echo $userfield['Inbound']['ANSWERED']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NO ANSWER</td>
                                                        <td><?php echo $userfield['Inbound']['NO ANSWER']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>BUSY</td>
                                                        <td><?php echo $userfield['Inbound']['BUSY']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>FAILED</td>
                                                        <td><?php echo $userfield['Inbound']['FAILED']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Internal</th>
                            <td>
                                <div class="dropdown show">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo array_sum($userfield['Internal']); ?>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="pointer-events: none;">
                                        <div class="dropdown-item">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>ANSWERED</td>
                                                        <td><?php echo $userfield['Internal']['ANSWERED']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NO ANSWER</td>
                                                        <td><?php echo $userfield['Internal']['NO ANSWER']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>BUSY</td>
                                                        <td><?php echo $userfield['Internal']['BUSY']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>FAILED</td>
                                                        <td><?php echo $userfield['Internal']['FAILED']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Outgoing</th>
                            <td>
                                <div class="dropdown show">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo array_sum($userfield['Outbound']); ?>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="pointer-events: none;">
                                        <div class="dropdown-item">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>ANSWERED</td>
                                                        <td><?php echo $userfield['Outbound']['ANSWERED']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NO ANSWER</td>
                                                        <td><?php echo $userfield['Outbound']['NO ANSWER']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>BUSY</td>
                                                        <td><?php echo $userfield['Outbound']['BUSY']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>FAILED</td>
                                                        <td><?php echo $userfield['Outbound']['FAILED']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">External</th>
                            <td>
                                <div class="dropdown show">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <?php echo array_sum($userfield['External']); ?>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="pointer-events: none;">
                                        <div class="dropdown-item">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td>ANSWERED</td>
                                                        <td><?php echo $userfield['External']['ANSWERED']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>NO ANSWER</td>
                                                        <td><?php echo $userfield['External']['NO ANSWER']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>BUSY</td>
                                                        <td><?php echo $userfield['External']['BUSY']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>FAILED</td>
                                                        <td><?php echo $userfield['External']['FAILED']; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col">
                <canvas id="donutUserfield" height="150"></canvas>
            </div>



        </div>


    </div>

    <div style="background-color:#F8F8F8">
        <hr>
        <div class="container">
            <div class="row">
                <canvas id="callByDispositionBarChart" width="400" height="200"></canvas>
            </div>
        </div>
        <hr>
    </div>


    <div class="container datatable-container">
        <div class="">
            <h2>Caller data</h2>
        </div>
        <div class="">
            <table id="caller_data" class="display table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Exit</th> <!-- caller and callee number both appear here-->
                        <th>Total call time</th>
                        <th>Answered</th>
                        <th>No answer</th>
                        <th>Busy</th>
                        <th>Failed</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $iterator = 0;
                    generateCallerNumDatatable($caller_num_data);

                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <hr id="hr_above_bigButton">
    <div class="container">
        <button id="bigbutton" type="button" class="btn btn-primary btn-lg btn-block">Show section statistics</button>
    </div>
    <hr id="hr_below_bigButton">
    <div id="hiddenDiv" style="display: none;">

        <div class="container datatable-container">

            <div class="">
                <h2 id="inbound_caller_data_heading">Incoming caller data</h2>
            </div>

            <div class="">
                <table id="inbound_caller_data" class="display table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Callee number</th>
                            <th>Total call time</th>
                            <th>ANSWERED</th>
                            <th>NO ANSWER</th>
                            <th>BUSY</th>
                            <th>FAILED</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        generateCallerNumDatatable($caller_num_data_by_userfield['Inbound']);

                        ?>
                    </tbody>
                </table>



            </div>


        </div>

        <hr />
        <div class="container datatable-container">

            <div class="">
                <h2 id="internal_caller_data_heading">Internal caller data</h2>
            </div>

            <div class="">
                <table id="internal_caller_data" class="display table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Caller number</th>
                            <th>Total call time</th>
                            <th>ANSWERED</th>
                            <th>NO ANSWER</th>
                            <th>BUSY</th>
                            <th>FAILED</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        generateCallerNumDatatable($caller_num_data_by_userfield['Internal']);

                        ?>
                    </tbody>
                </table>



            </div>


        </div>

        <hr />
        <div class="container datatable-container">

            <div class="">
                <h2 id="outbound_caller_data_heading">Outgoing caller data</h2>
            </div>

            <div class="">
                <table id="outbound_caller_data" class="display table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Caller number</th>
                            <th>Total call time</th>
                            <th>ANSWERED</th>
                            <th>NO ANSWER</th>
                            <th>BUSY</th>
                            <th>FAILED</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        generateCallerNumDatatable($caller_num_data_by_userfield['Outbound']);

                        ?>
                    </tbody>
                </table>



            </div>


        </div>

        <hr />
        <div class="container datatable-container">

            <div class="">
                <h2 id="external_caller_data_heading">External caller data</h2>
            </div>

            <div class="">
                <table id="external_caller_data" class="display table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Callee number</th>
                            <th>Total call time</th>
                            <th>ANSWERED</th>
                            <th>NO ANSWER</th>
                            <th>BUSY</th>
                            <th>FAILED</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        generateCallerNumDatatable($caller_num_data_by_userfield['External']);

                        ?>
                    </tbody>
                </table>



            </div>


        </div>






    </div>


    <!-- Footer -->
    <div style="padding-top:2rem">
        <footer class="bg-light text-center text-lg-start">


            <!-- Copyright -->
            <div class="text-center p-3" style="background-color:#85929E">
                By Aman.
                <a class="text-light" href="https://drive.google.com/file/d/1fUzPoq-PpmsJGjD1Elv6IpoxyyzRFhrx/view?usp=sharing">API Documentation.</a>
                <a class="text-light" href="<?php echo $datafile;?>">Download csv</a>
            </div>
            <!-- Copyright -->
        </footer>
    </div>
    <!-- Footer -->

    <!--loading scripts from disk-->
    <script src="/optimized/scripts/jquery-3.5.1.min.js"></script>
    <script src="/optimized/scripts/popper.min.js"></script>
    <script src="/optimized/scripts/bootstrap.min.js"></script>



    <script src="/optimized/scripts/jquery.dataTables.min.js"></script>
    <script src="/optimized/scripts/dataTables.buttons.min.js"></script>
    <script src="/optimized/scripts/jszip.min.js"></script>
    <script src="/optimized/scripts/pdfmake.min.js"></script>
    <script src="/optimized/scripts/vfs_fonts.js"></script>
    <script src="/optimized/scripts/buttons.html5.min.js"></script>
    <script src="/optimized/scripts/buttons.print.min.js"></script>
    <script src="/optimized/scripts/dataTablesDateSort.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>


    <!-- label plugin for chartjs -->
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

    <script>
        // previous colours used in canvasjs
        previousCanvasJSColors = ["#9BBB58", "#C0504E", "#4F81BC", "#23BFAA", ];
    </script>

    <script src='document.js'></script>

    <script>
        // Calls per day graph

        const days = <?php echo json_encode($days, JSON_NUMERIC_CHECK); ?>;
        const days_disposition = <?php echo json_encode($days_disposition, JSON_NUMERIC_CHECK); ?>;
        // console.log(days_disposition);

        // CHART JS DOC
        var ctx = document.getElementById('callsPerDayChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(days),
                datasets: [{
                        label: 'Answered',
                        data: days_disposition[0],
                        backgroundColor: 'rgba(75, 192, 192, 0)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        // borderWidth: 1
                    }, {
                        label: 'No answer',
                        data: days_disposition[1],
                        backgroundColor: 'rgba(255, 99, 132, 0)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        hidden: false
                        // borderWidth: 1
                    }, {
                        label: 'Busy',
                        data: days_disposition[2],
                        backgroundColor: 'rgba(54, 162, 235, 0)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        hidden: false
                        // borderWidth: 1
                    }, {
                        label: 'Failed',
                        data: days_disposition[3],
                        backgroundColor: 'rgba(255, 206, 86, 0)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        hidden: false
                        // borderWidth: 1
                    },
                    {
                        label: 'Total',
                        data: days_disposition[4],
                        backgroundColor: 'rgba(153, 102, 255, 0)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        // backgroundColor: [
                        //     'rgba(255, 99, 132, 0.2)', // red
                        //     'rgba(54, 162, 235, 0.2)',
                        //     'rgba(255, 206, 86, 0.2)',
                        //     'rgba(75, 192, 192, 0.2)', // light green
                        //     'rgba(153, 102, 255, 0.2)',
                        //     'rgba(255, 159, 64, 0.2)'
                        // ],
                        // borderColor: [
                        //     'rgba(255, 99, 132, 1)', // red
                        //     'rgba(54, 162, 235, 1)',
                        //     'rgba(255, 206, 86, 1)',
                        //     'rgba(75, 192, 192, 1)', // light green
                        //     'rgba(153, 102, 255, 1)',
                        //     'rgba(255, 159, 64, 1)'
                        // ],
                        // borderWidth: 1
                    },
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                title: {
                    display: true,
                    text: 'Number of calls by day',
                    fontSize: 20
                },
                legend: {
                    display: true
                },
                
            }
        });
    </script>



    <script>
        // Disposition donut chart
        const disposition = <?php echo json_encode($disposition, JSON_NUMERIC_CHECK); ?>;

        var ctx1 = document.getElementById('donutDisposition').getContext('2d');

        var myDoughnutChart = new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: Object.keys(disposition),
                datasets: [{
                    //label: '# of Tomatoes',
                    data: Object.values(disposition),
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',

                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: false,
                    text: 'Phone call status (overall)',
                    //fontSize: 20
                },
                plugins: {
                    labels: {
                        render: 'percentage',
                        fontColor: 'black',
                        fontStyle: 'bold',
                    }
                }
            }
        });
    </script>
    <script>
        // call by disposition bar chart
        const answered = <?php echo json_encode($answered, JSON_NUMERIC_CHECK); ?>;
        const no_answer = <?php echo json_encode($no_answer, JSON_NUMERIC_CHECK); ?>;
        const busy = <?php echo json_encode($busy, JSON_NUMERIC_CHECK); ?>;
        const failed = <?php echo json_encode($failed, JSON_NUMERIC_CHECK); ?>;


        departments = []

        answered.forEach(array => departments.push(array['label']));


        var callByDispositionBarChart = document.getElementById("callByDispositionBarChart").getContext("2d");
        window.myBar = new Chart(callByDispositionBarChart, {
            type: "bar",
            data: {
                labels: departments,
                datasets: [{
                        label: "ANSWERED",
                        data: Object.values(answered),
                        backgroundColor: 'rgba(75, 192, 192, 0.8)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: "NO ANSWER",
                        data: Object.values(no_answer),
                        backgroundColor: 'rgba(255, 99, 132, 0.8)',
                        borderColor: 'rgba(255,99,132,1)',
                        borderWidth: 1
                    },
                    {
                        label: "BUSY",
                        data: Object.values(busy),
                        backgroundColor: 'rgba(54, 162, 235, 0.8)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: "FAILED",
                        data: Object.values(failed),
                        backgroundColor: 'rgba(255, 206, 86, 0.8)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    }
                ],
            },
            options: {
                plugins: {
                    labels: {
                        // render 'label', 'value', 'percentage', 'image' or custom function, default is 'percentage'
                        render: 'value',
                    }

                },
                responsive: true,
                legend: {
                    position: "top"
                },
                title: {
                    display: true,
                    text: "Phone call statistics by department",
                    fontSize: 20
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        // Userfield Donut
        const userfield = <?php echo json_encode($userfield, JSON_NUMERIC_CHECK); ?>;

        function sum(array) {
            total = 0;
            Object.values(array).forEach(element => total += element);
            return total;
        }


        var ctx2 = document.getElementById('donutUserfield').getContext('2d');
        // Disposition donut
        var myDoughnutChart = new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: Object.keys(userfield),
                datasets: [{
                    //label: '# of Tomatoes',
                    data: [sum(userfield['Inbound']), sum(userfield['Internal']), sum(userfield['Outbound']), sum(userfield['External'])],
                    backgroundColor: [
                        'rgba(0, 63, 92,0.8)',
                        'rgba(122, 81, 149,0.8)',
                        'rgba(239, 86, 117,0.8)',
                        'rgba(255, 166, 0,0.8)'
                    ],
                    borderColor: [
                        'rgba(0, 63, 92,1)',
                        'rgba(122, 81, 149,1)',
                        'rgba(239, 86, 117,1)',
                        'rgba(255, 166, 0,1)'

                    ],
                    borderWidth: 1
                }]
            },
            options: {
                title: {
                    display: false,
                    text: 'Phone call status (overall)',
                    //fontSize: 20
                },
                plugins: {
                    labels: {
                        render: 'percentage',
                        fontColor: 'white',
                        fontStyle: 'bold',
                    }
                }
            }
        });
    </script>





</body>

</html>