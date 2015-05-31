<?php
include("../subroot.php");
include($subroot . "config.php");
include("../version.php");
echo $tngconfig['doctype'] ? $tngconfig['doctype'] . "\n\n" : "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n\n";
echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2" />
	<title>Help: Media Page</title>
<?php 
	include("../admin/adminmeta.php");
?>
<style>
p {margin-top: 0px;}
p.menu {
	margin-top:8px;
	margin-bottom:0px;
	color:#FFFFFF;
}
</style>
</head>

<body class="helpbody">
<a name="top"></a>
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="tblback normal">
<tr class="fieldnameback">
	<td class="tngshadow">
		<p style="float:right; text-align:right" class="smaller menu">
			<a href="http://tngforum.us" target="_blank" class="lightlink">TNG Forum</a> &nbsp; | &nbsp;
			<a href="http://tng.lythgoes.net/wiki" target="_blank" class="lightlink">TNG Wiki</a><br />
			<a href="more_help.php" class="lightlink">&laquo; Pomoc: Więcej</a> &nbsp; | &nbsp;
			<a href="collections_help.php" class="lightlink">Pomoc: Kolekcje &raquo;</a>
		</p>
		<span class="largeheader">Pomoc: Media</span>
		<p class="smaller menu">
			<a href="#search" class="lightlink">Szukaj</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Dodaj</a> &nbsp; | &nbsp;
			<a href="#edit" class="lightlink">Edycja</a> &nbsp; | &nbsp;
			<a href="#delete" class="lightlink">Usuń</a> &nbsp; | &nbsp;
			<a href="#convert" class="lightlink">Konwertuj</a> &nbsp; | &nbsp;
			<a href="#album" class="lightlink">Dodaj do albumu</a> &nbsp; | &nbsp;
			<a href="#sort" class="lightlink">Sortuj</a> &nbsp; | &nbsp;
			<a href="#thumbs" class="lightlink">Miniaturki</a> &nbsp; | &nbsp;
			<a href="#import" class="lightlink">Import</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="search"><p class="subheadbold">Szukanie</p></a>
        <p>Znajdź istniejące media wpisując <strong>ID Medium, Tytuł, Opis, Łącze, Właścicela</strong> albo
		<strong>tekst Body</strong> (tylko dla historii) lub ich część. Wybierz jedną z dostępnych opcji w celu dalszego zawężenia kryteriów wyszukiwania.
                Jeśli nie wybierzesz żadnej z proponowanych opcji, w polu wyszukiwania wyświetlą się wszystkie media zapisane w bazie danych. Opcje szukania zawierają:</p>

		<span class="optionhead">Drzewo</span>
		<p>Ogranicza wyniki do mediów przypisanych do wybranego drzewa.</p>

		<span class="optionhead">Kolekcja</span>
		<p>Ogranicza wyniki wyszukiwania do mediów z wybranej kolekcji. Aby dodać nową kolekcję, kliknij na "Dodaj kolekcję", a następnie wypełnić formularz w okienku (popup).
                Aby utworzyć folder dla nowej kolekcji, należy utworzyć własną ikonkę (lub wybrać istniejącą). Pole "Takie same ustawienie jak" pozwala na wskazanie
                jednego z podstawowych rodzajów Twoich kolekcji, z jakiego nowa kolekcja powinna przejąć ustawienia.</p>

		<span class="optionhead">Rozszerzenie pliku</span>
		<p>Podaj rozszerzenie pliku (np. "jpg" lub "gif") przed kliknięciem przycisku Szukaj, aby ograniczyć wyniki wyszukiwania do mediów z nazwami plików mającymi takie rozszerzenie.</p>

		<span class="optionhead">Tylko bez łączy</span>
		<p>Zaznacz to pole przed kliknięciem przycisku Szukaj, aby ograniczyć wyniki wyszukiwania do mediów, które nie są powiązane z żadnymi osobami, rodzinami, źródłami, repozytoriami lub miejscami.</p>

  		<span class="optionhead">Status</span>
		<p><strong>(Tylko nagrobki)</strong> Wybierz z status listy przed kliknięciem przycisku Szukaj, aby wyszukać wszystkie nagrobki o tym samym statusie.</p>

		<span class="optionhead">Cmentarz</span>
		<p><strong>(Tylko nagrobki)</strong> Wybierz z listy cmentarz przed kliknięciem przycisku Szukaj, aby wyszukać wszystkie nagrobki z tego samego cmentarza.</p>

		<p>Twoje kryteria wyszukiwania na tej stronie zostaną zapamiętane dopóki nie naciśniesz przycisku <strong>Zerowanie</strong>, który przywraca domyślne wartości wszystkich wyszukiwań.</p>

		<span class="optionhead">Czynność</span>
		<p>Ikonki w polu "czynność" obok każdego wyniku wyszukiwania pozwalają na edycję, usuwanie lub podgląd tego wyniku. Aby usunąć więcej niż jeden rekord jednocześnie, kliknij pole w kolumnie
		<strong>Wybierz</strong> dla każdego rekordu, który ma zostać usunięty, a następnie kliknąć przycisk "Usuń wybrane" znajdujący się na górze listy. Użyj <strong>Wybierz wszystko</strong> lub <strong>Wyczyść wszystko</strong>
		aby zaznaczyć lub usunąć zaznaczenie wszystkich pól naraz. Można również konwertować wiele mediów z jednej kolekcji do innej, lub dodać do albumu w ten sam sposób (patrz poniżej, aby uzyskać więcej informacji).</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="add"><p class="subheadbold">Dodawanie nowych mediów</p></a>
		<p>Aby dodać nowe media, kliknij przycisk <strong>Dodaj nowe</strong> a następnie wypełnić formularz. Niektóre informacje, w tym  Mapa zdjęcia, informacje o lokalizacji, oraz łącza do osób, rodzin i itp. mogą zostać dodane
                dopiero po kliknięciu na "Zapisz i kontynuuj". Do dyspozycji są następujące pola:</p>

		<span class="optionhead">Kolekcje</span>
		<p>Wybierz rodzaj medium (np. zdjęcie, dokument, nagrobek, historia, nagranie lub film). Nie ma ograniczeń dotyczących typów plików dla żadnej z <span class="emphasis">kolekcji</span>.</p>

		<span class="optionhead">To medium pochodzi z zewnętrznego źródła</span>
		<p>Zaznacz to pole, jeśli Twoje medium znajduje się w innym miejscu niż na Twoim serwerze. Musisz dostarczyć dokładną ścieżkę dostępu ( na przykład, "http://www.thatsite.com/image.jpg") w polu
                oznaczonym "Nazwa pliku na stronie" (pozostaw pole "Plik do załadowania " wolne). Jeśli chcesz mieć miniaturkę zdjęcia, musisz dostarczyć swoją (TNG jej nie utworzy).</p>

		<span class="optionhead">Plik mediów</span>
		<p>Wybierz fizyczny plik (z Twojego komputera lub z serwera) dla tego medium.</p>

		<span class="optionhead">Plik do załadowania</span>
		<p>Jeśli Twój plik nie został jeszcze załadowany na serwer naciśnij przycisk Przeglądaj, aby zlokalizować go w Twoim komputerze. Jeśli plik znajduje się już na serwerze, pozostaw to pole wolne.</p>

		<span class="optionhead">Nazwa pliku na stronie / Media URL</span>
		<p>Jeśli poprzednio załadowałeś Twój plik mediów, podaj ścieżkę dostępu i nazwę tego medium jaka istnieje w folderze odpowiedniej kolekcji na serwerze (lub na innej stronie www). Jeśli nie znasz dokładnej
                nazwy pliku, możesz kliknąć na przycisk Szukaj, aby zlokalizować plik na serwerze. Jeśli załadowujesz Twój plik korzystając z poprzedniej możliwości, w tym polu ukaże się ścieżka dostępu i nazwa Twojego pliku,
                która będzie zapisana w wybranej kolekcji na serwerze. Zasugerowana ścieżka dostępu i nazwa pliku zostaną dla Ciebie wypełnione. Jeśli zaznaczysz "To medium pochodzi z zewnętrznego źródła" ,
                zobaczysz pole "Media  URL", w którym należy podać dokładny adres Twojego medium.</p>

		<p><strong>UWAGA</strong>: Jeśli załadowujesz nowy plik, informacje, które tutaj podajesz muszą być "czytane przez wszystko". Jeśli nie, użyj Twojego programu FTP albo skontaktuj się z Administratorem,
                aby nadać temu plikowi właściwe uprawnienia (powinny być ustawione na 775, ale w niektórych przypadkach wymagane jest 777).<br>
                Nie można stosować polskich liter takich jak na przykład ą, ę, ź, ś itp, przecinków ani kropek (z wyjątkiem kropki przed rozszerzeniem pliku - .jpg czy .gif). Nie powinno się również używać spacji. Na przykład zdjęcie o nazwie "zdjęcie Józefa Mrówczyńskiego 12.11.1988.jpg"
                powinno zostać zapisane jako "zdjecie_jozefa_mrowczynskiego_12_11_1988.jpg </p>

		<span class="optionhead">ALBO Tekst Body</span>
		<p><strong>(Tylko historie)</strong> Zamiast fizycznego przesyłania plików do historii, można tu wpisać lub wkleić tekst lub kod HTML.</p>

		<p><strong>UWAGA:</strong> Jeśli użyjesz HTML <strong>nie może</strong> on zawierać znaczników HTML lub BODY.</p>

		<span class="optionhead">Konwertuj nowe linie (BR) do HTML</span>
		<p><strong>(Tylko historie)</strong> Wybierz tę opcję, aby TNG skonwertowało "nowe linie" zawarte w polu "Tekst BODY" do "nowych linii HTML". Pozostawianie tej kratki niezaznaczonej spowoduje, że "nowe linie" będą ignorowane.
                "Nowe linie HTML" z tego pola będą wszędzie respektowane. </p>

		<span class="optionhead">Plik miniaturki</span>
		<p>Wskaż istniejący plik (z twojego komputera lub ze strony WEB) aby stworzyć "miniaturkę" (mały obrazek) dla tego medium (jest to opcjonalne). Ważne: idealne miniaturki powinny mieć od 50 do 100 pixeli na stronę. Twoja miniaturka <strong>NIE MOŻE</strong> być tym samym obrazem co oryginał!
                TNG zgłosi zastrzeżenia jeżeli spróbujesz użyć oryginalnego obrazu jako miniaturki. TNG może stworzyć dla ciebie miniaturkę tylko jeżeli zawartość Twojego medium jest obowiązującym JPG, GIF lub PNG obrazem.</p>

		<span class="optionhead">Określone zdjęcie/Twórz z oryginału</span>
		<p>Jeśli Twój serwer wspiera bibliotekę GD image library, będziesz tutaj miał możliwość dostarczyć Twoją własną miniaturkę, albo utworzyć ją przy pomocy TNG z oryginału. W tym celu zaznacz pole Twórz z oryginału.
                Jeśli wybierzesz tę opcję, domyślnie nazwa nowego pliku będzie taka sama jak oryginał, tyle że dołączony zostanie na początku prefiks lub na końcu sufiks (przyrostek). Ten prefiks i sufiks, wraz z maks. szerokością i wysokością
                miniaturki są wyznaczone w Administracja/Ustawienia główne. <strong>UWAGA:</strong> Twoja miniaturka <strong>NIE MOŻE</strong> być tym samym oryginalnym zdjęciem! TNG będzie reklamować, jeśli będziesz usiłował użyć oryginalnego zdjęcia jako miniaturki.
                TNG może utworzyć dla Ciebie miniaturkę tylko wtedy, kiedy Twój plik mediów jest w aktualnym formacie JPG, GIF lub PNG, może jednak reklamować, jeśli miniaturka ma zostać utworzona ze zbyt dużego zdjęcia (ponad 1 MB).</p>

		<span class="optionhead">Plik do załadowania</span>
		<p>Jeśli sobie życzysz, miniatury obrazów każdego zdjęcia związanego z osobą są wyświetlane na jej stronie. Jeśli dla Twojego medium nie ma jeszcze na serwerze załadowanego pliku miniaturki, kliknij przycisk "Przeglądaj" i zlokalizuj miniaturkę w Twoim komputerze.
                Musisz wtedy wpisać ścieżkę dostępu do punktu docelowego i nazwę miniaturki w następnym polu ("Nazwa pliku na stronie"). Jeśli miniaturka jest już na serwerze, zostaw to pole puste.</p>

		<span class="optionhead">Nazwa pliku na stronie</span>
		<p>Jeśli poprzednio załadowałeś Twoją miniaturkę, podaj jej ścieżkę dostępu i dokładną nazwę taką, jaka zapisana jest w odpowiednim dla danej kolekcji folderze na serwerze (rada: jeśli chcesz trzymać miniaturki i oryginały oddzielnie, możesz je zapisywać w
                folderze podrzędnym. Będą mogły mieć te same nazwy, jak oryginały). Jeśli nie znasz dokładnej nazwy pliku, możesz kliknąć przycisk Wybierz, aby go zlokalizować w Twoim komputerze. Sugerowana ścieżka dostępu i nazwa pliku zostaną dla Ciebie wypełnione. </p>

		<p><strong>UWAGA</strong>: Jeśli załadowujesz nowy plik, informacje, które tutaj podajesz muszą być "czytane przez wszystko". Jeśli nie, użyj Twojego programu FTP albo skontaktuj się z Administratorem, aby nadać plikom właściwe uprawnienia
                (775 powinien funkcjonować, ale czasami wymagany jest 777). </p>

		<span class="optionhead">Zapisz pliki w: Folder multimediów/Folder kolekcji</span>
		<p>Możesz wybrać zapisywanie mediów w folderze odpowiadającym wybranej kolekcji (opcja domyślna), lub w folderze multimediów .</p>

		<span class="optionhead">Tytuł</span>
		<p>Powinno to być krótkie określenie &#151;  służące do identyfikacji Twojego medium. To określenie będzie użyte jako łącze do strony pokazującej Twoje medium.</p>

		<span class="optionhead">Opis</span>
		<p>Tutaj możesz podać więcej szczegółów zawierających informację o przedstawionym medium. Będzie widoczne jako notatka towarzysząca Twojemu tytułowi (poprzednie pole).</p>

		<span class="optionhead">Szerokość, wysokość</span>
		<p><strong>(dotyczy tylko filmów)</strong> Niektóre odtwarzacze wideo (np. Quicktime) wymagają podania wymiarów filmu. Jeśli nie będą one wyszczególnione,
                film może zostać za mocno obcięty i jego fragmenty nie będą widoczne. Dlatego polecamy podanie tutaj wymiarów Twojego filmu w pikselach. Proszę też pamiętać o
                pozostawieniu około 16 pionowych pikseli dla pulpitu sterowania odtwarzacza wideo ( odtwarzanie / stop / regulacje głośności, itp.).</p>

		<span class="optionhead">Właściciel/Źródło, Data wykonania, Miejsce wykonania</span>
		<p>Są to pola opcjonalne. Jeśli posiadasz jakieś informacje, wpisz je tutaj.</p>

		<span class="optionhead">Drzewo</span>
		<p>If Jeśli chciałbyś łączyć to medium z wybranym drzewem, wybierz to drzewo tutaj. Mogą to robić tylko użytkownicy mający uprawnienia do edycji danych dotyczących tych drzew.</p>

		<span class="optionhead">Cmentarz</span>
		<p><strong>(Tylko nagrobki)</strong> Wybierz z listy cmentarz, na którym znajduje się nagrobek. Musisz najpierw dodać cmentarz (pod Admin / Cmentarze) zanim będzie on widoczny w tym polu.</p>

		<span class="optionhead">Sektor</span>
		<p><strong>(Tylko nagrobki)</strong> Sektor, w którym zlokalizowany jest nagrobek (opcjonalne).</p>

		<span class="optionhead">Status</span>
		<p><strong>(Tylko nagrobki)</strong> Wybierz z listy określenie, które najlepiej opisuje okoliczność dotyczącą nagrobka.</p>

		<span class="optionhead">Zawsze widoczne</span>
		<p>Zaznacz to pole, jeśli chcesz, aby to medium było widoczne dla wszystkich bez względu na to, czy połączone z nim osoby są zapisane jako żyjące i niezależnie od uprawnień użytkownika.</p>

		<span class="optionhead">Otwór w nowym oknie</span>
		<p>Zaznacz to pole, jeśli chcesz, aby po kliknięciu na jego łącze to medium otwierało się w nowym oknie.</p>

		<span class="optionhead">Łącz bezpośrednio z wybranym cmentarzem</span>
		<p><strong>(Tylko nagrobki)</strong> Zaznacz to pole, aby połączyć to zdjęcie nagrobka z samym cmentarzem. Kiedy otworzy się ta strona, będą na niej widoczne wszystkie nagrobki zapisane dla tego cmentarza, to zdjęcie zaś pokaże się na szczycie strony.</p>

		<span class="optionhead">Pokaż mapę cmentarza za każdym razem, kiedy to zdjęcie zostanie wybrane</span>
		<p><strong>(Tylko nagrobki)</strong> Zaznacz to pole, jeśli dla cmentarza, na którym znajduje się ten nagrobek, istnieje mapa lub zdjęcie. Będzie ona widoczna zawsze razem z tym nagrobkiem.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="edit"><p class="subheadbold">Edycja istniejących mediów</p></a>
		<p>Aby wprowadzić zmiany do istniejących mediów, kliknij przycisk <a href="#search">Szukaj</a> w celu znalezienia medium a następnie kliknij na ikonkę Edycja obok tego elementu.
		 Oto elementy, których nie ma w "Dodaj nowe":</p>

		<span class="optionhead">Linki mediów</span>
		<p>Możesz tworzyć łącza mediów do osób, rodzin, źródeł, repozytoriów lub miejsc. Dla każdego łącza, należy najpierw wybrać drzewo związane z łączonym medium. Następnie rodzaj łącza
                (osoby, rodziny, źródła,  repozytoria lub miejsca) i wreszcie wprowadzić numer ID lub nazwę (tylko miejsca) łączonego podmiotu. Po wykonaniu tych czynności kliknij przycisk "Dodaj".</p>

		<p>Jeśli nie znasz numeru ID lub dokładnej nazwy miejsca, kliknij na ikonę lupy aby w celu wyszukiwania. Pojawi się okienko popup. Gdy znajdziesz żądany opis podmiotu,
		kliknij przycisk "Dodaj" po lewej stronie. Możesz kliknąć "Dodaj" dla wielu podmiotów. Po zakończeniu tworzenia  łączy kliknij na czerwone pole z krzyżykiem w prawym górnym rogu.</p>

		<p><strong>Istniejące łącza:</strong> Możesz edytować lub usuwać istniejące łącza mediów klikając na ikonkę Edycja lub Usuń obok wybranego łącza. Edycja łącza umożliwia
                jego skojarzenie wydarzeniem oraz wpisanie<strong>dodatkowego tytułu</strong> i <strong>dodatkowego opisu</strong>.</p>

		<p><strong>OSTRZEŻENIE</strong>: Łącza do wydarzeń niestandardowych utworzonych w ramach TNG mogą zostać nadpisane przy następnym imporcie GEDCOM-u.</p>

		<span class="optionhead">Jako standard</span>
		<p>Zaznacz to pole podczas edycji łączy mediów, aby użyć miniaturki tego medium w diagramach i na szczytach innych stron związanych z daną osobą lub obiektem, które są z nim połączone.</p>

		<span class="optionhead">Miejsce wykonania zdjęcia</span>
		<p><p>Ta sekcja jest przy starcie zamknięta. Aby ją rozwinąć, kliknij na napis "Miejsce wykonania zdjęcia" lub strzałkę obok niego. Jeśli znasz nazwę miejsca, gdzie zdjęcie zostało zrobione, wpisz ją w polu "Miejsce wykonania zdjęcia".</p>

		<span class="optionhead">Szerokość, Długość (geograficzna)</span>
		<p>Jeśli znasz współrzędne geograficzne miejsca związanego z Twoim medium wpisz je tutaj, aby pomóc innym dokładniej zlokalizować dane miejsce.
		Alternatywnie możesz użyć funkcji geocode Google Map, aby ustawić szerokość i długość geograficzną lokalizacji mediów. Kliknij na "Pokaż / Ukryj mapę Google", aby zobaczyć mapę Google.</p>

		<span class="optionhead">Zoom</span>
		<p>Wpisz poziom powiększenia mapy, lub dostosuj poziom przy pomocy suwaka na mapie Google. Ta opcja jest dostępna tylko jeśli masz "klucz mapy" z Google i wpisałeś go w Administracja/Ustawienia i konfiguracja/Ustawienia mapy.</p>

		<p>Uwaga: Szerokość/Długość/Zoom to dane o lokalizacji mediów tylko w celach informacyjnych. Ta lokalizacja nie jest oznakowana na mapie w strefie publicznej.</p>

		<span class="optionhead">Mapa zdjęcia</span>
		<p>Ta sekcja jest przy starcie zamknięta. Aby ją rozwinąć, kliknij na napis "Mapa zdjęcia" lub strzałkę obok niego. Umożliwia ona łączenie różnych fragmentów obrazu z osobami w bazie danych, lub do wyświetlania krótkich wiadomości,
                kiedy wskaźnik myszy zostanie umieszczony nad tymi fragmentami.</p>

		<p><strong>Uwaga</strong>: Abyś mógł skorzystać z tej funkcji, medium musi być zapisane w formacie JPG, GIF lub PNG.</p>

		<p>Jeśli chcesz utworzyć łącze do osoby, musisz po pierwsze wybrać jej drzewo, a następnie kształt (okrąg albo prostokąt) obszaru ( złożone kształty są również możliwe, ale musisz sam dostarczyć dla nich tekst lub kod łącza).
                Następnie postępuj według instrukcji dla wybranego kształtu, aby we właściwy sposób wybrać współrzędne łącza. Gdy współrzędne zostały wybrane, ukaże się okienko "Znajdź ID osoby". Podaj nazwisko oraz / lub imię (lub jego część) albo ID osoby.
                Okienko zamknie się, kiedy klikniesz na wybraną osobę i tekst lub kod łącza dla wybranego obszaru zostanie dodany do pola "Mapa zdjęcia". Jeśli jest to konieczne, możesz ten tekst lub kod łącza edytować.</p>

		<p>Powtórz ten proces dla wszystkich obszarów, które będziesz potrzebował. Wszystkie nowe teksty lub kody łączy będą dodane w polu "Mapa zdjęcia".</p>

		<p>Aby połączyć różne fragmenty zdjęcia do różnych stron, lub do wyświetlania krótkich wiadomości, kiedy wskaźnik myszy znajduje się nad tymi fragmentami, wprowadź potrzebny kod mapy zdjęcia w tym polu.
                Aby budować własną mapę zdjęcia, zobacz pole "Mapa zdjęcia" na dole strony (pod zdjęciem).</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="delete"><p class="subheadbold">Usuwanie mediów</p></a>
		<p>Aby usunąć jedno medium, należy nacisnąć przycisk <a href="#search">Szukaj</a> w celu jego zlokalizowania, a następnie kliknąć na ikonkę Usuń  obok tego medium. Wiersz zmieni kolor,
		a następnie zniknie. Medium zostało usunięte. Aby usunąć więcej niż jedno medium naraz, zaznacz pole w kolumnie Wybierz obok każdego medium, które ma zostać usunięte, a następnie kliknąć
                przycisk "Usuń wybrane" znajdujący się na górze strony.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="convert"><p class="subheadbold">Konwertowanie mediów z jednej kolekcji do drugiej</p></a>
		Aby przekonwertować media z jednej "Kolekcji" do innej, zaznacz odpowiednie pozycje w polu "Wybierz" na karcie Szukaj a następnie wybierz nową kolekcję z rozwijanej listy u góry strony
                obok "Konwertuj wybrane do ". Po dokonaniu wyboru kliknij przycisk "Konwertuj wybrane do". Strona zostanie otwarta ponownie i ukaże się czerwony napis informujący o statusie operacji.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="album"><p class="subheadbold">Dodawanie mediów do albumów</p></a>
		Aby dołączyć media do albumu, zaznacz odpowiednie pozycje w polu "Wybierz" na karcie Szukaj a następnie wybierz album z rozwijanej listy u góry strony obok "Dodaj do albumu". Po dokonaniu
                wyboru kliknij przycisk "Dodaj do albumu". Media mogą być także dodane do albumów w Administracja / Albumy.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="sort"><p class="subheadbold">Sortowanie mediów</p></a>
		<p>Domyślnie media połączone z osobami, rodzinami, źródłami, repozytoriami lub miejscami są sortowane według kolejności, w jakiej zostały utworzone łącza. Aby zmienić tę kolejność, możesz na karcie
                Media / Sortuj przesuwać media według życzenia.</p>

		<span class="optionhead">Drzewo, Rodzaj łącza, Kolekcja:</span>
		<p>Wybierz z drzewo związane z podmiotem, dla którego chcesz sortować media. Następnie wybierz rodzaj łącza (osoby, rodziny, źródła, repozytoria lub miejsca) oraz kolekcję, w której chcesz posortować media.</p>

		<span class="optionhead">ID:</span>
		<p>Wprowadź numer ID lub nazwę (tylko miejsca) podmiotu. Jeśli nie znasz numeru ID lub dokładnej nazwy miejsca, kliknij ikonkę lupy w celu ich wyszukania. Po znalezieniu żądanego podmiotu, kliknij przycisk
                "Wybierz" obok danego podmiotu. Okienko popup zostanie zamknięte i w polu ID pojawi się wybrany identyfikator .</p>

        <span class="optionhead">Łącze do wydarzeń niestandardowych</span>
		<p>Jeśli chcesz posortować tylko media  połączone z określonymi wydarzeniami związanymi z łączem podmiotu, zaznacz pole "Łącze do określonego wydarzenia". Możesz to jednak uczynić dopiero, kiedy wszystkie
                inne pola zostaną wypełnione &mdash; w tym numer ID. Spowoduje to otwarcie dodatkowego pola , w którym można wybrać określone wydarzenie (opcjonalnie).</p>

		<span class="optionhead">Procedura sortowania</span>
		<p>Po wybraniu lub wprowadzeniu numeru ID kliknij "Kontynuuj", aby wyświetlić wszystkie media dla wybranych podmiotów i ich kolekcji w aktualnym porządku. Aby zmienić kolejność pozycji, kliknij na pole "Przeciągnij"
                dla każdego medium, przytrzymaj przycisk myszy a następnie przesuń wskaźnika myszy do żądanej lokalizacji w obrębie listy, poczym zwolnij przycisk myszy ( "przeciągnij i upuść"). Zmiany są zapisywane automatycznie .</p>

		<span class="optionhead">Zdjęcie standardowe</span>
		<p>Podczas sortowania, możesz również wybrać dowolne zdjęcie  jako "Zdjęcie domyślne". Oznacza to, że miniaturka wybranego zdjęcia będzie wyświetlana na diagramach i nagłówkach aktualnie wybranej nazwy podmiotu lub tytułu.
                Aby ustawić lub usunąć zdjęcie standardowe, zatrzymaj wskaźnik myszy nad dowolnym z widocznych zdjęć a następnie kliknij na jedną z opcji "Jako standard" lub "Usuń". Aktualne zdjęcie standardowe może zostać również usunięte
                przez kliknięcie przycisku "Usuń zdjęcie standardowe" u góry strony.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="thumbs"><p class="subheadbold">Miniaturki</p></a>

		<span class="optionhead">Generowanie miniaturek</span>
		<p> Kiedy klikniesz na przycisk "Generuj", TNG automatycznie utworzy miniaturki dla wszystkich plików JPG, GIF oraz PNG, które jej jeszcze nie mają. Nazwa nowej miniaturki będzie taka sama jak oryginał, ale będzie poprzedzona
                prefiksem i / albo będzie miała przyrostek taki, jak to zostało przez Ciebie zdefiniowane w Ustawieniach ogólnych. Zaznacz pole "Regeneruj istniejące miniaturki", aby ponownie utworzyć miniaturki dla mediów, które już je posiadają.
                "Regeneruj nazwę ścieżki pliku miniaturki jeśli plik nie istnieje" jeśli sądzisz, że niektóre miniaturki dotyczą nieprawidłowych plików. To spowoduje przywrócenie przez TNG nazw łączy miniaturek przed ich regeneracją.
                Bez tej funkcji nieprawidłowe nazwy miniaturek będą regenerowane "tam i z powrotem".</p>

		<p><strong>Uwaga</strong>: Jeśli nie widzisz pola Generuj miniaturki, znaczy że Twój serwer nie wspiera biblioteki GD image library.</p>

		<span class="optionhead">Twórz zdjęcia standardowe</span>
		<p>Ta opcja pozwala na wybranie pierwszego zdjęcia dla każdej osoby, rodziny i źródła się jako zdjęcie standardowe (wyświetlanych w nagłówkach diagramów, arkuszy  osób i rodzin oraz innych stron tego podmiotu).
                Przyporządkowanie może być dokonane w odniesieniu do wszystkich osób, rodzin, źródła i repozytoriów w wybranym drzewie. Zaznacz pole "Nadpisz aktualne ustawienia standardowe ", aby zmienić domyślne ustawienia niezależnie od tego,
                co zostało wcześniej ustalone. Jeśli nie zaznaczysz tego pola, poprzednie ustawienia pozostaną bez zmian.</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="import"><p class="subheadbold">Import zdjęć</p></a>

		<p>Ta funkcja tworzy zapis medium dla każdego pliku w dowolnym Twoim folderze mediów TNG z tytułem takim jak nazwa pliku. Do przeprowadzenia importu wybierz najpierw Kolekcję (lub wcześniej utwórz nową kolekcję) oraz drzewo
                (jeżeli importowana zawartość powinna być połączona z tym drzewem). Następnie kliknij przycisk "Import". Jeżeli zapis już istnieje dla tej zawartości to nowy zapis nie zostanie utworzony.</p>
		<li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>

	</td>
</tr>

</table>
</body>
</html>
