var redirect_uri = 'http://192.168.0.20/spotify/index.php';

var client_id = "";

var client_secret = "";

const AUTHORIZE = "https://accounts.spotify.com/authorize";
const TOKEN = "https://accounts.spotify.com/api/token";
const SEARCH = "https://api.spotify.com/v1/search";

function onPageLoad() {

    client_id = localStorage.getItem("client_id");
    client_secret = localStorage.getItem("client_secret");

    if (window.location.search.length > 0) {
        handleRedirect();
    }
    else {
        access_token = localStorage.getItem("access_token");
        if (access_token == null) {
            //we don't have a access token to present token section
            document.getElementById("tokenSection").style.display = 'block';
        } else {
            //we have an access token so present device section
            document.getElementById("deviceSection").style.display = "block";
        }
    }

}

function handleRedirect() {
    let code = getCode();
    fetchAccessToken(code);
    window.history.pushState("", "", redirect_uri);// remove param from url
}

function fetchAccessToken(code) {

    let body = "grant_type=authorization_code";
    body += "&code=" + code;
    body += "&redirect_uri=" + encodeURI(redirect_uri);
    body += "&client_id=" + client_id;
    body += "&client_secret=" + client_secret;
    callAuthorizationApi(body);

}

function callAuthorizationApi(body) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", TOKEN, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('Authorization', 'Basic ' + btoa(client_id + ":" + client_secret));
    xhr.send(body);
    xhr.onload = handleAuthorizationResponse;
}


function refreshAccessToken() {
    refresh_token = localStorage.getItem("refresh_token");
    let body = "grant_type=refresh_token";
    body += "&refresh_token=" + refresh_token;
    body += "&client_id=" + client_id;
    callAuthorizationApi(body);
}


function handleAuthorizationResponse() {
    if (this.status == 200) {
        var data = JSON.parse(this.responseText);
        console.log(data);
        var data = JSON.parse(this.responseText);
        if (data.access_token != undefined) {
            access_token = data.access_token;
            localStorage.setItem("access_token", access_token);
        }
        if (data.refresh_token != undefined) {
            refresh_token = data.refresh_token;
            localStorage.setItem("refresh_token", refresh_token);
        }
        onPageLoad();
    }
    else {
        console.log(this.responseText);
        //alert(this.responseText);
    }
}


function getCode() {
    let code = null;
    const queryString = window.location.search;
    if (queryString.length > 0) {
        const urlParams = new URLSearchParams(queryString);
        code = urlParams.get('code');
    }
    return code;
}

function requestAuthorization() {
    client_id = document.getElementById("clientId").value;
    client_secret = document.getElementById("clientSecret").value;
    localStorage.setItem("client_id", client_id);
    localStorage.setItem("client_secret", client_secret);

    let url = AUTHORIZE
    url += "?client_id=" + client_id;
    url += "&response_type=code";
    url += "&redirect_uri=" + encodeURI(redirect_uri);
    url += "&show_dialog=true";
    url += "&scope=ugc-image-upload user-read-playback-state user-modify-playback-state user-read-private user-follow-modify user-follow-read user-library-modify user-library-read streaming user-read-playback-position playlist-modify-private playlist-read-collaborative app-remote-control user-read-email playlist-read-private user-top-read playlist-modify-public user-read-currently-playing user-read-recently-played";
    window.location.href = url;

}

function handleSearchResponse() {
    if (this.status == 200) {
        var data = JSON.parse(this.responseText);
        console.log(data);
        getAlbumImg(data);
    } else if (this.status == 401) {
        refreshAccessToken();
    } else {
        console.log(this.responseText);
        alert(this.responseText);
    }
}


function callApi(method, url, body, callback) {
    let xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('Authorization', 'Bearer ' + access_token);
    xhr.send(body);
    xhr.onload = callback;
}

function searchAlbum(albumName, artistName) {




    albumName = searchClean(albumName);
    artistName = searchClean(artistName);




    //"?q=name:abc&type=album&include_external=audio"
    // console.log(albumName + " " + artistName);

    query = "?q=" + albumName + "+artist:" + artistName + "&type=album";



    callApi("GET", SEARCH + query, null, handleSearchResponse);






}

function searchClean(name) {

    name = name.toLowerCase();
    name = name.trim();
    name = name.replaceAll(' ', '%20');
    return name;

}

function getAlbumImg(data) {

    let albumImg = data.albums.items[0].images[0].url;


    count = 1;

    search = data.albums.href;


    search = search.substring(40);

    comp = search.split("+artist");


    album = comp[0];
    album = album.replaceAll("%27", "");
    album = album.replaceAll("+", "-");

    update = document.querySelector("." + album);

    //update.innerHtml = albumImg;


    var tag = document.createElement("p"); // <p></p>
    var text = document.createTextNode(albumImg);
    tag.appendChild(text); // <p>TEST TEXT</p>

    update.appendChild(tag);

    console.log(update);

    console.log(albumImg);
}








function updateDisplayResultsId(count) {

    let print = document.querySelector('.display-results');



}