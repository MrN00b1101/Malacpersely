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
    
    |Kulcs:|Érték pléda:|Leírás|
    |:-----|:-----------|:------|
    |User|Kocsira|A megtakarítási zseb neve, ha a tranzakció nem tartozik kölön zsebhez akkor az érték "Personal" vagy "Family"|
    |Id|Valaki|A tranzakciót felvivő felhasználó neve|
    |Name|Megtakarítás|A tranzakció kategóriájának neve|
    |CreatorId|9|A tranzakciót felvivő felhasználó azonosítója|
    |Global|4|A tranzakció kategóriájának azonosítója|
    
    
* Felhasználók listája:
* Családok listája:
* Családtagok listája:
* User adatai:
* Kijelentkezés:

* Regisztráció:
* Kategória felvitele:
* Tranzakció felvitele:
* Család felvitele:
* Bejelentkezés:

* Felhasználó adatainak módosítása:
* Kategória adatainak módosítása:
    
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
