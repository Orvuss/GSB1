<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
	// Connexion du visiteur
		$login = $_REQUEST['login'];
		$mdp = sha1($_REQUEST['mdp']);
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else{
            $id = $visiteur['id'];
            $nom =  $visiteur['nom'];
            $prenom = $visiteur['prenom'];
            $statut = $visiteur['statut'];
            connecter($id,$nom,$prenom,$statut);
            if ($statut == 'C') {
				include './vues/v_sommaireComptable.php';
			} 
			else {
				include './vues/v_sommaire.php';
			}
        }
        break;
	}

	
	case 'deconnexion':{
        $id = $_SESSION['idVisiteur'];
        deconnecter();
        unset($_SESSION);
        header('Location: index.php');
        break;
    }
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>