Webbteknik_II-Lab02
===================

För att testa besök:
http://grayfish.se/labb2/

#Säkerhet

###Användaren kunde logga in med vilket lösenord/användarnamn som helst
- Hittades när jag sökte testade att logga in med ogiltiga uppgifter
- Kan utnytjas genom att icke tillåtna användare kan logga in utan riktiga uppgifter
- Jag löste problemet genom att ändra isUser-funktionen i sec.php

###Användarens lösenord var ej krypterat
- Hittades när jag kollade i db-filen
- Om db-filen skulle komma i fel händer så kan han enkelt hämta känsliga användaruppgifter
- Jag löste problemet genom att se till att lösenorden hashas. (Jag kontrollerar bara av hashing, jag hashar inga lösenord) lösenorden i databasen skrev jag om så att de nu är hashade.

###Injection vid input av meddelanden (?) 
- Hittades när jag kikade i Post.php-filen. Jag är inte säker på om datan var injektbar men Query-frågorna var ställda så att de inte kontrollerades efter injection. Dock så testade jag både att göra "DROP TABLE messages" samt <script>a|lert("xxs är tillgänglig")</script> men inget av dem visade tecken av att injection var möjlig.
- Om injection var möjlig så skulle en elak användare kunnat utföra hack med javascript. (typ som sammy)
- Jag har sett till att parameterfrågorna blir testade när datan skjuts in i databasen. Sen har jag utfört tester som pekar på att det inte är några risker för inskjutning av javascript, även kollat i databasen där javascripten ligger som strängar. Dock så lagras inte saker som "DROP TABLE messages" men de körs inte heller...

###Lade till "use strict" i javascript-filerna... 
- Är inte säker på vad riskerna är eller varför men jag har lärt mig att "strict mode" ska vara i toppen av js-filer (annars körs javascirpt i quirksmode...)

#Optimering

###Flyttade in alla inline-styles till egna css filer
- Eftersom externa filer (js, css) cacheas så blir det mer tidsnålt i längden att använda externa filer istället för att skriva direkt i HTML/PHP-filerna. Jag tror det gick mycket snabbare då detta också resulterade i att jag flyttade på inläsningen av CSSn till headern.
- Innan denna förändring så tog det runt 2-3 sekunder. Efter förändringen mellan 700ms till 1.37sekunder.
- Källa: High Performance Web Sites Kapitel 8

###Gjorde en header(Expire) på mess.php
- Om jag har förstått rätt så läggs denna i en speciell cache. Klienten kommer inte göra en förfråga på denna fil nästa gång den behöver den, utan använder den cachade. Detta sker tills du byter namn på filen eller header(exipres) går ut.
- Innan denna förändring så tog det runt 700ms till 1.37 sekunder. Efter förändringen mellan 650ms till 1sekunder.
- Källa: High Performance Web Sites Kapitel 3

###Flyttade Script till längst ner i bodyn, Flyttade CSS till headern
- Man vill att script ska läsas in sist för att inte avbryta sidan för att komma fram. Om man har skriptet mitt i sidan så kommer sidan stanna och ladda in skriptet där istället för att fortsätta exekveringen av sidan. CSSn flyttades till toppen devlis för att om den ligger långt nere så kommer också stilen laddas in senare, vilket som ser "Choppy/choppigt" ut. Genom att ladda in CSSn tidigt så slipper vi det hackiga och sidan upplevs snabbare.
- Innan denna förändring så tog det runt 650ms till 1 sekund. Efter förändringen mellan 650ms till 800ms.
- Källa: High Performance Web Sites Kapitel 5 och 6

###Ändrade ett inlinescript och lade den i filen script.js.
- Detta gjorde inte sidan snabbare utan lite saktare. Även fast jag följer idéen om att alla script och stilar ska vara i egna filer. Anledningen till att det bara påverkar negativt är att filen behöver laddas ner och anropas (antar jag), det rörde sig om väldigt lite kod; i de fallen då det rör väldigt lite kod så kan ibland det mest optimala vara att använda inline.
- Gick upp från 650ms till 800ms till 750ms->850ms, min dator är väldigt seg så detta kan vara ett sammanträffande snarare än ett resultat av ändringen.
- Källa: High Performance Web Sites Kapitel 8

###Minifierade CSS och JS-filer
- Enligt boken så ska en minifiering göra väldigt mycket prestandamässigt. Det är för att filerna blir mindre i storlek och går snabbare för datorn att läsa. 
- Jag märkte ingen skillnad, laddningstiden låg fortfarande runt 750ms till 850ms.
- Källa: High Performance Web Sites Kapitel 10

####Något som kunde göras: Slå samman bilderna till 1 storbild-fil och sedan använda sprite-teknik

#Long Polling
- Angående min lösning; I MessageBoard.js så har vi funktionen getMessages, den anropas när sidan först laddas. Funktionen gör ett ajaxanrop och ser till att hämta ner alla meddelanden som finns i databasen. 
Jag har gjort att ajax-delen av koden körs varannan sekund, det funktionen gör efter att ha hämtat all message-data är att den bygger ihop varje meddelanden och pushar in dem i MessageBoard.messages, innan den får göra det så kontrollerar jag först hur många meddelanden som finns på användarens skärm, om det är mer än antalet meddelanden som har loggats så betyder det att ett nytt medelande har lagts till, då får koden köras. Detta gör att så fort en användare lägger till ett meddelande så meddelas ajax att skicka ut den nya listan med meddelanden.
För att få nyaste meddelanden att hamna först så "reversade" jag bara datan med meddelanderna i.
