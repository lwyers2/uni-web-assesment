function editBox(editInfo) {

    let choice = document.querySelector('.edit-' + editInfo);


    let choiceDisplay = choice.style.display;

    if (choiceDisplay == 'none') {
        choice.style.display = 'block';
    } else if (choiceDisplay == 'block') {
        choice.style.display = 'none';
    }



}

function showHideChoice(choice) {

    //update button choice title
    let buttonChoice = document.querySelector("#" + choice + "-button");
    // get div of either favourite or owned
    let albumsShown = document.querySelector("#" + choice);
    if (albumsShown.style.display == 'none') {
        buttonChoice.innerHTML = "Hide " + choice;
        albumsShown.style.display = "block";
    } else if (albumsShown.style.display == 'block') {
        buttonChoice.innerHTML = "Show " + choice;
        albumsShown.style.display = "none";
    }

}






function showHideButton(buttonId) {
    let filterButton = document.querySelector("#" + buttonId + "-button");

    var x = document.getElementById(buttonId);
    console.log(x);
    if (x.style.display === "none") {
        x.style.display = "block";
        filterButton.innerHTML = "Hide " + buttonId;
    } else {
        x.style.display = "none";
        filterButton.innerHTML = "Show " + buttonId;
    }
}


function showHideAll() {



    let filterButton = document.getElementById("show-button");

    var x = document.getElementById("all-result");
    console.log(filterButton);
    if (x.style.display === "none") {
        x.style.display = "block";
        filterButton.innerHTML = "Hide All";
    } else {
        x.style.display = "none";
        filterButton.innerHTML = "Show All";
    }

}

function addGenreBox() {
    let genreInput = document.querySelector('.add-genre');
    genreInput.style.display = "block";
}

function updateSpaces() {
    let searchValue = document.querySelector('#search-value');
    spaceReplace = searchValue.value;
    spaceReplace = spaceReplace.replaceAll(" ", "%");
    searchValue.value = spaceReplace;
}