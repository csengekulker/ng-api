## Beüzemelési lépések (demo)

1. Git tároló klónozása

```console
git clone https://github.com/csengekulker/ng-api.git
```

2. Függőségek telepítése

```console
npm install && composer install
```

3. Környezet beállítása

```console
cp .env.example .env
```

4. Módosítsa a *.env* állományt a következőképpen:

```code
DB_DATABASE=zold
```

5. Alkalmazáskulcs generálása

```console
php artisan key:generate
```

6. Adatbázis táblák létrehozása

```console
php artisan migrate
```

7. Adatbázis feltöltése tesztadatokkal

```console
php artisan db:seed
```

8. Fejlesztői szerver indítása

```console
php artisan serve
```
