window.onload = function()
{
    var url = 'http://imdbcutre.test/information.php?platforms';
    fetch(url).then(function(response){ return response.json(); })
    .then(function(json){ setPlatforms(json); });
}

function setPlatforms(json)
{
    console.log(json);
    for (const platform of json) {
        console.log(platform);
        var option = createPlatformOption(platform['nom']);
        appendOption(option);
    }
}

function createPlatformOption(platformName)
{
    var option = document.createElement('option');
    option.setAttribute('value', platformName);
    option.innerHTML = platformName;
    return option;
}

function appendOption(option)
{
    var select = document.getElementById('platform');
    select.appendChild(option);
}

document.getElementById('director1').addEventListener('onchange', checkRadioInput);
document.getElementById('director2').addEventListener('onchange', checkRadioInput);
function checkRadioInput()
{
    var selected = document.querySelector('input[name="director"]:checked').value;
    selected=1 ? createDirectorInputs(1) : createDirectorInputs(2);
}

function createDirectorInputs(num)
{
    var placeAppend = document.getElementById('rating');
    for (let index = 0; index < num; index++) {
        var input = document.createElement('input');
        input.setAttribute('class', 'movie-data');
        input.setAttribute('type', 'text');
        placeAppend.parentNode.insertBefore(input, placeAppend);
    }
}