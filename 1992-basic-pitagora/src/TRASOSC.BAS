DEFINT A-Z
'declarations
DECLARE SUB Trasosc ()
' Runprogram
  CLS
  Trasosc
END

SUB Trasosc
Sfondort:
COLOR 15, 1: CLS
'titolo
LOCATE 2, 13: PRINT " PITAGORA : RISOLUZIONI PROBLEMI SUI TRAPEZI ISOSCELI"
FINESTRA1:
COLOR 15, 3
FOR A = 1 TO 17: LOCATE 6, A + 5: PRINT CHR$(205): NEXT A
LOCATE 6, 23: PRINT CHR$(203): FOR A = 1 TO 7
LOCATE 6, A + 23: PRINT CHR$(205): NEXT A
LOCATE 6, 31: PRINT CHR$(203): FOR A = 1 TO 2: LOCATE 6, A + 31
PRINT CHR$(205): NEXT A
LOCATE 6, 34: PRINT CHR$(185): LOCATE 5, 34: PRINT CHR$(186)
LOCATE 4, 34: PRINT CHR$(187)
FOR A = 1 TO 28: LOCATE 4, A + 5: PRINT CHR$(205): NEXT A
LOCATE 4, 5: PRINT CHR$(201): LOCATE 5, 5: PRINT CHR$(186)
LOCATE 6, 5: PRINT CHR$(204)
FOR A = 1 TO 6: LOCATE A + 6, 5: PRINT CHR$(186): NEXT A
FOR A = 1 TO 6: LOCATE A + 6, 23: PRINT CHR$(186): NEXT A
FOR A = 1 TO 6: LOCATE A + 6, 34: PRINT CHR$(186): NEXT A
FOR A = 1 TO 6: LOCATE A + 6, 31: PRINT CHR$(186): NEXT A
LOCATE 13, 5: PRINT CHR$(200)
FOR A = 1 TO 17: LOCATE 13, A + 5: PRINT CHR$(205): NEXT A
LOCATE 13, 23: PRINT CHR$(202)
FOR A = 1 TO 10: LOCATE 13, A + 23: PRINT CHR$(205): NEXT A
LOCATE 13, 31: PRINT CHR$(202)
LOCATE 13, 34: PRINT CHR$(188)
PRESENTAZIONE1:
COLOR 14, 3: LOCATE 5, 6: PRINT " I"
COLOR 15, 3: LOCATE 5, 8: PRINT "POTESI                    "
A$ = " 1: Base maggiore"
B$ = " 2: Base minore  "
C$ = " 3: Altezza      "
D$ = " 4: Lato obliquo "
E$ = " 5: Perimetro    "
F$ = " 6: Area         "
G$ = "SI"
H$ = "NO"
l$ = "       "
LOCATE 7, 6: PRINT A$
LOCATE 8, 6: PRINT B$
LOCATE 9, 6: PRINT C$
LOCATE 10, 6: PRINT D$
LOCATE 11, 6: PRINT E$
LOCATE 12, 6: PRINT F$
LOCATE 7, 24: PRINT l$: LOCATE 7, 32: PRINT H$
LOCATE 8, 24: PRINT l$: LOCATE 8, 32: PRINT H$
LOCATE 9, 24: PRINT l$: LOCATE 9, 32: PRINT H$
LOCATE 10, 24: PRINT l$: LOCATE 10, 32: PRINT H$
LOCATE 11, 24: PRINT l$: LOCATE 11, 32: PRINT H$
LOCATE 12, 24: PRINT l$: LOCATE 12, 32: PRINT H$
FINESTRA2:
FOR A = 1 TO 28: LOCATE 6, A + 45: PRINT CHR$(205): NEXT A
LOCATE 6, 73: PRINT CHR$(185): LOCATE 5, 73: PRINT CHR$(186)
LOCATE 4, 73: PRINT CHR$(187)
FOR A = 1 TO 27: LOCATE 4, A + 45: PRINT CHR$(205): NEXT A
LOCATE 4, 45: PRINT CHR$(201): LOCATE 5, 45: PRINT CHR$(186)
LOCATE 6, 45: PRINT CHR$(204)
FOR A = 1 TO 6: LOCATE A + 6, 45: PRINT CHR$(186): NEXT A
FOR A = 1 TO 6: LOCATE A + 6, 73: PRINT CHR$(186): NEXT A
LOCATE 13, 45: PRINT CHR$(200)
FOR A = 1 TO 28: LOCATE 13, A + 45: PRINT CHR$(205): NEXT A
LOCATE 13, 73: PRINT CHR$(188)
presentazione2:
COLOR 14, 3: LOCATE 5, 46: PRINT " T"
COLOR 15, 3: LOCATE 5, 48: PRINT "ESI                      "
LOCATE 7, 46: PRINT A$
LOCATE 7, 63: PRINT SPACE$(10)
LOCATE 8, 46: PRINT B$
LOCATE 8, 63: PRINT SPACE$(10)
LOCATE 9, 46: PRINT C$
LOCATE 9, 63: PRINT SPACE$(10)
LOCATE 10, 46: PRINT D$
LOCATE 10, 63: PRINT SPACE$(10)
LOCATE 11, 46: PRINT E$
LOCATE 11, 63: PRINT SPACE$(10)
LOCATE 12, 46: PRINT F$
LOCATE 12, 63: PRINT SPACE$(10)
finestra3:
FOR A = 1 TO 34: LOCATE 17, A + 22: PRINT CHR$(205): NEXT A
LOCATE 17, 56: PRINT CHR$(185)
LOCATE 16, 56: PRINT CHR$(186): LOCATE 15, 56: PRINT CHR$(187)
FOR A = 1 TO 33: LOCATE 15, A + 22: PRINT CHR$(205): NEXT A
LOCATE 15, 22: PRINT CHR$(201): LOCATE 16, 22: PRINT CHR$(186)
LOCATE 17, 22: PRINT CHR$(204)
FOR A = 1 TO 4
   LOCATE A + 17, 22: PRINT CHR$(186)
   LOCATE A + 17, 56: PRINT CHR$(186)
NEXT A
LOCATE 22, 22: PRINT CHR$(200)
FOR A = 1 TO 34: LOCATE 22, A + 22: PRINT CHR$(205): NEXT A
LOCATE 22, 56: PRINT CHR$(188)
PRESENTAZIONE3:
COLOR 14, 3: LOCATE 16, 23: PRINT " V"
COLOR 15, 3: LOCATE 16, 25: PRINT "ISUAL                          "
da$ = " VISUALIZAZIONE PROBLEMI         "
db$ = " MENU PRINCIPALE                 "
LOCATE 18, 23: PRINT da$
LOCATE 20, 23: PRINT db$
LOCATE 19, 23: PRINT TAB(56);
LOCATE 21, 23: PRINT TAB(56);
cur1trip:
COLOR 0, 3
LOCATE 7, 6: PRINT A$
COLOR 15, 3
LOCATE 8, 6: PRINT B$
LOCATE 9, 6: PRINT C$
LOCATE 10, 6: PRINT D$
LOCATE 11, 6: PRINT E$
LOCATE 12, 6: PRINT F$
GOSUB SHOW1TRIP
CUR2TRIP:
COLOR 0, 3
LOCATE 8, 6: PRINT B$
COLOR 15, 3
LOCATE 7, 6: PRINT A$
LOCATE 9, 6: PRINT C$
GOSUB SHOW2TRIP
CUR3TRIP:
COLOR 0, 3
LOCATE 9, 6: PRINT C$
COLOR 15, 3
LOCATE 8, 6: PRINT B$
LOCATE 10, 6: PRINT D$
GOSUB SHOW3TRIP
CUR4TRIP:
COLOR 0, 3
LOCATE 10, 6: PRINT D$
COLOR 15, 3
LOCATE 9, 6: PRINT C$
LOCATE 11, 6: PRINT E$
GOSUB SHOW4TRIP
CUR5TRIP:
COLOR 0, 3
LOCATE 11, 6: PRINT E$
COLOR 15, 3
LOCATE 10, 6: PRINT D$
LOCATE 12, 6: PRINT F$
GOSUB show5trip
CUR6TRIP:
COLOR 0, 3
LOCATE 12, 6: PRINT F$
COLOR 15, 3
LOCATE 7, 6: PRINT A$
LOCATE 11, 6: PRINT E$
GOSUB sHOW6TRIP
SHOW1TRIP:
DO
N$ = INKEY$
LOOP UNTIL N$ <> ""
SELECT CASE N$
CASE CHR$(0) + "H"
GOSUB CUR6TRIP
CASE CHR$(0) + "P"
GOSUB CUR2TRIP
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 6: PRINT A$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 7, 24: INPUT "", A: LOCATE 7, 32: PRINT G$
GOSUB CUR1TRIP2
CASE ELSE
BEEP: GOSUB cur1trip
END SELECT
SHOW2TRIP:
DO
M$ = INKEY$
LOOP UNTIL M$ <> ""
SELECT CASE M$
CASE CHR$(0) + "H"
GOSUB cur1trip
CASE CHR$(0) + "P"
GOSUB CUR3TRIP
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 6: PRINT B$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 8, 24: INPUT "", B: LOCATE 8, 32: PRINT G$
GOSUB SHOW2TRIP2
CASE ELSE
BEEP: GOSUB CUR2TRIP
END SELECT
SHOW3TRIP:
DO
O$ = INKEY$
LOOP UNTIL O$ <> ""
SELECT CASE O$
CASE CHR$(0) + "H"
GOSUB CUR2TRIP
CASE CHR$(0) + "P"
GOSUB CUR4TRIP
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 6: PRINT C$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 9, 24: INPUT "", C: LOCATE 9, 32: PRINT G$
GOSUB SHOW3TRIP2
CASE ELSE
BEEP: GOSUB CUR3TRIP
END SELECT
SHOW4TRIP:
DO
p$ = INKEY$
LOOP UNTIL p$ <> ""
SELECT CASE p$
CASE CHR$(0) + "H"
GOSUB CUR3TRIP
CASE CHR$(0) + "P"
GOSUB CUR5TRIP
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 6: PRINT D$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 10, 24: INPUT "", D: LOCATE 10, 32: PRINT G$
GOSUB SHOW4TRIP2
CASE ELSE
BEEP: GOSUB SHOW4TRIP
END SELECT
show5trip:
DO
R$ = INKEY$
LOOP UNTIL R$ <> ""
SELECT CASE R$
CASE CHR$(0) + "H"
GOSUB CUR4TRIP
CASE CHR$(0) + "P"
GOSUB CUR6TRIP
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 6: PRINT E$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 11, 24: INPUT "", E: LOCATE 11, 32: PRINT G$
GOSUB SHOW5TRIP2
CASE ELSE
BEEP: GOSUB show5trip
END SELECT
sHOW6TRIP:
DO
S$ = INKEY$
LOOP UNTIL S$ <> ""
SELECT CASE S$
CASE CHR$(0) + "H"
GOSUB CUR5TRIP
CASE CHR$(0) + "P"
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 12, 6: PRINT F$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 12, 24: INPUT "", F: LOCATE 12, 32: PRINT G$
GOSUB SHOW6TRIP2
CASE ELSE
BEEP: GOSUB sHOW6TRIP
END SELECT
CUR1TRIP2:
COLOR 0, 3
LOCATE 7, 6: PRINT A$
COLOR 15, 3
LOCATE 8, 6: PRINT B$
LOCATE 9, 6: PRINT C$
LOCATE 10, 6: PRINT D$
LOCATE 11, 6: PRINT E$
LOCATE 12, 6: PRINT F$
GOSUB SHOW1TRIP2
CUR2TRIP2:
COLOR 0, 3
LOCATE 8, 6: PRINT B$
COLOR 15, 3
LOCATE 7, 6: PRINT A$
LOCATE 9, 6: PRINT C$
GOSUB SHOW2TRIP2
CUR3TRIP2:
COLOR 0, 3
LOCATE 9, 6: PRINT C$
COLOR 15, 3
LOCATE 8, 6: PRINT B$
LOCATE 10, 6: PRINT D$
GOSUB SHOW3TRIP2
CUR4TRIP2:
COLOR 0, 3
LOCATE 10, 6: PRINT D$
COLOR 15, 3
LOCATE 9, 6: PRINT C$
LOCATE 11, 6: PRINT E$
GOSUB SHOW4TRIP2
CUR5TRIP2:
COLOR 0, 3
LOCATE 11, 6: PRINT E$
COLOR 15, 3
LOCATE 10, 6: PRINT D$
LOCATE 12, 6: PRINT F$
GOSUB SHOW5TRIP2
CUR6TRIP2:
COLOR 0, 3
LOCATE 12, 6: PRINT F$
COLOR 15, 3
LOCATE 7, 6: PRINT A$
LOCATE 11, 6: PRINT E$
GOSUB SHOW6TRIP2
SHOW1TRIP2:
DO
t$ = INKEY$
LOOP UNTIL t$ <> ""
SELECT CASE t$
CASE CHR$(0) + "H"
GOSUB CUR6TRIP2
CASE CHR$(0) + "P"
GOSUB CUR2TRIP2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 6: PRINT A$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 7, 24: PRINT l$: LOCATE 7, 32: PRINT H$
GOSUB cur1trip
CASE ELSE
BEEP: GOSUB CUR1TRIP2
END SELECT
SHOW2TRIP2:
DO
U$ = INKEY$
LOOP UNTIL U$ <> ""
SELECT CASE U$
CASE CHR$(0) + "H"
GOSUB CUR1TRIP2
CASE CHR$(0) + "P"
GOSUB CUR3TRIP2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 6: PRINT B$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 8, 24: PRINT l$: LOCATE 8, 32: PRINT H$
GOSUB CUR2TRIP
CASE ELSE
BEEP: GOSUB CUR2TRIP2
END SELECT
SHOW3TRIP2:
DO
V$ = INKEY$
LOOP UNTIL V$ <> ""
SELECT CASE V$
CASE CHR$(0) + "H"
GOSUB CUR2TRIP2
CASE CHR$(0) + "P"
GOSUB CUR4TRIP2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 6: PRINT C$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 9, 24: PRINT l$: LOCATE 9, 32: PRINT H$
GOSUB CUR3TRIP
CASE ELSE
BEEP: GOSUB CUR3TRIP2
END SELECT
SHOW4TRIP2:
DO
Z$ = INKEY$
LOOP UNTIL Z$ <> ""
SELECT CASE Z$
CASE CHR$(0) + "H"
GOSUB CUR3TRIP2
CASE CHR$(0) + "P"
GOSUB CUR5TRIP2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 6: PRINT D$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 10, 24: PRINT l$: LOCATE 10, 32: PRINT H$
GOSUB CUR4TRIP
CASE ELSE
BEEP: GOSUB CUR4TRIP2
END SELECT
SHOW5TRIP2:
DO
aa$ = INKEY$
LOOP UNTIL aa$ <> ""
SELECT CASE aa$
CASE CHR$(0) + "H"
GOSUB CUR4TRIP2
CASE CHR$(0) + "P"
GOSUB CUR6TRIP2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 6: PRINT E$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 11, 24: PRINT l$: LOCATE 11, 32: PRINT H$
GOSUB CUR5TRIP
CASE ELSE
BEEP: GOSUB CUR5TRIP2
END SELECT
SHOW6TRIP2:
DO
ab$ = INKEY$
LOOP UNTIL ab$ <> ""
SELECT CASE ab$
CASE CHR$(0) + "H"
GOSUB CUR5TRIP2
CASE CHR$(0) + "P"
GOSUB CUR1TRIP2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 12, 6: PRINT F$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 12, 24: PRINT l$: LOCATE 12, 32: PRINT H$
GOSUB CUR6TRIP
CASE ELSE
BEEP: GOSUB CUR6TRIP2
END SELECT
CUR1TRTE:
COLOR 0, 3
LOCATE 7, 46: PRINT A$
COLOR 15, 3
LOCATE 12, 46: PRINT F$
LOCATE 8, 46: PRINT B$
GOSUB show1trte
CUR2TRTE:
COLOR 0, 3
LOCATE 8, 46: PRINT B$
COLOR 15, 3
LOCATE 7, 46: PRINT A$
LOCATE 9, 46: PRINT C$
GOSUB SHOW2TRTE
CUR3TRTE:
COLOR 0, 3
LOCATE 9, 46: PRINT C$
COLOR 15, 3
LOCATE 8, 46: PRINT B$
LOCATE 10, 46: PRINT D$
GOSUB SHOW3TRTE
CUR4TRTE:
COLOR 0, 3
LOCATE 10, 46: PRINT D$
COLOR 15, 3
LOCATE 9, 46: PRINT C$
LOCATE 11, 46: PRINT E$
GOSUB SHOW4TRTE
CUR5TRTE:
COLOR 0, 3
LOCATE 11, 46: PRINT E$
COLOR 15, 3
LOCATE 10, 46: PRINT D$
LOCATE 12, 46: PRINT F$
GOSUB SHOW5TRTE
CUR6trte:
COLOR 0, 3
LOCATE 12, 46: PRINT F$
COLOR 15, 3
LOCATE 7, 46: PRINT A$
LOCATE 11, 46: PRINT E$
GOSUB SHOW6TRTE
show1trte:
DO
bb$ = INKEY$
LOOP UNTIL bb$ <> ""
SELECT CASE bb$
CASE CHR$(0) + "H"
GOSUB CUR6trte
CASE CHR$(0) + "P"
GOSUB CUR2TRTE
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 7, 46: PRINT A$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 46: PRINT A$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB b1A
CASE ELSE
BEEP: GOSUB CUR1TRTE
END SELECT
SHOW2TRTE:
DO
bc$ = INKEY$
LOOP UNTIL bc$ <> ""
SELECT CASE bc$
CASE CHR$(0) + "H"
GOSUB CUR1TRTE
CASE CHR$(0) + "P"
GOSUB CUR3TRTE
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 8, 46: PRINT B$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 46: PRINT B$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB lo
CASE ELSE
BEEP: GOSUB CUR2TRTE
END SELECT
SHOW3TRTE:
DO
bd$ = INKEY$
LOOP UNTIL bd$ <> ""
SELECT CASE bd$
CASE CHR$(0) + "H"
GOSUB CUR2TRTE
CASE CHR$(0) + "P"
GOSUB CUR4TRTE
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 9, 46: PRINT C$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 46: PRINT C$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB al
CASE ELSE
BEEP: GOSUB CUR3TRTE
END SELECT
SHOW4TRTE:
DO
be$ = INKEY$
LOOP UNTIL be$ <> ""
SELECT CASE be$
CASE CHR$(0) + "H"
GOSUB CUR3TRTE
CASE CHR$(0) + "P"
GOSUB CUR5TRTE
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 10, 46: PRINT D$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 46: PRINT D$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB lo
CASE ELSE
BEEP: GOSUB CUR4TRTE
END SELECT
SHOW5TRTE:
DO
BF$ = INKEY$
LOOP UNTIL BF$ <> ""
SELECT CASE BF$
CASE CHR$(0) + "H"
GOSUB CUR4TRTE
CASE CHR$(0) + "P"
GOSUB CUR6trte
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 11, 46: PRINT E$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 46: PRINT E$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB pr
CASE ELSE
BEEP: GOSUB CUR5TRTE
END SELECT
SHOW6TRTE:
DO
BG$ = INKEY$
LOOP UNTIL BG$ <> ""
SELECT CASE BG$
CASE CHR$(0) + "H"
GOSUB CUR5TRTE
CASE CHR$(0) + "P"
GOSUB CUR1TRTE
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 12, 46: PRINT F$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 12, 46: PRINT F$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB ar
CASE ELSE
BEEP: GOSUB CUR6trte
END SELECT
CUR1TRVI:
COLOR 0, 3
LOCATE 18, 23: PRINT da$
COLOR 15, 3
LOCATE 20, 23: PRINT db$
GOSUB show1trVI
CUR2TRVI:
COLOR 0, 3
LOCATE 20, 23: PRINT db$
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB SHOW2TRVI
show1trVI:
DO
de$ = INKEY$
LOOP UNTIL de$ <> ""
SELECT CASE de$
CASE CHR$(0) + "H"
GOSUB CUR2TRVI
CASE CHR$(0) + "P"
GOSUB CUR2TRVI
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB cur1trip
CASE CHR$(27)
END
CASE CHR$(13)
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB CUR1TRTE
END SELECT
SHOW2TRVI:
DO
DF$ = INKEY$
LOOP UNTIL DF$ <> ""
SELECT CASE DF$
CASE CHR$(0) + "H"
GOSUB CUR1TRVI
CASE CHR$(0) + "P"
GOSUB CUR1TRVI
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 20, 23: PRINT db$
GOSUB cur1trip
CASE CHR$(27)
END
CASE CHR$(13)
RUN "pit"
CASE ELSE
BEEP: GOSUB CUR2TRVI
END SELECT
b1A:
IF B > 0 AND C > 0 AND D > 0 THEN GOSUB B1A1
IF B > 0 AND C > 0 AND F > 0 THEN GOSUB B1A2
IF B > 0 AND D > 0 AND E > 0 THEN GOSUB B1A3
IF C > 0 AND D > 0 AND F > 0 THEN GOSUB B1A4
GOSUB er
B2A:
IF A > 0 AND C > 0 AND D > 0 THEN GOSUB B2A1
IF A > 0 AND C > 0 AND F > 0 THEN GOSUB B2A2
IF A > 0 AND D > 0 AND E > 0 THEN GOSUB B2A3
IF C > 0 AND D > 0 AND F > 0 THEN GOSUB B2A4
GOSUB er
al:
IF A > 0 AND B > 0 AND D > 0 THEN GOSUB AL1
IF A > 0 AND D > 0 AND E > 0 THEN GOSUB AL2
IF A > 0 AND B > 0 AND F > 0 THEN GOSUB AL3
IF A > 0 AND D > 0 AND E > 0 THEN GOSUB AL4
IF A > 0 AND D > 0 AND F > 0 THEN GOSUB AL5
IF B > 0 AND D > 0 AND E > 0 THEN GOSUB AL6
IF B > 0 AND D > 0 AND F > 0 THEN GOSUB AL7
GOSUB er
lo:
IF A > 0 AND B > 0 AND C > 0 THEN GOSUB LO1
IF A > 0 AND B > 0 AND E > 0 THEN GOSUB LO2
IF A > 0 AND B > 0 AND F > 0 THEN GOSUB LO3
IF B > 0 AND C > 0 AND F > 0 THEN GOSUB LO4
IF C > 0 AND E > 0 AND F > 0 THEN GOSUB LO5
GOSUB er
pr:
IF A > 0 AND B > 0 AND C > 0 THEN GOSUB PR1
IF A > 0 AND B > 0 AND D > 0 THEN GOSUB pr2
IF A > 0 AND B > 0 AND F > 0 THEN GOSUB pr3
IF A > 0 AND C > 0 AND D > 0 THEN GOSUB pr4
IF A > 0 AND C > 0 AND F > 0 THEN GOSUB pr5
IF B > 0 AND C > 0 AND D > 0 THEN GOSUB Pr6
IF B > 0 AND C > 0 AND F > 0 THEN GOSUB PR7
IF C > 0 AND D > 0 AND F > 0 THEN GOSUB PR8
GOSUB er
ar:
IF A > 0 AND B > 0 AND C > 0 THEN GOSUB ar1
IF A > 0 AND B > 0 AND D > 0 THEN GOSUB AR2
IF A > 0 AND B > 0 AND E > 0 THEN GOSUB AR3
IF A > 0 AND C > 0 AND D > 0 THEN GOSUB AR4
IF A > 0 AND D > 0 AND E > 0 THEN GOSUB AR5
IF B > 0 AND C > 0 AND D > 0 THEN GOSUB AR6
IF B > 0 AND D > 0 AND E > 0 THEN GOSUB AR7
IF C > 0 AND D > 0 AND E > 0 THEN GOSUB AR8
GOSUB er
er:
COLOR 31, 3
LOCATE 14, 15: PRINT "IL PROBLEMA E` IMPOSSIBILE O C'E` GIA` LA SOLUZIONE"
COLOR 15, 1
LOCATE 23, 1: PRINT "Premi ENTER per continuare"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(13)
GOSUB Sfondort
CASE ELSE
BEEP: GOSUB er
END SELECT
B1A1:
aa = F * 2 / B
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'ipotenusa di un triangolo triangolo sapendo la misura dell'area e dell'altezza relativa all'ipotenusa"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; B; "="; aa
aa = 0: F = 0: B = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
B1A2:
aa = F * 2 / C
ab = (C ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; C; "="; aa
LOCATE 7, 1: PRINT "√"; C; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: C = 0: F = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
B1A3:
ab = (C ^ 2) + (D ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura dei cateti"
LOCATE 5, 1: PRINT "√"; C; "²"; "+"; D; "²"; "="; "√"; ab; "="; ac
ab = 0: ac = 0: C = 0: D = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
B1A4:
aa = F * 2 / D
ab = (D ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; D; "="; aa
LOCATE 7, 1: PRINT "√"; D; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: D = 0: F = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
B2A1:
ba = F * 2 / A
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
B2A2:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
B2A3:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
B2A4:
aa = F * 2 / B
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'ipotenusa di un triangolo triangolo sapendo la misura dell'area e dell'altezza relativa all'ipotenusa"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; B; "="; aa
aa = 0: F = 0: B = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AL1:
aa = F * 2 / C
ab = (C ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; C; "="; aa
LOCATE 7, 1: PRINT "√"; C; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: C = 0: F = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AL2:
ab = (C ^ 2) + (D ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura dei cateti"
LOCATE 5, 1: PRINT "√"; C; "²"; "+"; D; "²"; "="; "√"; ab; "="; ac
ab = 0: ac = 0: C = 0: D = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AL3:
aa = F * 2 / D
ab = (D ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; D; "="; aa
LOCATE 7, 1: PRINT "√"; D; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: D = 0: F = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AL4:
ba = F * 2 / A
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AL5:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AL6:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AL7:
aa = F * 2 / B
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'ipotenusa di un triangolo triangolo sapendo la misura dell'area e dell'altezza relativa all'ipotenusa"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; B; "="; aa
aa = 0: F = 0: B = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
LO1:
aa = F * 2 / C
ab = (C ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; C; "="; aa
LOCATE 7, 1: PRINT "√"; C; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: C = 0: F = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
LO2:
ab = (C ^ 2) + (D ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura dei cateti"
LOCATE 5, 1: PRINT "√"; C; "²"; "+"; D; "²"; "="; "√"; ab; "="; ac
ab = 0: ac = 0: C = 0: D = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
LO3:
aa = F * 2 / D
ab = (D ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; D; "="; aa
LOCATE 7, 1: PRINT "√"; D; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: D = 0: F = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
LO4:
ba = F * 2 / A
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
LO5:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
PR1:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
pr2:
aa = F * 2 / B
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'ipotenusa di un triangolo triangolo sapendo la misura dell'area e dell'altezza relativa all'ipotenusa"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; B; "="; aa
aa = 0: F = 0: B = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
pr3:
aa = F * 2 / C
ab = (C ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; C; "="; aa
LOCATE 7, 1: PRINT "√"; C; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: C = 0: F = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
pr4:
ab = (C ^ 2) + (D ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura dei cateti"
LOCATE 5, 1: PRINT "√"; C; "²"; "+"; D; "²"; "="; "√"; ab; "="; ac
ab = 0: ac = 0: C = 0: D = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
pr5:
aa = F * 2 / D
ab = (D ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; D; "="; aa
LOCATE 7, 1: PRINT "√"; D; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: D = 0: F = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
Pr6:
ba = F * 2 / A
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
PR7:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
PR8:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
ar1:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; F; "·"; "2"; ")"; ":"; A; "="; ba
ba = 0: F = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AR2:
ba = (D / .433) ^ (1 / 2)
bc = ba * 1.732
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza di un triangolo equilatero sapendo la misura dell'altezza"
LOCATE 5, 1: PRINT "√"; D; ":"; "0,433"; "="; ba
LOCATE 7, 1: PRINT ba; "·"; "1,732"; "="; bc
ba = 0: D = 0: bb = 0: bc = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AR3:
ca = A * 3
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare il perimetro di un triangolo equilatero sapendo la misura del lato"
LOCATE 5, 1: PRINT A; "·"; "3"; "="; ca
ca = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AR4:
ca = (D / .433) ^ (1 / 2)
cb = ca * 3
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare il perimetro di un triangolo equilatero sapendo la misura dell'area"
LOCATE 5, 1: PRINT "√"; D; ":"; "0,433"; "="; ca
LOCATE 7, 1: PRINT ca; "·"; "3"; "="; cb
ca = 0: D = 0: cb = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AR5:
cb = B / 1.732
cc = cb * 3
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare il perimetro di un triangolo equilatero sapendo la misura dell'altezza"
LOCATE 5, 1: PRINT B; ":"; "1,732"; " = "; cb
LOCATE 7, 1: PRINT cb; "·"; "3"; "="; cc
ca = 0: C = 0: cb = 0: cc = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AR6:
cb = B / 1.732
cc = cb * 3
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare il perimetro di un triangolo equilatero sapendo la misura dell'altezza"
LOCATE 5, 1: PRINT B; ":"; "1,732"; " = "; cb
LOCATE 7, 1: PRINT cb; "·"; "3"; "="; cc
ca = 0: C = 0: cb = 0: cc = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AR7:
da = A ^ 2 * .433
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'area di un triangolo equilatero sapendo la misura del lato"
LOCATE 5, 1: PRINT A; "²"; "·"; "0,433"; "="; da
da = 0: A = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
AR8:
cb = B / 1.732
cc = cb * 3
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare il perimetro di un triangolo equilatero sapendo la misura dell'altezza"
LOCATE 5, 1: PRINT B; ":"; "1,732"; " = "; cb
LOCATE 7, 1: PRINT cb; "·"; "3"; "="; cc
ca = 0: C = 0: cb = 0: cc = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondort
CASE ELSE
GOSUB Sfondort
END SELECT
END SUB

