window.onload = function()
{
    var url = 'http://imdbcutre.test/information.php?home';
    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ viewFilms(json); });
    
    document.getElementById('search-btn').addEventListener('click', showMovies);
}

function showMovies()
{
    var title = document.getElementById('search-input').value;
    var url = 'http://imdbcutre.test/information.php?search='+title;

    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ viewFilms(json); });
}