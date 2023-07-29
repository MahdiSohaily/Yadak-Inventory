<?php
$q = $_GET['q'];
 require_once("db.php"); 
$sql="SELECT * FROM customer WHERE name LIKE '".$q."%'";
$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $name = $row['name'];
        $lastname = $row['lastname'];
        $mobile = $row['mobile'];
        $phone = $row['phone'];

 
    echo '<div id="'.$id.'">'.$name.' / '.$lastname.' / '.$mobile.' / '.$phone.'</div>';
     
 }
    } // end while

else {
    echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
}
mysqli_close($con);
?>
