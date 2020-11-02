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
    document.querySelectorAll('.link-movie').forEach(item=>{item.addEventListener('click', showInfo)})
}

function showMovies()
{
    var title = document.getElementById('search-input').value;
    var url = 'http://imdbcutre.test/information.php?search='+title;

    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ viewFilms(json); });
}

function showInfo()
{
    
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

function applyFilter()
{
    var formData = {};
    formData = addPlatform(formData);
    formData = addCheckbox(formData, 'genres');
    formData = addCheckbox(formData, 'releases');

    sendData(JSON.stringify(formData));
}

function addPlatform(formData)
{
    var platform = document.querySelector('input[name="platforms"]:checked');
    if(platform !== null) formData['platform'] = platform.value;

    return formData;
}

function addCheckbox(formData, name)
{
    var values = document.querySelectorAll('input[name="'+name+'"]:checked');
    var arrValues = [];

    for (let index = 0; index < values.length; index++) {
        arrValues.push(values[index].value);
    }

    formData[name] = arrValues;

    return formData;
}

function sendData(formData)
{
    var request = new XMLHttpRequest();
    request.onload = function() {
        response = JSON.parse(request.responseText);
        viewFilms(response);
    };

    request.open('get', 'http://imdbcutre.test/information.php?filter='+formData);
    request.send();
}