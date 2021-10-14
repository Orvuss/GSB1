<?php
    session_start();
    include "../fpdf/fpdf.php";
    include "../include/fonctionCo.php";
    $bdd = connexion();
    if($bdd){
        $user = $_SESSION['idVisiteur'];

        $PDF = new fpdf();
        $PDF->AddPage();
        $PDF->SetFont("Arial","B",16);
        $PDF->SetTextColor(0,0,0);
        $PDF->MultiCell(0, 10, "PDF de :\n" . $_SESSION['prenom'], 1, "C", 0);
        $PDF->Image("../images/logo.jpg", 80, 40, 50, 50);

        $position = 120; 
        $requete2 = $bdd->prepare("SELECT * FROM Visiteur WHERE login = :num;");
        $requete2->bindParam(':num', $user);
        $requete2->execute();
        $PDF->SetTextColor(0,0,0);

        $PDF->SetY($position-8);
        $PDF->SetX(15);
        $PDF->MultiCell(60,8,utf8_decode("Id du visiteur"),4,'C');
        $PDF->SetY($position-8);
        $PDF->SetX(45);
        $PDF->MultiCell(60,8,utf8_decode("Mois"),4,'C');
        $PDF->SetY($position-8);
        $PDF->SetX(75);
        $PDF->MultiCell(60,8,utf8_decode("Libellé"),4,'C');
        $PDF->SetY($position-8);
        $PDF->SetX(110);
        $PDF->MultiCell(60,8,utf8_decode("Date"),4,'C');
        $PDF->SetY($position-8);
        $PDF->SetX(140);
        $PDF->MultiCell(60,8,utf8_decode("Montant"),4,'C');

        $PDF->SetTextColor(0,0,0);

        $donne = $requete2->fetch();

        $id = $donne['id'];
        $select = $bdd->prepare("SELECT * FROM LigneFraisHorsForfait WHERE idVisiteur = :numero;");
        $select->bindParam(':numero', $user);
        $select->execute();
        $donneesProduit = $select->fetch();
        $PDF->SetFont("Arial","I",16);

        $PDF->SetY($position);
        $PDF->SetX(15);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['idVisiteur']),4,'C');
        $PDF->SetY($position);
        $PDF->SetX(45);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['mois']),4,'C');
        $PDF->SetY($position);
        $PDF->SetX(75);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['libelle']),4,'C');
        $PDF->SetY($position);
        $PDF->SetX(110);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['date']),4,'C');
        $PDF->SetY($position);
        $PDF->SetX(140);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['montant']),4,'C');

        $position += 8;

        $PDF->Output();
    }
    else{
      echo "erreur";
    }
?>