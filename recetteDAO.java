import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class RecetteDAO {
    private Connection conn;

    public RecetteDAO() throws SQLException {
        this.conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/recette_app", "root", "password");
    }

    // Méthode pour ajouter une recette
    public void ajouterRecette(Recette recette) throws SQLException {
        String sql = "INSERT INTO Recette (titre, description, ingredients, instructions, utilisateur_id, categorie_id, date_publication) VALUES (?, ?, ?, ?, ?, ?, ?)";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, recette.getTitre());
            stmt.setString(2, recette.getDescription());
            stmt.setString(3, recette.getIngredients());
            stmt.setString(4, recette.getInstructions());
            stmt.setInt(5, recette.getUtilisateurId());
            stmt.setInt(6, recette.getCategorieId());
            stmt.setDate(7, new java.sql.Date(recette.getDatePublication().getTime()));
            stmt.executeUpdate();
        }
    }

    // Méthode pour récupérer toutes les recettes
    public List<Recette> getAllRecettes() throws SQLException {
        String sql = "SELECT * FROM Recette";
        List<Recette> recettes = new ArrayList<>();
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                recettes.add(new Recette(
                        rs.getInt("id"),
                        rs.getString("titre"),
                        rs.getString("description"),
                        rs.getString("ingredients"),
                        rs.getString("instructions"),
                        rs.getInt("utilisateur_id"),
                        rs.getInt("categorie_id"),
                        rs.getDate("date_publication")
                ));
            }
        }
        return recettes;
    }

    // Autres méthodes (modifier, supprimer, rechercher par catégorie, etc.)
}
