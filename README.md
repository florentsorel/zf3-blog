# ZF3 Blog

## Installation

```bash
$ git clone git@github.com:rtransat/zf3-blog.git
$ cd zf3-blog
$ cp config/.env.dist config/.env
$ composer install && yarn && yarn run build
```

## Variable d'environnement (.env)
- Configurer l'accès à la base de données
- La valeur de `POST_PER_PAGE` doit être un entier *(10 par défaut)*

## Enable development mode
```bash
$ composer development-enable
```

## Disable development mode
```bash
$ composer development-disable
```

## Migration
```bash
$ composer migration:migration
$ composer seed:run
```