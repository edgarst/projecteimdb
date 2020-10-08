function showMovies()
{
    var title = document.getElementById("search-input").value;
    // JSON.parse('test.json');
    fetch('http://imdbcutre.test/informacio.php?title='+title)
    .then(response => response.json())
    .then(response => console.log(response))
}