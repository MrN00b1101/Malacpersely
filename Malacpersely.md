Malacpersely specifikáció
Alap ötlet: Családi költségvetés követése.
Jelenlegi helyzet: 
Egy családban nehézkes követni a pénzügyi kiadások és bevételek sokaságát, ezt szeretnénk egyszerűsíteni egy webalkalmazás segítségével.
Vágyálom rendszer:
	Minden felhasználó rendelkezik saját és családi kasszával ahol nyomon tudja követni a család pénzügyi helyzetét, láthatja, hogy hol tud csökkenteni a kiadásokon, hogy elérje a céljait.
Minden felhasználó megfogalmazhat célokat, amiket el szeretne érni, a rendszer pedig előre kiszámolja, hogy az eddigi megtakarítási szokásai alapján mennyi idő alatt érheti el, és követi a spórolás folyamatát.
Rendszeres bevételeket, és kiadásokat lehet meghatározni, amik beállított időközönként levonódnak vagy hozzá adódnak a kasszához.
Blokk és számla fényképe alapján egyszerűsített adatfelvitel.
Hónap végi kimutatások és látványos grafikonok, amiken a laikus felhasználó is egyszerűen láthatja, hogy éppen hol folyik el a pénze, vagy, hogy milyen távol áll még álmai megvalósításától.
A látvány legyen egyszerű, intuitív, látványos, és legyen a gyermekek számára is egyszerűen értelmezhető felület, hogy a kisebb korosztály is mielőbb beletanulhasson a pénzügyek világába.
Személyre szabható kiadás és bevétel kategóriák.
Pénzügyi történetét figyelembe véve személyre szabott pénzügyi tanácsadás lehetősége ahol akár képzett pénzügyi tanácsadóval köti össze a rendszer a személyt.

Modulok:
Regisztrációs és bejelentkeztető felület
1. Jogosultsági szintek felhasználók szerint 
1-es szintű jogosultsággal rendelkező felhasználó meg tudja a költségvetést tekinteni, költséget/bevételt hozzáadni, törölni, módosítani
2-es szintű jogosultsággal rendelkező felhasználó meg tudja a költségvetést tekinteni.
2. Jelszó megváltoztatása, és elfelejtett jelszó esetén jelszó emlékeztető, és e-mail címre átmeneti jelszó küldése.

Bejelentkezés után a bevétel és költségek havi nézete. Itt lehet bevételt, költséget hozzáadni, és alapértelmezetten a felhasználó havi nézete jelenik meg. A havi nézetről tud váltani napi, heti, és éves összesítőre, továbbá az egyéni költségről lehet váltani a családi költség mutatására számokkal és diagramokkal illusztrálva. Az éppen aktuálisan megjelenő nézetet Excel fájlba ki lehet exportálni.
Megtakarítás kalkulátor, ahol meg lehet határozni egy elérni kívánt célt, és az oldal kikalkulálja az összeg, és a havi rászánt megtakarított összeg alapján, hogy mikorra lehet összegyűjteni a hozzá szükséges pénzt, és az oldal havi szinten nyomon követi a megtakarítás sikerességét.
Családtag hozzáadása, eltávolítása menüpont.
web applikáció (platform függetlenség miatt)
mysql
rest api
google authentikáció
bootstrap

Balázs: BackEnd (adatbázis felépítés és azzal a kommunikáció kiépítése)
Kata: Látványterv (weblap, mobil, hogynéz ki, akár logo terv)
Ádám: Bootstrap, javascript, fronted logikai része

Adatbázisterv:
User:
	Id (Primary key)
	Nev
	Mail
	Jelszó
Költség:
	Id (Foreign key)
	Kiadás kategória
	Összeg
	Dátum	
Bevétel:
	Id (Foreign key)
	Bevétel kategória
	Összeg
	Dátum	

Látványterv:
	![főoldal](https://github.com/MrN00b1101/Malacpersely/blob/master/home.png)
	![belépés gomb](https://github.com/MrN00b1101/Malacpersely/blob/master/homeLogBtn.png)
	![belépés](https://github.com/MrN00b1101/Malacpersely/blob/master/login.png)
	![belépve](https://github.com/MrN00b1101/Malacpersely/blob/master/loggedIn.png)

