import javax.swing.*;
import java.awt.*;
import java.awt.event.*;

public class RecetteGUI {
    private JFrame frame;
    private JPanel panel;
    private JButton btnPublier, btnRechercher;
    private JTextField txtRecherche;

    public RecetteGUI() {
        frame = new JFrame("Application de Recettes");
        panel = new JPanel();
        panel.setLayout(new FlowLayout());

        // Champ de recherche
        txtRecherche = new JTextField(20);
        panel.add(txtRecherche);

        // Boutons
