# Translating 

We use the [translations manager](https://github.com/barryvdh/laravel-translation-manager) package 
to manage translations for this project. 

### Log in to the internationalization dashboad

//TODO - needs to be set up.

### Setup 

Make sure you're up to date with migrations, then import translations to the database:
```bash
php artisan migrate
php artisan translations:import
php artisan translations:find
```

### Translating & export

Head over to {appplication url}/translations and log in with an admin account.
Once you're done translating, update the files to include your work:
```bash
php artisan translations:export
git add resources/lang
git commit
git push origin i18n
```


