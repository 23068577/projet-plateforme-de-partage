import java.sql.*;

public class UtilisateurDAO {
    private Connection conn;

    public UtilisateurDAO() throws SQLException {
        this.conn = DriverManager.getConnection("jdbc:mysql://localhost:3306/recette_app", "root", "password");
    }

    // Méthode pour ajouter un utilisateur
    public void ajouterUtilisateur(Utilisateur utilisateur) throws SQLException {
        String sql = "INSERT INTO Utilisateur (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, utilisateur.getNom());
            stmt.setString(2, utilisateur.getEmail());
            stmt.setString(3, utilisateur.getMotDePasse());
            stmt.setString(4, utilisateur.getRole());
            stmt.executeUpdate();
        }
    }

    // Méthode pour récupérer un utilisateur par email
    public Utilisateur getUtilisateurByEmail(String email) throws SQLException {
        String sql = "SELECT * FROM Utilisateur WHERE email = ?";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setString(1, email);
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                return new Utilisateur(
                        rs.getInt("id"),
                        rs.getString("nom"),
                        rs.getString("email"),
                        rs.getString("mot_de_passe"),
                        rs.getString("role")
                );
            }
        }
        return null;
    }

    // Autres méthodes (modifier, supprimer) peuvent être ajoutées ici
}
