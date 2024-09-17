<!DOCTYPE html>
<html>
<head>
    <title>Inscription Patiente</title>
</head>
<body>
    <p>Bonjour {{ $user->prenom }} {{ $user->nom }},</p>
    <p>Votre compte a été créé avec succès.</p>
    <p>Voici vos informations de connexion :</p>
    <p>Email : {{ $user->email }}</p>
    <p>Mot de passe : {{ $password }}</p>
    <p>Vous pouvez vous connecter et commencer à utiliser notre application.</p>
    <p>Cordialement,</p>
    <p>L'équipe de support</p>
</body>
</html>
