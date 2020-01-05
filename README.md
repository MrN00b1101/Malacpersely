Malacpersely specifikáció
=========================
## Alap ötlet:  
Családi költségvetés követése.
## Jelenlegi helyzet:  
Egy családban nehézkes követni a pénzügyi kiadások és bevételek sokaságát, ezt szeretnénk egyszerűsíteni egy webalkalmazás segítségével.
## Vágyálom rendszer:  
Minden felhasználó rendelkezik saját és családi kasszával ahol nyomon tudja követni a család pénzügyi helyzetét, láthatja, hogy hol tud csökkenteni a kiadásokon, hogy elérje a céljait.  
Minden felhasználó megfogalmazhat célokat, amiket el szeretne érni, a rendszer pedig előre kiszámolja, hogy az eddigi megtakarítási szokásai alapján mennyi idő alatt érheti el, és követi a spórolás folyamatát.  
Rendszeres bevételeket, és kiadásokat lehet meghatározni, amik beállított időközönként levonódnak vagy hozzá adódnak a kasszához.
Blokk és számla fényképe alapján egyszerűsített adatfelvitel.  
Hónap végi kimutatások és látványos grafikonok, amiken a laikus felhasználó is egyszerűen láthatja, hogy éppen hol folyik el a pénze, vagy, hogy milyen távol áll még álmai megvalósításától.  
A látvány legyen egyszerű, intuitív, látványos, és legyen a gyermekek számára is egyszerűen értelmezhető felület, hogy a kisebb korosztály is mielőbb beletanulhasson a pénzügyek világába.  
Személyre szabható kiadás és bevétel kategóriák.  
Pénzügyi történetét figyelembe véve személyre szabott pénzügyi tanácsadás lehetősége ahol akár képzett pénzügyi tanácsadóval köti össze a rendszer a személyt.  

## Modulok:
**Regisztrációs és bejelentkeztető felület:**  
1. Jogosultsági szintek felhasználók szerint  
	1-es szintű jogosultsággal rendelkező felhasználó meg tudja a költségvetést tekinteni, költséget/bevételt hozzáadni, törölni, módosítani  
	2-es szintű jogosultsággal rendelkező felhasználó meg tudja a költségvetést tekinteni.
2. Jelszó megváltoztatása, és elfelejtett jelszó esetén jelszó emlékeztető, és e-mail címre átmeneti jelszó küldése.  
Bejelentkezés után a bevétel és költségek havi nézete. Itt lehet bevételt, költséget hozzáadni, és alapértelmezetten a felhasználó havi nézete jelenik meg. A havi nézetről tud váltani napi, heti, és éves összesítőre, továbbá az egyéni költségről lehet váltani a családi költség mutatására számokkal és diagramokkal illusztrálva. Az éppen aktuálisan megjelenő nézetet Excel fájlba ki lehet exportálni.
Megtakarítás kalkulátor, ahol meg lehet határozni egy elérni kívánt célt, és az oldal kikalkulálja az összeg, és a havi rászánt megtakarított összeg alapján, hogy mikorra lehet összegyűjteni a hozzá szükséges pénzt, és az oldal havi szinten nyomon követi a megtakarítás sikerességét.
Családtag hozzáadása, eltávolítása menüpont.

## Használni tervezett technológiák:
* web applikáció (platform függetlenség miatt)
* mysql
* rest api
* google authentikáció
* bootstrap

## Feladatok:
* Balázs: BackEnd (adatbázis felépítés és azzal a kommunikáció kiépítése)
* Kata: Látványterv (weblap, mobil, hogynéz ki, akár logo terv)
* Ádám: Bootstrap, javascript, fronted logikai része

## Adatbázisterv:
**User:**

A felhasználók adatainak tárolására használjuk.

|Mezőnév:|Típus:|Megkötés:|Kulcs-e:|Leírás:|
|:-------|:-----|:--------|:-------|:------|
|Id|Number|Not Null|Elsődleges Kulcs|A felhasználó egyedi azonosítója|
|Name|Varchar2(30)|Not Null||A felhasználó neve|
|Mail|Varcghar2(50)|Not Null||A felhasználó e-mail címe|
|Password|Varchar2(32)|Not Null||A felhasználó jelszavának a hash-e|
|FamilyId|Number|Not Null|Idegen kulcs (Family tábla Id mezőjéhez kapcsolva)|A felhasználó családjának azonosítója|

**Transactions:**  

A pénzügyi tranzakciókat tároljuk ebben a táblában.

|Mezőnév:|Típus:|Megkötés:|Kulcs-e:|Leírás:|
|:-------|:-----|:--------|:-------|:------|
|UserId|Number|Not Null|Idegen kulcs (User tábla Id mezőjéhez kapcsolva)|A tranzakciót végrehajtó felhasználó azonosítója|
|TranCatId|Number|Not Null|Idegen kulcs (Categorys tábla Id mezőjéhez kapcsolva)|A tranzakció típusa|
|Value|Number|Not Null||A tranzakció összege, ha minusz akkor kiadás ha plussz akkor bevétel|
|Personal|Number|Not Null||Ha az értéke -1 akkor a kiadás személyes, ha 0 akkor a kiadás családi ha ezektől eltérő akkor annak a megtakarításnak az azonosítója amihez tartozik|
|Date|TimeStamp|Not Null||A tranzakció ideje|

**Categorys:**  

A tranzakciók kategóriáit tároljuk itt.

|Mezőnév:|Típus:|Megkötés:|Kulcs-e:|Leírás:|
|:-------|:-----|:--------|:-------|:------|
|Id|Number|Not Null|Elsődleges kulcs|A kategória egyedi azonosítója|
|Name|Varchar2(10)|Not Null||A kategória megnevezése|

**Family:**  

A családokat tároljuk ebben a táblában.

|Mezőnév:|Típus:|Megkötés:|Kulcs-e:|Leírás:|
|:-------|:-----|:--------|:-------|:------|
|Id|Number|Not Null|Elsődleges kulcs|A család egyedi azonosítója|
|Name|Varchar2(10)|Not Null||A család megnevezése|
|FatherId|Id|Not Null|Idegen kulcs a User tábla Id mezőjéhez kötve|A családfő azonosítója (ő hozza létre a családod, és ő tud tagokat hozzá adni!)|

**Savings:**  

A Megtakarításokat tároljuk ebben a táblában.

|Mezőnév:|Típus:|Megkötés:|Kulcs-e:|Leírás:|
|:-------|:-----|:--------|:-------|:------|
|Id|Number|Not Null|Elsődleges kulcs|A megtakarítás egyedi azonosítója|
|Name|Varchar2(30)|Not Null||A megtakarítás megnevezése|
|Destination|Number|||A megtakarítás célösszegét tároljuk a mezőben|
|DesDat|Date| | |A megtakarítás határidejét tároljuk|
|CreatorId|Id|Not Null|Idegen kulcs a User tábla Id mezőjéhez kötve|A készítő azonosítója|
|Personal|Bit|Not Null||Ha az értéke 1 akkor a megtakarítás személyes, ha 0 akkor a kiadás családi|


## Api használat:
    Az api a következő hívásokra van felkészítve (ha egy parméternél engedélyezett a 'null' abban az esetben egy 'null'-t stringként várja)
**Modulok:**

    Get requestel elérhető funkciók

*Tranzakciók listája:
    Szükséges adatok:

|Kulcs:|Érték példa:|Leírás:|
|:-----|:-----------|:------|
|com|'tran'|Ez határozza meg milyen adatot kérünk|
|user|12|userID|
|cat|'null'|kategóriaID (lehet 'null')|
|minVal|-100|minimum érték (lehet 'null')|
|maxVal|0|maximum érték (lehet 'null')|
|minDat|'null'|kezdő dátum (lehet 'null')|
|maxDat|'2019-12-30'|vég dátum (lehet 'null')|
|personal|0|Ha az értéke -1 akkor a kiadás személyes, ha 0 akkor a kiadás családi ha ezektől eltérő akkor annak a megtakarításnak az azonosítója amihez tartozik|
|token|cookieből olvasott token|A login során kapott token (a teszt.html-ben bemutatott módszerrel olvasható ki)|

    Visszakapott adatok:
|Kulcs:|Érték pléda:|Leírás|
|:-----|:-----------|:------|
|UserId|9|A tranzakciók készítőjének azonosítója|


    Kategóriák listája:
    Felhasználók listája:
    Családok listája:
    Családtagok listája:
    User adatai:
    Kijelentkezés

    Regisztráció:
    Kategória felvitele:
    Tranzakció felvitele:
    Család felvitele:
    Megtakarítás készítése:
    Bejelentkezés:

    Felhasználó adatainak módosítása:
    Kategória adatainak módosítása:
    Tranzakció adatainak módosítása:
    Családtag családhoz való adása:

    Tranzakció törlése:
    Bármi más törlése:
    

    Regisztráció: Post request 
    
    szükséges adatok: 
    {
    "com":"user",
    "name":"felhasználó neve",
    "mail":"email cím",
    "password":"jelszó hash"
    }
    
    Kategória felvitele: Post request, 
    
    szükséges adatok:    
    {    
    "com":"cat",
    "name":"kategória név",
    "creaId":létrehozó felhasználó azonosítója,  
    "global":láthatóság (0-global,1-personal,2-család)   
    }
    
    Tranzakció felvitele: Post request, 
    
    szükséges adatok:    
    {    
    "com": "tran",
    "uId":felhasználó azonosító,
    "catId":kategória azonosító,  
    "value":érték,
    "personal": 0/1 személyes vagy családi'  
    }
    
    Család felvitele: Post request, 
    
    szükséges adatok:    
    {    
    "com":"family",
    "name":"család név",
    "fId":Családfő azonosítója   
    }

    User, Család, Kategória törlése: DELETE request,
    
    szükséges adatok:
    {
    "table": "tábla neve ahonnan törölni akarunk",
    "Id":a rekord azonosítója amit törölni akarunk
    }
## Látványterv:

![főoldal](https://github.com/MrN00b1101/Malacpersely/blob/master/home.png)
![belépés gomb](https://github.com/MrN00b1101/Malacpersely/blob/master/homeLogBtn.png)
![belépés](https://github.com/MrN00b1101/Malacpersely/blob/master/login.png)
![belépve](https://github.com/MrN00b1101/Malacpersely/blob/master/loggedIn.png)

