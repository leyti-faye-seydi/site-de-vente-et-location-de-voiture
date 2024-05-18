<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "root";
$base_de_donnees = "CarsDB";

$connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

if ($connexion->connect_error) {
    die("Échec de la connexion : " . $connexion->connect_error);
}

$marque = "";
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['marque'])) {
    $marque = htmlspecialchars($_GET['marque']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voitures à Vendre</title>
    <style>
        /* Styles de base pour le conteneur et les éléments de voiture */
        #voitures {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .car-case {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            flex: 0 1 calc(33.333% - 20px); /* 3 voitures par ligne avec espace entre */
            box-sizing: border-box;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .car-case img {
            max-width: 100%;
            height: auto;
        }
        .car-case:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        @media (max-width: 768px) {
            .car-case {
                flex: 0 1 calc(50% - 20px); /* 2 voitures par ligne pour écrans moyens */
            }
        }
        @media (max-width: 480px) {
            .car-case {
                flex: 0 1 calc(100% - 20px); /* 1 voiture par ligne pour petits écrans */
            }
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header form {
            margin: 0;
        }
    </style>
</head>
<body>

<div class="header" style="background-color: cadetblue;">
    <h2>Liste des voitures disponibles pour la vente :</h2>
    <form method="get" action="">
        <label for="marque">Rechercher par marque :</label>
        <input type="text" id="marque" name="marque" value="<?php echo $marque; ?>">
        <button type="submit">Rechercher</button>
    </form>
</div>

<?php
if (!empty($marque)) {
    $requete = $connexion->prepare("SELECT * FROM Voitures WHERE disponible = ? AND marque LIKE ?");
    $disponible = 'vente';
    $marque_param = "%" . $marque . "%";
    $requete->bind_param("ss", $disponible, $marque_param);
} else {
    $requete = $connexion->prepare("SELECT * FROM Voitures WHERE disponible = ?");
    $disponible = 'vente';
    $requete->bind_param("s", $disponible);
}

$requete->execute();
$resultat = $requete->get_result();

if ($resultat->num_rows > 0) {
    echo "<div id='voitures'>";
    while($row = $resultat->fetch_assoc()) {
        $id_voiture = htmlspecialchars($row["id"]);
        $image = htmlspecialchars($row["image_url"]);
        $marque = htmlspecialchars($row["marque"]);
        $modele = htmlspecialchars($row["modele"]);
        $prix = htmlspecialchars($row["prix"]);
        $details = htmlspecialchars($row["details"]);

        echo "<div class='car-case' data-id='$id_voiture' data-marque='$marque' data-modele='$modele' data-prix='$prix' data-details='$details' data-image='$image' onclick='ToutSurVoiture(this)'>";
        echo "<img src='/MiniProjet/" . $image . "' alt='Image de " . $marque . " " . $modele . "'><br>";
        echo "<h4>" . $marque . " " . $modele . "</h4>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "Aucune voiture disponible pour la vente.";
}

$connexion->close();
?>

<script>
function ToutSurVoiture(element) {
    var id = element.getAttribute('data-id');
    var marque = element.getAttribute('data-marque');
    var modele = element.getAttribute('data-modele');
    var prix = element.getAttribute('data-prix');
    var details = element.getAttribute('data-details');
    var imageUrl = element.getAttribute('data-image');

    alert("Détails de la voiture:\n\nMarque: " + marque + "\nModèle: " + modele + "\nPrix: " + prix + " €\nDétails: " + details);
}
</script>

</body>
</html>
