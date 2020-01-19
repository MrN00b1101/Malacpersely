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

* Tranzakciók listája:

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
    |Savings|Kocsira|A megtakarítási zseb neve, ha a tranzakció nem tartozik kölön zsebhez akkor az érték "Personal" vagy "Family"|
    |User|Valaki|A tranzakciót felvivő felhasználó neve|
    |Category|Megtakarítás|A tranzakció kategóriájának neve|
    |UseId|9|A tranzakciót felvivő felhasználó azonosítója|
    |TranCatId|4|A tranzakció kategóriájának azonosítója|
    |Value|200|A tranzakció értéke|
    |Personal|3|Ha az értéke -1 akkor a kiadás személyes, ha 0 akkor a kiadás családi ha ezektől eltérő akkor annak a megtakarításnak az azonosítója amihez tartozik|
    |TranDate|"2019-12-30 11:05:28"|A tranzakció időpontja|

* Kategóriák listája:

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'cat'|Ez határozza meg milyen adatot kérünk|
    |user|12|userID|
    |fam|0|Ha az értéke 0 akkor a Globális kategóriákat listázza, ha 1 akkor a személyes kategóriákat ha pedig 2 akkor a létrehozó családjának kategóriáit|
    |token|cookieből olvasott token|A login során kapott token (a teszt.html-ben bemutatott módszerrel olvasható ki)|

    Visszakapott adatok:
    
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
    
    * Tranzakció adatainak módosítása:

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'tran'|Ez határozza meg milyen adatot szeretnénk módosítani|
    |Value|100|Amire módosítani szeretnénk a tranzakció értékét|
    |TranCatId|3|Annak a kategóriának az azonosítója amire módosítani szeretnénk|
    |Personal|0|Az érték amire a Personal mező értékét módosítani szeretnénk|
    |uid|9|Annak a felhasználónak az ID-je aki a módosítandó tranzakciót létrehozta|
    |Personal|0|Az érték amire a Personal mező értékét módosítani szeretnénk|
    |time|'2019-12-28 13:13:28'|A módosítandó tranzakció időbélyegzője|
    |token|cookieből olvasott token|A login során kapott token (a teszt.html-ben bemutatott módszerrel olvasható ki)|    
   
    
    
    Családtag családhoz való adása:

    * Tranzakció törlése:

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'tran'|Ez határozza meg milyen adatot szeretnénk törölni|
    |uid|9|Annak a felhasználónak az ID-je aki a módosítandó tranzakciót létrehozta|
    |time|'2019-12-28 13:13:28'|A módosítandó tranzakció időbélyegzője|
    |token|cookieből olvasott token|A login során kapott token (a teszt.html-ben bemutatott módszerrel olvasható ki)|
    
    
    
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

## Weboldal felépítés:
**index.html:**
* Felső navigációs bár

		Malacpersely - Főoldal - Információ - Kapcsolat - Belépés
		Malacpersely: A webalkalmazás megnevezése.
		Főoldal (gomb): Frissíti az éppen aktuális oldalt.
		Információ (gomb): A webalkalmazás tulajdonosának tevékenységéről, és magáról az alkalmazásról alapvető információkhoz 		       			  navigál.
		Kapcsolat (gomb): A webalkalmazás tulajdonosának elérhetőségéhez navigál.
		Belépés (gomb): Előhívja a bejelentkezési felületet (modalt).
* Content

		Háttérkép
		Rövid promóciós leírás az alkalmazásról.
		Regisztráció (gomb): Előhívja a regisztrációs felületet.
		Bővebb információ a weboldalról.
		A weboldal tulajdonosának elérhetősége.
* Modalok

		Bejelentkezési modal
		x - kilépés a modalból.
		Felhasználónév megadás.
		Jelszó megadás.
		Jelszó megjegyzése checkbox.
		Bejelentkezés gomb.
		Bejelentkezés facebook profillal lehetőség.
		Bejelentkezés google profillal lehetőség.
		Elfelejtett jelszó lehetőség.
		
		Regisztráció modal
		Felhasználónév megadás.
		Email-cím megadás.
		Szsületési dátum megadás.
		Jelszó megadás.
		Jelszó megerősítése.
		Regisztráció (gomb): Sikeres regisztráció esetén a bejelentkezési modal előhívása.
		Bejelentkezés (gomb): Bejelentkezés modal előhívása. (Ha már rendelkezik profillal a user)
		Regisztráció facebook profillal lehetőség.
		Regisztráció google profillal lehetőség.
	
**mainPage.html:**
* Felső navigációs bár

		Malacpersely - Pénzügyek - Beállítások - Profil - Statisztika
		Malacpersely: A webalkalmazás megnevezése, az oldal frissítése.
		Pénzügyek: A felhasználó pénzügyeinek összesítése, kimutatása.
		Beállítások: Felhasználói adatok módosítása.
		Profil: Felhasználó adatok megjelenítése.
		Statisztika: Statisztikai diagramok megjelenítése.
		
* Oldalsó navigációs bár

		Menü - Család - Kategóriák - Tranzakciók - Megtakarítások - Költségvetés
		Oldalsó menü ki-be gomb.
		Család: Családtagok listázása.
			Családtag hozzáadása gomb (Családtag hozzáadása modal).
			Családtag törlése gomb (Családtag törlése modal).
		Kategóriák: Kategóriák kilistázása.
			    Kategória hozzáadása (Kategória hozzáadása modal).
			    Kategória törlése (Kategória törlése modal).
		Tranzakciók: Hónapok kilistázása, amelyikről a tranzakciómegjelenítést kérjük.
		Megtakarítások: Megtakarítani kívánt célok kilistázása, és a cél eléréséhez szükséges követelmények elemzése.
		Költségvetés: Hónapok kilistázása, amelyikről a költségvetésmegjelenítést kérjük.
	
* Content

		Kártyák

		Családtagok - Kategóriák - Összesítés
		Családtagok: Családtagok kilistázása
		Kategóriák: Kategóriák kilistázása
		Összesítés: Előző havi záróegyenleg
			    Ehavi bevétel - kiadás különbsége
			    Jelenlegi egyenleg
			    
		Tranzakció hozzáadása gomb: Tranzakció hozzáadása modal előhívása.
		Tranzakció módosítása gomb: Tranzakció módosítás modal előhívása, a kijelölt tétel módosításának lehetősége.
		Tranzakció törlése gomb: Kijelölt tételek törlése.
		
		Bevételek:

		Sorszám - UserId - Kategória - Összeg - Dátum - Módosítás radiobuttonok - Törlés checkboxok
		Sorszám: Bevétel sorszáma.
		UserId: Felhasználó azonosítója.
		Kategória: Az adott bevétel milyen kategóriába tartozik.
		Összeg: Bevétel értéke.
		Dátum: Bevétel rögzítésének dátuma.
		Módosítás radiobutton: A kiválasztásával kijelölhető az adott bevétel.
		Törlés checkbox: Checkboxok kiválasztásával kijelölhetőek az adott bevételek.
		Bevételek összesítése.
		
		Kiadások:

		Sorszám - UserId - Kategória - Összeg - Dátum - Módosítás radiobuttonok - Törlés checkboxok
		Sorszám: Kiadás sorszáma.
		UserId: Felhasználó azonosítója.
		Kategória: Az adott Kiadás milyen kategóriába tartozik.
		Összeg: Kiadás értéke.
		Dátum: Kiadás rögzítésének dátuma.
		Módosítás radiobutton: A kiválasztásával kijelölhető az adottkiadás.
		Törlés checkbox: Checkboxok kiválasztásával kijelölhetőek az adott kiadások.
		Kiadások összesítése.
		
* Modalok

		Családtag hozzáadása
		x - Modal bezárása
		Felhasználónév - A családhoz hozzáadni kívánt felhasználónév.
		Hozzáadás gomb.
		
		Családtag törlése
		x - Modal bezárása
		Családtagok kilistázása select megoldásával.
		Családtag törlése gomb.
		
		Kategória hozzáadása modal
		x - Modal bezárása
		Kategória hozzáadása input mező.
		Hozzáadás gomb: Meghívásra kerül a newCategory() function.
		
		Kategória törlése modal
		x - Modal bezárása
		Kategóriák kilistázása select megoldásával.
		Kategória törlése gomb: Meghívásra kerül a deleteCategory() function.
		
		Tranzakció hozzáadása modal
		x - Modal bezárása
		Kategóriák kilistázása select megoldásával.
		Összeg input.
		Személyes kiadás checkbox bepipálása lehetőség.
		Tranzakció hozzáadása gomb: Meghívásra kerül a newTranzaction() function.
		
		Tranzakció módosítása modal
		x - Modal bezárása
		Kategóriák kilistázása select megoldásával.
		Összeg input.
		Személyes kiadás checkbox bepipálása lehetőség.
		Tranzakció hozzáadása gomb: Meghívásra kerül a updateTransaction() function.
		
## Javascript function leírások

**newUser()**

    Új felhasználó hozzáadása.

        'POST' request
		"com": "user",
   		"name": "inputUserName" mező értéke.
    	"mail": "inputEmailReg" mező értéke.
    	"pass": "inputPassword" mező értéke.

**loggin()**

    Felhasználó bejelentkezés.

        'POST' request
		"com": "login",
    	"Name": "inputNameLog" mező értéke.
    	"password": "inputPasswordLog" mező értéke.

**logout()**

    Kijelentkezés.

        'GET' request
        "com": "logout"

**getTranList()**

        'GET' request

        Paraméterek: 

        com : 'tran'
        user : Bejelentkezett userId
        cat : Az összes kategória
        minVal : Legkisebb tranzakcióérték
        maxVal : Legnagyobb tranzakcióérték
        minDat : Legkorábbi tranzakciódátum
        maxDat : Legkésőbbi tranzakciódátum
        personal : Személyes kiadás
        token : cookie

        Tranzakciók kilistázása értékük alapján. Ha a tranzakció értéke nagyobb, mint 0, akkor a bevétel oldalon jelenik meg, különben pedig a kiadás oldalon.

        Bevétel és kiadás összesen számítása.

        A tranzakció törléséhez használandó checkboxok, valamint a tranzakció módosításához való radio buttonok kilistázása a tranzakciók mellé. 

**getCategoryList()**

        'GET' request

        Paraméterek: 

        com : 'cat'
        user : Bejelentkezett userId
        token : cookie

        Kategóriák kilistázása a megfelelő mezőkbe.


**newTranzaction()**

    Tranzakció felvétele a modalban szereplő értékek alapján.

    'POST' request

    "com": tran
    "uId": userId
    "catId" : Kiválasztott kategória
    "value" : 'inputIncome' mezőben levő érték
    "personal" : Személyes kiadás?
    "token" : token

**newCategory()**

    Kategória felvétele a modalban szereplő értékek alapján.

    'POST' request

    "com": 'cat'
    "name" : 'inputCategory' mezőben levő érték
    "creaId" : creaId
    "global" : global
    "token" : token

**deleteTransaction()**

    A checkbox által kiválasztott tranzakciók törlése.

    'DELETE' request

    'delete' nevű checkboxok által kiválasztott tételek.
    "com" : 'tran'
    "uId" : userId
    "time" : a kiválasztott tranzakciók dátuma
    "token" : token

**updateTransaction()**

    A radiobutton által kiválasztott tranzakció módosítása a modal-ban szereplő értékek alapján.

    'PUT' request

    "com" : tran
    "Value" : 'updatee' nevű radiobutton által kiválasztott tétel
    "TranCatId" : Kategória kiválasztása
    "Personal" : Személyes kiadás?
    "uid" : userId
    "time" : a kiválasztott tranzakció dátuma
    "token" : token

**deleteCategory()**

    A modalban kiválasztott kategória törlése.

    'DELETE' request

    "com" : cat
    "table" : Categorys
    "Id" : A kiválasztott kategória ID-ja.
    "token" : token

## Látványterv:

![főoldal](https://github.com/MrN00b1101/Malacpersely/blob/master/home.png)
![belépés gomb](https://github.com/MrN00b1101/Malacpersely/blob/master/homeLogBtn.png)
![belépés](https://github.com/MrN00b1101/Malacpersely/blob/master/login.png)
![belépve](https://github.com/MrN00b1101/Malacpersely/blob/master/loggedIn.png)

