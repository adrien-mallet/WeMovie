
let buttonlist = document.querySelectorAll('.movie-item .movie-link');

buttonlist.forEach(function (link) {
    link.addEventListener('click', function (e) {
        e.stopImmediatePropagation();
        e.preventDefault();
        let target = e.currentTarget || e.target;
        let video = target.parentElement.querySelector('.movie-video');
        toogleVideo(video);
    })
})

let lastCallable;
function toogleVideo(video)
{
    let overlay = document.getElementById('overlay');
    if ('none' === overlay.style.display || '' === overlay.style.display) {
        overlay.style.display = 'block';
        video.style.display = 'block';
        overlay.addEventListener('click', lastCallable = function (e) {
            toogleVideo(video)
        })
    } else {
        overlay.removeEventListener('click', lastCallable);
        overlay.style.display = 'none';
        video.style.display = 'none';
        let src = video.getElementsByTagName('iframe')[0].src
        video.getElementsByTagName('iframe')[0].src = src;
    }
}

let inputSearch = document.getElementById('search_text');
inputSearch.addEventListener('keyup', function (e) {
    if (inputSearch.value.length >= 3) {
        var oReq = new XMLHttpRequest();
        oReq.addEventListener("load", function (e) {
            if (oReq.status === 200) {
                let autocomplete = document.getElementById('autocomplete-result');
                autocomplete.innerHTML = '';
                let ul = document.createElement('ul');
                let movies = JSON.parse(oReq.responseText);
                movies.forEach(function (movie) {
                    let li = document.createElement('li');
                    let a = document.createElement('a');
                    a.href = movie_route.replace('0', movie.id);
                    a.appendChild(document.createTextNode(movie.title));
                    li.appendChild(a);
                    ul.appendChild(li);
                });
                autocomplete.appendChild(ul);
                autocomplete.style.display = 'block';
            }
        });
        oReq.open("GET", search_route+'?search='+inputSearch.value);
        oReq.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
        oReq.send();
    }
})