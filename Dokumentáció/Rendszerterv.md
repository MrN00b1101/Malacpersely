RENDSZERTERV
============

A projektet két nagyobb részre lehet elkülöníteni, amik az adatbázis és 
az internetes alkalmazás. 

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
|CreatorId|int|Not Null|Idegen kulcs (User tábla Id mezőjéhez kapcsolva)|A létrehozó felhasználó azonosítója|
|Global|int|Not Null||Ennek a mezőnek az értéke határozza meg, hogy az adott kategóriát kik láthatják, 0 esetén mindenki, 1 esetén csak a létrehozó, 2 esetén pedig csak a létrehozó csládja|

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


* Tranzakciók listája (Get request):

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
    |token|cookieből olvasott token|A login során kapott token |

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

* Kategóriák listája (Get request):

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'cat'|Ez határozza meg milyen adatot kérünk|
    |user|12|userID|
    |fam|0|Ha az értéke 0 akkor a Globális kategóriákat listázza, ha 1 akkor a személyes kategóriákat ha pedig 2 akkor a létrehozó családjának kategóriáit|
    |token|cookieből olvasott token|A login során kapott token |

   Visszakapott adatok:
    
    |Kulcs:|Érték pléda:|Leírás|
    |:-----|:-----------|:------|
    |User|Kocsira|A megtakarítási zseb neve, ha a tranzakció nem tartozik kölön zsebhez akkor az érték "Personal" vagy "Family"|
    |Id|Valaki|A tranzakciót felvivő felhasználó neve|
    |Name|Megtakarítás|A tranzakció kategóriájának neve|
    |CreatorId|9|A tranzakciót felvivő felhasználó azonosítója|
    |Global|4|A tranzakció kategóriájának azonosítója|
    
    
* Felhasználók listája:

    Szükséges adatok (Get request):

    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'user'|Ez határozza meg milyen adatot kérünk|
    |token|cookieből olvasott token|A login során kapott token |

   Visszakapott adatok:
    Az adatokat egy JSON tömben kapjuk vissza!

    |Kulcs:|Érték pléda:|Leírás|
    |:-----|:-----------|:------|
    |Id|9|Felhasználó azonsítója|
    |Name|'Valaki|A tranzakció kategóriájának neve|
    |Mail|'valaki@valami.hu'|A felhasználó mail címe|
    

* Családok listája:

    Szükséges adatok (Get request):
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'family'|Ez határozza meg milyen adatot kérünk|
    |token|cookieből olvasott token|A login során kapott token |

   Visszakapott adatok:
    Az adatokat egy JSON tömben kapjuk vissza!

    |Kulcs:|Érték pléda:|Leírás|
    |:-----|:-----------|:------|
    |Id|Valaki|Család azonosítója|
    |Name|'Kiss'|A család neve|
    |FatherId|9|A család alapítójának azonosítója|

* Családtagok listája:

    Szükséges adatok (Get request):
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'famMem'|Ez határozza meg milyen adatot kérünk|
    |famId|2|A család azonosítója amelyik tagjait lekérdezzük|
    |token|cookieből olvasott token|A login során kapott token |

   Visszakapott adatok:
    Az adatokat egy JSON tömben kapjuk vissza!

    |Kulcs:|Érték pléda:|Leírás|
    |:-----|:-----------|:------|
    |Id|Valaki|A felhasználó azonosítója|
    |Name|'Kiss'|A felhasználó neve|


* Kijelentkezés (Get request):

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'logout'|Csak ezt az egy értéket kell megadnunk a kijelentkezéshez!|
    

* Regisztráció (Post request):

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'user'|Ez határozza meg milyen adatot szeretnénk az adatbázishoz adni|
    |name|'Valaki'|Regisztráló felhasználó neve|
    |mail|'valaki@valami.hu'|A felhasználó e-mail címe|
    |password|'Bonyolult jelszó!'|A felhasználó jelszava (a szerver már csak MD5 hash értéket tárol|

* Kategória felvitele (Post request):

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'cat'|Ez határozza meg milyen adatot szeretnénk az adatbázishoz adni|
    |name|'fizetés'|A kategória neve|
    |creaId|9|A kategóriát létrehozó felhasználó azonosítója|
    |global|0|Meghatározza, hogy a kategória globális, személyes vagy családi|
    |token|cookieből olvasott token|A login során kapott token |

* Tranzakció felvitele:
    
    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'cat'|Ez határozza meg milyen adatot szeretnénk az adatbázishoz adni|
    |name|'fizetés'|A kategória neve|
    |creaId|9|A kategóriát létrehozó felhasználó azonosítója|
    |global|0|Meghatározza, hogy a kategória globális, személyes vagy családi|
    |token|cookieből olvasott token|A login során kapott token |

* Család felvitele (Post request):

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'family'|Ez határozza meg milyen adatot szeretnénk az adatbázishoz adni|
    |name|'Kiss'|A család neve|
    |fId|9|A család létrehozó felhasználó azonosítója|
    |token|cookieből olvasott token|A login során kapott token |


* Bejelentkezés:

    Szükséges adatok (Post request):
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'login'|Ez határozza meg mit szeretnénk kérni az APItól|
    |Name|'Kiss'|A felhasználó neve|
    |password|'Bonyolult jelszó'|A felhasználó jelszava|


* Felhasználó adatainak módosítása (Put request):

    Szükséges adatok (Put request):
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'user'|Ez határozza meg mit szeretnénk módosítani|
    |userId|9|A módosítandó felhasználó azonosítója|
    |Name|'Valaki'|A felhasználó neve, amire módosítani szeretnénk (lehet null)|
    |Mail|'valaki@valammi.hu'|A felhasználó mail címe, amire módosítani szeretnénk (lehet null)|
    |password|'Bonyolult jelszó'|A felhasználó jelszava, amire módosítani szeretnénk (lehet null|
    |token|cookieből olvasott token|A login során kapott token |    


* Kategória adatainak módosítása (Put request):

    Szükséges adatok (Put request):
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'cat'|Ez határozza meg mit szeretnénk módosítani|
    |catId|9|A módosítandó kategória azonosítója|
    |Name|'Valaki'|A kategória neve, amire módosítani szeretnénk (lehet null)|
    |token|cookieből olvasott token|A login során kapott token |    
    
* Tranzakció adatainak módosítása (Put request):

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
    |token|cookieből olvasott token|A login során kapott token |    
   
    
    
    *Családtag családhoz való adása (Put request):

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'fammember'|Ez határozza meg milyen adattal szeretnénk dolgozni|
    |uId|9|Kit szeretnénk a családhoz adni?|
    |famId|3|Melyik családhoz szeretnénk adni?|
    |token|cookieből olvasott token|A login során kapott token |    

    * Tranzakció törlése (Delete request):

    Szükséges adatok:
    
    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |com|'tran'|Ez határozza meg milyen adatot szeretnénk törölni|
    |uid|9|Annak a felhasználónak az ID-je aki a módosítandó tranzakciót létrehozta|
    |time|'2019-12-28 13:13:28'|A módosítandó tranzakció időbélyegzője|
    |token|cookieből olvasott token|A login során kapott token|
    
    
    
    *Bármi más törlése (Delete request):

    Szükséges adatok:

    |Kulcs:|Érték példa:|Leírás:|
    |:-----|:-----------|:------|
    |table|'User'|Ez határozza meg melyik táblából szeretnénk törölni|
    |Id|9|Annak a rekordnak az azonosítója amit törölni szeretnénk|
    |token|cookieből olvasott token|A login során kapott token|

   