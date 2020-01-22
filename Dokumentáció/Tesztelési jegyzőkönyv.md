# FEJLESZTÉSI TESZTELÉSI JEGYZŐKÖNYV

## Komponens, integrációs és rendszerteszt


A tesztelést végzők:
* Géczi Katalin
* Ragó Ádám
* Varga Balázs



## TESZTELÉSI ELVÁRÁSOK
Funkcionális
- API funkciók működése
- JavaScript funkciók
- együttes működés
- Index.html, mainPage.html különféle böngészőkben való megjelenítése

Nem-funkcionális
- a desing megfeleljen a megbízó követelményeinek




## API TESZTELÉS


Az API hívásokat a Postman tesztelőprogram segítségével teszteltük.
A tesztelés során kölün figyelmet kellett arra fordítanunk, hogy a tesztelt oldal 
megfelelő adatokkal lássa el az API-t.

## Tesztelt funkciók:
User tábla
- regisztráció (insertUser)
- bejelentkezés (login)
- kijelentkezés (logout)
- be van e jelentkezve (isLogged)
- kilistázás (getUserList)

Categories tábla
- hozzáadás (insertCategory)
- törlés (delete)
- kilistázás (getCategoryList)

Transactions
- hozzáadás (insertTransaction)
- törlés (delTransaction)
- frissítés (updateTransaction)
- kilistázás (getPersonTranList)


A teszt a várt adatokat szolgáltatta.



## JAVASCRIPT FUNKCIÓK

A tesztelés célja, a megfelelő API által fogadott adatok ellenőrzése.

- új felhasználó (newUser)
- bejelentkezés (login)
- kijelentkezés (logout)

- listázás (getTransList, getCategoryList)
- törlés (deleteTransaction, deletCategory)
- új elemek hozzáadása (newTransaction, newCategory)
- módosítás (updateTransaction)

A teszt a megfelelő adatokat szolgáltatta.



## MEGJELENÍTÉS

Tesztelésre került, hogy az oldal betöltése, és az oldalon található összes részlet 
elhelyezkedése a különböző böngészőkben egységes képet mutasson.


## DESIGN

A weboldalak stílusa a megrendelő elvárásainak eleget téve vidám színeket használ, a sötét kék
és rózsaszín elemek egységesen kiegészítik egymást.




A teszt sikeresen zárult, minden funkció megfelelően működik.



Eger, 2020.01.10.