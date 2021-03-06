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
                    <a class="nav-item nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    <a class="nav-item nav-link active" href="#">Department</a>
                    <!-- <a class="nav-item nav-link" href="rawdata.php">Raw-data</a> -->

                </div>
            </div>
        </div>
    </nav>

    <div>
        <div class="container" style="padding-top:2rem;">

            <!-- <div class="row">
            <canvas id="callsPerDayChart" width="400" height="100"></canvas>
        </div> -->
            <div class="row">
                <canvas id="callByDispositionBarChart" width="400" height="200"></canvas>
            </div>


        </div>
        
    </div>

    <div style="background-color:#F8F8F8">
        <hr id="generate_graphs_scroll_location">
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
                <div class="col-5" style="padding-left:0px; padding-right:5px">
                    <select disabled id="department_employee_selector" class="selectpicker" data-style="btn-outline-dark" data-live-search="true" data-width="100%" title="Choose an employee">
                        <?php
                        // foreach ($department_employee_donuts as $ext) {
                        //     foreach ($ext as $key => $value) {
                        //         echo "<option>".$value[0]." (".$key.")</option>";
                        //     }
                        // }
                        ?>
                    </select>
                </div>
                <div class="col" style="padding-left:0px">
                    <button type="submit" class="btn btn-primary mb-2" id="generate_graph_button" disabled>Generate graphs</button>
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
            <h2>Department data</h2>
        </div>
        <div class="">
            <table id="department_data" class="display table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Department</th>
                        <th>Total call time</th>
                        <th>Answered</th>
                        <th>No answer</th>
                        <th>Busy</th>
                        <th>Failed</th>
                        <th>Total calls</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $iterator = 0;
                    foreach ($department_datatable as $key => $value) {
                        $total = $value['ANSWERED'] + $value['NO ANSWER'] + $value['BUSY'] + $value['FAILED'];
                        echo "<tr>";
                        echo "<td><b>" . ++$iterator . "</b></td>";
                        echo "<td>" . $key . "</td>"; // key represents department
                        echo "<td>" . convertDate($value['call time']) . "</td>";
                        echo "<td>" . $value['ANSWERED'] . "</td>";
                        echo "<td>" . $value['NO ANSWER'] . "</td>";
                        echo "<td>" . $value['BUSY'] . "</td>";
                        echo "<td>" . $value['FAILED'] . "</td>";
                        echo "<td>" . $total . "</td>";
                        echo "</tr>";
                    }

                    ?>
                </tbody>
            </table>
        </div>
    </div>





    <!-- Footer -->
    <div style="padding-top:2rem">
        <footer class="bg-light text-center text-lg-start">


            <!-- Copyright -->
            <div class="text-center p-3" style="background-color:#85929E">
                By Aman.
                <a class="text-light" href="https://drive.google.com/file/d/1fUzPoq-PpmsJGjD1Elv6IpoxyyzRFhrx/view?usp=sharing">API Documentation.</a>
                <a class="text-light" href="<?php echo $datafile; ?>">Download csv</a>
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

    <!--select picker-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>


    <!-- label plugin for chartjs -->
    <script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>

    <script>
        // previous colours used in canvasjs
        previousCanvasJSColors = ["#9BBB58", "#C0504E", "#4F81BC", "#23BFAA", ];
    </script>

    <script src='document.js'></script>
    <script>
     $(document).ready(function () {

    // selectpicker
    $('select').selectpicker();
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
                },
                plugins: {
                    labels: {
                        render: 'value',
                    }
                }
            }
        });
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
        }


        // generate graph button clicked
        const generate_graph_button = document.getElementById("generate_graph_button");
        const department_selector = document.getElementById("department_selector");
        const php_department_donut_data = <?php echo json_encode($department_donuts, JSON_NUMERIC_CHECK); ?>;
        const departmentDonutsContainerDiv = document.getElementById("departmentDonutsContainerDiv");
    </script>

    <script>
        const php_department_employee_donut_data = <?php echo json_encode($department_employee_donuts, JSON_NUMERIC_CHECK); ?>;

        $('#department_selector').on('change', function() {
            generate_graph_button.disabled = false;

            $('#department_employee_selector').prop("disabled", false);

            let curr_department = $('#department_selector').selectpicker('val');
            $('#department_employee_selector').empty();

            $('#department_employee_selector').append(`<option>All employees</option>`);
            Object.keys(php_department_employee_donut_data[curr_department]).forEach((key) => {
                $('#department_employee_selector').append(`<option>${php_department_employee_donut_data[curr_department][key][0]} (${key})</option>`);
            });


            $('#department_employee_selector').selectpicker('refresh');
            $('#department_employee_selector').selectpicker("val", "All employees");
        });
    </script>

    <script>
        let navbar = $("#top_navbar"); // for scrolling

        generate_graph_button.onclick = function() {
            let current_department = department_selector.value;
            let curr_employee = $('#department_employee_selector').selectpicker('val');
            let num = curr_employee.split(" ").pop();
            num = num.substring(1,num.length-1);
            

            if (current_department === "") { // quit function if no department selected
                alert("Please select a department to generate graph");
                return;
            }
            departmentDonutsContainerDiv.style.display = "block";

            if (curr_employee==="All employees") {
                drawDepartmentDonut(php_department_donut_data[current_department]['Inbound'], "inboundDepartmentDonut", "Incoming");
                drawDepartmentDonut(php_department_donut_data[current_department]['Internal'], "internalDepartmentDonut", "Internal");
                drawDepartmentDonut(php_department_donut_data[current_department]['Outbound'], "outboundDepartmentDonut", "Outgoing");
                drawDepartmentDonut(php_department_donut_data[current_department]['External'], "externalDepartmentDonut", "External");
            } else {
                drawDepartmentDonut(php_department_employee_donut_data[current_department][num][1]['Inbound'], "inboundDepartmentDonut", "Inbound");
                drawDepartmentDonut(php_department_employee_donut_data[current_department][num][1]['Internal'], "internalDepartmentDonut", "Internal");
                drawDepartmentDonut(php_department_employee_donut_data[current_department][num][1]['Outbound'], "outboundDepartmentDonut", "Outbound");
                drawDepartmentDonut(php_department_employee_donut_data[current_department][num][1]['External'], "externalDepartmentDonut", "External");
            }

            // scrolling
            
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#generate_graphs_scroll_location").offset().top - navbar.height()
            }, 1000);

        }
    </script>

    <script>
    // handling on click for date. Creates a GET request
    let start = ""; // start date variable
    let end = ""; // end date variable

    let original_start = $('#startdate').val();
    let original_end = $('#enddate').val();

    const selectStartElement = document.getElementById('startdate');

    function dateError(startString, endString) {
        // max possible start and end date in the dataset
        const min_date = Date.parse(document.getElementById("min_date").innerHTML);
        const max_date = Date.parse(document.getElementById("max_date").innerHTML) + 86400000;
        
        const start = Date.parse(startString);
        const end = Date.parse(endString);

        if (start < min_date) {
            alert("Start date cannot be lower than dataset value");
        } else if (end > max_date) {
            alert("End date cannot be greater than dataset value");
        } else if (start > end) {
            alert("Start date cannot be greater than End date");
        } else if (start > max_date) {
            alert("Start cannot be greater than dataset value")
        } else if (end < min_date) {
            alert("End cannot be less than dataset value");
        } else {
            return false;
        }
        return true;
    }

    selectStartElement.addEventListener('change', (event) => {
        const result = document.querySelector('.result');
        // result.textContent = `You like ${event.target.value}`;
        start = $('#startdate').val();
        end = $('#enddate').val();

        if (!dateError(start, end)) {
            const Url = `?start=${start}&end=${end}`;
            window.location.href = Url;
        } else {
            selectStartElement.value = original_start; 
            selectEndElement.value = original_end;
            console.log(original_start);
            console.log(original_end);
        }
    });

    const selectEndElement = document.getElementById('enddate');

    selectEndElement.addEventListener('change', (event) => {
        const result = document.querySelector('.result');
        // result.textContent = `You like ${event.target.value}`;
        start = $('#startdate').val();
        end = $('#enddate').val();

        if (!dateError(start, end)) {
            const Url = `?start=${start}&end=${end}`;
            window.location.href = Url;
        } else {
            selectStartElement.value = original_start; 
            selectEndElement.value = original_end;
            console.log(original_start);
            console.log(original_end);
        }
    });
    </script>



</body>

</html>