Webbteknik_II-Lab02
===================

###Säkerhet
##Inloggning
#Användaren kunde logga in med vilket lösenord/användarnamn som helst
-Hittades när jag sökte testade att logga in med ogiltiga uppgifter
-Kan utnytjas genom att icke tillåtna användare kan logga in utan riktiga uppgifter
-Jag löste problemet genom att ändra isUser-funktionen i sec.php

#Användarens lösenord var ej krypterat
-Hittades när jag kollade i db-filen
-Om db-filen skulle komma i fel händer så kan han enkelt hämta känsliga användaruppgifter
-Jag löste problemet genom att se till att lösenorden hashas. (Jag kontrollerar bara av hashing, jag hashar inga lösenord) lösenorden i databasen skrev jag om så att de nu är hashade.

#Injection vid input av meddelanden (?) 
-Hittades när jag kikade i Post.php-filen. Jag är inte säker på om datan var injektbar men Query-frågorna var ställda så att de inte kontrollerades efter injection. Dock så testade jag både att göra "DROP TABLE messages" samt <script>a|lert("xxs är tillgänglig")</script> men inget av dem visade tecken av att injection var möjlig.
-Om injection var möjlig så skulle en elak användare kunnat utföra hack med javascript. (typ som sammy)
-Jag har sett till att parameterfrågorna blir testade när datan skjuts in i databasen. Sen har jag utfört tester som pekar på att det inte är några risker för inskjutning av javascript

###Optimering


###Long Polling
