Poniżej powtórzona treść zadania wraz z nazwą klasy, przez którą dany podpunkt jest realizowany:
- klasę pozwalająca na odczyt zawartości pliku tekstowego - linia po linii, zachowując newline'y => `TextFileReader`,
- klasę zamieniającą znaki końca linii na Unixowe, wykorzystując wzorzec projektowy dekorator => `UnixEndOfLineTextFileReaderDecorator`,
- klasę proxującą (wzorzec proxy), która, jeśli plik nie jest dostępny, pobierze go z zadanego zasobu internetowego => `ProxyFileDownloader`,
- klasę, stosującą wzorzec strategia, która optymalizuje odczyt małego pliku vs bardzo dużego pliku => ponownie `TextFileReader`.

