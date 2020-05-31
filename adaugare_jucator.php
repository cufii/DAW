<?php

    if(isset($_POST['buton_adaugare_jucator']))
    {
        $idEchipa      = $_POST['idEchipa'];
        $nume          = $_POST['nume'];
        $prenume       = $_POST['prenume'];
        $dataNasterii  = $_POST['data_nasterii'];
        $nationalitate = $_POST['nationalitate'];
        $URL           = $_POST['imgURL'];
    }

    require 'dbh.inc.php';

    if(empty($nume) || empty($prenume) || empty($dataNasterii) || empty($nationalitate) || empty($URL))
    {
        header("Location ../index.php?error=Informatii_insuficiente&nume=" . $nume . "&prenume=" . $prenume . "&dataNasterii=" . $dataNasterii . "&nationalitate=" . $nationalitate . "&URL=" . $URL);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z\040]*$/", $nume))
    {
        header("Location ../index.php?error=numeinvalid&prenume=" . $prenume . "&dataNasterii=" . $dataNasterii . "&nationalitate=" . $nationalitate . "&URL=" . $URL);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z\040]*$/", $prenume))
    {
        header("Location ../index.php?error=prenumeinvalid&nume=" . $nume . "&dataNasterii=" . $dataNasterii . "&nationalitate=" . $nationalitate . "&URL=" . $URL);
        exit();
    }
    elseif(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $dataNasterii))
    {
        header("Location ../index.php?error=data_nasterii_invalida&nume=" . $nume . "&prenume=" . $prenume . "&nationalitate=" . $nationalitate . "&URL=" . $URL);
        exit();
    }
    elseif(!preg_match("/^[a-zA-Z\040]*$/", $nationalitate))
    {
        header("Location ../index.php?error=nationalitate_invalida&nume=" . $nume . "&prenume=" . $prenume . "&dataNasterii=" . $dataNasterii . "&URL=" . $URL);
        exit();
    }
    else
    {
        $sql  = "INSERT INTO fotbalisti (Nume, Prenume, DataNasterii, TaraOrigine, IdEchipa, LinkImg) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql))
        {
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else
        {
            mysqli_stmt_bind_param($stmt, "ssssss", $nume, $prenume, $dataNasterii, $nationalitate, $idEchipa, $URL);
            mysqli_stmt_execute($stmt);
            header("Location: ../index.php?adaugat=success");
        }
    }
