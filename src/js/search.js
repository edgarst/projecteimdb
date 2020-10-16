function showMovies()
{
    var title = document.getElementById('search-input').value;
    var url = 'http://imdbcutre.test/information.php?search='+title;

    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ viewFilms(json); });
}

function viewFilms(json)
{ 
   deleteClass('row');
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
    row.className = 'row';
    return row
}

function createCol()
{
    var col = document.createElement('div');
    col.className = 'col';
    return col;
}

function createImg(linkImg) 
{
    var img = document.createElement('img');
    img.src = linkImg;
    img.alt = 'error';
    return img;
}

function createDivTitle()
{
    var divText = document.createElement('div');
    divText.className = 'text-img';
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
    link.href = 'http://imdbcutre.test/information.php?title='+title;
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

function deleteClass(nameClass)
{
    classDelete = '.'+nameClass;
    document.querySelectorAll(classDelete).forEach(function(deleted){
        deleted.remove();
    });
}