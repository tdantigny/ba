$().ready(function() {
    $("#registration-newsletter").click(function () {
        $.ajax({
            url: Routing.generate('fo_newsletter_register'), // La ressource ciblée
            type: 'GET', // Le type de la requête HTTP.
            success: function (code_html, statut) { // success est toujours en place, bien sûr !
                document.location.href=Routing.generate('fo_newsletter', {'fromAjax': 1});
            },
            error: function (resultat, statut, erreur) {
                console.log('Impossible de vous inscrire à la newsletter');
            }
        });
    });
});