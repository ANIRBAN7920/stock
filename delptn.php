<?php
include("db.php");
$did= $_GET['did'];
$sel="SELECT * FROM appointment WHERE ptnid='$did'";
$rs=$dbLink->query($sel);
$row=$rs->fetch_assoc();
// unlink("product_img/".$row['product_image']);
$d="DELETE FROM appointment WHERE ptnid='$did'";
$dbLink->query($d);
header("location:appointment-list.php");

?>