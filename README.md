# Gas prices

Ich hatte mal die Idee die Preise an den Tankstellen in meiner Umgebung mittels einem
Python-Skript, das auf einem Raspberry-Pi für mehr als ein Jahr regelmäßig die Preise
abfragte und in einer Datenbank speicherte, zu sammeln, um diese dann später zu
analysieren.

Diese Anwendung liest die erfassten Daten aus der Datenbank aus und zeigt sie in einem
Graphen an.

Für die Darstellung der Graphen wurde HTML und JS in Verbindung mit der Plotly-Bibliothek
(https://plotly.com/javascript) verwendet. Um die Daten aus der Datenbank auszulesen,
dient PHP als Zwischenmann.
