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

    <title>List Of Products</title>

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
                    <h1 class="h3 mb-4 text-gray-800">Products</h1>

                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">Product I'D</th>
                          <th scope="col">Product Name</th>
                          <th scope="col">Price</th>
                          <th scope="col">Description</th>
                          <th scope="col">Product Image</th>
                          <th scope="col">Delete</th>

                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <?php
                            $sel="SELECT * FROM product";
                            $rs=$dbLink->query($sel);
                            while ($row=$rs->fetch_assoc()) {
                            ?>
                          <td><?php echo $row['productid'] ?></td>
                          <td><?php echo $row['pname'] ?></td>
                          <td><?php echo $row['price'] ?>RS</td>
                          <td><?php echo $row['pdescription'] ?></td>
                          <td><img style="height: 150px;" src="upload/<?php echo $row['productImg'] ?>"></td>
                          <td><a onclick="return confirm('Are You Sure');" class="btn btn-danger" href="delp.php?did=<?php echo $row['productid'];  ?>">delete</a></td>
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