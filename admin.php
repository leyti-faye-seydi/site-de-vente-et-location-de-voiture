<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    td {
        vertical-align: top;
    }
</style>
<body>
    <table>
        <td>
        <?php
// Connexion à la base de données
$serveur = "Localhost";
$utilisateur = "root";
$mot_de_passe = "root";
$base_de_donnees = "CarsDB";
$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

// Vérification de la connexion
if ($connexion->connect_error) {
    die("La connexion a échoué: " . $connexion->connect_error);
}

$requeteVente = "SELECT * FROM Voitures WHERE disponible='vente'";
$resultatVente = $connexion->query($requeteVente);

if ($resultatVente->num_rows > 0) {
    echo "<h1>Voiture disponible pour la vente</h1>";
    echo "<div id='voitures'>";
    while($row = $resultatVente->fetch_assoc()) {
        $id_voiture = $row["id"];
        $marque = $row["marque"];
        $modele = $row["modele"];
        $prix = $row["prix"];
        $details = $row["details"];
        $imageChemin = $row["image_url"];
        $dispo = $row["disponible"];
        // Stocker les détails de la voiture dans des attributs data-* pour récupération ultérieure avec JavaScript
        echo "<div id='case' onclick='afficherInfosVoiture(\"$id_voiture\", \"$marque\", \"$modele\", \"$prix\", \"$details\", \"$imageChemin\", \"$dispo\")'>";
        echo "<p>$marque $modele</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "Aucune voiture disponible pour la vente.";
}

$requeteLoc = "SELECT * FROM Voitures WHERE disponible='location'";
$resultatLoc = $connexion->query($requeteLoc);

if ($resultatVente->num_rows > 0) {
    echo "<h1>Voiture disponible pour la location</h1>";
    echo "<div id='voitures'>";
    while($row = $resultatLoc->fetch_assoc()) {
        $id_voiture = $row["id"];
        $marque = $row["marque"];
        $modele = $row["modele"];
        $prix = $row["prix"];
        $details = $row["details"];
        // Stocker les détails de la voiture dans des attributs data-* pour récupération ultérieure avec JavaScript
        echo "<div id='case' onclick='afficherInfosVoiture(\"$id_voiture\", \"$marque\", \"$modele\", \"$prix\", \"$details\", \"$imageChemin\", \"$dispo\")'>";
        echo "<p>$marque $modele</p>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "Aucune voiture disponible pour la vente.";
}
?>
        </td>
        <td>
            <!-- Formulaire pour ajouter une voiture -->
<h2 style="background-color: red;">Ajouter une Voiture</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">

    <label for="marque">Marque :</label>
    <input type="text" id="marque" name="marque" required><br><br>

    <label for="modele">Modèle :</label>
    <input type="text" id="modele" name="modele" required><br><br>

    <label for="prix">Prix :</label>
    <input type="text" id="prix" name="prix" required><br><br>

    <label for="details">Détails :</label>
    <textarea id="details" name="details" required></textarea><br><br>

    <label for="image">Chemin de l'image :</label>
    <input type="text" id="image" name="image" required><br><br>

    <label for="disponibilite">Disponibilité :</label>
    <select id="disponibilite" name="disponibilite" required>
        <option value="vente">Vente</option>
        <option value="location">Location</option>
    </select><br><br>

    <button type="submit" name="action" value="ajout">Ajouter Voiture</button>

</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        // Connexion à la base de données
        $serveur = "Localhost";
        $utilisateur = "root";
        $mot_de_passe = "root";
        $base_de_donnees = "CarsDB";
        $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

        // Vérification de la connexion
        if ($connexion->connect_error) {
            die("La connexion a échoué: " . $connexion->connect_error);
        }

        // Vérifier l'action du formulaire
        if ($action === "ajout") {
            // Récupérer les données du formulaire
            $marque = $_POST["marque"];
            $modele = $_POST["modele"];
            $disponibilite = $_POST["disponibilite"];
            $image_url = $_POST["image"]; // Récupérer le chemin de l'image
            $prix = $_POST["prix"];
            $details = $_POST["details"];

            // Requête SQL pour ajouter la voiture à la base de données
            $requete = "INSERT INTO Voitures (marque, modele, disponible, image_url, prix, details) VALUES ('$marque', '$modele', '$disponibilite', '$image_url', '$prix', '$details')";

            if ($connexion->query($requete) === TRUE) {
                echo "La voiture a été ajoutée avec succès.";
            } else {
                echo "Erreur lors de l'ajout de la voiture: " . $connexion->error;
            }
        } elseif ($action === 'supprimer_voiture' && isset($_POST['id_voiture'])) {
            // Conserver les données reçues sans nettoyer
            $id_voiture = $_POST['id_voiture'];
            supprimerVoiture($id_voiture);
        } elseif ($action === 'modifier_voiture' && isset($_POST['id_voiture'], $_POST['marque'], $_POST['modele'], $_POST['prix'], $_POST['details'], $_POST['image'], $_POST['disponibilite'])) {
            // Conserver les données reçues sans nettoyer
            $id_voiture = $_POST['id_voiture'];
            $marque = $_POST['marque'];
            $modele = $_POST['modele'];
            $prix = $_POST['prix'];
            $details = $_POST['details'];
            $image = $_POST['image'];
            $disponibilite = $_POST['disponibilite'];

            // Appeler la fonction pour modifier la voiture
            $resultat = modifierVoiture($id_voiture, $marque, $modele, $prix, $details, $image, $disponibilite, $connexion);
            echo $resultat;
        } else {
            // Action non reconnue ou données manquantes
            echo "Action non reconnue ou données manquantes.";
        }

        // Fermer la connexion
        $connexion->close();
    } else {
        // 'action' n'est pas défini dans $_POST
        echo "'action' n'est pas défini dans la requête POST.";
    }
}

?>




        </td>
        <td>
             <!-- Div pour afficher les informations de la voiture -->
             <?php
// Fonction PHP pour supprimer une voiture
function supprimerVoiture($id_voiture) {
    // Connexion à la base de données
    $serveur = "Localhost";
    $utilisateur = "root";
    $mot_de_passe = "root";
    $base_de_donnees = "CarsDB";
    $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

    // Vérifie si la connexion à la base de données a réussi
    if ($connexion->connect_error) {
        die("La connexion à la base de données a échoué : " . $connexion->connect_error);
    }

    // Requête SQL pour supprimer la voiture avec l'identifiant spécifié
    $requete = "DELETE FROM Voitures WHERE id = '$id_voiture'";

    // Exécute la requête SQL
    if ($connexion->query($requete) === TRUE) {
        echo "La voiture a été supprimée avec succès.";
    } else {
        echo "Erreur lors de la suppression de la voiture : " . $connexion->error;
    }

    // Ferme la connexion à la base de données
    $connexion->close();
}

// Fonction PHP pour modifier une voiture
function modifierVoiture($id, $marque, $modele, $prix, $details, $image, $disponibilite) {
    // Connexion à la base de données
    $serveur = "Localhost";
    $utilisateur = "root";
    $mot_de_passe = "root";
    $base_de_donnees = "CarsDB";
    $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

    // Vérifie si la connexion à la base de données a réussi
    if ($connexion->connect_error) {
        die("La connexion à la base de données a échoué : " . $connexion->connect_error);
    }

    // Requête SQL pour mettre à jour la voiture dans la base de données


    $requete = "UPDATE Voitures SET marque='$marque', modele='$modele', prix='$prix', details='$details', image='$image', disponible='$disponibilite' WHERE id='$id'";

    // Exécute la requête SQL
    if ($connexion->query($requete) === TRUE) {
        return "La voiture a été modifiée avec succès.";
    } else {
        return "Erreur lors de la modification de la voiture : " . $connexion->error;
    }

    // Ferme la connexion à la base de données
    $connexion->close();
}


?>

<div id="infoVoiture"></div>
<div id="infoVoituremod"></div>

<!-- Script JavaScript -->
<script>
    // Fonction pour afficher les informations de la voiture dans la div "infoVoiture"
    function afficherInfosVoiture(id, marque, modele, prix, details, image, Disponib) {
        // Construire le contenu avec les informations de la voiture
        var contenu = "<h2>Informations de la voiture</h2>";
        contenu += "<p>Marque: " + marque + "</p>";
        contenu += "<p>Modèle: " + modele + "</p>";
        contenu += "<p>Prix: " + prix + "</p>";
        contenu += "<p>Détails: " + details + "</p>";
        contenu += "<p>Image URL: " + image + "</p>";
        contenu += "<p>Disponibilité: " + Disponib + "</p>";

        // Ajouter les boutons de modification et de suppression
        contenu += "<button onclick='afficherFormulaireModification(" + id + ", \"" + marque + "\", \"" + modele + "\", \"" + prix + "\", \"" + details + "\", \"" + image + "\", \"" + Disponib + "\")'>Modifier</button>";
        contenu += "<button onclick='supprimerVoiture(" + id + ")'>Supprimer</button>";

        // Mettre à jour le contenu de la div "infoVoiture"
        document.getElementById('infoVoiture').innerHTML = contenu;
    }

    // Fonction JavaScript pour supprimer une voiture
    function supprimerVoiture(id) {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Voiture supprimée avec succès"); // Afficher la réponse du serveur
            } else {
                console.error('Erreur lors de la requête AJAX : ' + xhr.status);
            }
        }
    };
    xhr.open('POST', '', true); // Laissez l'URL vide pour envoyer la requête au même fichier
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('action=supprimer_voiture&id_voiture=' + id);
}

function afficherFormulaireModification(id, marque, modele, prix, details, image, Disponib) {
    var contenu = "<h2>Modifier la voiture</h2>";
    contenu += "<form id='formModifierVoiture'>";
    contenu += "<input type='hidden' name='id' value='" + id + "'>";
    contenu += "<label for='marque'>Marque :</label>";
    contenu += "<input type='text' id='marque' name='marque' value='" + marque + "' required><br><br>";
    contenu += "<label for='modele'>Modèle :</label>";
    contenu += "<input type='text' id='modele' name='modele' value='" + modele + "' required><br><br>";
    contenu += "<label for='prix'>Prix :</label>";
    contenu += "<input type='text' id='prix' name='prix' value='" + prix + "' required><br><br>";
    contenu += "<label for='details'>Détails :</label>";
    contenu += "<textarea id='details' name='details' required>" + details + "</textarea><br><br>";
    contenu += "<label for='image'>Image URL :</label>";
    contenu += "<input type='text' id='image' name='image' value='" + image + "' required><br><br>";
    contenu += "<label for='disponibilite'>Disponibilité :</label>";
    contenu += "<select id='disponibilite' name='disponibilite' required>";
    contenu += "<option value='vente' " + (Disponib === 'vente' ? 'selected' : '') + ">Vente</option>";
    contenu += "<option value='location' " + (Disponib === 'location' ? 'selected' : '') + ">Location</option>";
    contenu += "</select><br><br>";
    contenu += "<button type='submit' name='modif' value='modifier_voiture'>Modifier</button>";
    contenu += "</form>";

    document.getElementById('infoVoituremod').innerHTML = contenu;
}

function modifierVoiture() {
    var id = document.getElementById('formModifierVoiture').querySelector('input[name="id"]').value;
    var marque = document.getElementById('marque').value;
    var modele = document.getElementById('modele').value;
    var prix = document.getElementById('prix').value;
    var details = document.getElementById('details').value;
    var image = document.getElementById('image').value;
    var disponibilite = document.getElementById('disponibilite').value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                alert("Voiture modifiée avec succès");
                // Mettre à jour les champs du formulaire avec les nouvelles valeurs
                document.getElementById('marque').value = marque;
                document.getElementById('modele').value = modele;
                document.getElementById('prix').value = prix;
                document.getElementById('details').value = details;
                document.getElementById('image').value = image;
                document.getElementById('disponibilite').value = disponibilite;
            } else {
                console.error('Erreur lors de la requête AJAX : ' + xhr.status);
            }
        }
    };
    
    // Création de la chaîne de requête avec les paramètres
    var params = 'action=modifier_voiture&id_voiture=' + id +
                 '&marque=' + encodeURIComponent(marque) +
                 '&modele=' + encodeURIComponent(modele) +
                 '&prix=' + encodeURIComponent(prix) +
                 '&details=' + encodeURIComponent(details) +
                 '&image=' + encodeURIComponent(image) +
                 '&disponibilite=' + encodeURIComponent(disponibilite);
    
    xhr.open('POST', '', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(params);
}



</script>

        </td>
    </table>
</body>
</html>