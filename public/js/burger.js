// Burger menu
$("#burgerMenu").on("click", () => { 
    $("#burgerNav").toggle();
    $(".bar1, .bar2, .bar3").toggleClass("change");
});