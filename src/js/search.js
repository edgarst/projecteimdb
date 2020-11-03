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
        var text = createTitle(film['id'], film['titol']);
        appendFilm(text, divText, col, img, row);
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

function createTitle(id, title)
{
    var text = document.createElement('h4');
    text.innerHTML = title;
    text.id = id;
    return text;
}

function appendFilm(text, divText, col, img, row) {
    divText.appendChild(text);
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