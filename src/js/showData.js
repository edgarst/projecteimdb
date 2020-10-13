document.getElementById('search-btn').addEventListener('click', showMovies);

function showMovies()
{
    var title = document.getElementById('search-input').value;
    var url = 'http://imdbcutre.test/informacio.php?search='+title;

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
    var row = createRow();
    for (const film of json) {
        var col = createCol();
        var img = createImg(film['caratula']);
        var divText = createDivTitle();
        var text = createTitle(film['titol']);
        var link = createTitleLink(film['titol']);
        appendFilm(link, text, divText, col, img, row);
    }
}

function createRow()
{
    var row = document.createElement('div');
    row.setAttribute('class', 'row');
    return row
}

function createCol()
{
    var col = document.createElement('div');
    col.setAttribute('class', 'col');
    return col;
}

function createImg(linkImg) 
{
    var img = document.createElement('img');
    img.setAttribute('alt', 'error');
    img.setAttribute('src', linkImg);
    return img;
}

function createDivTitle()
{
    var divText = document.createElement('div');
    divText.setAttribute('class', 'text-img');
    return divText;
}

function createTitle(title)
{
    var text = document.createElement('h4');
    text.innerHTML = title;
    return text;
}

function createTitleLink(title)
{
    var link = document.createElement('a');
    link.setAttribute('href', 'http://imdbcutre.test/informacio.php?name='+title);
    return link;
}

function appendFilm(link, text, divText, col, img, row) {
    link.appendChild(text);
    divText.appendChild(link);
    col.appendChild(img);
    col.appendChild(divText);
    row.appendChild(col);
    document.body.appendChild(row);
}

function resetDivs()
{
    var divs = document.getElementsByClassName('row');
    for (var i = 0; i < divs.length; i++) {
        document.body.removeChild(divs[i]);
    }
}
