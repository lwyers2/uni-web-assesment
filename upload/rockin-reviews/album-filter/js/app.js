let buttonChoice = document.querySelector('.filter-choice-buttons');
let filterButton = document.querySelector("#filter-button");
let alphabetButton = document.querySelector("#alphabet-button");
let filterTitle = document.querySelector('#choice');
let decadeButton = document.querySelector("#decade-button");



function showHideFilterButtons(filterButtonName) {
    console.log("clicked");

    var x = document.getElementById("filter-show");
    if (x.style.display === "none") {
        x.style.display = "flex";
        filterButton.innerHTML = "Hide " + filterButtonName;
    } else {
        x.style.display = "none";
        filterButton.innerHTML = "Show All " + filterButtonName;
    }
}


function showHideAlphabetButtons() {
    console.log("clicked");

    var x = document.getElementById("alphabet-show");
    if (x.style.display === "none") {
        x.style.display = "flex";
        alphabetButton.innerHTML = "Hide Alphabet";
    } else {
        x.style.display = "none";
        alphabetButton.innerHTML = "View All Letters";
    }
}


function showHideDecadeButtons() {
    console.log("clicked");

    var x = document.getElementById("decade-show");
    if (x.style.display === "none") {
        x.style.display = "flex";
        decadeButton.innerHTML = "Hide Decades";
    } else {
        x.style.display = "none";
        decadeButton.innerHTML = "Show All Decades";
    }
}



function showHideYearButtons() {
    console.log("clicked");

    var x = document.getElementById("year-show");
    if (x.style.display === "none") {
        x.style.display = "flex";
    } else {
        x.style.display = "none";
    }
}



function showAll() {
    let viewAllButton = document.querySelector("#view-all-button");
    var x = document.getElementById("hidden");
    if (x.style.display === "none") {
        x.style.display = "block";
        viewAllButton.innerHTML = "Hide";
    } else {
        x.style.display = "none";
        viewAllButton.innerHTML = "View All";
    }
}


