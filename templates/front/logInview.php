
<div class="modal fade" id="logInModal" tabindex="-1" role="dialog" aria-labelledby="logInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="logInModalLabel">Connexion</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="logInForm" action="index.php?action=logInCheck" method="post">
                    <div class="form-group">
                        <label for="usernameLog" class="col-form-label">Pseudo*</label>
                        <input type="text" class="form-control" id="usernameLog" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="passLog" class="col-form-label">Password*</label>
                        <input type="password" class="form-control" id="passLog" name="pass" required>
                    </div>
                    <div class="form-group">
                        <label for="autoLogIn" class="col-form-label">Connexion automatique</label>
                        <input type="checkbox" id="autoLogIn" name="autoLogIn">
                    </div>
                    <input type="submit" class="btn btn-primary" name="login" value="Connexion"/>
                </form>
            </div>
        </div>
    </div>
</div>
