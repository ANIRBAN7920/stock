<?php session_start();
if(!isset($_SESSION['an'])){
    header("location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<?php
include("db.php");
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Order List</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include("common/sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
        <?php include("common/topbar.php"); ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Order</h1>

                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Order I'D</th>
                          <th scope="col">Product Name</th>
                          <th scope="col">Customer Name</th>
                          <th scope="col">Customer Email</th>
                          <th scope="col">Product Phone</th>
                          <th scope="col">Customer Address</th>
                          <th scope="col">Additional Information</th>

                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <?php
                            $sel="SELECT * FROM  prorder ORDER by id DESC";
                            
                            $rs=$dbLink->query($sel);
                            while ($row=$rs->fetch_assoc()) {
                            ?>
                          <td><?php echo $row['id'] ?></td>
                          <td><?php echo $row['pName'] ?></td>
                          <td><?php echo $row['name'] ?></td>
                          <td><a href="mailto:<?php echo $row['email'] ?>"><?php echo $row['email'] ?></a></td>
                          <td><a href="tel:<?php echo $row['phone'] ?>"><?php echo $row['phone'] ?></a></td>
                          <td>
                            <?php echo $row['addone'] ?>
                            <br>
                            <?php echo $row['addtwo'] ?>
                            <br>
                            <?php echo $row['state'] ?>
                            <br>
                            <?php echo $row['pincode'] ?>
                          </td>
                          <td><?php echo $row['addinfo'] ?></td>
                          
                        </tr>
                        <?php
                            
                            }
                            ?>
                      </tbody>
                    </table>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
                    <?php include("common/footer.php") ?>

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>