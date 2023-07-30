<?php
require_once("db.php");
$sql = "SELECT id, name FROM seller ORDER BY sort DESC";
$result = mysqli_query($con, $sql);

$data = [];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {

    $id = $row['id'];
    $name =  $row['name'];
    $data[$id] = $name;
  }
}

$data = persianSort($data);

print_r(json_encode($data));

function persianSort($array)
{
  $persianAlphabet = array(
    'ا', 'ب', 'پ', 'ت', 'ث', 'ج', 'چ', 'ح', 'خ', 'د', 'ذ', 'ر', 'ز', 'ژ', 'س', 'ش', 'ص', 'ض', 'ط', 'ظ', 'ع', 'غ', 'ف', 'ق', 'ک', 'گ', 'ل', 'م', 'ن', 'و', 'ه', 'ی'
  );

  usort($array, function ($a, $b) use ($persianAlphabet) {
    $aLength = mb_strlen($a);
    $bLength = mb_strlen($b);
    $maxLength = max($aLength, $bLength);

    for ($i = 0; $i < $maxLength; $i++) {
      $aChar = mb_substr($a, $i, 1);
      $bChar = mb_substr($b, $i, 1);

      $aIndex = array_search($aChar, $persianAlphabet);
      $bIndex = array_search($bChar, $persianAlphabet);

      if ($aIndex !== false && $bIndex !== false) {
        if ($aIndex < $bIndex) {
          return -1;
        } elseif ($aIndex > $bIndex) {
          return 1;
        }
      } elseif ($aIndex !== false) {
        return -1;
      } elseif ($bIndex !== false) {
        return 1;
      }
    }

    return 0;
  });

  return $array;
}
