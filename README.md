# anderswelt

- Es wird das Design-Pattern „Model-View-Controller“ angewendet
- In der View werden nur Formulare beschrieben (HTML + CSS), keine Logik, Formatierung nur im CSS
- Die Controller-Schicht umfasst zwei Ebenen
	- Ebene 1: xxx_form_controller.php
		- Hier werden Formulardaten validiert & vorbereitet + Business Logik
	- Ebene 2: xxx_cntroller.php
		- Basic Connector für DB-Abfragen (DAO, Create, Read, Update, Delete...)
		- Es wird davon ausgegangen, dass nur valide Daten aufgerufen werden
		- Fehlerbehandlung über try { } catch { }
		- Pro Abfrage 1 Funktion (atomar)

		- Funktionsnamen entsprechen dem Inhalt
