<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="contactModalLabel">Contacter Jean Forteroche</h2>
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
                    <div class="form-group">
                        <input disabled  maxlength="3" size="3" value="1000" id="counter">
                        <label for="counter" class="col-form-label"><em>caractères restants</em></label>
                        <input type="submit" class="btn btn-primary" value="Envoyer"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
