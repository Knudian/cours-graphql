# Cours GRAPHQL

Il faut deux instances de terminal.

## Pour le back-end
```bash
cd book-api
vim .env # modifier les informations de connexion à la base de données.
php bin/console doctrine:migrations:migrate -n
php bin/console doctrine:fixtures:load -n 
php bin/console server:run
```

## Pour le front end
```bash
cd book-client
yarn install
ng serve -o
```

## Infos
* `http://localhost:8000/` : la page lève une erreur, ce qui est normal, car il n'y a pas de route associée.
* `http://localhost:8000/graphiql` : la page montrant l'intégralité des query/mutations GraphQL existantes.
* `http://localhost:4200/`: l'url du front-end