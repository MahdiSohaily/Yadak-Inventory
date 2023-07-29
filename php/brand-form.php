<?php
 require_once("db.php");
$sql="SELECT * FROM brand ORDER BY sort DESC";
$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      
    $val = $row['id'];
    $name =  $row['name'];
        echo ' <option value="'.$val.'">'.$name.'</option>';

    }
}
