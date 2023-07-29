<?php
 require_once("db.php");
$sql="SELECT * FROM users";
$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
      
    $val = $row['id'];
    $name =  $row['username'];
        echo ' <option value="'.$val.'">'.$name.'</option>';

    }
}
