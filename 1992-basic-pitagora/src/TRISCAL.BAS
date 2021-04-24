DEFINT A-Z
'declarations
DECLARE SUB triscal ()
' Runprogram
  CLS
  triscal
END

SUB triscal
Sfondo:
COLOR 15, 1: CLS
'titolo
LOCATE 2, 13: PRINT " PITAGORA : RISOLUZIONI PROBLEMI SUI TRIANGOLI SCALENI"
FINESTRA1:
COLOR 15, 3
FOR a = 1 TO 17: LOCATE 6, a + 5: PRINT CHR$(205): NEXT a
LOCATE 6, 23: PRINT CHR$(203): FOR a = 1 TO 7
LOCATE 6, a + 23: PRINT CHR$(205): NEXT a
LOCATE 6, 31: PRINT CHR$(203): FOR a = 1 TO 2: LOCATE 6, a + 31
PRINT CHR$(205): NEXT a
LOCATE 6, 34: PRINT CHR$(185): LOCATE 5, 34: PRINT CHR$(186)
LOCATE 4, 34: PRINT CHR$(187)
FOR a = 1 TO 28: LOCATE 4, a + 5: PRINT CHR$(205): NEXT a
LOCATE 4, 5: PRINT CHR$(201): LOCATE 5, 5: PRINT CHR$(186)
LOCATE 6, 5: PRINT CHR$(204)
FOR a = 1 TO 6: LOCATE a + 6, 5: PRINT CHR$(186): NEXT a
FOR a = 1 TO 6: LOCATE a + 6, 23: PRINT CHR$(186): NEXT a
FOR a = 1 TO 6: LOCATE a + 6, 34: PRINT CHR$(186): NEXT a
FOR a = 1 TO 6: LOCATE a + 6, 31: PRINT CHR$(186): NEXT a
LOCATE 13, 5: PRINT CHR$(200)
FOR a = 1 TO 17: LOCATE 13, a + 5: PRINT CHR$(205): NEXT a
LOCATE 13, 23: PRINT CHR$(202)
FOR a = 1 TO 10: LOCATE 13, a + 23: PRINT CHR$(205): NEXT a
LOCATE 13, 31: PRINT CHR$(202)
LOCATE 13, 34: PRINT CHR$(188)
PRESENTAZIONE1:
COLOR 14, 3: LOCATE 5, 6: PRINT " I"
COLOR 15, 3: LOCATE 5, 8: PRINT "POTESI                    "
a$ = " 1: Base         "
b$ = " 2: Altezza      "
c$ = " 3: Lato obliquo1"
d$ = " 4: Lato obliquo2"
e$ = " 5: Perimetro    "
f$ = " 6: Area         "
G$ = "SI"
H$ = "NO"
l$ = "       "
LOCATE 7, 6: PRINT a$
LOCATE 8, 6: PRINT b$
LOCATE 9, 6: PRINT c$
LOCATE 10, 6: PRINT d$
LOCATE 11, 6: PRINT e$
LOCATE 12, 6: PRINT f$
LOCATE 7, 24: PRINT l$: LOCATE 7, 32: PRINT H$
LOCATE 8, 24: PRINT l$: LOCATE 8, 32: PRINT H$
LOCATE 9, 24: PRINT l$: LOCATE 9, 32: PRINT H$
LOCATE 10, 24: PRINT l$: LOCATE 10, 32: PRINT H$
LOCATE 11, 24: PRINT l$: LOCATE 11, 32: PRINT H$
LOCATE 12, 24: PRINT l$: LOCATE 12, 32: PRINT H$
FINESTRA2:
FOR a = 1 TO 28: LOCATE 6, a + 45: PRINT CHR$(205): NEXT a
LOCATE 6, 73: PRINT CHR$(185): LOCATE 5, 73: PRINT CHR$(186)
LOCATE 4, 73: PRINT CHR$(187)
FOR a = 1 TO 27: LOCATE 4, a + 45: PRINT CHR$(205): NEXT a
LOCATE 4, 45: PRINT CHR$(201): LOCATE 5, 45: PRINT CHR$(186)
LOCATE 6, 45: PRINT CHR$(204)
FOR a = 1 TO 6: LOCATE a + 6, 45: PRINT CHR$(186): NEXT a
FOR a = 1 TO 6: LOCATE a + 6, 73: PRINT CHR$(186): NEXT a
LOCATE 13, 45: PRINT CHR$(200)
FOR a = 1 TO 28: LOCATE 13, a + 45: PRINT CHR$(205): NEXT a
LOCATE 13, 73: PRINT CHR$(188)
presentazione2:
COLOR 14, 3: LOCATE 5, 46: PRINT " T"
COLOR 15, 3: LOCATE 5, 48: PRINT "ESI                      "
LOCATE 7, 46: PRINT a$
LOCATE 7, 63: PRINT SPACE$(10)
LOCATE 8, 46: PRINT b$
LOCATE 8, 63: PRINT SPACE$(10)
LOCATE 9, 46: PRINT c$
LOCATE 9, 63: PRINT SPACE$(10)
LOCATE 10, 46: PRINT d$
LOCATE 10, 63: PRINT SPACE$(10)
LOCATE 11, 46: PRINT e$
LOCATE 11, 63: PRINT SPACE$(10)
LOCATE 12, 46: PRINT f$
LOCATE 12, 63: PRINT SPACE$(10)
finestra3:
FOR a = 1 TO 34: LOCATE 17, a + 22: PRINT CHR$(205): NEXT a
LOCATE 17, 56: PRINT CHR$(185)
LOCATE 16, 56: PRINT CHR$(186): LOCATE 15, 56: PRINT CHR$(187)
FOR a = 1 TO 33: LOCATE 15, a + 22: PRINT CHR$(205): NEXT a
LOCATE 15, 22: PRINT CHR$(201): LOCATE 16, 22: PRINT CHR$(186)
LOCATE 17, 22: PRINT CHR$(204)
FOR a = 1 TO 4
   LOCATE a + 17, 22: PRINT CHR$(186)
   LOCATE a + 17, 56: PRINT CHR$(186)
NEXT a
LOCATE 22, 22: PRINT CHR$(200)
FOR a = 1 TO 34: LOCATE 22, a + 22: PRINT CHR$(205): NEXT a
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
LOCATE 7, 6: PRINT a$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 9, 6: PRINT c$
LOCATE 10, 6: PRINT d$
LOCATE 11, 6: PRINT e$
LOCATE 12, 6: PRINT f$
GOSUB SHOW1TRIP
CUR2TRIP:
COLOR 0, 3
LOCATE 8, 6: PRINT b$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 9, 6: PRINT c$
GOSUB SHOW2TRIP
CUR3TRIP:
COLOR 0, 3
LOCATE 9, 6: PRINT c$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 10, 6: PRINT d$
GOSUB SHOW3TRIP
CUR4TRIP:
COLOR 0, 3
LOCATE 10, 6: PRINT d$
COLOR 15, 3
LOCATE 9, 6: PRINT c$
LOCATE 11, 6: PRINT e$
GOSUB SHOW4TRIP
CUR5TRIP:
COLOR 0, 3
LOCATE 11, 6: PRINT e$
COLOR 15, 3
LOCATE 10, 6: PRINT d$
LOCATE 12, 6: PRINT f$
GOSUB show5trip
CUR6TRIP:
COLOR 0, 3
LOCATE 12, 6: PRINT f$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 11, 6: PRINT e$
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
LOCATE 7, 6: PRINT a$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 7, 24: INPUT "", a: LOCATE 7, 32: PRINT G$
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
LOCATE 8, 6: PRINT b$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 8, 24: INPUT "", b: LOCATE 8, 32: PRINT G$
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
LOCATE 9, 6: PRINT c$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 9, 24: INPUT "", c: LOCATE 9, 32: PRINT G$
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
LOCATE 10, 6: PRINT d$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 10, 24: INPUT "", d: LOCATE 10, 32: PRINT G$
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
LOCATE 11, 6: PRINT e$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 11, 24: INPUT "", e: LOCATE 11, 32: PRINT G$
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
LOCATE 12, 6: PRINT f$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 12, 24: INPUT "", f: LOCATE 12, 32: PRINT G$
GOSUB SHOW6TRIP2
CASE ELSE
BEEP: GOSUB sHOW6TRIP
END SELECT
CUR1TRIP2:
COLOR 0, 3
LOCATE 7, 6: PRINT a$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 9, 6: PRINT c$
LOCATE 10, 6: PRINT d$
LOCATE 11, 6: PRINT e$
LOCATE 12, 6: PRINT f$
GOSUB SHOW1TRIP2
CUR2TRIP2:
COLOR 0, 3
LOCATE 8, 6: PRINT b$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 9, 6: PRINT c$
GOSUB SHOW2TRIP2
CUR3TRIP2:
COLOR 0, 3
LOCATE 9, 6: PRINT c$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 10, 6: PRINT d$
GOSUB SHOW3TRIP2
CUR4TRIP2:
COLOR 0, 3
LOCATE 10, 6: PRINT d$
COLOR 15, 3
LOCATE 9, 6: PRINT c$
LOCATE 11, 6: PRINT e$
GOSUB SHOW4TRIP2
CUR5TRIP2:
COLOR 0, 3
LOCATE 11, 6: PRINT e$
COLOR 15, 3
LOCATE 10, 6: PRINT d$
LOCATE 12, 6: PRINT f$
GOSUB SHOW5TRIP2
CUR6TRIP2:
COLOR 0, 3
LOCATE 12, 6: PRINT f$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 11, 6: PRINT e$
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
LOCATE 7, 6: PRINT a$
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
LOCATE 8, 6: PRINT b$
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
LOCATE 9, 6: PRINT c$
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
LOCATE 10, 6: PRINT d$
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
LOCATE 11, 6: PRINT e$
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
LOCATE 12, 6: PRINT f$
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
LOCATE 7, 46: PRINT a$
COLOR 15, 3
LOCATE 12, 46: PRINT f$
LOCATE 8, 46: PRINT b$
GOSUB show1trte
CUR2TRTE:
COLOR 0, 3
LOCATE 8, 46: PRINT b$
COLOR 15, 3
LOCATE 7, 46: PRINT a$
LOCATE 9, 46: PRINT c$
GOSUB SHOW2TRTE
CUR3TRTE:
COLOR 0, 3
LOCATE 9, 46: PRINT c$
COLOR 15, 3
LOCATE 8, 46: PRINT b$
LOCATE 10, 46: PRINT d$
GOSUB SHOW3TRTE
CUR4TRTE:
COLOR 0, 3
LOCATE 10, 46: PRINT d$
COLOR 15, 3
LOCATE 9, 46: PRINT c$
LOCATE 11, 46: PRINT e$
GOSUB SHOW4TRTE
CUR5TRTE:
COLOR 0, 3
LOCATE 11, 46: PRINT e$
COLOR 15, 3
LOCATE 10, 46: PRINT d$
LOCATE 12, 46: PRINT f$
GOSUB SHOW5TRTE
CUR6trte:
COLOR 0, 3
LOCATE 12, 46: PRINT f$
COLOR 15, 3
LOCATE 7, 46: PRINT a$
LOCATE 11, 46: PRINT e$
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
LOCATE 7, 46: PRINT a$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 46: PRINT a$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB batrSC
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
LOCATE 8, 46: PRINT b$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 46: PRINT b$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB ALTRSC
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
LOCATE 9, 46: PRINT c$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 46: PRINT c$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB LO1TRSC
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
LOCATE 10, 46: PRINT d$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 46: PRINT d$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB LO2TRSC
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
LOCATE 11, 46: PRINT e$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 46: PRINT e$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB PRTRSC
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
LOCATE 12, 46: PRINT f$
GOSUB cur1trip
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 12, 46: PRINT f$
GOSUB CUR1TRVI
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB ARTRSC
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
batrSC:
IF b > 0 AND f > 0 THEN GOSUB bATRSC1
IF b > 0 AND c > 0 AND d > 0 AND c > b AND d > b THEN GOSUB BATRSC2
IF c > 0 AND d > 0 AND e > 0 THEN GOSUB BATRSC3
IF a = 0 AND b = 0 AND c = 0 AND d = 0 AND e = 0 AND f = 0 THEN GOSUB trscer
GOSUB trscer
ALTRSC:
IF a > 0 AND f > 0 THEN GOSUB altrsc1
IF c > 0 AND d > 0 AND e > 0 AND f > 0 THEN GOSUB ALTRSC2
GOSUB trscer
LO1TRSC:
IF a > 0 AND d > 0 AND e > 0 THEN GOSUB LO1trsc1
IF a > 0 AND b > 0 AND d > 0 THEN GOSUB LO1TRSC2
IF b > 0 AND d > 0 AND f > 0 THEN GOSUB lo1trsc3
GOSUB trscer
LO2TRSC:
IF a > 0 AND c > 0 AND e > 0 THEN GOSUB LO2trsc1
IF a > 0 AND b > 0 AND c > 0 THEN GOSUB LO2TRSC2
IF b > 0 AND c > 0 AND f > 0 THEN GOSUB lo2trsc3
PRTRSC:
IF a > 0 AND b > 0 AND c > 0 THEN GOSUB prtrsc1
IF a > 0 AND b > 0 AND d > 0 THEN GOSUB prtrsc2
IF a > 0 AND c > 0 AND d > 0 THEN GOSUB prtrsc3
IF a > 0 AND c > 0 AND f > 0 THEN GOSUB prtrsc4
IF a > 0 AND d > 0 AND f > 0 THEN GOSUB prtrsc5
IF b > 0 AND d > 0 AND f > 0 THEN GOSUB prtrsc6
IF b > 0 AND c > 0 AND f > 0 THEN GOSUB prtrsc7
GOSUB trscer
ARTRSC:
IF b > 0 AND c > 0 AND d > 0 THEN GOSUB artrsc2
IF a > 0 AND b > 0 THEN GOSUB ARTRSC1
GOSUB trscer
trscer:
COLOR 31, 3
LOCATE 14, 15: PRINT "IL PROBLEMA E` IMPOSSIBILE O C'E` GIA` LA SOLUZIONE"
COLOR 15, 1
LOCATE 23, 1: PRINT "Premi ENTER per continuare"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(13)
GOSUB Sfondo
CASE ELSE
BEEP: GOSUB trscer
END SELECT
bATRSC1:
aa = f * 2 / b
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare la base di un triangolo scaleno sapendo la misura dell'area e dell'altezza"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; aa
aa = 0: f = 0: b = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
BATRSC2:
IF b > c AND b > d THEN GOSUB trscer2
aa = (c ^ 2) - (b ^ 2)
ab = aa ^ (1 / 2)
ac = (d ^ 2) - (b ^ 2)
Ad = ac ^ (1 / 2)
aE = ab + Ad
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare la base di un triangolo scaleno sapendo la misura dei lati obliqui e dell'altezza"
LOCATE 5, 1: PRINT "√"; c; "²"; "-"; b; "²"; "="; "√"; aa; "="; ab
LOCATE 7, 1: PRINT "√"; d; "²"; "-"; b; "²"; "="; "√"; ac; "="; Ad
LOCATE 9, 1: PRINT ab; "+"; Ad; "="; aE
aE = 0: ab = 0: ac = 0: aa = 0: Ad = 0: c = 0: d = 0: b = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
BATRSC3:
aa = c + d
ab = e - aa
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare la base di un triangolo scaleno sapendo la misura dei lati obliqui e del perimetro"
LOCATE 5, 1: PRINT c; "+"; d; "="; aa
LOCATE 7, 1: PRINT e; "-"; aa; "="; ab
aa = 0: ab = 0: c = 0: d = 0: e = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
altrsc1:
ba = f * 2 / a
COLOR 15, 3: CLS
PRINT "Trovare l'altezza di un triangolo scaleno sapendo la misura della base e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: a = 0: f = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
ALTRSC2:
ba = e - (c + d)
bb = f * 2 / ba
COLOR 15, 3: CLS
PRINT "Trovare l'altezza  di un triangolo scaleno sapendo la misura dei lati obliqui il perimetro e l'area"
LOCATE 5, 1: PRINT e; "-"; "("; c; "+"; d; ")"; "="; ba
LOCATE 7, 1: PRINT "("; f; "·"; 2; ")"; ":"; b; "="; bb
c = 0: e = 0: d = 0: bb = 0: f = 0: ba = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
LO1trsc1:
ca = e - (a + d)
COLOR 15, 3: CLS
PRINT "Trovare un lato obliquo di un triangolo scaleno sapendo la misura del perimetro della base e dell'altro lato obliquo"
LOCATE 5, 1: PRINT e; "-"; "("; a; "+"; d; ")"; "="; ca
ca = 0: e = 0: d = 0: a = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
LO1TRSC2:
IF b > d THEN GOSUB trscer2
ea = (d ^ 2) - (b ^ 2)
eb = ea ^ (1 / 2)
ec = a - eb
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
COLOR 15, 3: CLS
PRINT "Trovare un lato obliquo di un triangolo scaleno sapendo la misura della base dell'altro lato obliquo e dell'altezza e l'area"
LOCATE 5, 1: PRINT "√"; d; "²"; "-"; b; "²"; "="; "√"; ea; "="; eb
LOCATE 7, 1: PRINT a; "-"; eb; "="; ec
LOCATE 9, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
a = 0: c = 0: ee = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
lo1trsc3:
IF b > d THEN GOSUB trscer2
ea = f * 2 / b
eb = (d ^ 2) - (b ^ 2)
eba = eb ^ (1 / 2)
ec = ea - eba
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
COLOR 15, 3: CLS
PRINT "Trovare un lato obliquo di un triangolo scaleno sapendo la misura dell'altro lato obliquo dell'altezza e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; ea
LOCATE 7, 1: PRINT "√"; d; "²"; "-"; ea; "²"; "="; "√"; eb; "="; eba
LOCATE 9, 1: PRINT ea; "-"; eba; "="; ec
LOCATE 11, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
a = 0: d = 0: e = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0: eba = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
LO2trsc1:
da = e - (a + c)
COLOR 15, 3: CLS
PRINT "Trovare un lato obliquo di un triangolo scaleno sapendo la misura del perimetro della base e dell'altro lato obliquo"
LOCATE 5, 1: PRINT e; "-"; "("; a; "+"; c; ")"; "="; da
c = 0: e = 0: da = 0: a = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
LO2TRSC2:
IF b > c THEN GOSUB trscer2
ea = (c ^ 2) - (b ^ 2)
eb = ea ^ (1 / 2)
ec = a - eb
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
COLOR 15, 3: CLS
PRINT "Trovare un lato obliquo di un triangolo scaleno sapendo la misura della base dell'altro lato obliquo e dell'altezza e l'area"
LOCATE 5, 1: PRINT "√"; c; "²"; "-"; b; "²"; "="; "√"; ea; "="; eb
LOCATE 7, 1: PRINT a; "-"; eb; "="; ec
LOCATE 9, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
a = 0: c = 0: ee = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
lo2trsc3:
IF b > c THEN GOSUB trscer2
ea = f * 2 / b
eb = (c ^ 2) - (b ^ 2)
eba = eb ^ (1 / 2)
ec = ea - eba
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
COLOR 15, 3: CLS
PRINT "Trovare un lato obliquo di un triangolo scaleno sapendo la misura dell'altro lato obliquo e dell'altezza e della base"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; ea
LOCATE 7, 1: PRINT "√"; c; "²"; "-"; ea; "²"; "="; "√"; eb; "="; eba
LOCATE 9, 1: PRINT ea; "-"; eba; "="; ec
LOCATE 11, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
a = 0: c = 0: ee = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0:  eba = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
prtrsc1:
IF b > c THEN GOSUB trscer2
ea = (c ^ 2) - (b ^ 2)
eb = ea ^ (1 / 2)
ec = a - eb
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
eF = a + c + ee
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo scaleno sapendo la misura della base di un lato obliquo e dell'altezza e l'area"
LOCATE 5, 1: PRINT "√"; c; "²"; "-"; b; "²"; "="; "√"; ea; "="; eb
LOCATE 7, 1: PRINT a; "-"; eb; "="; ec
LOCATE 9, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
LOCATE 11, 1: PRINT a; "+"; c; "+"; ee; "="; eF
a = 0: c = 0: eF = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
prtrsc2:
IF b > d THEN GOSUB trscer2
ea = (d ^ 2) - (b ^ 2)
eb = ea ^ (1 / 2)
ec = a - eb
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
eF = a + d + ee
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo scaleno sapendo la misura della base di un lato obliquo e dell'altezza e l'area"
LOCATE 5, 1: PRINT "√"; d; "²"; "-"; b; "²"; "="; "√"; ea; "="; eb
LOCATE 7, 1: PRINT a; "-"; eb; "="; ec
LOCATE 9, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
LOCATE 11, 1: PRINT a; "+"; d; "+"; ee; "="; eF
a = 0: c = 0: eF = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
prtrsc3:
ea = a + c + d
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo scaleno sapendo la misura dei lati"
LOCATE 5, 1: PRINT a; " + "; c; " + "; d; "="; ea
c = 0: ea = 0: d = 0: a = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
prtrsc4:
ea = f * 2 / a
IF ea > c THEN GOSUB trscer2
eb = (c ^ 2) - (ea ^ 2)
eba = eb ^ (1 / 2)
ec = a - eba
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
eF = a + c + ee
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo scaleno sapendo la misura della base di un lato obliquo e dell'altezza e l'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ea
LOCATE 7, 1: PRINT "√"; c; "²"; "-"; ea; "²"; "="; "√"; eb; "="; eba
LOCATE 9, 1: PRINT a; "-"; eba; "="; ec
LOCATE 11, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
LOCATE 13, 1: PRINT a; "+"; c; "+"; ee; "="; eF
a = 0: c = 0: eF = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0: eba = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
prtrsc5:
IF ea > d THEN GOSUB trscer2
ea = f * 2 / a
eb = (d ^ 2) - (ea ^ 2)
eba = eb ^ (1 / 2)
ec = a - eba
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
eF = a + d + ee
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo scaleno sapendo la misura della base di un lato obliquo e l'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ea
LOCATE 7, 1: PRINT "√"; d; "²"; "-"; ea; "²"; "="; "√"; eb; "="; eba
LOCATE 9, 1: PRINT a; "-"; eba; "="; ec
LOCATE 11, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
LOCATE 13, 1: PRINT a; "+"; d; "+"; ee; "="; eF
a = 0: d = 0: eF = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0: eba = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
prtrsc6:
IF b > d THEN GOSUB trscer2
ea = f * 2 / b
eb = (d ^ 2) - (b ^ 2)
eba = eb ^ (1 / 2)
ec = ea - eba
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
eF = a + d + ee
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo scaleno sapendo la misura di un lato obliquo e dell'altezza e l'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; ea
LOCATE 7, 1: PRINT "√"; d; "²"; "-"; b; "²"; "="; "√"; eb; "="; eba
LOCATE 9, 1: PRINT ea; "-"; eba; "="; ec
LOCATE 11, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
LOCATE 13, 1: PRINT a; "+"; d; "+"; ee; "="; eF
a = 0: d = 0: eF = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0: eba = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
prtrsc7:
IF b > c THEN GOSUB trscer2
ea = f * 2 / b
eb = (c ^ 2) - (b ^ 2)
eba = eb ^ (1 / 2)
ec = ea - eba
ed = (ec ^ 2) + (b ^ 2)
ee = ed ^ (1 / 2)
eF = a + c + ee
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo scaleno sapendo la misura di un lato obliquo e dell'altezza e l'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; ea
LOCATE 7, 1: PRINT "√"; c; "²"; "-"; ea; "²"; "="; "√"; eb; "="; eba
LOCATE 9, 1: PRINT ea; "-"; eba; "="; ec
LOCATE 11, 1: PRINT "√"; ec; "²"; "+"; b; "²"; "="; "√"; ed; "="; ee
LOCATE 13, 1: PRINT a; "+"; c; "+"; ee; "="; eF
a = 0: c = 0: eF = 0: b = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0: eba = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
ARTRSC1:
fA = a * b / 2
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'area di un triangolo scaleno sapendo la misura dell'altezza e dalla base"
LOCATE 5, 5: PRINT "("; a; "·"; b; ")"; ":"; "2"; "="; fA
a = 0: b = 0: fA = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
artrsc2:
IF b > c THEN GOSUB trscer2
aa = (c ^ 2) - (b ^ 2)
ab = aa ^ (1 / 2)
ac = (d ^ 2) - (b ^ 2)
Ad = ac ^ (1 / 2)
aE = ab + Ad
fA = aE * b / 2
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'area di un triangolo scaleno sapendo la misura dei lati obliqui e dell'altezza"
LOCATE 5, 1: PRINT "√"; c; "²"; "-"; b; "²"; "="; "√"; aa; "="; ab
LOCATE 7, 1: PRINT "√"; d; "²"; "-"; b; "²"; "="; "√"; ac; "="; Ad
LOCATE 9, 1: PRINT ab; "+"; Ad; "="; aE
LOCATE 11, 1: PRINT "("; aE; "·"; b; ")"; ":"; "2"; "="; fA
aE = 0: ab = 0: ac = 0: aa = 0: Ad = 0: c = 0: d = 0: b = 0: fA = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondo
CASE ELSE
GOSUB Sfondo
END SELECT
trscer2:
COLOR 31, 3
LOCATE 14, 15: PRINT "L'ALTEZZA NON PUO` ESSERE PIU GRANDE DEI LATI OBLIQUI"
COLOR 15, 1
LOCATE 23, 1: PRINT "Premi ENTER per continuare"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(13)
GOSUB Sfondo
CASE ELSE
BEEP: GOSUB trscer2
END SELECT

END SUB

