<?php include(__DIR__ . DIRECTORY_SEPARATOR . 'header.php'); ?>
<h1>Contact</h1>
<form action="#" method="post">
    <div>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required minlength="2" maxlength="255">
    </div>
    <div>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" minlength="2" maxlength="255">
    </div>
    <div>
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="message">Message :</label>
        <textarea id="message" name="message" required minlength="10" maxlength="3000"></textarea>
    </div>
    <button type="submit">Envoyer</button>
</form>

<?php include(__DIR__ . DIRECTORY_SEPARATOR . 'footer.php'); ?>
