    // On load page
var numDirectors; // Saves directors number
window.onload = function()
{
    var platforms = 'http://imdbcutre.test/information.php?platforms';
    fetch(platforms).then(function(response){ return response.json(); })
    .then(function(json){ setPlatforms(json); });

    var genres = 'http://imdbcutre.test/information.php?genres';
    fetch(genres).then(function(response){ return response.json(); })
    .then(function(genre){ setGenres(genre); });
    
    createEvents();
}

function createEvents()
{
    document.getElementById('submit').addEventListener('click', getFormData);
}

    // Generate inputs (genre, platform, director)
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
    genre.name = 'genres'
    genre.value = genre.id = genreName;
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

    // Get form data
function getFormData()
{
    var form = document.getElementById('form');
    var formData = new FormData();
    formData = addData(formData, form);
    sendData(formData);
}

function addData(formData, form)
{
    formData = addInputs(formData, form);
    formData = addTextArea(formData, form);
    formData = addGenres(formData);
    formData = addPlatform(formData);
    formData = getFormImage(formData);

    return formData;
}

function addGenres(formData)
{
    var genresCheck = document.querySelectorAll('input[type="checkbox"]:checked');
    var genres = getInputArrays(genresCheck);
    formData.append('genres', genres);

    return formData;
}

function getInputArrays(inputs)
{
    var values = [];
    for (let index = 0; index < inputs.length; index++) {
        values.push(inputs[index].value);
    }
    return values;
}

function getFormImage(formData)
{
    var file = document.querySelector('[type=file]').files[0];
    formData.append('file', file);
    
    return formData;
}

    // Add input data (title, file, release_date...)
function addInputs(formData, form)
{
    var formInputs = getInputs(form);
    for (let index = 0; index < formInputs.length; index++) {
        formData.append(formInputs[index].name, formInputs[index].value);
    }
    
    return formData;
}

    // Get inputs (title, release_date, rating)
function getInputs(form)
{
    var formInputs = form.querySelectorAll('input');
    var inputs = [], inputType;

    for (let i = 0; i < formInputs.length; i++) {
        inputType = formInputs[i].type;
        if (filterInputs(inputType)) {
            inputs.push(formInputs[i]);
        }
    }

    return inputs;
}

    // Filter inputs (title, release_date, rating)
function filterInputs(inputType)
{
    if (inputType === 'text' || inputType === 'date' || inputType === 'number') {
        return true;
    }
    return false;
}

    // Add textArea data (Actors, sinopsis, directors)
function addTextArea(formData, form)
{
    var textArea = form.querySelectorAll('textarea');
    var index = 0;
    while (index<textArea.length) {
        if(textArea[index].value !== ""){
            formData.append(textArea[index].name, textArea[index].value);
        } 
        index++;
    }

    return formData;
}

    // Add platform data
function addPlatform(formData)
{
    var platform = document.getElementById('platform').value;
    formData.append('platform', platform);
    return formData;
}

function sendData(formData)
{
    fetch('http://imdbcutre.test/information.php?insertForm', {
        method: 'POST',
        body: formData,
    }).then(function(response){ return response.json() })
    .then(function(error){ showPopUp(error) });
}

function showPopUp(error)
{
    console.log(error);
    var show;
    if(!isError(error)){
        document.getElementById('submit').removeEventListener('click', getFormData);
        show = error['info'];
    } else {
        show = error['error'];
    }

    alert(show);
}

function isError(error)
{
    if(('error' in error)) return true;
    return false;
}