



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

function updateSpaces() {
    let searchValue = document.querySelector('#search-value');
    spaceReplace = searchValue.value;
    spaceReplace = spaceReplace.replaceAll(" ", "%");
    searchValue.value = spaceReplace;
}