window.onload = function()
{
    var url = 'http://imdbcutre.test/information.php?home';
    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ viewFilms(json); });
    
    createFilter();
    addEvents();
}

function addEvents()
{
    document.getElementById('apply-filter').addEventListener('click', applyFilter);
    document.getElementById('search-btn').addEventListener('click', showMovies);
}

function showMovies()
{
    var title = document.getElementById('search-input').value;
    var url = 'http://imdbcutre.test/information.php?search='+title;

    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ viewFilms(json); });
}


// Filter
function createFilter()
{
    getPlatforms();
    getGenres();
    getReleases();
}

function getPlatforms()
{
    var url = 'http://imdbcutre.test/information.php?platforms';
    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ viewPlatforms(json); });
}

function getGenres()
{
    var genres = 'http://imdbcutre.test/information.php?genres';
    fetch(genres).then(function(response){ return response.json(); })
    .then(function(genre){ viewGenres(genre); });
}

function getReleases()
{
    var release = 'http://imdbcutre.test/information.php?release';
    fetch(release).then(function(response){ return response.json(); })
    .then(function(releases){ viewReleases(releases) });
}

function viewPlatforms(json)
{
    var label, input;
    for (const platform of json) {
        input = createInput('radio', platform['nom'], platform['nom'], 'platforms');
        label = createLabel(platform['nom']);
        appendTo(input, 'platform');
        appendTo(label, 'platform');
    }
}

function viewGenres(json) 
{
    for (const genres of json) {
        var genre = createInput('checkbox', genres['genere'], genres['genere'], 'genres');
        var label = createLabel(genres['genere']);
        appendTo(genre, 'genres');
        appendTo(label, 'genres');
    }
}

function viewReleases(json)
{
    for (const releases of json) {
        var release = createInput('checkbox', releases['publicacio'], releases['publicacio'], 'releases');
        var label = createLabel(releases['publicacio']);
        appendTo(release, 'release');
        appendTo(label, 'release');
    }
}

function createInput(type, value, text, name)
{
    var input = document.createElement('input');
    input.type = type;
    input.name = name;
    input.value = value;
    input.innerHTML = text;
    return input;
}

function createLabel(name)
{
    var label = document.createElement('label');
    label.innerHTML = name;
    label.setAttribute('for', name);
    return label;
}

function appendTo(input, parentId)
{
    var div = document.getElementById(parentId);
    div.appendChild(input);
}

function createFormData(formInputs)
{
    var formData = new FormData();
    for (let index = 0; index < formInputs.length; index++) {
        formData.append(formInputs[index].name, formInputs[index].value);
    }
    return formData;
}

function applyFilter()
{
    var formData = createFormData(formInputs);
}

function sendData(formData)
{
    fetch('http://imdbcutre.test/information.php?filter', {
        method: 'GET',
        body: formData,
    }).then(function(response){ return response.json() })
    .then(function(message){ showPopUp(message) });
}

