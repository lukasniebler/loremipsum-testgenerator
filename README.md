# LoremIpsum Testgenerator V.1.0.0

Wichtig:

Der Shortcode lorem nutzt die API von http://loripsum.net/ und ist für Testzwecke auf Testinstanzen angedacht.

## Shortcode lorem

[lorem number=" " type=" " length=" "]
    
    number steuert die Anzahl der ausgegebenen Paragraphen/Listen/Blockquotes
        - angabe als integer
    type steuert die Art der ausgegebenen Elemente. Möglich sind:
        - leer lassen = paragraph
        - ul
        - ol
        - bq (blockquotes)
        - dl (description lists)
        - code (code samples)
        - link (links)
        - decorate (Dekoriert den Paragraphentext mit gängigen formattierungen bold, italic, marked)
        - allcaps 
    length steuert die Länge der ausgegebenen Elementbestandteile. Möglich sind:
        - short
        - medium
        - long
        - verylong

## Shortcode ipsum

[ipsum number="1"] generiert einen Paragraphen anhand einer vorgegebenen Liste aus Fach- und Füllwörtern.

## Shortcode unicode

[unicode modus="1" type="default"] generiert je nach Parameter eine Liste von Unicode-Symbolen:

    modus="1" generiert eine Standardpalette von ca. 50 Symbolen
    modus="2" generiert alle Unicode-Symbole von 1 bis 10.000+
        type="default" nummeriert die Ausgabe nicht
        type="debug" nummeriert alle ausgegebenen UnicodeSymbole
    ___


