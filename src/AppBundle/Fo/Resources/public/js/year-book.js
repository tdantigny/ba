$().ready(function() {
    $('.voteYearBook').click(function () {
        $.ajax({
            url: Routing.generate('fo_year_book_vote'), // La ressource ciblée
            type: 'POST', // Le type de la requête HTTP.
            data: { yearBookId: $(this).data('yearbook'), rate: $(this).data('id') },
            success: function (code_html, statut) { // success est toujours en place, bien sûr !
                var data = JSON.parse(code_html);
                for(var i = $(this).data('id'); i > 0; i--) {
                    var voteYear = $('*[data-id="'+i+'"]');
                    voteYear.removeClass('glyphicon glyphicon-star-empty');
                    voteYear.addClass('glyphicon glyphicon-star');
                }
                $('#rate-data-'+data.yearBookId).data('rate', data.rate);
                $('#calculate-rate-'+data.yearBookId).html(data.calculatedRate);
            },
            error: function (resultat, statut, erreur) {
                alert('Impossible to rate this year book')
            }
        });
    });

    $('.go-year-book').click(function () {
        $.ajax({
            url: Routing.generate('fo_year_book_go'), // La ressource ciblée
            type: 'POST', // Le type de la requête HTTP.
            data: { yearBookId: $(this).data('id') },
            success: function (code_html, statut) {
                var data = JSON.parse(code_html);// success est toujours en place, bien sûr !
                $('#number-click-'+data.yearBookId).html(data.numberOfClick);
            },
            error: function (resultat, statut, erreur) {
                console.log('Impossible to incremente the number of click for this year book')
            }
        });
    });
});

function overStar(yearBookId, number)
{
    for(var i = 5; i > 0; i--) {
        var voteYear = $('.star-'+yearBookId+'-'+i);
        voteYear.removeClass('glyphicon glyphicon-star');
        voteYear.addClass('glyphicon glyphicon-star-empty');
    }

    for(var i = number; i > 0; i--) {
        var voteYear = $('.star-'+yearBookId+'-'+i);
        voteYear.removeClass('glyphicon glyphicon-star-empty');
        voteYear.addClass('glyphicon glyphicon-star');
    }
}

function outStar(yearBookId, number)
{
    for(var i = 5; i > 0; i--) {
        var voteYear = $('.star-'+yearBookId+'-'+i);
        voteYear.removeClass('glyphicon glyphicon-star');
        voteYear.addClass('glyphicon glyphicon-star-empty');
    }

    for(var i = number; i > 0; i--) {
        var voteYear = $('.star-'+yearBookId+'-'+i);
        voteYear.removeClass('glyphicon glyphicon-star');
        voteYear.addClass('glyphicon glyphicon-star-empty');
    }

    var rate = $('#rate-data-'+yearBookId).data('rate');
    if (rate) {
        for(var i = rate; i > 0; i--) {
            var voteYear = $('.star-'+yearBookId+'-'+i);
            voteYear.removeClass('glyphicon glyphicon-star-empty');
            voteYear.addClass('glyphicon glyphicon-star');
        }
    }
}