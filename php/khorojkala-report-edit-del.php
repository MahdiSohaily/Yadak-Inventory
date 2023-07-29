<?php
$q = $_GET['q'];
 require_once("db.php"); 
$sql="DELETE FROM exitrecord WHERE id LIKE '".$q."' ";

$result = mysqli_query($con,$sql);

     

        if(!$result)
{
    echo "Error MySQLI QUERY: ".mysqli_error($con)."";
    die();

}
else
{
    echo "Query succesfully executed!";


} 
        
        
        
mysqli_close($con);
?>
