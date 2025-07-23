<section class="sectionAuthentification">

<form method="POST" action="controleurFrontal.php">
    <input type='hidden' name='action' value='connecter'>
    <input type='hidden' name='controleur' value='agent'>
    <div class="divConnexion">
       <h2> Authentification</h2>
             <div class="divLogin">
                <label for="login">
                    <input type="text" id="login" placeholder="Login" name="login" required>
                </label>
            </div>

        <div class="divMotDePasse">
            <label for="motDePasse">
                <input type="text" id="motDePasse" placeholder="Mot de passe" name="motDePasse" required>
            </label>
        </div>
        <input type="submit" value="Connecter" id="btnConnexion"/>
    </div>
</form>

</section>