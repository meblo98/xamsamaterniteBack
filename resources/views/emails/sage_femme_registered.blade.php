<!DOCTYPE html>
<html>
<head>
    <title>Sage-Femme Inscrite</title>
</head>
<body>
    <p>Bonjour {{ $user->prenom }} {{ $user->nom }},</p>
    <p>Vous avez été inscrite en tant que sage-femme. Voici vos informations :</p>
    <p>Email : {{ $user->email }}</p>
    <p>Téléphone : {{ $user->telephone }}</p>
    <p>Mot de passe : {{ $password }}</p>
    <p>Merci,</p>
    <p>L'équipe de l'application</p>
</body>
</html>
