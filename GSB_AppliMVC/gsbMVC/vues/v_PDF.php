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
        $requete2 = $bdd->query("SELECT * FROM Visiteur WHERE login = '$user';");

        $PDF->SetTextColor(0,0,0);

        //Affichage des cell

    
        $PDF->SetY($position-8);
        $PDF->SetX(25);
        $PDF->MultiCell(60,8,utf8_decode("Id du visiteur"),4,'C');

        $PDF->SetY($position-8);
        $PDF->SetX(55);
        $PDF->MultiCell(60,8,utf8_decode("Mois"),4,'C');

        $PDF->SetY($position-8);
        $PDF->SetX(85);
        $PDF->MultiCell(60,8,utf8_decode("Libellé"),4,'C');

        $PDF->SetY($position-8);
        $PDF->SetX(120);
        $PDF->MultiCell(60,8,utf8_decode("Date"),4,'C');

        $PDF->SetY($position-8);
        $PDF->SetX(150);
        $PDF->MultiCell(60,8,utf8_decode("Montant"),4,'C');

        $PDF->SetTextColor(0,0,0);


        $donne = $requete2->fetch();
            
        
        $id = $donne['id'];
        $select = $bdd->query("SELECT * FROM LigneFraisHorsForfait WHERE id = 1;");
        $donneesProduit = $select->fetch();
        $PDF->SetFont("Arial","I",16);

        $PDF->SetY($position);
        $PDF->SetX(25);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['idVisiteur']),4,'C');

        $PDF->SetY($position);
        $PDF->SetX(55);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['mois']),4,'C');

        $PDF->SetY($position);
        $PDF->SetX(85);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['libelle']),4,'C');

        $PDF->SetY($position);
        $PDF->SetX(120);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['date']),4,'C');

        $PDF->SetY($position);
        $PDF->SetX(150);
        $PDF->MultiCell(60,8,utf8_decode($donneesProduit['montant']),4,'C');

        $position += 8;

        
        
        $PDF->Output();
        /*$recupNbCommade = $bdd->query("SELECT COUNT(*) AS nbCommade FROM commade WHERE userConnexion = '$user' ;");
        $resultatNbCommade = $recupNbCommade->fetch();
        $nbCommade = $resultatNbCommade['nbCommade'];
        $nbCommade = $nbCommade + 1;
        $PDF->Output("commande/".$user.$nbCommade.".PDF", "F");*/
    }
    else{
      echo "erreur";
    }
?>