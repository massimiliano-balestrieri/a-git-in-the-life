DEFINT A-Z
'declarations
DECLARE SUB TRISOSC ()
' Runprogram
  TRISOSC
END

SUB TRISOSC
Sfondososc:
COLOR 15, 1: CLS
'titolo
LOCATE 2, 13: PRINT " PITAGORA : RISOLUZIONI PROBLEMI SUI TRIANGOLI ISOSCELI"
FINESTRA1sosc:
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
FOR a = 1 TO 5: LOCATE a + 6, 5: PRINT CHR$(186): NEXT a
FOR a = 1 TO 5: LOCATE a + 6, 23: PRINT CHR$(186): NEXT a
FOR a = 1 TO 5: LOCATE a + 6, 34: PRINT CHR$(186): NEXT a
FOR a = 1 TO 5: LOCATE a + 6, 31: PRINT CHR$(186): NEXT a
LOCATE 12, 5: PRINT CHR$(200)
FOR a = 1 TO 17: LOCATE 12, a + 5: PRINT CHR$(205): NEXT a
LOCATE 12, 23: PRINT CHR$(202)
FOR a = 1 TO 10: LOCATE 12, a + 23: PRINT CHR$(205): NEXT a
LOCATE 12, 31: PRINT CHR$(202)
LOCATE 12, 34: PRINT CHR$(188)
PRESENTAZIONE1sosc:
COLOR 14, 3: LOCATE 5, 6: PRINT " I"
COLOR 15, 3: LOCATE 5, 8: PRINT "POTESI                    "
a$ = " 1: Base         "
b$ = " 2: Altezza      "
c$ = " 3: Lato         "
d$ = " 4: Perimetro    "
e$ = " 5: Area         "
G$ = "SI"
H$ = "NO"
l$ = "       "
LOCATE 7, 6: PRINT a$
LOCATE 8, 6: PRINT b$
LOCATE 9, 6: PRINT c$
LOCATE 10, 6: PRINT d$
LOCATE 11, 6: PRINT e$
LOCATE 7, 24: PRINT l$: LOCATE 7, 32: PRINT H$
LOCATE 8, 24: PRINT l$: LOCATE 8, 32: PRINT H$
LOCATE 9, 24: PRINT l$: LOCATE 9, 32: PRINT H$
LOCATE 10, 24: PRINT l$: LOCATE 10, 32: PRINT H$
LOCATE 11, 24: PRINT l$: LOCATE 11, 32: PRINT H$
FINESTRA2sosc:
FOR a = 1 TO 28: LOCATE 6, a + 45: PRINT CHR$(205): NEXT a
LOCATE 6, 73: PRINT CHR$(185): LOCATE 5, 73: PRINT CHR$(186)
LOCATE 4, 73: PRINT CHR$(187)
FOR a = 1 TO 27: LOCATE 4, a + 45: PRINT CHR$(205): NEXT a
LOCATE 4, 45: PRINT CHR$(201): LOCATE 5, 45: PRINT CHR$(186)
LOCATE 6, 45: PRINT CHR$(204)
FOR a = 1 TO 5: LOCATE a + 6, 45: PRINT CHR$(186): NEXT a
FOR a = 1 TO 5: LOCATE a + 6, 73: PRINT CHR$(186): NEXT a
LOCATE 12, 45: PRINT CHR$(200)
FOR a = 1 TO 28: LOCATE 12, a + 45: PRINT CHR$(205): NEXT a
LOCATE 12, 73: PRINT CHR$(188)
presentazione2sosc:
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
finestra3sosc:
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
PRESENTAZIONE3sosc:
COLOR 14, 3: LOCATE 16, 23: PRINT " V"
COLOR 15, 3: LOCATE 16, 25: PRINT "ISUAL                          "
da$ = " VISUALIZAZIONE PROBLEMI         "
db$ = " MENU PRINCIPALE                 "
LOCATE 18, 23: PRINT da$
LOCATE 20, 23: PRINT db$
LOCATE 19, 23: PRINT TAB(56);
LOCATE 21, 23: PRINT TAB(56);
cur1trSO:
COLOR 0, 3
LOCATE 7, 6: PRINT a$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 9, 6: PRINT c$
LOCATE 10, 6: PRINT d$
LOCATE 11, 6: PRINT e$
GOSUB SHOW1TRso
CUR2TRSO:
COLOR 0, 3
LOCATE 8, 6: PRINT b$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 9, 6: PRINT c$
GOSUB SHOW2TRSO
CUR3TRSO:
COLOR 0, 3
LOCATE 9, 6: PRINT c$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 10, 6: PRINT d$
GOSUB SHOW3TRSO
CUR4TRSO:
COLOR 0, 3
LOCATE 10, 6: PRINT d$
COLOR 15, 3
LOCATE 9, 6: PRINT c$
LOCATE 11, 6: PRINT e$
GOSUB SHOW4TRSO
CUR5TRSO:
COLOR 0, 3
LOCATE 11, 6: PRINT e$
COLOR 15, 3
LOCATE 10, 6: PRINT d$
LOCATE 7, 6: PRINT a$
GOSUB show5trSO
SHOW1TRso:
DO
N$ = INKEY$
LOOP UNTIL N$ <> ""
SELECT CASE N$
CASE CHR$(0) + "H"
GOSUB CUR5TRSO
CASE CHR$(0) + "P"
GOSUB CUR2TRSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 6: PRINT a$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 7, 24: INPUT "", a: LOCATE 7, 32: PRINT G$
GOSUB CUR1TRSO2
CASE ELSE
BEEP: GOSUB cur1trSO
END SELECT
SHOW2TRSO:
DO
M$ = INKEY$
LOOP UNTIL M$ <> ""
SELECT CASE M$
CASE CHR$(0) + "H"
GOSUB cur1trSO
CASE CHR$(0) + "P"
GOSUB CUR3TRSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 6: PRINT b$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 8, 24: INPUT "", b: LOCATE 8, 32: PRINT G$
GOSUB SHOW2TRSO2
CASE ELSE
BEEP: GOSUB CUR2TRSO
END SELECT
SHOW3TRSO:
DO
O$ = INKEY$
LOOP UNTIL O$ <> ""
SELECT CASE O$
CASE CHR$(0) + "H"
GOSUB CUR2TRSO
CASE CHR$(0) + "P"
GOSUB CUR4TRSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 6: PRINT c$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 9, 24: INPUT "", c: LOCATE 9, 32: PRINT G$
GOSUB SHOW3TRSO2
CASE ELSE
BEEP: GOSUB CUR3TRSO
END SELECT
SHOW4TRSO:
DO
p$ = INKEY$
LOOP UNTIL p$ <> ""
SELECT CASE p$
CASE CHR$(0) + "H"
GOSUB CUR3TRSO
CASE CHR$(0) + "P"
GOSUB CUR5TRSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 6: PRINT d$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 10, 24: INPUT "", d: LOCATE 10, 32: PRINT G$
GOSUB SHOW4TRSO2
CASE ELSE
BEEP: GOSUB SHOW4TRSO
END SELECT
show5trSO:
DO
R$ = INKEY$
LOOP UNTIL R$ <> ""
SELECT CASE R$
CASE CHR$(0) + "H"
GOSUB CUR4TRSO
CASE CHR$(0) + "P"
GOSUB cur1trSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 6: PRINT e$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 11, 24: INPUT "", e: LOCATE 11, 32: PRINT G$
GOSUB SHOW5TRSO2
CASE ELSE
BEEP: GOSUB show5trSO
END SELECT
CUR1TRSO2:
COLOR 0, 3
LOCATE 7, 6: PRINT a$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 9, 6: PRINT c$
LOCATE 10, 6: PRINT d$
LOCATE 11, 6: PRINT e$
GOSUB SHOW1TRSO2
CUR2TRSO2:
COLOR 0, 3
LOCATE 8, 6: PRINT b$
COLOR 15, 3
LOCATE 7, 6: PRINT a$
LOCATE 9, 6: PRINT c$
GOSUB SHOW2TRSO2
CUR3TRSO2:
COLOR 0, 3
LOCATE 9, 6: PRINT c$
COLOR 15, 3
LOCATE 8, 6: PRINT b$
LOCATE 10, 6: PRINT d$
GOSUB SHOW3TRSO2
CUR4TRSO2:
COLOR 0, 3
LOCATE 10, 6: PRINT d$
COLOR 15, 3
LOCATE 9, 6: PRINT c$
LOCATE 11, 6: PRINT e$
GOSUB SHOW4TRSO2
CUR5TRSO2:
COLOR 0, 3
LOCATE 11, 6: PRINT e$
COLOR 15, 3
LOCATE 10, 6: PRINT d$
LOCATE 7, 6: PRINT a$
GOSUB SHOW5TRSO2
SHOW1TRSO2:
DO
t$ = INKEY$
LOOP UNTIL t$ <> ""
SELECT CASE t$
CASE CHR$(0) + "H"
GOSUB CUR5TRSO2
CASE CHR$(0) + "P"
GOSUB CUR2TRSO2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 6: PRINT a$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 7, 24: PRINT l$: LOCATE 7, 32: PRINT H$
GOSUB cur1trSO
CASE ELSE
BEEP: GOSUB CUR1TRSO2
END SELECT
SHOW2TRSO2:
DO
U$ = INKEY$
LOOP UNTIL U$ <> ""
SELECT CASE U$
CASE CHR$(0) + "H"
GOSUB CUR1TRSO2
CASE CHR$(0) + "P"
GOSUB CUR3TRSO2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 6: PRINT b$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 8, 24: PRINT l$: LOCATE 8, 32: PRINT H$
GOSUB CUR2TRSO
CASE ELSE
BEEP: GOSUB CUR2TRSO2
END SELECT
SHOW3TRSO2:
DO
V$ = INKEY$
LOOP UNTIL V$ <> ""
SELECT CASE V$
CASE CHR$(0) + "H"
GOSUB CUR2TRSO2
CASE CHR$(0) + "P"
GOSUB CUR4TRSO2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 6: PRINT c$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 9, 24: PRINT l$: LOCATE 9, 32: PRINT H$
GOSUB CUR3TRSO
CASE ELSE
BEEP: GOSUB CUR3TRSO2
END SELECT
SHOW4TRSO2:
DO
Z$ = INKEY$
LOOP UNTIL Z$ <> ""
SELECT CASE Z$
CASE CHR$(0) + "H"
GOSUB CUR3TRSO2
CASE CHR$(0) + "P"
GOSUB CUR5TRSO2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 6: PRINT d$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 10, 24: PRINT l$: LOCATE 10, 32: PRINT H$
GOSUB CUR4TRSO
CASE ELSE
BEEP: GOSUB CUR4TRSO2
END SELECT
SHOW5TRSO2:
DO
aa$ = INKEY$
LOOP UNTIL aa$ <> ""
SELECT CASE aa$
CASE CHR$(0) + "H"
GOSUB CUR4TRSO2
CASE CHR$(0) + "P"
GOSUB CUR1TRSO2
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 6: PRINT e$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
LOCATE 11, 24: PRINT l$: LOCATE 11, 32: PRINT H$
GOSUB CUR5TRSO
CASE ELSE
BEEP: GOSUB CUR5TRSO2
END SELECT
CUR1TRTESO:
COLOR 0, 3
LOCATE 7, 46: PRINT a$
COLOR 15, 3
LOCATE 11, 46: PRINT e$
LOCATE 8, 46: PRINT b$
GOSUB show1trteSO
CUR2TRTESO:
COLOR 0, 3
LOCATE 8, 46: PRINT b$
COLOR 15, 3
LOCATE 7, 46: PRINT a$
LOCATE 9, 46: PRINT c$
GOSUB SHOW2TRTESO
CUR3TRTESO:
COLOR 0, 3
LOCATE 9, 46: PRINT c$
COLOR 15, 3
LOCATE 8, 46: PRINT b$
LOCATE 10, 46: PRINT d$
GOSUB SHOW3TRTESO
CUR4TRTESO:
COLOR 0, 3
LOCATE 10, 46: PRINT d$
COLOR 15, 3
LOCATE 9, 46: PRINT c$
LOCATE 11, 46: PRINT e$
GOSUB SHOW4TRTESO
CUR5TRTESO:
COLOR 0, 3
LOCATE 11, 46: PRINT e$
COLOR 15, 3
LOCATE 10, 46: PRINT d$
LOCATE 7, 46: PRINT a$
GOSUB SHOW5TRTESO
show1trteSO:
DO
bb$ = INKEY$
LOOP UNTIL bb$ <> ""
SELECT CASE bb$
CASE CHR$(0) + "H"
GOSUB CUR5TRTESO
CASE CHR$(0) + "P"
GOSUB CUR2TRTESO
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 7, 46: PRINT a$
GOSUB cur1trSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 7, 46: PRINT a$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB batrso
CASE ELSE
BEEP: GOSUB CUR1TRTESO
END SELECT
SHOW2TRTESO:
DO
bc$ = INKEY$
LOOP UNTIL bc$ <> ""
SELECT CASE bc$
CASE CHR$(0) + "H"
GOSUB CUR1TRTESO
CASE CHR$(0) + "P"
GOSUB CUR3TRTESO
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 8, 46: PRINT b$
GOSUB cur1trSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 8, 46: PRINT b$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB ALTRSO
CASE ELSE
BEEP: GOSUB CUR2TRTESO
END SELECT
SHOW3TRTESO:
DO
bd$ = INKEY$
LOOP UNTIL bd$ <> ""
SELECT CASE bd$
CASE CHR$(0) + "H"
GOSUB CUR2TRTESO
CASE CHR$(0) + "P"
GOSUB CUR4TRTESO
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 9, 46: PRINT c$
GOSUB cur1trSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 9, 46: PRINT c$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB LOTRSO
CASE ELSE
BEEP: GOSUB CUR3TRTESO
END SELECT
SHOW4TRTESO:
DO
be$ = INKEY$
LOOP UNTIL be$ <> ""
SELECT CASE be$
CASE CHR$(0) + "H"
GOSUB CUR3TRTESO
CASE CHR$(0) + "P"
GOSUB CUR5TRTESO
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 10, 46: PRINT d$
GOSUB cur1trSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 10, 46: PRINT d$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB PRTRSO
CASE ELSE
BEEP: GOSUB CUR4TRTESO
END SELECT
SHOW5TRTESO:
DO
BF$ = INKEY$
LOOP UNTIL BF$ <> ""
SELECT CASE BF$
CASE CHR$(0) + "H"
GOSUB CUR4TRTESO
CASE CHR$(0) + "P"
GOSUB CUR1TRTESO
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 11, 46: PRINT e$
GOSUB cur1trSO
CASE CHR$(0) + "/"
COLOR 15, 3
LOCATE 11, 46: PRINT e$
GOSUB CUR1TRVISO
CASE CHR$(27)
END
CASE CHR$(13)
GOSUB ARTRSO
CASE ELSE
BEEP: GOSUB CUR5TRTESO
END SELECT
CUR1TRVISO:
COLOR 0, 3
LOCATE 18, 23: PRINT da$
COLOR 15, 3
LOCATE 20, 23: PRINT db$
GOSUB show1trVISO
CUR2TRVISO:
COLOR 0, 3
LOCATE 20, 23: PRINT db$
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB SHOW2TRVISO
show1trVISO:
DO
de$ = INKEY$
LOOP UNTIL de$ <> ""
SELECT CASE de$
CASE CHR$(0) + "H"
GOSUB CUR2TRVISO
CASE CHR$(0) + "P"
GOSUB CUR2TRVISO
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB cur1trSO
CASE CHR$(27)
END
CASE CHR$(13)
COLOR 15, 3
LOCATE 18, 23: PRINT da$
GOSUB CUR1TRTESO
END SELECT
SHOW2TRVISO:
DO
DF$ = INKEY$
LOOP UNTIL DF$ <> ""
SELECT CASE DF$
CASE CHR$(0) + "H"
GOSUB CUR1TRVISO
CASE CHR$(0) + "P"
GOSUB CUR1TRVISO
CASE CHR$(0) + CHR$(23)
COLOR 15, 3
LOCATE 20, 23: PRINT db$
GOSUB cur1trSO
CASE CHR$(27)
END
CASE CHR$(13)
RUN "PIT"
CASE ELSE
BEEP: GOSUB CUR2TRVISO
END SELECT
batrso:
IF b > 0 AND c > 0 THEN GOSUB batrso1
IF b > 0 AND e > 0 THEN GOSUB batrso2
IF c > 0 AND d > 0 THEN GOSUB batrso3
GOSUB trsoer
ALTRSO:
IF a > 0 AND c > 0 THEN GOSUB altrso1
IF a > 0 AND d > 0 THEN GOSUB altrso2
IF a > 0 AND e > 0 THEN GOSUB altrso3
IF c > 0 AND d > 0 THEN GOSUB altrso4
GOSUB trsoer
LOTRSO:
IF a > 0 AND b > 0 THEN GOSUB LOTRSO1
IF a > 0 AND d > 0 THEN GOSUB LOTRSO2
IF a > 0 AND e > 0 THEN GOSUB LOTRSO3
IF b > 0 AND e > 0 THEN GOSUB lotrso4
GOSUB trsoer
PRTRSO:
IF a > 0 AND b > 0 THEN GOSUB prtrso1
IF a > 0 AND c > 0 THEN GOSUB PRTRSO2
IF a > 0 AND e > 0 THEN GOSUB PRTRSO3
IF b > 0 AND c > 0 THEN GOSUB PRTRSO4
IF b > 0 AND e > 0 THEN GOSUB PRTRSO5
GOSUB trsoer
ARTRSO:
IF a > 0 AND b > 0 THEN GOSUB artrso1
IF a > 0 AND c > 0 THEN GOSUB aRTRSO2
IF a > 0 AND d > 0 THEN GOSUB artrso3
IF b > 0 AND c > 0 THEN GOSUB aRTRSO4
IF c > 0 AND d > 0 THEN GOSUB artrso5
GOSUB trsoer
trsoer:
COLOR 31, 3
LOCATE 14, 16: PRINT "IL PROBLEMA E` IMPOSSIBILE O C'E` GIA` LA SOLUZIONE"
COLOR 15, 1
LOCATE 23, 1: PRINT "Premi ENTER per continuare"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(13)
GOSUB Sfondososc
CASE ELSE
BEEP: GOSUB trsoer
END SELECT
batrso1:
IF b > c THEN GOSUB trsoer2
aa = (c ^ 2) - (b ^ 2)
ab = aa ^ (1 / 2)
ac = ab * 2
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare la base di un triangolo isoscele sapendo la misura dell'altezza e del lato"
LOCATE 5, 1: PRINT "√"; c; "²"; "-"; b; "²"; "="; "√"; aa; "="; ab
LOCATE 7, 1: PRINT ab; "·"; "2"; "="; ac
aa = 0: c = 0: b = 0: ab = 0: ac = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
batrso2:
aa = e * 2 / b
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare la base di un triangolo isoscele sapendo la misura dell'area e dell'altezza"
LOCATE 5, 1: PRINT "("; e; "·"; "2"; ")"; ":"; b; "="; aa
aa = 0: f = 0: b = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
batrso3:
ba = c * 2
bb = d - ba
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza di un triangolo isoscele sapendo la misura del perimetro e del lato"
LOCATE 5, 1: PRINT d; "-"; "("; c; "·"; "2"; ")"; "="; bb
ba = 0: bb = 0: c = 0: d = 0
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT

altrso1:
ba = a / 2
IF ba > c THEN GOSUB trsoer2
bb = (c ^ 2) - (ba ^ 2)
bc = bb ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza di un triangolo isoscele sapendo la misura del lato e della base"
LOCATE 5, 1: PRINT a; ":"; "2"; "="; ba
LOCATE 7, 1: PRINT "√"; c; "²"; "-"; ba; "²"; "="; "√"; ba; "="; bc
a = 0: c = 0: ba = 0: bb = 0: bc = 0
LOCATE 23, 1: PRINT "Premi un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
altrso2:
ba = d - a / 2
bb = a / 2
IF bb > ba THEN GOSUB trsoer2
bc = (ba ^ 2) - (bb ^ 2)
bd = bc ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza di un triangolo isoscele sapendo la misura del perimetro e della base"
LOCATE 5, 1: PRINT "("; d; "-"; a; ")"; ":"; "2"; "="; ba
LOCATE 7, 1: PRINT a; ":"; "2"; "="; bb
LOCATE 9, 1: PRINT "√"; ba; "²"; "-"; bb; "²"; "="; "√"; bc; "="; bd
a = 0: d = 0: ba = 0: bb = 0: bc = 0: bd = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
altrso3:
bb = e * 2 / a
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza di un triangolo isoscele sapendo la misura dell'area e della base"
LOCATE 5, 1: PRINT "("; e; "·"; "2"; ")"; ":"; a; "="; bb
a = 0: e = 0: bb = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
altrso4:
ba = c * 2
bb = d - ba
bc = bb / 2
IF bc > c THEN GOSUB trsoer2
bd = (c ^ 2) - (bc ^ 2)
be = bd ^ (1 / 2)
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'altezza di un triangolo isoscele sapendo la misura del perimetro e del lato"
LOCATE 5, 1: PRINT d; "-"; "("; c; "·"; "2"; ")"; "="; bb
LOCATE 7, 1: PRINT "√"; c; "²"; "-"; bc; "²"; "="; "√"; bd; "="; be
ba = 0: c = 0: d = 0: bb = 0: bc = 0: bd = 0: be = 0
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
LOTRSO1:
ca = a / 2
cb = (b ^ 2) + (ca ^ 2)
cc = cb ^ (1 / 2)
COLOR 15, 3: CLS
PRINT "Trovare un lato di un triangolo isoscele sapendo la misura della base e dell'altezza"
LOCATE 5, 1: PRINT a; ":"; "2"; "="; ca
LOCATE 7, 1: PRINT "√"; b; "²"; "+"; ca; "²"; "="; "√"; cb; "="; cc
a = 0: b = 0: ca = 0: cb = 0: cc = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
LOTRSO2:
ca = d - a / 2
COLOR 15, 3: CLS
PRINT "Trovare un lato di un triangolo isoscele sapendo la misura della base e del perimetro"
LOCATE 5, 1: PRINT "("; d; "-"; a; ")"; ":"; "2"; "="; ca
a = 0: d = 0: ca = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
LOTRSO3:
ca = e * 2 / a
cb = (ca ^ 2) + (a ^ 2)
cc = cb ^ (1 / 2)
COLOR 15, 3: CLS
PRINT "Trovare un lato di un triangolo isoscele sapendo la misura della base dell'area"
LOCATE 5, 1: PRINT "("; e; "·"; a; ")"; ":"; 2; ";" = ";ca"
LOCATE 7, 1: PRINT "√"; ca; "²"; "+"; a; "²"; "="; "√"; cb; "="; cc
a = 0: ca = 0: cb = 0: cc = 0: e = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
lotrso4:
ca = e * 2 / b
cb = (ca ^ 2) + (b ^ 2)
cc = cb ^ (1 / 2)
COLOR 15, 3: CLS
PRINT "Trovare un lato di un triangolo isoscele sapendo la misura dell'altezza dell'area"
LOCATE 5, 1: PRINT "("; e; "·"; b; ")"; ":"; 2; ";" = ";ca"
LOCATE 7, 1: PRINT "√"; ca; "²"; "+"; b; "²"; "="; "√"; cb; "="; cc
b = 0: ca = 0: cb = 0: cc = 0: e = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
prtrso1:
ca = a / 2
cb = (b ^ 2) + (ca ^ 2)
cc = cb ^ (1 / 2)
cd = cc * 2
ce = cd + a
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo isoscele sapendo la misura della base e dell'altezza"
LOCATE 5, 1: PRINT a; ":"; "2"; "="; ca
LOCATE 7, 1: PRINT "√"; b; "²"; "+"; ca; "²"; "="; "√"; cb; "="; cc
LOCATE 9, 1: PRINT a; "+"; cc; "+"; cc; "="; ce
a = 0: b = 0: ca = 0: cb = 0: cc = 0: cd = 0: ce = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
PRTRSO2:
da = c + c + a
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo isoscele sapendo la misura della base e del lato"
LOCATE 5, 1: PRINT a; "+"; c; "+"; c; "="; da
a = 0: da = 0: c = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
PRTRSO3:
ca = e * 2 / a
cb = (ca ^ 2) + (a ^ 2)
cc = cb ^ (1 / 2)
cd = a + cc + cc
COLOR 15, 3: CLS
PRINT "Trovare il perimetro un triangolo isoscele sapendo la misura della base dell'area"
LOCATE 5, 1: PRINT "("; e; "·"; a; ")"; ":"; 2; ";" = ";ca"
LOCATE 7, 1: PRINT "√"; ca; "²"; "+"; a; "²"; "="; "√"; cb; "="; cc
LOCATE 9, 1: PRINT a; "+"; cc; "+"; cc; "="; cd
a = 0: ca = 0: cb = 0: cc = 0: e = 0: cd = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
PRTRSO4:
IF b > c THEN GOSUB trsoer2
da = (c ^ 2) - (b ^ 2)
db = da ^ (1 / 2)
dc = db * 2
dd = c + c + db
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo isoscele sapendo la misura dell'altezza e del lato"
LOCATE 5, 1: PRINT "√"; c; "²"; "-"; b; "²"; "="; "√"; da; "="; db
LOCATE 7, 1: PRINT db; "·"; "2"; "="; dc
LOCATE 9, 1: PRINT db; "+"; c; "+"; c; "="; dd
c = 0: b = 0: da = 0: ddb = 0: dc = 0: dd = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
PRTRSO5:
ca = e * 2 / b
cb = (ca ^ 2) + (b ^ 2)
cc = cb ^ (1 / 2)
cd = ca + cc + cc
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo isoscele sapendo la misura dell'altezza dell'area"
LOCATE 5, 1: PRINT "("; e; "·"; b; ")"; ":"; 2; ";" = ";ca"
LOCATE 7, 1: PRINT "√"; ca; "²"; "+"; b; "²"; "="; "√"; cb; "="; cc
LOCATE 9, 1: PRINT ca; "+"; cc; "+"; cc; "="; cd
b = 0: ca = 0: cb = 0: cc = 0: e = 0: cd = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
artrso1:
ca = a * b / 2
COLOR 15, 3: CLS
PRINT "Trovare l'area di un triangolo isoscele sapendo la misura della base e dell'altezza"
LOCATE 5, 1: PRINT "("; a; "·"; b; ")"; ":"; "2"; "="; ca
a = 0: b = 0: ca = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
aRTRSO2:
ea = a / 2
IF ea > c THEN GOSUB trsoer2
eb = (c ^ 2) - (ea ^ 2)
ec = eb ^ (1 / 2)
ed = a * ec / 2
COLOR 15, 3: CLS
PRINT "Trovare l'area di un triangolo isoscele sapendo la misura della base e del lato"
LOCATE 5, 1: PRINT a; ":"; "2"; "="; ea
LOCATE 7, 1: PRINT "√"; c; "²"; "-"; ea; "²"; "="; "√"; eb; "="; ec
LOCATE 9, 1: PRINT "("; a; "·"; ec; ")"; ":"; "2"; "="; ed
a = 0: c = 0: ea = 0: eb = 0: ec = 0: ed = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
artrso3:
ea = d - a / 2
eb = a / 2
IF eb > c THEN GOSUB trsoer2
ec = (ea ^ 2) - (eb ^ 2)
ed = ec ^ (1 / 2)
ee = a * ed / 2
COLOR 15, 3: CLS
PRINT "Trovare l'area di un triangolo isoscele sapendo la misura della base e del perimetro"
LOCATE 5, 1: PRINT "("; d; "-"; a; ")"; ":"; "2"; "="; ea
LOCATE 7, 1: PRINT a; ":"; "2"; "="; eb
LOCATE 9, 1: PRINT "√"; ea; "²"; "-"; eb; "²"; "="; "√"; ec; "="; ed
LOCATE 11, 1: PRINT "("; a; "·"; ed; ")"; ":"; "2"; "="; ee
a = 0: d = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
aRTRSO4:
IF b > c THEN GOSUB trsoer2
da = (c ^ 2) - (b ^ 2)
db = da ^ (1 / 2)
dc = db * 2
dd = db * b / 2
COLOR 15, 3: CLS
PRINT "Trovare il perimetro di un triangolo isoscele sapendo la misura dell'altezza e del lato"
LOCATE 5, 1: PRINT "√"; c; "²"; "-"; b; "²"; "="; "√"; da; "="; db
LOCATE 7, 1: PRINT db; "·"; "2"; "="; dc
LOCATE 9, 1: PRINT "("; db; "·"; b; ")"; ":"; "2"; "="; dd
c = 0: b = 0: da = 0: ddb = 0: dc = 0: dd = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
artrso5:
ea = d - (c * 2)
eb = ea / 2
IF eb > c THEN GOSUB trsoer2
ec = (c ^ 2) - (eb ^ 2)
ed = ec ^ (1 / 2)
ee = ea * ed / 2
COLOR 15, 3: CLS
LOCATE 1, 1: PRINT "Trovare l'area di un triangolo isoscele sapendo la misura del perimetro e del lato"
LOCATE 5, 1: PRINT d; "-"; "("; c; "·"; "2"; ")"; "="; ea
LOCATE 7, 1: PRINT ea; ":"; "2"; "="; eb
LOCATE 9, 1: PRINT "√"; c; "²"; "-"; eb; "²"; "="; "√"; ec; "="; ed
LOCATE 11, 1: PRINT "("; ea; "·"; ed; ")"; ":"; "2"; "="; ee
d = 0: c = 0: ea = 0: eb = 0: ec = 0: ed = 0: ee = 0
LOCATE 23, 1: PRINT "Premere un tasto"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(0)
GOSUB Sfondososc
CASE ELSE
GOSUB Sfondososc
END SELECT
trsoer2:
COLOR 31, 3
LOCATE 14, 15: PRINT "L'ALTEZZA NON PUO` ESSERE PIU GRANDE DEI LATI OBLIQUI"
COLOR 15, 1
LOCATE 23, 1: PRINT "Premi ENTER per continuare"
DO
x$ = INKEY$
LOOP UNTIL x$ <> ""
SELECT CASE x$
CASE CHR$(13)
GOSUB Sfondososc
CASE ELSE
BEEP: GOSUB trsoer2
END SELECT
END SUB

