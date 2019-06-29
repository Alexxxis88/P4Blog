<div class="modal fade" id="singInModal" tabindex="-1" role="dialog" aria-labelledby="singInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="singInModalLabel">Inscription</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="singInForm" action="index.php?action=addNewMember" method="post">
                    <div class="form-group">
                        <label for="usernameSign" class="col-form-label"><em>Le pseudo doit faire 4 caractères minimum (20 maximum) et peut contenir des lettres et des chiffres</em><br><br>Pseudo*</label>
                        <input type="text" class="form-control" id="usernameSign" name="username" required>
                    </div><br><br>
                    <div class="form-group">
                        <label for="passSign" class="col-form-label"><em>Le password doit faire 8 caractères minimum (20 maximum) et peut contenir des lettres, chiffres et caractères spéciaux authorisés ( . - _ ! ?)</em><br><br>Password*</label>
                        <input type="password" class="form-control" id="passSign" name="pass" required>
                    </div><br>
                    <div class="form-group">
                        <label for="passCheck" class="col-form-label">Vérification du password*</label>
                        <input type="password" class="form-control" id="passCheck" name="passCheck" placeholder="Tapez votre Password à nouveau" required>
                    </div><br>
                    <div class="form-group">
                        <label for="email" class="col-form-label">Adresse Email*</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div><br>
                    <div class="g-recaptcha" data-sitekey="6Lck9KoUAAAAAMCUwtdhDPbJPiAQTEzi8mIFOpI9" data-callback="enableBtn"></div><br>
                    <input type="submit" class="btn btn-primary" id="signInBtn" value="S'inscrire"/>
                </form>
            </div>
        </div>
    </div>
</div>
