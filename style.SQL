CREATE TABLE Utilisateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    mot_de_passe VARCHAR(100),
    role ENUM('user', 'admin') DEFAULT 'user'
);
CREATE TABLE Categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100)
);

CREATE TABLE Recette (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255),
    description TEXT,
    ingredients TEXT,
    instructions TEXT,
    utilisateur_id INT,
    categorie_id INT,
    date_publication DATE,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id),
    FOREIGN KEY (categorie_id) REFERENCES Categorie(id)
);

CREATE TABLE Commentaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contenu TEXT,
    utilisateur_id INT,
    recette_id INT,
    date_commentaire DATE,
    FOREIGN KEY (utilisateur_id) REFERENCES Utilisateur(id),
    FOREIGN KEY (recette_id) REFERENCES Recette(id)
);
