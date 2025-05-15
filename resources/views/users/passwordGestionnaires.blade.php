<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Accès à l'application </title>
</head>
<body>
    <h1>Bonjour {{ $gestionnaire->name }},</h1>
    <p> Votre compte pour le projet {{ $gestionnaire->nom_projet }} a été créé avec succès.</p>
    <p>Voici votre mot de passe : <strong>{{ $password }}</strong></p>
    <p>Nous vous recommandons de le changer dès que vous vous connecterez.</p>
    <p>Cordialement,</p>
    <p>L'équipe {{ config('Gestion Projet') }}</p>
</body>
</html>
