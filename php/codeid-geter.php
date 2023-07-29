<?php
$q = $_GET['q'];
 require_once("db.php"); 
$sql="SELECT * FROM nisha WHERE partnumber LIKE '".$q."%'";
$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $partnumber = $row['partnumber'];
        $codeid = $row['id'];

 
    echo '<div codeid="'.$codeid.'">'.$partnumber.'</div>';
     
 }
    } // end while

else {
    echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
}
mysqli_close($con);
?>
