<?php
  $id = $_GET['id'];

  include('database.php');
  // do some validation here to ensure id is safe
  $sql = "SELECT logo, logo_type FROM company WHERE id=" . $id;
  $sth = $DBH->prepare($sql);
  $sth->execute();
  if ($sth->rowCount() > 0) {
    $row = $sth->fetch(PDO::FETCH_ASSOC);
    if($row['logo']) {
        header("Content-type: " . $row['logo_type']);
        echo $row['logo'];
    } else {
        $filename = "images/your_logo_here.png";
        $fp = fopen($filename, "r");
        $data = fread($fp, filesize($filename));
        fclose($fp);      
        header("Content-type: image/png");
        echo $data;
    }
  }
?>