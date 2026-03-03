/**
 * Système d'onglets réutilisable
 * Utilisation : ajoutez la classe 'tabs' au conteneur et 'tab-button' aux boutons
 */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Désactiver tous les onglets et contenus
            document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
            
            // Activer l'onglet cliqué
            this.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        });
    });
});
