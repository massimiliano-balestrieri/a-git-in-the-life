DEFINT A-Z
'declarations
DECLARE SUB trirett ()
' Runprogram
  trirett
END

SUB trirett
Sfondort:
COLOR 15, 1: CLS
'titolo
LOCATE 2, 13: PRINT " PITAGORA : RISOLUZIONI PROBLEMI SUI TRIANGOLI RETTANGOLI"
FINESTRA1RT:
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
PRESENTAZIONE1RT:
COLOR 14, 3: LOCATE 5, 6: PRINT " I"
COLOR 15, 3: LOCATE 5, 8: PRINT "POTESI                    "
a$ = " 1: Ipotenusa    "
b$ = " 2: Altezza (Ipo)"
c$ = " 3: Cateto 1     "
d$ = " 4: Cateto 2     "
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
FINESTRA2RT:
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
presentazione2RT:
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
finestra3RT:
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
PRESENTAZIONE3RT:
COLOR 14, 3: LOCATE 16, 23: PRINT " V"
COLOR 15, 3: LOCATE 16, 25: PRINT "ISUAL                          "
da$ = " VISUALIZAZIONE PROBLEMI         "
db$ = " MENU PRINCIPALE                 "
LOCATE 18, 23: PRINT da$
LOCATE 20, 23: PRINT db$
LOCATE 19, 23: PRINT TAB(56);
LOCATE 21, 23: PRINT TAB(56);
cur1triprt:
COLOR 0, 3
LOCATE 7, 6: PRINT a$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 9, 6: PRINT c$
LOCATE 10, 6: PRINT d$
LOCATE 11, 6: PRINT e$
LOCATE 12, 6: PRINT f$
GOSUB SHOW1TRIPrt
CUR2TRIPrt:
COLOR 0, 3
LOCATE 8, 6: PRINT b$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 9, 6: PRINT c$
GOSUB SHOW2TRIPrt
CUR3TRIPrt:
COLOR 0, 3
LOCATE 9, 6: PRINT c$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 10, 6: PRINT d$
GOSUB SHOW3TRIPrt
CUR4TRIPrt:
COLOR 0, 3
LOCATE 10, 6: PRINT d$
COLOR 15, 3
LOCATE 9, 6: PRINT c$
LOCATE 11, 6: PRINT e$
GOSUB SHOW4TRIPrt
CUR5TRIPrt:
COLOR 0, 3
LOCATE 11, 6: PRINT e$
COLOR 15, 3
LOCATE 10, 6: PRINT d$
LOCATE 12, 6: PRINT f$
GOSUB show5triprt
CUR6TRIPrt:
COLOR 0, 3
LOCATE 12, 6: PRINT f$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 11, 6: PRINT e$
GOSUB sHOW6TRIPrt
SHOW1TRIPrt:
DO
N$ = INKEY$
LOOP UNTIL N$ <> ""
SELECT CASE N$
CASE CHR$(0) + "H"
GOSUB CUR6TRIPrt
CASE CHR$(0) + "P"
GOSUB CUR2TRIPrt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 6: PRINT a$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 7, 24: INPUT "", a: LOCATE 7, 32: PRINT G$
GOSUB CUR1TRIPrt2
CASE ELSE
BEEP: GOSUB cur1triprt
END SELECT
SHOW2TRIPrt:
DO
M$ = INKEY$
LOOP UNTIL M$ <> ""
SELECT CASE M$
CASE CHR$(0) + "H"
GOSUB cur1triprt
CASE CHR$(0) + "P"
GOSUB CUR3TRIPrt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 6: PRINT b$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 8, 24: INPUT "", b: LOCATE 8, 32: PRINT G$
GOSUB SHOW2TRIPrt2
CASE ELSE
BEEP: GOSUB CUR2TRIPrt
END SELECT
SHOW3TRIPrt:
DO
O$ = INKEY$
LOOP UNTIL O$ <> ""
SELECT CASE O$
CASE CHR$(0) + "H"
GOSUB CUR2TRIPrt
CASE CHR$(0) + "P"
GOSUB CUR4TRIPrt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 6: PRINT c$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 9, 24: INPUT "", c: LOCATE 9, 32: PRINT G$
GOSUB SHOW3TRIPrt2
CASE ELSE
BEEP: GOSUB CUR3TRIPrt
END SELECT
SHOW4TRIPrt:
DO
p$ = INKEY$
LOOP UNTIL p$ <> ""
SELECT CASE p$
CASE CHR$(0) + "H"
GOSUB CUR3TRIPrt
CASE CHR$(0) + "P"
GOSUB CUR5TRIPrt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 6: PRINT d$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 10, 24: INPUT "", d: LOCATE 10, 32: PRINT G$
GOSUB SHOW4TRIPrt2
CASE ELSE
BEEP: GOSUB SHOW4TRIPrt
END SELECT
show5triprt:
DO
R$ = INKEY$
LOOP UNTIL R$ <> ""
SELECT CASE R$
CASE CHR$(0) + "H"
GOSUB CUR4TRIPrt
CASE CHR$(0) + "P"
GOSUB CUR6TRIPrt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 6: PRINT e$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 11, 24: INPUT "", e: LOCATE 11, 32: PRINT G$
GOSUB SHOW5TRIPrt2
CASE ELSE
BEEP: GOSUB show5triprt
END SELECT
sHOW6TRIPrt:
DO
S$ = INKEY$
LOOP UNTIL S$ <> ""
SELECT CASE S$
CASE CHR$(0) + "H"
GOSUB CUR5TRIPrt
CASE CHR$(0) + "P"
GOSUB cur1triprt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 12, 6: PRINT f$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 12, 24: INPUT "", f: LOCATE 12, 32: PRINT G$
GOSUB SHOW6TRIPrt2
CASE ELSE
BEEP: GOSUB sHOW6TRIPrt
END SELECT
CUR1TRIPrt2:
COLOR 0, 3
LOCATE 7, 6: PRINT a$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 9, 6: PRINT c$
LOCATE 10, 6: PRINT d$
LOCATE 11, 6: PRINT e$
LOCATE 12, 6: PRINT f$
GOSUB SHOW1TRIPrt2
CUR2TRIPrt2:
COLOR 0, 3
LOCATE 8, 6: PRINT b$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 9, 6: PRINT c$
GOSUB SHOW2TRIPrt2
CUR3TRIPrt2:
COLOR 0, 3
LOCATE 9, 6: PRINT c$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 10, 6: PRINT d$
GOSUB SHOW3TRIPrt2
CUR4TRIPrt2:
COLOR 0, 3
LOCATE 10, 6: PRINT d$
COLOR 15, 3
LOCATE 9, 6: PRINT c$
LOCATE 11, 6: PRINT e$
GOSUB SHOW4TRIPrt2
CUR5TRIPrt2:
COLOR 0, 3
LOCATE 11, 6: PRINT e$
COLOR 15, 3
LOCATE 10, 6: PRINT d$
LOCATE 12, 6: PRINT f$
GOSUB SHOW5TRIPrt2
CUR6TRIPrt2:
COLOR 0, 3
LOCATE 12, 6: PRINT f$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 11, 6: PRINT e$
GOSUB SHOW6TRIPrt2
SHOW1TRIPrt2:
DO
t$ = INKEY$
LOOP UNTIL t$ <> ""
SELECT CASE t$
CASE CHR$(0) + "H"
GOSUB CUR6TRIPrt2
CASE CHR$(0) + "P"
GOSUB CUR2TRIPrt2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 6: PRINT a$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 7, 24: PRINT l$: LOCATE 7, 32: PRINT H$
GOSUB cur1triprt
CASE ELSE
BEEP: GOSUB CUR1TRIPrt2
END SELECT
SHOW2TRIPrt2:
DO
U$ = INKEY$
LOOP UNTIL U$ <> ""
SELECT CASE U$
CASE CHR$(0) + "H"
GOSUB CUR1TRIPrt2
CASE CHR$(0) + "P"
GOSUB CUR3TRIPrt2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 6: PRINT b$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 8, 24: PRINT l$: LOCATE 8, 32: PRINT H$
GOSUB CUR2TRIPrt
CASE ELSE
BEEP: GOSUB CUR2TRIPrt2
END SELECT
SHOW3TRIPrt2:
DO
V$ = INKEY$
LOOP UNTIL V$ <> ""
SELECT CASE V$
CASE CHR$(0) + "H"
GOSUB CUR2TRIPrt2
CASE CHR$(0) + "P"
GOSUB CUR4TRIPrt2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 6: PRINT c$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 9, 24: PRINT l$: LOCATE 9, 32: PRINT H$
GOSUB CUR3TRIPrt
CASE ELSE
BEEP: GOSUB CUR3TRIPrt2
END SELECT
SHOW4TRIPrt2:
DO
Z$ = INKEY$
LOOP UNTIL Z$ <> ""
SELECT CASE Z$
CASE CHR$(0) + "H"
GOSUB CUR3TRIPrt2
CASE CHR$(0) + "P"
GOSUB CUR5TRIPrt2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 6: PRINT d$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 10, 24: PRINT l$: LOCATE 10, 32: PRINT H$
GOSUB CUR4TRIPrt
CASE ELSE
BEEP: GOSUB CUR4TRIPrt2
END SELECT
SHOW5TRIPrt2:
DO
aa$ = INKEY$
LOOP UNTIL aa$ <> ""
SELECT CASE aa$
CASE CHR$(0) + "H"
GOSUB CUR4TRIPrt2
CASE CHR$(0) + "P"
GOSUB CUR6TRIPrt2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 6: PRINT e$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 11, 24: PRINT l$: LOCATE 11, 32: PRINT H$
GOSUB CUR5TRIPrt
CASE ELSE
BEEP: GOSUB CUR5TRIPrt2
END SELECT
SHOW6TRIPrt2:
DO
ab$ = INKEY$
LOOP UNTIL ab$ <> ""
SELECT CASE ab$
CASE CHR$(0) + "H"
GOSUB CUR5TRIPrt2
CASE CHR$(0) + "P"
GOSUB CUR1TRIPrt2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 12, 6: PRINT f$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 12, 24: PRINT l$: LOCATE 12, 32: PRINT H$
GOSUB CUR6TRIPrt
CASE ELSE
BEEP: GOSUB CUR6TRIPrt2
END SELECT
CUR1TRTErt:
COLOR 0, 3
LOCATE 7, 46: PRINT a$
COLOR 15, 3
LOCATE 12, 46: PRINT f$
LOCATE 8, 46: PRINT b$
GOSUB show1trtert
CUR2TRTErt:
COLOR 0, 3
LOCATE 8, 46: PRINT b$
COLOR 15, 3
LOCATE 7, 46: PRINT a$
LOCATE 9, 46: PRINT c$
GOSUB SHOW2TRTErt
CUR3TRTErt:
COLOR 0, 3
LOCATE 9, 46: PRINT c$
COLOR 15, 3
LOCATE 8, 46: PRINT b$
LOCATE 10, 46: PRINT d$
GOSUB SHOW3TRTErt
CUR4TRTErt:
COLOR 0, 3
LOCATE 10, 46: PRINT d$
COLOR 15, 3
LOCATE 9, 46: PRINT c$
LOCATE 11, 46: PRINT e$
GOSUB SHOW4TRTErt
CUR5TRTErt:
COLOR 0, 3
LOCATE 11, 46: PRINT e$
COLOR 15, 3
LOCATE 10, 46: PRINT d$
LOCATE 12, 46: PRINT f$
GOSUB SHOW5TRTErt
CUR6trtert:
COLOR 0, 3
LOCATE 12, 46: PRINT f$
COLOR 15, 3
LOCATE 7, 46: PRINT a$
LOCATE 11, 46: PRINT e$
GOSUB SHOW6TRTErt
show1trtert:
DO
bb$ = INKEY$
LOOP UNTIL bb$ <> ""
SELECT CASE bb$
CASE CHR$(0) + "H"
GOSUB CUR6trtert
CASE CHR$(0) + "P"
GOSUB CUR2TRTErt
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 7, 46: PRINT a$
GOSUB cur1triprt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 46: PRINT a$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB iptrrt
CASE ELSE
BEEP: GOSUB CUR1TRTErt
END SELECT
SHOW2TRTErt:
DO
bc$ = INKEY$
LOOP UNTIL bc$ <> ""
SELECT CASE bc$
CASE CHR$(0) + "H"
GOSUB CUR1TRTErt
CASE CHR$(0) + "P"
GOSUB CUR3TRTErt
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 8, 46: PRINT b$
GOSUB cur1triprt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 46: PRINT b$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB alTRrt
CASE ELSE
BEEP: GOSUB CUR2TRTErt
END SELECT
SHOW3TRTErt:
DO
bd$ = INKEY$
LOOP UNTIL bd$ <> ""
SELECT CASE bd$
CASE CHR$(0) + "H"
GOSUB CUR2TRTErt
CASE CHR$(0) + "P"
GOSUB CUR4TRTErt
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 9, 46: PRINT c$
GOSUB cur1triprt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 46: PRINT c$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB ca1trrt
CASE ELSE
BEEP: GOSUB CUR3TRTErt
END SELECT
SHOW4TRTErt:
DO
be$ = INKEY$
LOOP UNTIL be$ <> ""
SELECT CASE be$
CASE CHR$(0) + "H"
GOSUB CUR3TRTErt
CASE CHR$(0) + "P"
GOSUB CUR5TRTErt
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 10, 46: PRINT d$
GOSUB cur1triprt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 46: PRINT d$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB ca2trrt
CASE ELSE
BEEP: GOSUB CUR4TRTErt
END SELECT
SHOW5TRTErt:
DO
BF$ = INKEY$
LOOP UNTIL BF$ <> ""
SELECT CASE BF$
CASE CHR$(0) + "H"
GOSUB CUR4TRTErt
CASE CHR$(0) + "P"
GOSUB CUR6trtert
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 11, 46: PRINT e$
GOSUB cur1triprt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 46: PRINT e$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB prtrrt
CASE ELSE
BEEP: GOSUB CUR5TRTErt
END SELECT
SHOW6TRTErt:
DO
BG$ = INKEY$
LOOP UNTIL BG$ <> ""
SELECT CASE BG$
CASE CHR$(0) + "H"
GOSUB CUR5TRTErt
CASE CHR$(0) + "P"
GOSUB CUR1TRTErt
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 12, 46: PRINT f$
GOSUB cur1triprt
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 12, 46: PRINT f$
GOSUB CUR1TRVIrt
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB artrrt
CASE ELSE
BEEP: GOSUB CUR6trtert
END SELECT
CUR1TRVIrt:
COLOR 0, 3
LOCATE 18, 23: PRINT da$
COLOR 15, 3
LOCATE 20, 23: PRINT db$
GOSUB show1trVIrt
CUR2TRVIrt:
COLOR 0, 3
LOCATE 20, 23: PRINT db$
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB SHOW2TRVIrt
show1trVIrt:
DO
de$ = INKEY$
LOOP UNTIL de$ <> ""
SELECT CASE de$
CASE CHR$(0) + "H"
GOSUB CUR2TRVIrt
CASE CHR$(0) + "P"
GOSUB CUR2TRVIrt
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB cur1triprt
CASE CHR$(27)
END
CASE CHR$(13)
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB CUR1TRTErt
END SELECT
SHOW2TRVIrt:
DO
DF$ = INKEY$
LOOP UNTIL DF$ <> ""
SELECT CASE DF$
CASE CHR$(0) + "H"
GOSUB CUR1TRVIrt
CASE CHR$(0) + "P"
GOSUB CUR1TRVIrt
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 20, 23: PRINT db$
GOSUB cur1triprt
CASE CHR$(27)
END
CASE CHR$(13)
RUN "pit"
CASE ELSE
BEEP: GOSUB CUR2TRVIrt
END SELECT
iptrrt:
IF b > 0 AND f > 0 THEN GOSUB ipTRrt1
IF c > 0 AND f > 0 THEN GOSUB ipTRrt2
IF c > 0 AND d > 0 THEN GOSUB ipTRrt3
IF d > 0 AND f > 0 THEN GOSUB ipTRrt4
GOSUB ertrrt
alTRrt:
IF a > 0 AND f > 0 THEN GOSUB alTRrt1
IF c > 0 AND d > 0 THEN GOSUB alTRrt2
IF a > 0 AND c > 0 THEN GOSUB altrrt3
IF a > 0 AND d > 0 THEN GOSUB alTRrt4
IF c > 0 AND f > 0 THEN GOSUB alTRrt5
IF d > 0 AND f > 0 THEN GOSUB alTRrt6
GOSUB ertrrt
ca1trrt:
IF a > 0 AND b > 0 THEN GOSUB ca1TRrt1
IF a > 0 AND d > 0 THEN GOSUB ca1TRrt2
IF a > 0 AND f > 0 THEN GOSUB ca1TRrt3
IF b > 0 AND f > 0 THEN GOSUB ca1trrt4
IF d > 0 AND f > 0 THEN GOSUB ca1TRrt5
GOSUB ertrrt
ca2trrt:
IF a > 0 AND b > 0 THEN GOSUB ca2TRrt1
IF a > 0 AND c > 0 THEN GOSUB ca2TRrt2
IF a > 0 AND f > 0 THEN GOSUB ca2TRrt3
IF b > 0 AND f > 0 THEN GOSUB ca2tRrt4
IF c > 0 AND f > 0 THEN GOSUB ca2TRrt5
GOSUB ertrrt
prtrrt:
IF a > 0 AND c > 0 THEN GOSUB prtrrt1
IF a > 0 AND d > 0 THEN GOSUB prTRrt2
IF c > 0 AND d > 0 THEN GOSUB prTRrt3
IF c > 0 AND f > 0 THEN GOSUB prTRrt4
IF d > 0 AND f > 0 THEN GOSUB prTRrt5
GOSUB ertrrt
artrrt:
IF a > 0 AND b > 0 THEN GOSUB arTRrt1
IF a > 0 AND c > 0 THEN GOSUB arTRrt2
IF a > 0 AND d > 0 THEN GOSUB artrrt3
IF c > 0 AND d > 0 THEN GOSUB artrrt4
GOSUB ertrrt
ertrrt:
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
BEEP: GOSUB ertrrt
END SELECT
ipTRrt1:
aa = f * 2 / b
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'ipotenusa di un triangolo triangolo sapendo la misura dell'area e dell'altezza relativa all'ipotenusa"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; aa
aa = 0: f = 0: b = 0
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
ipTRrt2:
aa = f * 2 / c
ab = (c ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; c; "="; aa
LOCATE 7, 1: PRINT "√"; c; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: c = 0: f = 0
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
ipTRrt3:
ab = (c ^ 2) + (d ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura dei cateti"
LOCATE 5, 1: PRINT "√"; c; "²"; "+"; d; "²"; "="; "√"; ab; "="; ac
ab = 0: ac = 0: c = 0: d = 0
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
ipTRrt4:
aa = f * 2 / d
ab = (d ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; d; "="; aa
LOCATE 7, 1: PRINT "√"; d; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: d = 0: f = 0
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
alTRrt1:
ba = f * 2 / a
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
alTRrt2:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
altrrt3:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
alTRrt4:
aa = f * 2 / b
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'ipotenusa di un triangolo triangolo sapendo la misura dell'area e dell'altezza relativa all'ipotenusa"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; aa
aa = 0: f = 0: b = 0
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
alTRrt5:
aa = f * 2 / c
ab = (c ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; c; "="; aa
LOCATE 7, 1: PRINT "√"; c; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: c = 0: f = 0
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
alTRrt6:
ab = (c ^ 2) + (d ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura dei cateti"
LOCATE 5, 1: PRINT "√"; c; "²"; "+"; d; "²"; "="; "√"; ab; "="; ac
ab = 0: ac = 0: c = 0: d = 0
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
ca1TRrt1:
aa = f * 2 / d
ab = (d ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; d; "="; aa
LOCATE 7, 1: PRINT "√"; d; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: d = 0: f = 0
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
ca1TRrt2:
ba = f * 2 / a
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
ca1TRrt3:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
ca1trrt4:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
ca1TRrt5:
aa = f * 2 / b
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'ipotenusa di un triangolo triangolo sapendo la misura dell'area e dell'altezza relativa all'ipotenusa"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; aa
aa = 0: f = 0: b = 0
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
ca2TRrt1:
aa = f * 2 / c
ab = (c ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; c; "="; aa
LOCATE 7, 1: PRINT "√"; c; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: c = 0: f = 0
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
ca2TRrt2:
ab = (c ^ 2) + (d ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura dei cateti"
LOCATE 5, 1: PRINT "√"; c; "²"; "+"; d; "²"; "="; "√"; ab; "="; ac
ab = 0: ac = 0: c = 0: d = 0
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
ca2TRrt3:
aa = f * 2 / d
ab = (d ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; d; "="; aa
LOCATE 7, 1: PRINT "√"; d; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: d = 0: f = 0
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
ca2tRrt4:
ba = f * 2 / a
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
ca2TRrt5:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
prtrrt1:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
prTRrt2:
aa = f * 2 / b
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'ipotenusa di un triangolo triangolo sapendo la misura dell'area e dell'altezza relativa all'ipotenusa"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; b; "="; aa
aa = 0: f = 0: b = 0
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
prTRrt3:
aa = f * 2 / c
ab = (c ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; c; "="; aa
LOCATE 7, 1: PRINT "√"; c; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: c = 0: f = 0
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
prTRrt4:
ab = (c ^ 2) + (d ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura dei cateti"
LOCATE 5, 1: PRINT "√"; c; "²"; "+"; d; "²"; "="; "√"; ab; "="; ac
ab = 0: ac = 0: c = 0: d = 0
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
prTRrt5:
aa = f * 2 / d
ab = (d ^ 2) + (aa ^ 2)
ac = ab ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l' ipotenusa di un triangolo rettangolo sapendo la misura di un cateto e dell'area"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; d; "="; aa
LOCATE 7, 1: PRINT "√"; d; "²"; "+"; aa; "²"; "="; "√"; ab; "="; ac
aa = 0: ab = 0: ac = 0: d = 0: f = 0
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
arTRrt1:
ba = f * 2 / a
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
arTRrt2:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'area e dell'ipotenusa "
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
artrrt3:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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
artrrt4:
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza relativa all'ipotenusa di un triangolo rettangolo sapendo la misura dell'ipotenusa e di un cateto"
LOCATE 5, 1: PRINT "("; f; "·"; "2"; ")"; ":"; a; "="; ba
ba = 0: f = 0: a = 0
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

