// Close success messages modal box after 1.5s

let delayConfirmationMsg = setTimeout(hideThanks, 1500);
function hideThanks(){
$(".successModal").fadeOut();
}