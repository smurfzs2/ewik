<!DOCTYPE html>
<html>

<head>
    <!-- <title>Datatables Example using PHP and MySQL</title> -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href='../assets/bootstrap/css/bootstrap.css'>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
</head>

<body>
    <h2 style="text-align:center;">Datatables Server-Side Example</h2>
    <table id="sample" class="display" width="100%" cellspacing="0">
        <thead>
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
    </table>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/scroller/2.1.0/js/dataTables.scroller.min.js"></script>
    <!-- <style>
        #header-fixed {
            position: fixed;
            top: 0px;
            display: none;
            background-color: white;
        }
    </style> -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#sample').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "eric_serverProcessing.php",
                "scrollerY":200,

                // "fixedHeader": true,
            });
        });
    </script>
</body>

</html>