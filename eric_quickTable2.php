<?php
include('eric_function.php');
include('eric_connection.php');

// if(isset())
?>

<!DOCTYPE html>
<html>

<head>
    <!-- <title>Datatables Example using PHP and MySQL</title> -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href='../assets/bootstrap/css/bootstrap.css'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
        .dataTables_scrollBody {
            max-height: 450;
            /* Set a max height for the scrolling area */
            overflow-y: scroll;
            /* Enable vertical scrolling */
            scroll-behavior: smooth;
            /* background-color: #aliceblue; */
            /* Add smooth scrolling behavior */
        }
    </style>

<body class='px-5'>
    <div class="d-flex flex-row-reverse bd-highlight pt-5">
        <div class="p-2 bd-highlight">
            <a href='eric_csv.php' class='btn btn-primary fw-bold'> CSV </a>
        </div>
        <div class="p-2 bd-highlight">
            <a href='eric_pdf.php' class='btn btn-primary fw-bold'> PDF </a>
        </div>
        <div class="p-2 bd-highlight">
            <a href='eric_pieGraph.php' class='btn btn-warning fw-bold'> Pie </a>
        </div>
        <div class="p-2 bd-highlight">
            <a href='eric_barGraph.php' class='btn btn-success fw-bold'> Bar </a>
        </div>
        <div class="p-2 bd-highlight">
            <a href='eric_clusteredGraph.php' class='btn btn-info fw-bold'> Clustered </a>
        </div>
        <!-- <div class="p-2 bd-highlight">
            <div class="bd-highlight"><button type="submit" name="filter" class="btn btn-primary fw-bold">SORT</button></div>
        </div> -->
        <div class="p-2 bd-highlight">
            <select class="form-select" value="<?php echo $_POST['name']; ?>" id="name">
                <!-- <option hidden selected>Name</option> -->
                <option value="">Name/All</option>
                <!-- <option value="" Hidden>All</option> -->
                <?php echo getNamesData(); ?>
            </select>
        </div>
        <!-- <div class="p-2 bd-highlight">
            <input type="text" id="search">
        </div> -->
        <div class="p-2 bd-highlight">
            <select class="form-select" value="<?php echo $_POST['age']; ?>" id="age">
                <!-- <option hidden selected>Age</option> -->
                <option value="">Age/All</option>
                <?php echo getAgeData(); ?>
            </select>
        </div>
        <div class="p-2 bd-highlight">
            <select class="form-select" value="<?php echo $_POST['gender']; ?>" id="gender">
                <!-- <option hidden sele cted>Gender</option> -->
                <option value="">Gender/All</option>
                <option value="0">Male</option>
                <option value="1">Female</option>
            </select>
        </div>
        <div class="p-2 bd-highlight">
            <select class="form-select" value="<?php echo $_POST['birthday']; ?>" id="birthday">
                <!-- <option hidden selected>Birthday</option> -->
                <option value="">Birthday/All</option>
                <?php echo getBdateData(); ?>
            </select>
        </div>
        <div class="p-2 bd-highlight">
            <select class="form-select" value="<?php echo $_POST['address']; ?>" id="address">
                <!-- <option hidden>Address</option> -->
                <option value="">Address/All</option>
                <?php echo getaddressData(); ?>
            </select>
        </div>
        <div class="p-2 bd-highlight">
            <select class="form-select" value="<?php echo $_POST['deparment']; ?>" id="department">
                <!-- <option hidden>Address</option> -->
                <option value="">Departments/All</option>
                <?php echo getDepartmentData(); ?>
                <?php  ?>
            </select>
        </div>
    </div>
    <!-- <h2 style="text-align:center;">Datatables Server-Side Example</h2> -->

    </style>
    <table id="sample" class="table table-bordered table-striped" width="100%">
        <thead style='background-color:#3452B4; color:aliceblue;'>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Birthday</th>
                <th>Address</th>
                <th>Department</th>
                <th>Action</th>

            </tr>
        </thead>
        <tfoot style='background-color:#3452B4;color:aliceblue;'>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-center" style="background-color: FF9200 ;"><label for="" class="fw-b fs-5" id='total'></label></th>

            </tr>
        </tfoot>
    </table>
    <!-- <div class="d-flex flex-row-reverse bd-highlight"><label for="" class="fw-b fs-5" id='total'></label></div> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.1.0/js/dataTables.scroller.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var dataTable = $('#sample').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                "bLengthChange": false,
                "searching": true,
                sort: false,
                "info": false,
                "sDom": "lrti",
                deferRender: true,
                scrollY: 450,
                scrollCollapse: true,
                scroller: true,
                "initComplete": function(settings, json) {
                    // Get the total number of records from DataTable
                    // var totalRecords = dataTable.page.info().totalRecords;
                    // $('#total').text("  " + totalRecords);
                    // console.log(json)
                },
                "rowCallback": function(row, data, index) {
                    $(row).hover(function() {
                        $(this).css('background-color', '#FF9200');
                        $(this).css('transition', ' 0.3s ease-in-out');
                    }, function() {
                        $(this).css('background-color', '');
                    });
                    // console.log(data)s
                },
                'searching': false, // Remove default Search Control
                'ajax': {
                    'url': 'eric_ajax2.php',
                    'data': function(data) {
                        // Read values
                        console.log("recordsFiltered:", data.recordsFiltered);
                        let gender = $('#gender').val();
                        let name = $('#name').val();
                        let department = $('#department').val();
                        let age = $('#age').val();
                        let address = $('#address').val();
                        let birthday = $('#birthday').val();

                        // Append to data
                        data.searchByGender = gender;
                        data.searchByName = name;
                        data.searchByDepartment = department;
                        data.searchByAge = age;
                        data.searchByAddress = address;
                        data.searchByBirthday = birthday;


                    }
                },
                'columns': [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'age'
                    },
                    {
                        data: 'gender'
                    },
                    {
                        data: 'birthday'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'departmentName'
                    },
                    {
                        data: 'action'
                    },

                ]

            });
            $('#gender,#name,#department,#age,#address,#birthday').change(function() {
                dataTable.draw();
            });
        });
    </script>
</body>

</html>