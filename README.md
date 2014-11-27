Webbteknik_II-Lab02
===================

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
- Man vill att script ska läsas in sist för att inte avbryta sidan för att komma fram. Om man har skriptet mitt i sidan så kommer sidan stanna och ladda in skriptet där istället för att fortsätta exekveringen av sidan. CSSn 
- Innan denna förändring så tog det runt 650ms till 1 sekund. Efter förändringen mellan 650ms till 800ms.
- Källa: High Performance Web Sites Kapitel 5 och 6



####Något som kunde göras: Slå samman bilderna till 1 storbild-fil och sedan använda sprite-teknik


#Long Polling
