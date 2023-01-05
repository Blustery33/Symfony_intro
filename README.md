# Symfony_intro
Exercice symfony 2itech

Cloner le repo

Copier/coller votre env. en env.local
changer la ligne "DATABASE_URL=mysql://Utilisateur:MotDePasse@127.0.0.1:3306/NomDeVotreBDD" avec vos infos

Dans le terminal faite un "composer install" et "yarn install"

Faite un "yarn encore dev" cela vous permettra de compilé le css pour qu'il s'affiche

Créer la database "php bin/console d:d:c" ( d:d:c = doctrine:database:create)

migration "php bin/console make:migration"
          "php bin/console doctrine:migrations:migrate"

N'ayant pas encore créer la page pour créer un utilisateur aller dans SecurityController, dans la function Login et décommenter toute les lignes
changer ensuite ces valeurs -> $user->setEmail('william@gmail.com');
                               $plaintextPassword = 'william';
Pour créer votre compte. 
! ATTENTION ! N'oubliez pas de re commenter les lignes pour pas que ça créer un utilisateur en boucle quand vous aller sur la page de Login 

Vous pouvez ensuite vous connectez, créer des sujets et des messages, vos messages apparaitrons dans votre profile
