<?php
require('fpdf186/fpdf.php');

//error_reporting(E_ALL); ini_set('display_errors', 1);
$con=mysqli_connect('localhost' , 'root' , '');
mysqli_select_db($con,'tif');

class PDF extends FPDF{
    
    function Header(){
        // Afficher le titre uniquement lorsque la page courante est la première
        if ($this->PageNo() === 1) {
            
            $this->SetFont('Courier', 'B', 10); // Nouvelle ligne

            $this->Cell(0,10,'ULTRASTIFO',0,1,'L');
            $this->Line(10, $this->GetY(), 200, $this->GetY()); // Ajouter une ligne après UltrasTifo
           
            
            $this->SetFont('Arial' ,'B' ,15);
            $this->Cell(0,10,'Toutes les planifications effectuees',0,1,'C');}
            $this->Ln(5);
            $this->SetFont('Arial' ,'B',11);
            $this->SetFillColor(80, 80, 80);
            $this->SetDrawColor(40,40,40);
            $this->SetTextColor(255);
            $this->Cell(25, 5, 'Num Du Tifo', 1, 0, 'C', true); 
           
            $this->Cell(20, 5, 'Chaise X', 1, 0, 'C', true);
            $this->Cell(20, 5, 'Chaise Y', 1, 0, 'C', true);
            $this->Cell(25, 5, 'Couleur', 1, 0, 'C', true);
            $this->Cell(25, 5, 'Chanson', 1, 0, 'C', true);
            $this->Cell(20, 5, 'Duree', 1, 0, 'C', true);
            $this->Cell(25, 5, 'Mouvement', 1, 0, 'C', true);
            $this->Cell(38, 5, 'Nombre De scenario', 1, 1, 'C', true);
        }
    
        
    function Footer(){
        $this->Cell(190,0,'','T','l','',true);
        $this->SetY(-15);
        $this->SetFont('Arial','' ,8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . ' / {nb}', 0, 0, 'C');
    }
}

$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages('{nb}');
$pdf->AddPage();
$pdf->SetFont('Arial' ,'' ,9);
$pdf->SetDrawColor(50,50,100);

$req = mysqli_query($con, "SELECT m.coordonnees_x, m.coordonnees_y, m.id_tifo, a.couleur, a.chanson, a.duree, a.mouvement, a.nbrs
                           FROM membre m
                           INNER JOIN action a ON m.id_membre = a.id_membre");

if ($req) { // Vérifiez si la requête a réussi
    while ($data = mysqli_fetch_array($req)) {
        $coordonnees_x = utf8_decode($data['coordonnees_x']);
        $coordonnees_y = utf8_decode($data['coordonnees_y']);
        $id_tifo = utf8_decode($data['id_tifo']);
        $couleur_hex = utf8_decode($data['couleur']); // Supposons que la couleur est stockée dans la colonne 'couleur' en format hexadécimal
        $chanson = utf8_decode($data['chanson']);
        $duree = utf8_decode($data['duree']);
        $mouvement = utf8_decode($data['mouvement']);
        $nbrs = utf8_decode($data['nbrs']);
        
        // Convertir la couleur hexadécimale en composantes RGB
        list($r, $g, $b) = sscanf($couleur_hex, "#%02x%02x%02x");

        // Définir la couleur de remplissage des cellules dans le PDF
        $pdf->SetFillColor($r, $g, $b);

        // Afficher les autres données dans les cellules du PDF
        $pdf->Cell(25, 5, $id_tifo, 1, 0, 'C', false);
        $pdf->Cell(20, 5, $coordonnees_x, 1, 0, 'C', false);
        $pdf->Cell(20, 5, $coordonnees_y, 1, 0, 'C', false);
        $pdf->Cell(25, 5, '', 1, 0, 'C', true); // Cellule vide pour la couleur
        $pdf->Cell(25, 5, $chanson, 1, 0, 'C', false);
        $pdf->Cell(20, 5, $duree, 1, 0, 'C', false);
        $pdf->Cell(25, 5, $mouvement, 1, 0, 'C', false);
        $pdf->Cell(38, 5, $nbrs, 1, 1, 'C', false);
    }
} else {
    // Gérez l'erreur de requête (facultatif)
    echo "Erreur : impossible de récupérer les données de la base de données.";
}

$pdf->Output();
?>
