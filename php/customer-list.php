<?php
require_once("db.php");

$sql = "SELECT * FROM customer";

global $shakhes ;
$shakhes = 1 ;

$result = mysqli_query($con,$sql);
if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {
     ?>

<tr>
    <td><?php echo $shakhes ?></td>
    <td><?php echo $row["name"] ?></td>
    <td><?php echo $row["lastname"] ?></td>
    <td><?php echo $row["mobile"] ?></td>
    <td><?php echo $row["phone"] ?></td>
    <td><?php echo $row["address"] ?></td>
    <td><?php echo $row["car"] ?></td>
    <td><a id="<?php echo $row["id"] ?>" class="edit-bt edit-customer">ویرایش<i class="fas fa-edit"></i></a></td>
</tr>


<?php
         $shakhes = $shakhes + 1 ;
    }
}
else {
echo '<tr><td colspan="6">متاسفانه نتیجه ای یافت نشد</td></tr>';

}
mysqli_close($con);
?>
