<?php
  session_start();

  if(isset($_POST["buton_modificare_jucator"]))
  {
    $idFotbalist   = $_POST["idJucator"];
    $prenume       = $_POST["prenume"];
    $nume          = $_POST["nume"];
    $nationalitate = $_POST["nationalitate"];
    $URL           = $_POST["imgURL"];


    if(!preg_match("/^[a-zA-Z\040]*$/", $prenume))
    {
      header("Location: ../index.php?error=prenume_invalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z\040]*$/", $nume))
    {
      header("Location: ../index.php?error=nume_invalid");
      exit();
    }
    elseif(!preg_match("/^[a-zA-Z\040]*$/", $nationalitate))
    {
      header("Location: ../index.php?error=nationalitate_invalid");
      exit();
    }
    else
    {
      require 'dbh.inc.php';

      $sql  = "UPDATE fotbalisti SET Nume = ?, Prenume = ?, TaraOrigine = ?, LinkImg = ? WHERE idFotbalist = '$idFotbalist';";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql))
      {
        header("Location: ../index.php?error=sqlerror");
        echo mysqli_stmt_error($stmt);
        exit();
      }
      else
      {
        mysqli_stmt_bind_param($stmt, "ssss", $nume, $prenume, $nationalitate, $URL);
        mysqli_stmt_execute($stmt);


        header("Location: ../index.php?modificat=succes");
        exit();
      }
    }
  }
  else {
    header("Location: ../index.php");
    exit();
  }

