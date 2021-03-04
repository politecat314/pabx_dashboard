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
                    <a class="nav-item nav-link" href="department.php">Department</a>
                    <a class="nav-item nav-link active" href="#">Raw-data</a>
                    
                </div>
            </div>
        </div>
    </nav>

    <div class="container datatable-container" style="padding-top:2rem">
        <div class="">
            <h2>Raw-Data</h2>
        </div>
        <div class="">
            <table id="raw_data" class="display table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Caller</th>
                        <th>Callee</th>
                        <th>Start time</th>
                        <th>Call time</th>
                        <th>Userfield</th>
                        <th>Disposition</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $iterator = 0;
                    foreach ($csv as $value) {
                        if ($value[$ref['userfield']] === 'Inbound' or $value[$ref['userfield']] === 'External') { // to select caller num or callee num
                            $number = $value[$ref['callee number']];
                        } else {
                            $number = $value[$ref['caller number']];
                        }

                        echo "<tr>";
                        echo "<td><b>" . ++$iterator . "</b></td>";
                        echo "<td>" . $contactlist[$number][1] . "</td>";
                        echo "<td>" . $value[$ref['caller number']] . "</td>";
                        echo "<td>" . $value[$ref['callee number']] . "</td>";
                        echo "<td>" . $value[$ref['start time']] . "</td>";
                        echo "<td>" . convertDate($value[$ref['call time']]) . "</td>";
                        echo "<td>" . $value[$ref['userfield']] . "</td>";
                        echo "<td>" . $value[$ref['disposition']] . "</td>";
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




    <script>
        data_table_object = {
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "pageLength" : 25,
            dom: 'Blfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        }
        
        $(document).ready(function() {
            $('#raw_data').DataTable(data_table_object);
        });
        

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