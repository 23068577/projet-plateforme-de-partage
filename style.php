<?php
$servername = "localhost";
$username = "root"; // Votre nom d'utilisateur MySQL
$password = ""; // Votre mot de passe MySQL
$dbname = "recette_app"; // Nom de votre base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php
include 'db.php';

// Récupération des recettes depuis la base de données
$sql = "SELECT * FROM Recette";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql .= " WHERE titre LIKE '%$search%' OR description LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application de Recettes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Bienvenue sur l'Application de Recettes</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="publier_recette.php">Publier une recette</a>
            <a href="recherche_recette.php">Rechercher des recettes</a>
        </nav>
    </header>

    <div class="search-container">
        <h2>Trouver une recette</h2>
        <form action="index.php" method="GET">
            <input type="text" name="search" placeholder="Entrez un mot-clé" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>

    <section class="recettes">
        <h2>Liste des Recettes</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='recette-item'>";
                echo "<h3>" . $row['titre'] . "</h3>";
                echo "<p>" . $row['description'] . "</p>";
                echo "<a href='recette_detail.php?id=" . $row['id'] . "'>Voir la recette</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Aucune recette trouvée.</p>";
        }
        ?>
    </section>

    <footer>
        <p>&copy; 2024 Application de Recettes</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $titre = $_POST['titre'];
    $categorie = $_POST['categorie'];
    $description = $_POST['description'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    // Insertion de la recette dans la base de données
    $sql = "INSERT INTO Recette (titre, description, ingredients, instructions, categorie_id) 
            VALUES ('$titre', '$description', '$ingredients', '$instructions', '$categorie')";

    if ($conn->query($sql) === TRUE) {
        echo "Recette publiée avec succès!";
        header("Location: index.php"); // Rediriger vers la page d'accueil après publication
        exit();
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier une Recette</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Publier une Recette</h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="publier_recette.php">Publier une recette</a>
            <a href="recherche_recette.php">Rechercher des recettes</a>
        </nav>
    </header>

    <div class="form-container">
        <h2>Formulaire de Publication</h2>
        <form action="publier_recette.php" method="POST">
            <label for="titre">Titre :</label>
            <input type="text" name="titre" required>

            <label for="categorie">Catégorie :</label>
            <input type="text" name="categorie" required>

            <label for="description">Description :</label>
            <textarea name="description" required></textarea>

            <label for="ingredients">Ingrédients :</label>
            <textarea name="ingredients" required></textarea>

            <label for="instructions">Instructions :</label>
            <textarea name="instructions" required></textarea>

            <button type="submit">Publier la recette</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Application de Recettes</p>
    </footer>
</body>
</html>

<?php
$conn->close();
?>
<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer la recette depuis la base de données
    $sql = "SELECT * FROM Recette WHERE id = $id";
    $result = $conn->query($sql);
    $recette = $result->fetch_assoc();

    // Récupérer les commentaires de la recette
    $sql_comments = "SELECT * FROM Commentaire WHERE recette_id = $id";
    $comments = $conn->query($sql_comments);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ajouter un commentaire
    $commentaire = $_POST['commentaire'];
    $sql_insert_comment = "INSERT INTO Commentaire (contenu, recette_id) VALUES ('$commentaire', '$id')";
    if ($conn->query($sql_insert_comment) === TRUE) {
        echo "Commentaire ajouté avec succès!";
        header("Location: recette_detail.php?id=$id");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $recette['titre']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1><?php echo $recette['titre']; ?></h1>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="publier_recette.php">Publier une recette</a>
            <a href="recherche_recette.php">Rechercher des recettes</a>
        </nav>
    </header>

    <section class="recette-detail">
        <h2>Description</h2>
        <p><?php echo $recette['description']; ?></p>

        <h3>Ingrédients</h3>
        <p><?php echo $recette['ingredients']; ?></p>

        <h3>Instructions</h3>
        <p><?php echo $recette['instructions']; ?></p>

        <h3>Commentaires</h3>
        <?php while ($comment = $comments->fetch_assoc()) { ?>
            <div class="commentaire">
                <p><?php echo $comment['contenu']; ?></p>
            </div>
        <?php } ?>

        <h3>Ajouter un commentaire</h3>
        <form action="recette_detail.php?id=<?php echo $id; ?>" method="POST">
            <textarea name="commentaire" required></textarea>
            <button type="submit">Ajouter</button>
        </form>
    </section>

    <footer>
