$('.search-home').height($(document).width() / (1920 / 900));

function loginRequire() {
    window.location="login.php";
}

// JS for Personal
var btnContainer = document.getElementById("nav-personal");
var btns = btnContainer.getElementsByClassName("nav-btn");
var btnCart = document.getElementById("btn-cart");
var cart = document.getElementById("cart");
var historyP = document.getElementById("history");
for (var i = 0; i < btns.length; i++) {
    btns[i].addEventListener("click", function() {
        var current = document.getElementsByClassName("active");
        current[0].className = current[0].className.replace(" active", "");
        this.className += " active";
        if (this === btnCart) {
            cart.className = cart.className.replace(" hide", "");
            historyP.className += " hide";
        } else {
            historyP.className = historyP.className.replace(" hide", "");
            cart.className += " hide";
        }
    });
}