$().ready(function() {
    $.ajax({
        url: Routing.generate('bo_horoscope_get'), // La ressource ciblée
        type: 'GET', // Le type de la requête HTTP.
        success: function (code_html, statut) { // success est toujours en place, bien sûr !
            //console.log(code_html);
        },
        error: function (resultat, statut, erreur) {
            console.log(resultat);
        }
    });
});