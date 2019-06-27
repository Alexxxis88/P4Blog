<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Formulaire de contact</title>
	</head>
	<body>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Contacter Jean Forteroche</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="contactForm" action="index.php?action=sendMessage" method="post">
                            <div class="form-group">
                                <label for="firstName" class="col-form-label">Votre prénom*</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" maxlength="20" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName" class="col-form-label">Votre nom*</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" maxlength="20" required>
                            </div>
                            <div class="form-group">
                                <label for="contactEmail" class="col-form-label">Votre adresse email*</label>
                                <input type="text" class="form-control" id="contactEmail" name="contactEmail" required>
                            </div>
                            <div class="form-group">
                                <label for="topic" class="col-form-label">Intitulé de votre message*</label>
                                <input type="text" class="form-control" id="topic" name="topic" maxlength="40" required>
                            </div>  

                            <div class="form-group">
                                <label for="messageContent" class="col-form-label">Votre message</label>
                                <textarea class="form-control" rows="10" id="messageContent" name="messageContent" maxlength="1000" required onkeyup="textCounter(this,'counter',1000);"></textarea>
                            </div>
                            <!-- Used to count how many characters there is left -->
                            <input disabled  maxlength="3" size="3" value="1000" id="counter">
                            <input type="submit" class="btn btn-primary" value="Envoyer"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>    

<!-- FIXME : étrange, ça fonctionne meme si je ne mets pas le code suivant -->
<!-- <script>
$('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var modal = $(this)
})</script> -->

<script>
function textCounter(field,field2,maxlimit)
{
let countfield = document.getElementById(field2);
if ( field.value.length > maxlimit ) {
field.value = field.value.substring( 0, maxlimit );
return false;
} else {
countfield.value = maxlimit - field.value.length;
}
}
</script>