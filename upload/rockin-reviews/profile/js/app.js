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