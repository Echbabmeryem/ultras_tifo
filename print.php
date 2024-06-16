<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UltrasTifoImpression</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="print.css" type="text/css" rel="stylesheet" media="print">
    <style>
        @media print {
            .hide-on-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between no-border">
                    <h4>Liste des Tifos</h4>
                    <div class="hide-on-print">
                    <a href="innnn.php"  class="btn btn-danger btn-sm" style="background-color: #142e61e8;  border: 2px solid #142e61e8;  width: 120px;">Retour</a>
          <button onclick="window.print();"  class="btn btn-secondary btn-sm print-button" style=" border: 2px solid #808080;  width: 120px;"id="print-btn">Imprimer</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive print-table">
                        <table class='table table-bordered table-striped table-sm w-100'>
                            <thead>
                                <tr class="text-center">
                                    <th class="col-auto">nbr</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Date d'exécution</th>
                                    <th>Temp début</th>
                                    <th>Email</th>
                                    <th>Mot de passe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'connexion.php';

                                $req = "SELECT * FROM tifos";
                                $res = mysqli_query($con, $req);

                                if(mysqli_num_rows($res) > 0){
                                    while($row = mysqli_fetch_assoc($res)){
                                        echo "<tr class='text-center'>";
                                        echo "<td class='col-auto'>".$row["id_tifo"]."</td>";
                                        echo "<td><img src='data:image/jpeg/png;base64,".base64_encode($row['image'])."' width='100' /></td>";
                                        echo "<td>".$row["description"]."</td>";
                                        echo "<td>".$row["date_execution"]."</td>";
                                        echo "<td>".$row["temp_debut"]."</td>";
                                        echo "<td>".$row["email"]."</td>";
                                        echo "<td>".$row["motpasse"]."</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

</script>
</body>
</html>
