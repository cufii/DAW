<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title> Proiect DAW</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="default.css" rel="stylesheet" type="text/css" />
</head>

<body>

  <div class="container containerDAW">

      <div id="header">
        <h1>Statistici sezon 2019-20</h1>
        <br>
        <h2>Top 5 ligi Europa</h2>
      </div>

    <div id="splash"><img src="images/img2.jpg" alt="" width="514" height="273" /></div>

    <div class="container">
      <?php
      include_once 'includes/dbh.inc.php';

      $sql = "SELECT * FROM Echipe";
      $stmt = mysqli_stmt_init($conn);

      if(!mysqli_stmt_prepare($stmt, $sql))
      {
        echo "Eroare - SQL statement - SELECT";
        exit();
      }
      else
      {
        mysqli_stmt_execute($stmt);
        $rezultat = mysqli_stmt_get_result($stmt);

        $arrayEchipe = array();

        while($row = mysqli_fetch_assoc($rezultat))
        {
          array_push($arrayEchipe, $row);
        }

        $nrEchipe = count($arrayEchipe);

        for($i = 0; $i < $nrEchipe; $i++)
        {
          echo '<div class="content bg2">
                  <div class="wrapper">
                    <h2 style="font-size:27px"> <img class="logo" src='.$arrayEchipe[$i]["ImgPath"].' alt="" width="25" height="25" /> '.$arrayEchipe[$i]["Nume"].'</h2>
                    <p>An fondare: - '.$arrayEchipe[$i]["AnFondare"].'</p>
                    <p>Orasul de provenienta: - '.$arrayEchipe[$i]["Oras"].'</p>
                    <p>Stadion: - '.$arrayEchipe[$i]["Stadion"].'</p>
                    <p>Liga: - '.$arrayEchipe[$i]["Liga"].'</p>

                    <div style="clear: both;">&nbsp;</div>

                    <a class="btn btn-primary btn-echipa" data-toggle="collapse" href="#collapse_echipa'.$arrayEchipe[$i]["IdEchipa"].'" role="button" aria-expanded="false" aria-controls="collapseExample">
                      Vezi echipa
                    </a>';

            $sql  = "SELECT * FROM fotbalisti WHERE IdEchipa = ?;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql))
            {
              header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=sqlerror");
              exit();
            }
            else
            {
              mysqli_stmt_bind_param($stmt, "s", $arrayEchipe[$i]["IdEchipa"]);
              mysqli_stmt_execute($stmt);

              $rezultat = mysqli_stmt_get_result($stmt);
              $arrayFotbalisti = array();

              while($row= mysqli_fetch_assoc($rezultat))
              {
                array_push($arrayFotbalisti, $row);
              }

                $nrFotbalisti = count($arrayFotbalisti);
                $data = time();

                echo '<div id="collapse_echipa'.$arrayEchipe[$i]["IdEchipa"].'" class="collapse">
                    <table class="table tableFotbalisti">
                      <thead>
                        <tr>
                          <th></th>
                          <th>Prenume</th>
                          <th>Nume</th>
                          <th>Varsta</th>
                          <th>Nationalitate</th>
                        </tr>
                      </thead>
                      <tbody>';
                
                for($var = 0; $var < $nrFotbalisti; $var ++)
                {
                $dataNasterii = strtotime($arrayFotbalisti[$var]["DataNasterii"]);

                $varsta = intval(($data - $dataNasterii) /60 / 60 / 24 / 365.25);

                  echo '
                  <tr data-id="'.$arrayFotbalisti[$var]["IdFotbalist"].'">
                    <td class="td_imgPath"> <img src="'.$arrayFotbalisti[$var]["LinkImg"].'" /></td>
                    <td class="td_prenume"> <span> '.$arrayFotbalisti[$var]["Prenume"].' </span> </td>
                    <td class="td_nume"> <span> '.$arrayFotbalisti[$var]["Nume"].' </span> </td>
                    <td class="td_varsta"> <span> '.$varsta.' </span> </td>
                    <td class="td_nationalitate"> <span> '.$arrayFotbalisti[$var]["TaraOrigine"].' </span> </td>
                  </tr>';
                }
              }

                  echo '</tbody>
                      </table>
                      <div class="menu">
                      <ul>
                        <li class="first adaugaJucator""><a href="" accesskey="1">Adauga Jucator</a></li>
                        <li><a class="modificaJucator" href="" accesskey="2">Modifica Jucator</a></li>
                        <li><a class="stergeJucator" href="" accesskey="3">Sterge Jucator</a></li>
                      </ul>
                    </div>
                  </div>
                    </div>
                  </div>';

      }
    }
      ?>

    </div>

    <div id="footer" class="bg3">
      <p>| Proiect DAW | Cufaiote Serban Iulian   |   iunie   |   2020   |</p>
    </div>

    <div class="modal fade" id="modificaJucator" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modificaJucator_Title">Modifica jucator</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form class="col-md-offset-2 col-md-8" action="includes/modificare_jucator.php" method="post">
            <p> Modificati informatiile jucatorului </p>
            <hr>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control input_idJucator" name="idJucator" required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">Prenume</label>
                <input type="text" class="form-control input_prenume" name="prenume" placeholder="Prenume..." required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">Nume</label>
                <input type="text" class="form-control input_nume" name="nume" placeholder="Nume..." required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">Nationalitate</label>
                <input type="text" class="form-control input_nationalitate" name="nationalitate" placeholder="Nationalitate..." required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">URL imagine</label>
                <input type="text" class="form-control input_imgURL" name="imgURL" placeholder="URL imagine..." required="required">
              </div>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
              <button type="submit" class="btn btn-primary" name="buton_modificare_jucator">Trimite</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="adaugaJucator" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modificaJucator_Title">Modifica jucator</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form class="col-md-offset-2 col-md-8" action="includes/adaugare_jucator.php" method="post">
            <p> Adaugati informatiile jucatorului </p>
            <hr>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control input_idEchipa" name="idEchipa" required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">Prenume</label>
                <input type="text" class="form-control input_prenume" name="prenume" placeholder="Prenume..." required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">Nume</label>
                <input type="text" class="form-control input_nume" name="nume" placeholder="Nume..." required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">DataNasterii (ANUL-LUNA-ZIUA - ex: 1989-04-25)</label>
                <input type="text" class="form-control input_data_nasterii" name="data_nasterii" placeholder="Data nasterii..." required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">Nationalitate</label>
                <input type="text" class="form-control input_nationalitate" name="nationalitate" placeholder="Nationalitate..." required="required">
              </div>
            </div>
            <div class="form-group">
              <div class="input-group">
                <label class="label">URL imagine</label>
                <input type="text" class="form-control input_imgURL" name="imgURL" placeholder="URL imagine..." required="required">
              </div>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
              <button type="submit" class="btn btn-primary" name="buton_adaugare_jucator">Adauga</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>



    <div class="modal fade" id="stergeJucator" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="stergeJucator_Title">Sterge jucator</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <form class="col-md-offset-2 col-md-8" action="includes/sterge_jucator.php" method="post">
            <p class="check"> Sunteti sigur ca doriti sa il stergeti pe </p>
            <hr>
            <div class="form-group">
              <div class="input-group">
                <input type="text" class="form-control input_idJucator" name="idJucator" required="required">
              </div>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
              <button type="submit" class="btn btn-primary" name="buton_sterge_jucator">Sterge</button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
  <script src="./index.js" type="text/javascript"></script>
</body>
</html>
