function disableUser(user) {
    if (confirm("Voulez-vous vraiment activer/désactiver cet utilisateur ?")) {
        $.ajax({
            url: Routing.generate('bo_user_enabled', {'user': user}), // La ressource ciblée
            type: 'GET', // Le type de la requête HTTP.
            success: function (code_html, statut) { // success est toujours en place, bien sûr !
                var enableButton = $('#enabledUser');
                if (enableButton.html() === 'Activer') {
                    enableButton.html('Désactiver');
                } else {
                    enableButton.html('Activer')
                }
            },
            error: function (resultat, statut, erreur) {
                alert('Impossible de désactiver cette utilisateur')
            }
        });
    }
}

function depersonalizeUser(user) {
    if (confirm("Voulez-vous vraiment dépersonnaliser cet utilisateur ?")) {
        $.ajax({
            url: Routing.generate('bo_user_depersonalize', {'user': user}), // La ressource ciblée
            type: 'GET', // Le type de la requête HTTP.
            success: function (code_html, statut) { // success est toujours en place, bien sûr !
                location.reload();
            },
            error: function (resultat, statut, erreur) {
                console.log(erreur);
            }
        });
    }
}
$().ready(function() {
    $("#delete-guidebook").click(function () {
        if (confirm("Voulez-vous vraiment supprimer ce guide ?")) {
            $.ajax({
                url: Routing.generate('bo_guide_book_delete', {'guideBook': $(this).data("id")}), // La ressource ciblée
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
                url: Routing.generate('bo_guide_book_enabled', {'guideBook': $(this).data("id")}), // La ressource ciblée
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
});
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