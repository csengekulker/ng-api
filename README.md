# Zöldpont Masszázs Stúdió - API kiszolgáló

Ez a Laravel program hivatott adattal kiszolgálni a [Zöldpont Masszázs Stúdió](https://github.com/csengekulker/zoldng) weboldalát. 

## CRUD műveletek

Minden, adminisztratív hatáskörbe eső művelet elvégezhető. A jelen verzióban az ezekhez szükséges felhasználói felületek nincsenek kialakítva.

## Levelező kliens 

Az API a [Gmail SMTP](https://developers.google.com/gmail/imap/imap-smtp) használatával bonyolítja le az e-mail küldést, valamint a későbbiekben a fogadást is.

## Tesztek

A projektkönyvtárban a **tests/Insomnia** alkönyvtárban végpontok tesztelésére alkalmas *.json*  kiterjesztésű állományok szerepelnek. Ezeket importálni lehet [Insomnia](https://insomnia.rest/) programban. 

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
