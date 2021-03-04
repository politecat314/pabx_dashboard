<?php
    $datafile = "big.csv";

    // start of importing contactlist
    $contactlist = array(); // csv data imported into this array
    
    $CSVfp = fopen("contactlist_names.csv", "r");
    if($CSVfp !== FALSE) {
        $data = fgetcsv($CSVfp, 1000, ",");
        while(! feof($CSVfp)) {
            $data = fgetcsv($CSVfp, 1000, ",");
            
            $contactlist[$data[0]] = array($data[1],$data[2]);
            // data stored in the format
            // $exit => array ($department, $name);
            // 123 => ("Research and Development", "John Doe")
        }
    }
    fclose($CSVfp);
    // end of importing contactlist


    // start of import data from csv file
    $CSVfp = fopen($datafile, "r");
    $csv = array(); // all the data is stored in this array

    if($CSVfp !== FALSE) {
        while(! feof($CSVfp)) {
            $data = fgetcsv($CSVfp, 1000, ",");
            array_push($csv, $data); // add date condition here later
        }
    }
    fclose($CSVfp);

    // removing empty lines at the end of csv data file
    while (!$csv[count($csv)-1]) {
        array_pop($csv);
    }
    // end of import data from csv data file


    // reference array for heading numbers. For example, account code => 0
    $ref = array(); 
    for ($i = 0; $i < count($csv[0]); $i++) {
        $ref[$csv[0][$i]] = $i;
    }


    // start of contactlist filtration. Eventually becomes obsolete. TODO remove
    $temp_array = array(); // Making the csv array as [1]=>,[2]=>,[3]=> etc
    $length = count($csv);
    for ($i=1; $i<$length; $i++) { // i = 1 to skip the heading name of the column
        if ($csv[$i][$ref["userfield"]] === 'Inbound' or $csv[$i][$ref["userfield"]] === 'External') {
            $caller_number = $csv[$i][$ref["callee number"]];
        } else {
            $caller_number = $csv[$i][$ref["caller number"]];
        }

        // $caller_number = $csv[$i][$ref["caller number"]];

        if (!array_key_exists($caller_number, $contactlist)) {
            echo "$i $caller_number ";
            print_r($csv[$i]);
            echo "</br>";

            // echo "$caller_number,Unknown Department,Unknown";
            
            // echo "</br>";
            
            unset($csv[$i]);
        } else {
            array_push($temp_array, $csv[$i]);
        }
    }

    $csv = $temp_array; // beyond this point, $csv does not have column headings
    // end of contactlist filtration
    
    // start of defining variables to be displayed
    $min_date = date("j M Y",strtotime($csv[0][$ref['start time']]));
    $max_date = date("j M Y",strtotime($csv[count($csv)-1][$ref['start time']]));

    // start of date filtration
    // setting the date to the previous value
    $startdatephp = $_GET['start'] ?? ""; // DO NOT CHANGE // TODO check with final variables
    $enddatephp = $_GET['end'] ?? ""; // DO NOT CHANGE

    $temp_array = array(); // making the csv array as [0]=>,[1]=>,[2]=> etc
    if (array_key_exists("start",$_GET) and array_key_exists("end",$_GET)) {
        $start_date = $_GET['start'];
        $end_date = $_GET['end'];
        $start_date_given = false;
        $end_date_given = false;
        
        if (strlen($start_date) !== 0) { // TODO check for same behaviour with $startdate !== "";
            $start_date = date_parse($start_date);
            $start_date_given = true;
        }

        if (strlen($end_date) !== 0) {
            $end_date = date('Y-m-d', strtotime($end_date . ' +1 day'));
            $end_date = date_parse($end_date);
            $end_date_given = true;
        }
        
        $length = count($csv);
        
        for ($i=0; $i<$length; $i++) {
            $date_of_call = date_parse($csv[$i][$ref["start time"]]);
            $unset_start_date = false;
            $unset_end_date = false;

            if ($start_date_given and $date_of_call < $start_date) {
                unset($csv[$i]);
                $unset_start_date = true;
            }

            if ($end_date_given and $date_of_call >= $end_date) {
                unset($csv[$i]);
                $unset_end_date = true;
            }

            if (!$unset_start_date and !$unset_end_date) {
                array_push($temp_array, $csv[$i]);
            }
        }
        $csv = $temp_array; // making the csv array as [0]=>,[1]=>,[2]=> etc
    }
    // end of date filtration

    // start of sorting csv by caller number. TODO sort everything at the end to be surest
    // $sort = array_column($csv, $ref['callee number']);
    // array_multisort($sort, SORT_ASC, $csv);
    // end of sorting csv by caller number

    // start of defining variables to be displayed

    $days = array(); // days and number of calls that day. For the Calls per day graph
    // echo date("j M",strtotime($csv[0][$ref['start time']]));

    $disposition = array(
        "ANSWERED" => 0,
        "NO ANSWER" => 0,
        "BUSY" => 0,
        "FAILED" => 0 
    );

    $userfield = array(
       "Inbound" => $disposition,
       "Internal" => $disposition,
       "Outbound" => $disposition,
       "External" => $disposition 
    );

    $department_datatable = array(); // for department datatable on deparment.php
    $department_donuts = array(); 
    // donuts for dropdown departments
    // $departmetn => $userfield => $disposition
    foreach ($contactlist as $value) {
        if (!array_key_exists($value[0], $department_donuts)) {
            $department_donuts[$value[0]] = $userfield;
            $department_datatable[$value[0]] = array(
            "call time" => 0,
            "ANSWERED" => 0,
            "NO ANSWER" => 0,
            "BUSY" => 0,
            "FAILED" => 0
            );
        }
    }

    $caller_num_data = array(); // datatable on index.html

    $caller_num_data_by_userfield = array( // caller_number data grouped by userfield
        "Inbound" => array(),
        "Internal" => array(),
        "Outbound" => array(),
        "External" => array()
    );

    foreach($contactlist as $key => $value) { // for all the datatables
        $current_caller_number_data_array = array(
            'Name'=> $value[1], 
            'Department'=> $value[0],
            'NO ANSWER'=>0,
            'ANSWERED'=>0,
            'FAILED'=>0,
            'BUSY'=>0,
            'call time'=>0
        );

        $caller_num_data[$key] = $current_caller_number_data_array;
        
        foreach($caller_num_data_by_userfield as $k => $v) {
            $caller_num_data_by_userfield[$k][$key] = $current_caller_number_data_array;
        }

    }


    

    // graph arrays
    $answered = array();
    $graph_ref = array(); // ref array for graphs
    $graph_ref_num = 0;
    foreach ($contactlist as $value) {
        $department = $value[0];
        if (!in_array(array('label'=>$department,'y'=>0),$answered)) {
            array_push($answered, array('label'=>$department,'y'=>0));
            $graph_ref[$department] = $graph_ref_num;
            $graph_ref_num++;
        }
    }
    $no_answer = $answered;
    $busy = $answered;
    $failed = $answered;

    // end of defining variables to be displayed



    // master loop. One pass do everything
    for ($i=0; $i<count($csv); $i++) {
        $current_userfield = $csv[$i][$ref['userfield']]; // select the current userfield on line i
        if ($current_userfield === 'Inbound' or $current_userfield === 'External') {
            $current_caller_number = $csv[$i][$ref['callee number']]; // select the current callee number on line i
        } else {
            $current_caller_number = $csv[$i][$ref['caller number']]; // select the current caller number on line i
        }
        
        $current_department = $contactlist[$current_caller_number][0];
        $current_name = $contactlist[$current_caller_number][1];
        $current_disposition = $csv[$i][$ref['disposition']]; // select current disposition on line i
        $current_talk_time = $csv[$i][$ref['call time']]; // select current disposition on line i
        
        // start of deparment datatable
        $department_datatable[$current_department][$current_disposition] += 1;
        $department_datatable[$current_department]['call time'] += $current_talk_time;
        // end of department datatable

        // start of department donuts
        $department_donuts[$current_department][$current_userfield][$current_disposition] += 1;
        // end of department donuts

        // start of calls per day counter
        $current_day = date("j M",strtotime($csv[$i][$ref['start time']]));
        if (array_key_exists($current_day,$days)) {
            $days[$current_day] += 1;
        } else {
            $days[$current_day] = 1;
        }
        // end of calls per day countr

        // start of counting disposition
        $disposition[$current_disposition] += 1;
        // end of counting disposition

        // start of counting userfield
        $userfield[$current_userfield][$current_disposition] += 1;
        // end of counting userfield

        // start of caller number datatables (index.php)
        $caller_num_data[$current_caller_number][$current_disposition] += 1;
        $caller_num_data[$current_caller_number]['call time'] += $current_talk_time;
        // end of caller number datatables (index.php)


        // start of datatables grouped by userfield
        $caller_num_data_by_userfield[$current_userfield][$current_caller_number][$current_disposition] += 1;
        $caller_num_data_by_userfield[$current_userfield][$current_caller_number]['call time'] += $current_talk_time;
        // end of datatables grouped by userfield

        // start of graph
        switch ($current_disposition) {
            case "ANSWERED":
                $answered[$graph_ref[$current_department]]['y'] += 1;
                break;
            case "NO ANSWER":
                $no_answer[$graph_ref[$current_department]]['y'] += 1;
                break;
            case "BUSY":
                $busy[$graph_ref[$current_department]]['y'] += 1;
                break;
            case "FAILED":
                $failed[$graph_ref[$current_department]]['y'] += 1;
        }
        // end of graph

    }

    // start of sorting
    ksort($department_donuts); // for department donuts selector
    ksort($caller_num_data);
    foreach($caller_num_data_by_userfield as &$value) {
        ksort($value);
    }
    ksort($department_datatable);

    

    // $sort = array_column($caller_num_data, $ref['callee number']);
    // array_multisort($sort, SORT_ASC, $csv);
    // end of sorting

    function convertDate($time) { // time must be in seconds. Returns time as a stirng
        // > 86400 when time is more than 1 day
        if ($time > 86400){ // when time is more than a day
            return gmdate("z\d\a\y G\h\\r i\m\i\\n", $time);
        } else if ($time > 3600) { // when time is more than an hour
            return gmdate("G\h\\r i\m\i\\n s\s", $time);
        } else { // return minutes and seconds
            return gmdate("i\m\i\\n s\s", $time);
        }
    }

    function generateCallerNumDatatable($data_arr) {
        $iterator = 0;
        foreach ($data_arr as $key => $value) {
            $total = $value['ANSWERED'] + $value['NO ANSWER'] + $value['BUSY'] + $value['FAILED'];
            echo "<tr>";
            echo "<td><b>" . ++$iterator . "</b></td>";
            echo "<td>" . $value['Name'] . "</td>";
            echo "<td>" . $value['Department'] . "</td>";
            echo "<td>" . $key . "</td>";
            echo "<td>" . convertDate($value['call time']) . "</td>";
            echo "<td>" . $value['ANSWERED'] . "</td>";
            echo "<td>" . $value['NO ANSWER'] . "</td>";
            echo "<td>" . $value['BUSY'] . "</td>";
            echo "<td>" . $value['FAILED'] . "</td>";
            echo "<td>" . $total . "</td>";
            echo "</tr>";
        }
    }



?>