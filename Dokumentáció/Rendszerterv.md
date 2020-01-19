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


API HASZNÁLAT TERVE

Az api Json obijektumban várja az adatokat!


MODULOK:

Regisztráció: Post request 

szükséges adatok: 
{
com:'user',
name:'felhasználó neve',
mail:'email cím',
password:'jelszó hash'
}


Kategória felvitele: Post request, 

szükséges adatok:    
{    
com:'cat',
name:'kategória név',
creaId:'létrehozó felhasználó azonosítója',  
global:'láthatóság (0-global,1-personal,2-család)'   
}


Tranzakció felvitele: Post request, 

szükséges adatok:    
{    
com:'tran',
uId:'felhasználó azonosító',
catId:'kategória azonosító',  
value:'érték',
persona: '0/1 személyes vagy családi'   
}


Család felvitele: Post request, 

szükséges adatok:    
{    
com:'family',
name:'család név',
fId:'Családfő azonosítója'   
}



