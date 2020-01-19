JEGYZŐKÖNYV
===========


Konferencia beszélgetés
-----------------------

Dátum: 2019.10.03.



RÉSZTVEVŐK:
-----------

Géczi Katalin
Ragó Ádám
Varga Balázs

(Teljes létszám jelen.)


TÉMA:
-----

A projekt témája, megvalósításának folyamata, használni kívánt eszközök és részfeladatok.


HASZNÁLNI KÍVÁNT TECHNOLÓGIÁK:
------------------------------

* Web applikáció
* MySQL
* RestAPI
* Google autentication
* Bootstrap



FELOSZTOTT RÉSZFELADATOK:
-------------------------

**Géczi Katalin**
* Látványterv
* Dokumentáció
* Konzultáció a Bootstrap-es végső kinézet kialakításában

**Ragó Ádám**
* Frontend logaikai része
* Bootsrap
* JavaScript

**Varga Balázs**
* BackEnd
* Adatbázis felépítése
* Adatbázissal való kommunikáció kiépítése



KEZDETLEGES ADATBÁZISTERV:
-------------------------

**User:**
* Id (Primary key)
* Nev
* Mail Jelszó

**Outgoings:**
* Id (Foreign key)
* Kiadás kategória
* Összeg
* Dátum

**Incomes:**
* Id (Foreign key)
* Bevétel kategória
* Összeg
* Dátum

**Categorys:**
* Id (Primary key)
* Nev

**Family:**
* Id (Primary key)
* Nev

**Family_members:**
* UserId (Foregin key)
* CsaladId (Forgein key)



REGISZTRÁCIÓS ÉS BEJELENTKEZTETŐ FELÜLET:
-----------------------------------------

1.Jogosultsági szintek felhasználók szerint.
1-es szintű jogosultsággal rendelkező felhasználó meg tudja a költségvetést tekinteni, 
költséget/bevételt hozzáadni, törölni, módosítani
2-es szintű jogosultsággal rendelkező felhasználó meg tudja a költségvetést tekinteni.

2.Jelszó megváltoztatása, és elfelejtett jelszó esetén jelszó emlékeztető, és e-mail 
címre átmeneti jelszó küldése. Bejelentkezés után a bevétel és költségek havi nézete. 
Itt lehet bevételt, költséget hozzáadni, és alapértelmezetten a felhasználó havi nézete 
jelenik meg. A havi nézetről tud váltani napi, heti, és éves összesítőre, továbbá az 
egyéni költségről lehet váltani a családi költség mutatására számokkal és diagramokkal 
illusztrálva. Az éppen aktuálisan megjelenő nézetet Excel fájlba ki lehet exportálni. 
Megtakarítás kalkulátor, ahol meg lehet határozni egy elérni kívánt célt, és az oldal 
kikalkulálja az összeg, és a havi rászánt megtakarított összeg alapján, hogy mikorra 
lehet összegyűjteni a hozzá szükséges pénzt, és az oldal havi szinten nyomon követi a 
megtakarítás sikerességét. Családtag hozzáadása, eltávolítása menüpont.




JEGYZŐKÖNYV II.


Konferencia beszélgetés

Dátum: 2019.11.01.


RÉSZTVEVŐK:

Géczi Katalin
Ragó Ádám
Varga Balázs

(Teljes létszám jelen.)


TÉMA:
-----

Modulok megbeszélése, azok miből állnak, hogyan kapcsolódnak a felületen.


MODULOK:
--------

*Regisztráció
*Login
*Tranzakciók felvitele
*Kategória felvitele
*Család menedzselése
*Állandó tranzakciók beállítása
*Költségvetés tételes megjelenítése
*Grafikus megjelenítés (grafikonok)
*Csoportos megjelenés
*Megtakarítási célok kezelése




