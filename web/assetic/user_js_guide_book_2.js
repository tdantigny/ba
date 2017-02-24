$("#delete-guidebook").click(function () {
    if (confirm("Voulez-vous vraiment supprimer ce guide ?")) {
        $.ajax({
            url: Routing.generate('bo_guide_book_delete', {'guideBook': guideBook}), // La ressource ciblée
            type: 'GET', // Le type de la requête HTTP.
            success: function (code_html, statut) { // success est toujours en place, bien sûr !
                window.location.replace(Routing.generate('bo_guide_book_list'));
            },
            error: function (resultat, statut, erreur) {
                alert('Impossible de supprimer ce guide')
            }
        });
    }
});

$("#desactivate-guidebook").click(function () {
    if (confirm("Voulez-vous vraiment activer/désactiver ce guide ?")) {
        $.ajax({
            url: Routing.generate('bo_guide_book_enabled', {'guideBook': guideBook}), // La ressource ciblée
            type: 'GET', // Le type de la requête HTTP.
            success: function (code_html, statut) { // success est toujours en place, bien sûr !
                var enableButton = $('#desactivate-guidebook');
                if (enableButton.html() === 'Activer') {
                    enableButton.html('Désactiver');
                } else {
                    enableButton.html('Activer')
                }
            },
            error: function (resultat, statut, erreur) {
                alert('Impossible de désactiver ce guide')
            }
        });
    }
});