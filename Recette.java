public class Utilisateur {
    private int id;
    private String nom;
    private String email;
    private String motDePasse;
    private String role;

    // Constructeurs, getters et setters
    public Utilisateur(int id, String nom, String email, String motDePasse, String role) {
        this.id = id;
        this.nom = nom;
        this.email = email;
        this.motDePasse = motDePasse;
        this.role = role;
    }

    // Getters et setters
}

public class Recette {
    private int id;
    private String titre;
    private String description;
    private String ingredients;
    private String instructions;
    private int utilisateurId;
    private int categorieId;
    private Date datePublication;

    // Constructeurs, getters et setters
    public Recette(int id, String titre, String description, String ingredients, String instructions,
                   int utilisateurId, int categorieId, Date datePublication) {
        this.id = id;
        this.titre = titre;
        this.description = description;
        this.ingredients = ingredients;
        this.instructions = instructions;
        this.utilisateurId = utilisateurId;
        this.categorieId = categorieId;
        this.datePublication = datePublication;
    }

    // Getters et setters
}

public class Commentaire {
    private int id;
    private String contenu;
    private int utilisateurId;
    private int recetteId;
    private Date dateCommentaire;

    // Constructeurs, getters et setters
    public Commentaire(int id, String contenu, int utilisateurId, int recetteId, Date dateCommentaire) {
        this.id = id;
        this.contenu = contenu;
        this.utilisateurId = utilisateurId;
        this.recetteId = recetteId;
        this.dateCommentaire = dateCommentaire;
    }

    // Getters et setters
}

public class Categorie {
    private int id;
    private String nom;

    // Constructeurs, getters et setters
    public Categorie(int id, String nom) {
        this.id = id;
        this.nom = nom;
    }

    // Getters et setters
}

