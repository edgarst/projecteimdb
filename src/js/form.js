window.onload = function()
{
    var platforms = 'http://imdbcutre.test/information.php?platforms';
    fetch(platforms).then(function(response){ return response.json(); })
    .then(function(json){ setPlatforms(json); });

    var genres = 'http://imdbcutre.test/information.php?genres';
    fetch(genres).then(function(response){ return response.json(); })
    .then(function(genre){ setGenres(genre); });
    
    document.getElementById('director1').addEventListener('change', checkRadioInput);
    document.getElementById('director2').addEventListener('change', checkRadioInput);
}

function setPlatforms(json)
{
    for (const platform of json) {
        var option = createPlatformOption(platform['nom']);
        appendTo(option, 'platform');
    }
}

function setGenres(json) 
{
    for (const genres of json) {
        var genre = createGenreCheck(genres['genere']);
        var label = createLabel(genres['genere']);
        appendTo(genre, 'genres');
        appendTo(label, 'genres');
    }
}

function createGenreCheck(genreName) 
{
    var genre = document.createElement('input');
    genre.type = 'checkbox';
    genre.value = genre.id = genre.name = genreName;
    return genre;
}

function createLabel(name)
{
    var label = document.createElement('label');
    label.innerHTML = name;
    label.className = 'genre-label';
    label.setAttribute('for', name);
    return label;
}

function createPlatformOption(platformName)
{
    var option = document.createElement('option');
    option.className = 'platform-options'
    option.value = platformName;
    option.innerHTML = platformName;
    return option;
}

function appendTo(option, parent)
{
    var select = document.getElementById(parent);
    select.appendChild(option);
}

function checkRadioInput()
{
    var selected = document.querySelector('input[name="director"]:checked').value;
    deleteClass('directors');
    createDirectorInputs(selected);
}

function createDirectorInputs(num)
{
    var placeAppend = document.getElementById('directors');
    for (let index = 0; index < num; index++) {
        var input = newDirectorInput(index);
        placeAppend.appendChild(input);
    }
}

function newDirectorInput(index)
{
    var input = document.createElement('input');
    input.className = 'movie-data directors';
    input.type = 'text';
    input.placeholder = input.name = 'Director '+ ++index;
    return input;
}