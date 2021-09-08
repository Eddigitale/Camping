<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/recapitulatif.css">
</head>

<body>
    <header>
        <h1>Les Flots Bleus</h1>
        <div class="nav">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="onglet nav-link" href="../html/camping.html">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="onglet nav-link" href="../html/reservation.html">Réservation</a>
                </li>
                <li class="nav-item">
                    <a class="onglet nav-link" href="../html/reglement.html">Règlement</a>
                </li>
            </ul>
        </div>
    </header>
    <?php
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $date = $_POST["date"];
    $adresse = $_POST["adresse"];
    $code_postal = $_POST["code_postal"];
    $ville = $_POST["ville"];
    $tel = $_POST["tel"];
    $pays = $_POST["pays"];
    $mail = $_POST["mail"];
    $immatriculation = $_POST["immatriculation"];
    $arrivee = $_POST["arrivee"];
    $depart = $_POST["depart"];
    if (isset($_POST["animaux"])) {
        $animaux = $_POST["animaux"];
    } else {
        $animaux = "non";
    }
    $emplacement = $_POST["emplacement"];
    $type_location = $_POST["type_location"];
    if (isset($_POST["electricite"])) {
        $electricite = $_POST["electricite"];
    } else {
        $electricite = "non";
    }
    if (isset($_POST["frigo"])) {
        $frigo = $_POST["frigo"];
    } else {
        $frigo = "non";
    }
    $paiement = $_POST["paiement"];
    $nom_signataire = $_POST["nom_signataire"];
    $ville_signature = $_POST["ville_signature"];
    $date_signature = $_POST["date_signature"];
    $signature = $_POST["signature"];
    $date1 = strtotime($arrivee);
    $date2 = strtotime($depart);
    $difference = $date2 - $date1;
    $nombre_jours = $difference / 86400;
    if ($type_location == "tente") {
        $prix = 30;
    } else if ($type_location == "voiture") {
        $prix = 50;
    } else if ($type_location == "caravane") {
        $prix = 75;
    } else {
        $prix = 100;
    }
    $prix *= $nombre_jours;
    if ($emplacement == "grand_confort") {
        $prix += 20;
    } else if ($emplacement == "pre_equipe") {
        $prix += 50;
    }
    if ($electricite == "oui") {
        $prix += 10;
    }
    if ($frigo == "oui") {
        $prix += 5;
    }
    if ($nombre_jours >= 7 && $nombre_jours < 14) {
        $prix -= $prix * 10 / 100;
    } else if ($nombre_jours >= 14) {
        $prix -= $prix * 20 / 100;
    }
    try {
        $connexion = new PDO('mysql:host=localhost;port=3306;dbname=ecf;charset=utf8', 'root', '');
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql0 = "SELECT `nom`, `mail` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail";
        $requete0 = $connexion->prepare($sql0);
        $requete0->bindParam(':mail', $mail, PDO::PARAM_STR);
        $requete0->bindParam(':nom', $nom, PDO::PARAM_STR);
        $requete0->execute();
        while ($row = $requete0->fetch()) {
            $nomexistant = $row["nom"];
            $mailexistant = $row["mail"];
        }
        $sql1 = "SELECT MIN(`id`) AS 'id' FROM `emplacement` WHERE type_location = :type_location AND disponibilite = 'disponible'";
        $requete1 = $connexion->prepare($sql1);
        $requete1->bindParam(':type_location', $type_location, PDO::PARAM_STR);
        $requete1->execute();
        while ($row = $requete1->fetch()) {
            if ($type_location == "tente" && $row["id"] != NULL || $type_location == "caravane" && $row["id"] != NULL || $type_location == "mobilhome" && $row["id"] != NULL || $type_location == "voiture" && $row["id"] != NULL) {
                if (!isset($nomexistant) && !isset($mailexistant)) {
                    $sql = "INSERT INTO `clients`(`nom`, `prenom`, `date_naissance`, `adresse`, `code_postal`, `ville`, `tel`, `pays`, `mail`, `immatriculation`) VALUES (:nom, :prenom, :date_naissance, :adresse, :code_postal, :ville, :tel, :pays, :mail, :immatriculation)";
                    $requete = $connexion->prepare($sql);
                    $requete->bindParam(':nom', $nom, PDO::PARAM_STR);
                    $requete->bindParam(':prenom', $prenom, PDO::PARAM_STR);
                    $requete->bindParam(':date_naissance', $date, PDO::PARAM_STR);
                    $requete->bindParam(':adresse', $adresse, PDO::PARAM_STR);
                    $requete->bindParam(':code_postal', $code_postal, PDO::PARAM_INT);
                    $requete->bindParam(':ville', $ville, PDO::PARAM_STR);
                    $requete->bindParam(':tel', $tel, PDO::PARAM_INT);
                    $requete->bindParam(':pays', $pays, PDO::PARAM_STR);
                    $requete->bindParam(':mail', $mail, PDO::PARAM_STR);
                    $requete->bindParam(':immatriculation', $immatriculation, PDO::PARAM_STR);
                    $requete->execute();
                }
                $sql2 = "INSERT INTO `detail_sejour`(`id_client`, `date_arrivee`, `date_depart`, `animaux`, `nombre_jours`) VALUES ((SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail), :date_arrivee, :date_depart, :animaux, :nombre_jours)";
                $requete2 = $connexion->prepare($sql2);
                $requete2->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete2->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete2->bindParam(':date_arrivee', $arrivee, PDO::PARAM_STR);
                $requete2->bindParam(':date_depart', $depart, PDO::PARAM_STR);
                $requete2->bindParam(':animaux', $animaux, PDO::PARAM_STR);
                $requete2->bindParam(':nombre_jours', $nombre_jours, PDO::PARAM_INT);
                $requete2->execute();
                $sql3 = "INSERT INTO `location_emplacement`(`id_client`, `emplacement`, `type_location`, `electricite`, `frigo`) VALUES ((SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail), :emplacement, :type_location, :electricite, :frigo)";
                $requete3 = $connexion->prepare($sql3);
                $requete3->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete3->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete3->bindParam(':emplacement', $emplacement, PDO::PARAM_STR);
                $requete3->bindParam(':type_location', $type_location, PDO::PARAM_STR);
                $requete3->bindParam(':electricite', $electricite, PDO::PARAM_STR);
                $requete3->bindParam(':frigo', $frigo, PDO::PARAM_STR);
                $requete3->execute();
                if (isset($_POST["nomacc"]) && isset($_POST["prenomacc"]) && isset($_POST["dateacc"])) {
                    $nomacc = array_filter($_POST["nomacc"]);
                    $prenomacc = array_filter($_POST["prenomacc"]);
                    $dateacc = array_filter($_POST["dateacc"]);
                    for ($i = 0; $i < count($nomacc); $i++) {
                        $sql4 = "INSERT INTO `accompagnants` (`id_client`, `nom`, `prenom`, `date_naissance`) VALUES ((SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail), :nomacc, :prenomacc, :date_naissanceacc)";
                        $requete4 = $connexion->prepare($sql4);
                        $requete4->bindParam(':nom', $nom, PDO::PARAM_STR);
                        $requete4->bindParam(':mail', $mail, PDO::PARAM_STR);
                        $requete4->bindParam(':nomacc', $nomacc[$i], PDO::PARAM_STR);
                        $requete4->bindParam(':prenomacc', $prenomacc[$i], PDO::PARAM_STR);
                        $requete4->bindParam(':date_naissanceacc', $dateacc[$i], PDO::PARAM_STR);
                        $requete4->execute();
                    }
                }
                $sql5 = "INSERT INTO `paiement`(`id_client`, `prix`, `moyen_paiement`, `nom`, `ville`, `date`, `signature`) VALUES ((SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail), :prix, :paiement, :nom_signature, :ville_signature, :date_signature, :signe)";
                $requete5 = $connexion->prepare($sql5);
                $requete5->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete5->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete5->bindParam(':prix', $prix, PDO::PARAM_INT);
                $requete5->bindParam(':paiement', $paiement, PDO::PARAM_STR);
                $requete5->bindParam(':nom_signature', $nom_signataire, PDO::PARAM_STR);
                $requete5->bindParam(':ville_signature', $ville_signature, PDO::PARAM_STR);
                $requete5->bindParam(':date_signature', $date_signature, PDO::PARAM_STR);
                $requete5->bindParam(':signe', $signature, PDO::PARAM_STR);
                $requete5->execute();
                $sql6 = "SELECT * FROM `clients` WHERE `nom` = :nom AND `mail` = :mail";
                $requete6 = $connexion->prepare($sql6);
                $requete6->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete6->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete6->execute();
                $sql7 = "SELECT * FROM `clients` INNER JOIN `detail_sejour` ON `clients`.`id` = `detail_sejour`.`id_client` WHERE `clients`.`id` = (SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail) ORDER BY `detail_sejour`.`id` DESC LIMIT 1";
                $requete7 = $connexion->prepare($sql7);
                $requete7->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete7->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete7->execute();
                $sql8 = "SELECT * FROM `clients` INNER JOIN `location_emplacement` ON `clients`.`id` = `location_emplacement`.`id_client` WHERE `clients`.`id` = (SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail) ORDER BY `location_emplacement`.`id` DESC LIMIT 1";
                $requete8 = $connexion->prepare($sql8);
                $requete8->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete8->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete8->execute();
                $sql9 = "SELECT * FROM `clients` INNER JOIN `paiement` ON `clients`.`id` = `paiement`.`id_client` WHERE `clients`.`id` = (SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail) ORDER BY `paiement`.`id` DESC LIMIT 1";
                $requete9 = $connexion->prepare($sql9);
                $requete9->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete9->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete9->execute();
                $sql10 = "SELECT * FROM `clients` INNER JOIN `accompagnants` ON `clients`.`id` = `accompagnants`.`id_client` WHERE `clients`.`id` = (SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail) ORDER BY `accompagnants`.`id` DESC LIMIT :compteur";
                $requete10 = $connexion->prepare($sql10);
                echo (count($nomacc));
                $requete10->bindValue(':compteur', count($nomacc), PDO::PARAM_INT);
                $requete10->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete10->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete10->execute();
                $sql11 = "UPDATE `emplacement` SET `id_client`= (SELECT `id` FROM `clients` WHERE `nom` = :nom AND `mail` = :mail),`disponibilite`='indisponible' WHERE type_location = :type_location AND disponibilite = 'disponible' AND `id` = :id_emplacement";
                $requete11 = $connexion->prepare($sql11);
                $requete11->bindParam(':nom', $nom, PDO::PARAM_STR);
                $requete11->bindParam(':mail', $mail, PDO::PARAM_STR);
                $requete11->bindParam(':type_location', $type_location, PDO::PARAM_STR);
                $requete11->bindParam(':id_emplacement', $row["id"], PDO::PARAM_INT);
                $requete11->execute();
    ?>
                <h2>Merci d'avoir réservé chez nous!</h2>
                <h2 class="recu">Récapitulatif de commande:</h2>
                <div class="reservation">
                    <div class="recap">
                        <div class="commande">
                            <h3>Votre commande:</h3>
                            <?php
                            while ($row = $requete6->fetch()) {
                            ?>
                                <strong>Nom: </strong><?php echo ($row["nom"]); ?><br>
                                <strong>Prénom: </strong><?php echo ($prenom); ?><br>
                                <strong>Date de naissance: </strong><?php echo ($date); ?><br>
                                <strong>Adresse: </strong><?php echo ($adresse); ?><br>
                                <strong>Code postal: </strong><?php echo ($code_postal); ?><br>
                                <strong>Ville: </strong><?php echo ($ville); ?><br>
                                <strong>Téléphone: </strong><?php echo ($tel); ?><br>
                                <strong>Pays: </strong><?php echo ($pays); ?><br>
                                <strong>E-mail: </strong><?php echo ($mail); ?><br>
                                <strong>Immatriculation véhicule: </strong><?php echo ($immatriculation); ?><br><br>
                            <?php
                            }
                            ?>
                            <?php
                            while ($row = $requete7->fetch()) {
                            ?>
                                <strong>Date d'arrivée: </strong><?php echo ($row["date_arrivee"]); ?><br>
                                <strong>Date de départ: </strong><?php echo ($row["date_depart"]); ?><br>
                                <strong>Animaux: </strong><?php echo ($row["animaux"]); ?><br><br>
                            <?php
                            }
                            ?>
                            <?php
                            while ($row = $requete8->fetch()) {
                            ?>
                                <strong>Emplacement: </strong><?php echo ($row["emplacement"]); ?><br>
                                <strong>Type de location: </strong><?php echo ($row["type_location"]); ?><br>
                                <strong>Electricité: </strong><?php echo ($row["electricite"]); ?><br>
                                <strong>Frigo: </strong><?php echo ($row["frigo"]); ?><br><br>
                            <?php
                            }
                            ?>
                            <?php
                            while ($row = $requete9->fetch()) {
                            ?>
                                <strong>Total: </strong><?php echo ($row["prix"]); ?> €<br>
                                <strong>Moyen de paiement: </strong><?php echo ($row["moyen_paiement"]); ?><br><br>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="accompagnants">
                            <h3>Personnes accompagnantes:</h3>
                            <?php
                            while ($row = $requete10->fetch()) {
                            ?>
                                <strong>Nom: </strong><?php echo ($row["nom"]); ?><br>
                                <strong>Prénom: </strong><?php echo ($row["prenom"]); ?><br>
                                <strong>Date de naissance: </strong><?php echo ($row["date_naissance"]); ?><br><br>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="reservation">
                    <h2>
                        Nous somme désolés mais nous n'avons plus d'emplacements disponibles pour les <?php echo $type_location ?>s.
                    </h2>
                </div>
    <?php
            }
        }
    } catch (PDOException $e) {
        echo 'Échec lors de la connexion : ' . $e->getMessage();
    }
    ?>
</body>

</html>