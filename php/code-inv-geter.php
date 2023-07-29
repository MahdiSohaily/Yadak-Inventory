<?php
$q = $_GET['q'];
  require_once("db.php"); 
 require_once("function.php"); 

$sql="SELECT * FROM nisha WHERE partnumber LIKE '".$q."%'";
$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $price = echoRial($row['price'],"GEN");
        $partnumber = $row['partnumber'];
 

 
    echo '<div id="'.$id.'"><div class="xxxxx">'.$partnumber.'</div><div class="yyyy"><input class="input-price" name="xxxxx" type="text" value="'.$price.'"><input class="input-qty" type="number" value="1"><a class="add-to-btn">افزودن <i class="fas fa-plus-circle"></i></a></div></div>';
     
 }
    } // end while

else {
    echo '<div id="error">کد فنی اشتباه یا ناقص می باشد</div>';
}
mysqli_close($con);
?>
