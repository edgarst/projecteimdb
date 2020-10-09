function showMovies()
{
    var title = document.getElementById('search-input').value;
    var url = 'http://imdbcutre.test/informacio.php?title='+title;
    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ viewFilms(json); });
}

function viewFilms(json)
{ 
   resetDivs();
   setFilmText(json);
}

function setFilmText(json)
{
    var text;
    var i = 1;
    for (const value of json) {
        console.log(value);
        text = getFilmData(value);
        document.getElementById('film'+i).style.display = 'block';
        document.getElementById('title'+i).innerHTML = value['titol'];
        document.getElementById("img"+i).src = value['caratula'];
        i++;
    }
}

function getFilmData(json)
{
    var text = '';
    for (const key in json) {
        if(key != 'titol' && key != 'caratula') text += key+': '+json[key]+', '; 
    }
    return text;
}

function resetDivs()
{
    var divs = document.getElementsByClassName('col');
    for (var i = 0; i < divs.length; i++) {
        divs[i].innerHTML = '';
    }
}