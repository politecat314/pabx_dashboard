<?php include 'include.php'; ?>

<html>

<head>




    <title>Phone Calls Dashboard</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- Select picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">


    <style>
        .jumbotron {
            padding-top: 20px !important;
            padding-bottom: 20px !important;
            margin-bottom: 0rem;
        }

        .container.datatable-container {}
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
                    <a class="nav-item nav-link" href="#">Department</a>
                    <a class="nav-item nav-link" href="rawdata.php">Raw-data</a>
                    <a class="nav-item nav-link" href="#">Info</a>
                </div>
            </div>
        </div>
    </nav>


    <div class="container" style="padding-top:2rem">

        <div class="row">
            <canvas id="callsPerDayChart" width="400" height="100"></canvas>
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
                            <th scope="row">Inbound</th>
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
                            <th scope="row">Outbound</th>
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
    <hr>
    <div class="container">
        <div class="row">
            <canvas id="callByDispositionBarChart" width="400" height="200"></canvas>
        </div>
    </div>

    <div style="background-color:#F8F8F8">
        <hr>
        <div class="container">
            <div class="row" style="padding-bottom:5px">
                <h3>Generate graphs</h3>
            </div>
            <div class="row">
                <div class="col-5" style="padding-left:0px; padding-right:5px">
                    <select id="department_selector" class="selectpicker" data-style="btn-outline-dark" data-live-search="true" data-width="100%" title="Choose a department">
                        <?php
                        foreach ($department_donuts as $dept_name => $value) {
                            echo "<option>$dept_name</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class="col" style="padding-left:0px">
                    <button type="submit" class="btn btn-primary mb-2" id="generate_graph_button">Generate graphs</button>
                </div>
            </div>

            <div style="display: none;" id="departmentDonutsContainerDiv">
                <div class="row" style="padding:1rem">
                    <div class="col" id="inboundDepartmentDonutParentDiv" class="department_donut">
                        <canvas id="inboundDepartmentDonut" height="150"></canvas>
                    </div>
                    <div class="col" id="internalDepartmentDonutParentDiv" class="department_donut">
                        <canvas id="internalDepartmentDonut" height="150"></canvas>
                    </div>
                </div>

                <div class="row" style="padding:1rem">
                    <div class="col" id="outboundDepartmentDonutParentDiv" class="department_donut">
                        <canvas id="outboundDepartmentDonut" height="150"></canvas>
                    </div>
                    <div class="col" id="externalDepartmentDonutParentDiv" class="department_donut">
                        <canvas id="externalDepartmentDonut" height="150"></canvas>
                    </div>
                </div>
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
                        <th>Total talk time</th>
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
        <button id="bigbutton" type="button" class="btn btn-primary btn-lg btn-block">Show caller data grouped by userfield</button>
        </div><hr id="hr_below_bigButton">
    <div id="hiddenDiv" style="display: none;">

        <div class="container datatable-container">
            
                <div class="">
                    <h2 id="inbound_caller_data_heading">Inbound caller data</h2>
                </div>

                <div class="">
                    <table id="inbound_caller_data" class="display table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Callee number</th>
                                <th>Total talk time</th>
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
                                <th>Callee number</th>
                                <th>Total talk time</th>
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
                    <h2 id="outbound_caller_data_heading">Outbound caller data</h2>
                </div>

                <div class="">
                    <table id="outbound_caller_data" class="display table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Callee number</th>
                                <th>Total talk time</th>
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
                                <th>Total talk time</th>
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
            <a class="text-light" href="https://drive.google.com/file/d/1fUzPoq-PpmsJGjD1Elv6IpoxyyzRFhrx/view?usp=sharing">API Documentation</a>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <!--select picker-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

    <script>
        // previous colours used in canvasjs
        previousCanvasJSColors = ["#9BBB58", "#C0504E", "#4F81BC", "#23BFAA", ];
    </script>

    <script src='document.js'></script>

    <script>
        // Calls per day graph

        const days = <?php echo json_encode($days, JSON_NUMERIC_CHECK); ?>;
        // CHART JS DOC
        var ctx = document.getElementById('callsPerDayChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(days),
                datasets: [{
                    label: 'Day',
                    data: Object.values(days),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
                }]
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
                    display: false
                }
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
        //  inboundDepartmentDonut

        // var inboundDepartmentDonut = document.getElementById("inboundDepartmentDonut").getContext("2d");
        // window.myBar = new Chart(inboundDepartmentDonut, {
        //     type: 'doughnut',
        //     data: {
        //         labels: Object.keys(disposition),
        //         datasets: [{
        //             //label: '# of Tomatoes',
        //             data: Object.values(disposition),
        //             backgroundColor: [
        //                 'rgba(75, 192, 192, 0.8)',
        //                 'rgba(255, 99, 132, 0.8)',
        //                 'rgba(54, 162, 235, 0.8)',
        //                 'rgba(255, 206, 86, 0.8)',

        //             ],
        //             borderColor: [
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(255,99,132,1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',

        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         title: {
        //             display: true,
        //             text: 'Inbound',
        //             fontSize: 15
        //         }
        //     }
        // });


        // //  internalDepartmentDonut

        // var internalDepartmentDonut = document.getElementById("internalDepartmentDonut").getContext("2d");
        // window.myBar = new Chart(internalDepartmentDonut, {
        //     type: 'doughnut',
        //     data: {
        //         labels: Object.keys(disposition),
        //         datasets: [{
        //             //label: '# of Tomatoes',
        //             data: Object.values(disposition),
        //             backgroundColor: [
        //                 'rgba(75, 192, 192, 0.8)',
        //                 'rgba(255, 99, 132, 0.8)',
        //                 'rgba(54, 162, 235, 0.8)',
        //                 'rgba(255, 206, 86, 0.8)',

        //             ],
        //             borderColor: [
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(255,99,132,1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',

        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         title: {
        //             display: true,
        //             text: 'Internal',
        //             fontSize: 15
        //         }
        //     }
        // });


        // //  outboundDepartmentDonut

        // var outboundDepartmentDonut = document.getElementById("outboundDepartmentDonut").getContext("2d");
        // window.myBar = new Chart(outboundDepartmentDonut, {
        //     type: 'doughnut',
        //     data: {
        //         labels: Object.keys(disposition),
        //         datasets: [{
        //             //label: '# of Tomatoes',
        //             data: Object.values(disposition),
        //             backgroundColor: [
        //                 'rgba(75, 192, 192, 0.8)',
        //                 'rgba(255, 99, 132, 0.8)',
        //                 'rgba(54, 162, 235, 0.8)',
        //                 'rgba(255, 206, 86, 0.8)',

        //             ],
        //             borderColor: [
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(255,99,132,1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',

        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         title: {
        //             display: true,
        //             text: 'Outbound',
        //             fontSize: 15
        //         }
        //     }
        // });

        // var externalDepartmentDonut = document.getElementById("externalDepartmentDonut").getContext("2d");
        // window.myBar = new Chart(externalDepartmentDonut, {
        //     type: 'doughnut',
        //     data: {
        //         labels: Object.keys(disposition),
        //         datasets: [{
        //             // label: 'External',
        //             data: Object.values(disposition),
        //             backgroundColor: [
        //                 'rgba(75, 192, 192, 0.8)',
        //                 'rgba(255, 99, 132, 0.8)',
        //                 'rgba(54, 162, 235, 0.8)',
        //                 'rgba(255, 206, 86, 0.8)',

        //             ],
        //             borderColor: [
        //                 'rgba(75, 192, 192, 1)',
        //                 'rgba(255,99,132,1)',
        //                 'rgba(54, 162, 235, 1)',
        //                 'rgba(255, 206, 86, 1)',

        //             ],
        //             borderWidth: 1
        //         }]
        //     },
        //     options: {
        //         title: {
        //             display: true,
        //             text: 'External',
        //             fontSize: 15,
        //         }
        //     }
        // });
    </script>

    <script>
        const drawDepartmentDonut = function(data, elementId, donut_title) {
            let current_element = document.getElementById(elementId);
            parentDiv = current_element.parentNode;
            parentDiv.removeChild(current_element);

            parentDiv.innerHTML += `<canvas id="${elementId}" height=150></canvas>`;


            window.myBar = new Chart(document.getElementById(elementId).getContext("2d"), { // todo change to current_element
                type: 'doughnut',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        // label: 'External',
                        data: Object.values(data),
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
                        display: true,
                        text: donut_title,
                        fontSize: 15,
                    }
                }
            });
        }


        // generate graph button clicked
        const generate_graph_button = document.getElementById("generate_graph_button");
        const department_selector = document.getElementById("department_selector");
        const php_department_donut_data = <?php echo json_encode($department_donuts, JSON_NUMERIC_CHECK); ?>;
        const departmentDonutsContainerDiv = document.getElementById("departmentDonutsContainerDiv");
        generate_graph_button.onclick = function() {



            let current_department = department_selector.value;

            if (current_department === "") { // quit function if no department selected
                alert("Please select a department to generate graph");
                return;
            }
            departmentDonutsContainerDiv.style.display = "block";
            // console.log(php_department_donut_data[current_department]);

            // php_department_donut_data[current_department]['Inbound']
            // php_department_donut_data[current_department]['Internal']
            // php_department_donut_data[current_department]['Outbound']
            drawDepartmentDonut(php_department_donut_data[current_department]['Inbound'], "inboundDepartmentDonut", "Inbound");
            drawDepartmentDonut(php_department_donut_data[current_department]['Internal'], "internalDepartmentDonut", "Internal");
            drawDepartmentDonut(php_department_donut_data[current_department]['Outbound'], "outboundDepartmentDonut", "Outbound");
            drawDepartmentDonut(php_department_donut_data[current_department]['External'], "externalDepartmentDonut", "External");

        }
    </script>



</body>

</html>