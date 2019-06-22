<div class="signInConfirmation"> 
    <p>Votre inscription est validée!</p>
    <p>Veuillez vous connecter avec votre identifiant et votre mot de passe.</p>
</div>

<script type="text/javascript" >
    let delayConfirmationMsg = setTimeout(hideThanks, 1500);
    function hideThanks(){
    $(".signInConfirmation").fadeOut();
    }
</script>
