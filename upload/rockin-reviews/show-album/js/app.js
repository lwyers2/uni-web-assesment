

function displayStars(score, userOrCom, isUserAdd) {



    //if -1 then nee to populate all to allow user to add score changes score to 0 to make 5 blank stars 

    if (score == -1) {
        score = 0;
    }


    //assign value to score
    let stars = score;

    //check if number is whole

    if (stars % 1 != 0) {
        //half star needed
        halfStar = true;
        //round down number for creation of stars
        stars = Math.floor(score);
    } else {
        //half star not
        halfStar = false;
    }

    //Shouldnt be more than 5. Will need to add validation
    if (stars == 5) {
        halfStar = false;
    }

    let ratingType = "";

    // if I have time make tenery

    if (userOrCom == 'com') {
        divClass = 'rating-community';
        ratingType = "Community Rating: ";
    } else if (userOrCom == 'user') {
        ratingType = "User Rating: ";
        divClass = 'rating-user';
    }


    let div = document.querySelector("." + divClass);
    console.log(div);



    if (userOrCom == 'com') {
        div.innerHTML = ratingType + getStars(stars, halfStar, isUserAdd) + "   AVG:(" + score + " / 5)" + "</div>";

    } else if (userOrCom == 'user') {
        //add closing div below so I can display avg above
        div.innerHTML = ratingType + getStars(stars, halfStar, isUserAdd) + "</div>";
    } else if (score == -1) {

    }


    //if not signed in score =-2;
    if (score == -2) {
        div.innerHTML = '';
    }




}

function getStars(fullStars, halfStar, isUserAdd) {


    let remainder = 5

    if (halfStar) {

        remainder = remainder - (fullStars + 1);

    } else {
        // remainder to make empty star
        remainder = remainder - fullStars;

    }


    html = '';



    for (let i = 0; i < fullStars; i++) {
        html += '<i class="fa-solid fa-star"></i>';
    }

    if (halfStar) {
        remainder - 1;
        html += '<i class="fa-solid fa-star-half-stroke"></i>';
    }

    if (isUserAdd) {

        for (let i = 0; i < remainder; i++) {
            html += '<i class="fa-regular fa-star" id="score-' + (i + 1) + '" onclick="addScore(' + (i + 1) + ')"></i>';
        }
    } else {
        for (let i = 0; i < remainder; i++) {
            html += '<i class="fa-regular fa-star"></i>';
        }
    }

    //Not needed anymore
    // //close off div as innerHTML replaces all
    // html += '</div';

    return html;

}



function addScore(score) {


    input = document.querySelector("#input_score");
    input.value = (score);
    star = document.querySelector('#score-' + score);

    for (let i = score; i > 0; i--) {
        let eachStar = document.querySelector('#score-' + i);
        eachStar.className = "fa-solid fa-star";
        console.log(eachStar);
    }

    //resests bar after chosing lower number
    for (let i = score + 1; i < 6; i++) {
        let eachStar = document.querySelector('#score-' + i);
        eachStar.className = "fa-regular fa-star";
        console.log(eachStar);
    }
}

function toggleFavourite(isFavourite) {



    let favourite = document.querySelector('.favourite');
    let inputFavourite = document.querySelector('#favourite_id');





    //if isFavourite =true/false album destroy old ione and create new one
    if (!isFavourite) {

        favourite.innerHTML = "Add to Favourites: <i class='fa-regular fa-heart' onclick=toggleFavourite(true)></i>";

        inputFavourite.setAttribute("value", 0);

    } else {
        favourite.innerHTML = "Favourited: <i class='fa-solid fa-heart' onclick=toggleFavourite(false)></i>";
        inputFavourite.setAttribute("value", 1);

    }


}



function toggleOwned(isOwned) {


    let owned = document.querySelector('.owned');
    let inputOwned = document.querySelector('#owned_id');



    //if isOwned =true/false album destroy old ione and create new one
    if (!isOwned) {
        owned.innerHTML = "Add to Owned: <i class='fa-regular fa-dollar-sign' onclick=toggleOwned(true) style='color:grey'></i>";
        inputOwned.setAttribute("value", 0);
    } else {
        owned.innerHTML = "Owned: <i class='fa-solid fa-dollar-sign' onclick=toggleOwned(false) style='color:green'></i>";
        inputOwned.setAttribute("value", 1);
    }


}

function addReviewBox() {

    let addReview = document.querySelector('.add-review');
    let showHideButton = document.querySelector('#but-add-review');
    console.log(showHideButton);
    if (addReview.style.display == "none") {
        addReview.style.display = "block";
        showHideButton.innerHTML = "Dicard User Review";
    } else {
        addReview.style.display = "none";
        showHideButton.innerHTML = "Add User Review";

    }



}