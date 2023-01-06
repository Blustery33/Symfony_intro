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

Vous pouvez ensuite créer votre compte et vous connectez, créer des sujets et des messages, vos messages créés  apparaitrons dans votre profile
