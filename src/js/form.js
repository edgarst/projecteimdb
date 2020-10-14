window.onload = function()
{
    var url = 'http://imdbcutre.test/information.php?platforms';
    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ setPlatforms(json); });
    
    document.getElementById('director1').addEventListener('change', checkRadioInput);
    document.getElementById('director2').addEventListener('change', checkRadioInput);
}

function setPlatforms(json)
{
    for (const platform of json) {
        var option = createPlatformOption(platform['nom']);
        appendOption(option);
    }
}

function createPlatformOption(platformName)
{
    var option = document.createElement('option');
    option.value = platformName;
    option.innerHTML = platformName;
    return option;
}

function appendOption(option)
{
    var select = document.getElementById('platform');
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
    var placeAppend = document.getElementById('info-btn');
    for (let index = 0; index < num; index++) {
        var input = newDirectorInput(index);
        placeAppend.parentNode.insertBefore(input, placeAppend);
    }
}

function newDirectorInput(index)
{
    var input = document.createElement('input');
    input.className = 'movie-data directors';
    input.type = 'text';
    input.placeholder = 'Director '+ ++index;
    return input;
}