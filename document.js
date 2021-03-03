$(document).ready(function () {
    // selectpicker
    $('select').selectpicker();


    data_table_object = {
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: 'Blfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    }


    $('#caller_data').DataTable(data_table_object);
    $('#inbound_caller_data').DataTable(data_table_object);
    $('#internal_caller_data').DataTable(data_table_object);
    $('#outbound_caller_data').DataTable(data_table_object);
    $('#external_caller_data').DataTable(data_table_object);
    $('#department_data').DataTable({
        dom: 'Bfrtip',
        pageLength:-1,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });

// "order": [[ 3, "asc" ]]

    
    

    // handling big button
    const bigButton = document.getElementById('bigbutton');
    const hiddenDiv = document.getElementById('hiddenDiv');
    var navbar = $("#top_navbar");

    bigButton.onclick = function () {
        if (hiddenDiv.style.display === "none") {
            hiddenDiv.style.display = "block";
            bigButton.innerHTML = "Hide caller data grouped by userfield";
            bigButton.classList.add('btn-secondary');
            bigButton.classList.remove('btn-primary');
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#hr_below_bigButton").offset().top - navbar.height()
            }, 1000);
        } else {
            hiddenDiv.style.display = "none";
            bigButton.innerHTML = "Show caller data grouped by userfield";
            bigButton.classList.add('btn-primary');
            bigButton.classList.remove('btn-secondary');
        }
    };

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
});