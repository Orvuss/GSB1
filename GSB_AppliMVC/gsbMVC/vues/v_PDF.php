<?php
  session_start();
  include "../fpdf/fpdf.php";
  
    $PDF = new fpdf();
    $PDF->AddPage();
    $PDF->SetFont("Arial","B",16);
    $PDF->SetTextColor(0,0,0);
    $PDF->MultiCell(0, 10, "PDF de :\n" . $_SESSION['idVisiteur'], 1, "C", 0);
    $PDF->Image("../Image/logo.jpg", 80, 40, 50, 50);

    $position = 120; 
    $requete2 = mysqli_query($bdd,"SELECT * FROM panier WHERE userConnexion = '$user';");

    $PDF->SetTextColor(0,0,0);

    $PDF->SetY($position-16);
    $PDF->SetX(75);
    $PDF->MultiCell(60,8,utf8_decode("Prix Total"),1,'C');
    $PDF->SetFont("Arial","",16);
    $PDF->SetY($position-16);
    $PDF->SetX(135);
    $PDF->MultiCell(60,8,utf8_decode($_SESSION['totalPanier']."e"),1,'C');

    $PDF->SetFont("Arial","B",16);
    $PDF->SetY($position-8);
    $PDF->SetX(15);
    $PDF->MultiCell(60,8,utf8_decode("Produit"),1,'C');

    $PDF->SetY($position-8);
    $PDF->SetX(75);
    $PDF->MultiCell(60,8,utf8_decode("Prix"),1,'C');

    $PDF->SetY($position-8);
    $PDF->SetX(135);
    $PDF->MultiCell(60,8,utf8_decode("Quantité"),1,'C');

    $PDF->SetTextColor(0,0,0);

    while ($donne = mysqli_fetch_assoc($requete2)) {
      $idProduit = $donne['idProduit'];
      $select = mysqli_query($bdd, "SELECT * FROM produit WHERE idProduit = '$idProduit';");
      $donneesProduit = mysqli_fetch_assoc($select);
      $PDF->SetFont("Arial","I",16);

      $PDF->SetY($position);
      $PDF->SetX(15);
      $PDF->MultiCell(60,8,utf8_decode($donneesProduit['titre']),1,'C');

      $PDF->SetY($position);
      $PDF->SetX(75);
      $PDF->MultiCell(60,8,utf8_decode($donneesProduit['prix']."e"),1,'C');

      $PDF->SetY($position);
      $PDF->SetX(135);
      $PDF->MultiCell(60,8,utf8_decode($donne['quantite']),1,'C');

      $position += 8;
    }
    mysqli_free_result($requete2);

    $PDF->Output();
    $recupNbCommade = mysqli_query($bdd, "SELECT COUNT(*) AS nbCommade FROM commade WHERE userConnexion = '$user' ;");
    $resultatNbCommade = mysqli_fetch_assoc($recupNbCommade);
    $nbCommade = $resultatNbCommade['nbCommade'];
    $nbCommade = $nbCommade + 1;
    $PDF->Output("commande/".$user.$nbCommade.".PDF", "F");
?>