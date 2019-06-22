<div class="signInConfirmation"> 
    <p>Votre mot de pass à bien été mis à jour!</p>
    <p>Veuillez vous reconnecter avec votre identifiant et votre nouveau mot de passe.</p>
</div>

<script type="text/javascript" >
    let delayConfirmationMsg = setTimeout(hideThanks, 1500);
    function hideThanks(){
    $(".signInConfirmation").fadeOut();
    }
</script>
