<?php

  if(isset($_POST["buton_sterge_jucator"]))
  {
    $idJucator   = $_POST["idJucator"];

    include 'dbh.inc.php';

    $sql = "DELETE FROM fotbalisti WHERE IdFotbalist = '$idJucator';";

    if (!mysqli_query($conn, $sql))
    {
      echo "Eroare: ".$sql;
      echo "<br>". mysqli_error($conn);
      exit();
    }
    else
    {
      header("Location: ../index.php?stergere=succes");
      exit();
    }
  }
  else
  {
    header("Location: ../index.php");
    exit();
  }