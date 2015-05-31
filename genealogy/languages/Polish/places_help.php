<?php
include("../subroot.php");
include($subroot . "config.php");
include($subroot . "mapconfig.php");
include("../version.php");
echo $tngconfig['doctype'] ? $tngconfig['doctype'] . "\n\n" : "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n\n";
echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2" />
	<title>Help: Places Page</title>
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
			<a href="cemeteries_help.php" class="lightlink">&laquo; Pomoc: Cmentarze</a> &nbsp; | &nbsp;
			<a href="places_googlemap_help.php" class="lightlink">: Mapy Google &raquo;</a>
		</p>
		<span class="largeheader">Pomoc: Miejsca</span>
		<p class="smaller menu">
			<a href="#search" class="lightlink">Szukaj</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Dodaj lub Edycja</a> &nbsp; | &nbsp;
			<a href="#delete" class="lightlink">Usuń</a> &nbsp; | &nbsp;
			<a href="#merge" class="lightlink">Scal</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="search"><p class="subheadbold">Szukanie</p></a>
        <p><p>Znajdź istniejące miejsce szukając jego pełnej nazwy lub jej części. Wybierz drzewo lub zaznacz pole "Tylko dokładna nazwa" w celu dalszego zawężenia kryteriów wyszukiwania.
              Jeśli nic nie wybierzesz, w polu wyszukiwania znajdziesz wszystkie miejsca zapisane w bazie danych.</p></p>

		<p>Twoje kryteria wyszukiwania na tej stronie zostaną zapamiętane dopóki nie naciśniesz przycisku <strong>Zerowanie</strong>, który przywraca domyślne wartości i wszystkich wyszukiwań.</p>

		<span class="optionhead">Czynność</span>
		<p>Ikonki w polu "czynność" obok każdego wyniku wyszukiwania pozwalają na edycję, usuwanie lub podgląd tego wyniku. Aby usunąć więcej niż jeden rekord jednocześnie, kliknij pole w kolumnie
		<strong>Wybierz</strong> dla każdego rekordu, który ma zostać usunięty, a następnie kliknąć przycisk "Usuń wybrane" znajdujący się na górze listy. Użyj <strong>Wybierz wszystko</strong> lub <strong>Wyczyść wszystko</strong>
		aby zaznaczyć lub usunąć zaznaczenie wszystkich pól wyboru naraz.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="add"><p class="subheadbold">Dodaj nowe / Edytuj istniejące miejsca</p></a>

		<p>TNG automatycznie dodaje nowy rekord Miejsca za każdym razem, gdy są dodawane nowe miejsca w Administracja / Osoby,  Administracja / Rodziny oraz jako część niestandardowe wydarzenia.
                Jeśli wprowadzasz zmiany istniejącego miejsca w którymś z tych działów i jest to nowa, unikatowa nazwa miejsca, utworzony zostanie nowy zapis miejsca.</p>

                <p>Aby dodać nowe miejsce, kliknij przycisk <strong>Dodaj nowe</strong>, a następnie wypełnić formularz. Aby edytować istniejące miejsce, należy użyć przycisku <a href="#search">Szukaj</a> aby zlokalizować miejsce,
                 a następnie kliknąć na ikonkę Edycja obok wybranej linii. Podczas dodawania lub edycji miejsca dostępne są następujące elementy:</p>

		<span class="optionhead">Drzewo</span>
		<p>Wybierz jedno z istniejących drzew. Każde miejsce musi być przypisane do drzewa. <strong> Uwaga: </strong> Drzewo nie może być zmieniane dla raz utworzonego miejsca (zamiast tego możesz usunąć miejsce i dodać go ponownie dla innego drzewa).</p>

		<span class="optionhead">Miejsce</span>
		<p>Podaj nazwę miejsca w kolejności do najmniejszej miejscowości do największej. Wszystkie miejscowości powinny być oddzielone przecinkami. Na przykład <em>Jabłoń, Pisz, piski, warmińsko-mazurskie, Polska</em>.
                Nie używaj niejednoznacznych lub mało znanych skrótów.</p>

		<span class="optionhead">Pokaż/ukryj mapę Google</span>
		<p>Kliknij przycisk "Pokaż / Ukryj mapę Google", aby pokazać mapę. Ta opcja jest dostępna tylko jeśli masz "klucz mapy" z Google i wpisałeś go w Administracja/Ustawienia i konfiguracja/Ustawienia mapy (patrz <a href="mapsettings_help.php">Pomoc: Ustawienia mapy</a>). Kliknij przycisk ponownie, aby ukryć mapę. Aby wyszukać
                miejscowość na mapie, wpisz jej nazwę w polu <strong>Określenie miejsca Geocode</strong> i kliknij "Szukaj". Możesz też kliknąć  na mapę i przeciągnąć, aby przenieść "szpilkę" na żądaną lokalizację. Można również użyć kontroli Zoom, aby pokazać bardziej szczegółowo żądany obszar. Zobacz stronę
		<a href="places_googlemap_help.php">Pomoc: Mapy Google</a> aby uzyskać więcej informacji. W celu uzyskania informacji na temat domyślnych ustawień mapy patrz również <a href="mapsettings_help.php">Pomoc: Ustawienia mapy</a>.</p>

		<span class="optionhead">Szerokość/długość (geograficzna)</span>
		<p>Wprowadź szerokość i długość geograficzną lokalizacji miejsca lub kliknij na wybrany punkt na mapie aby ustawić te wartości (opcjonalnie, patrz wyżej).</p>

		<span class="optionhead">Zoom</span>
		<p>Wpisz poziom powiększenia mapy, lub dostosuj poziom przy pomocy suwaka na mapie Google. Ta opcja jest dostępna tylko jeśli masz "klucz mapy" z Google i
                wpisałeś go w Administracja/Ustawienia i konfiguracja/Ustawienia mapy.</p>

		<span class="optionhead">Poziom miejsca</span></p>
		<p>Wybierz poziom miejsca, który najlepiej opisuje poziom lokalizacji reprezentujący nazwę miejsca. Może to pomóc odwiedzającym , jak można było dokładne identyfikować umiejscowienie "szpilki" .</p>

		<span class="optionhead">Notatki</span>
		<p> Jeśli do opisania cmentarza lub jego lokalizacji potrzebne są dodatkowe informacje, wprowadź je tutaj (opcjonalnie).</p>

		<span class="optionhead">Zmień w nazwy miejsca w istniejących wydarzeniach</span>
		<p>Zaznaczenie tego pola (widoczne tylko podczas edycji istniejącego miejsca) spowoduje, że wszystkie wydarzenia, w których to miejsce jest wykorzystywane będą uaktualniane podczas zapisywania zmian.</p>

        <p><strong>UWAGA:</strong> Kolejne importy GEDCOM z wykorzystaniem opcji "Nadpisz Wszystkie dane" <strong>NIE zastępują</strong> ani nie usuwają istniejących danych miejsca, jeżeli istniejące zapisy zawierają informacje o
                szerokości, długości lub notatkach, lub jeśli są załączone jakiekolwiek media.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="delete"><p class="subheadbold">Usuwanie miejsc</p></a>
		<p>Aby usunąć jedno miejsce, należy nacisnąć przycisk <a href="#search">Szukaj</a> w celu jego zlokalizowania, a następnie kliknąć na ikonkę Usuń  obok tego miejsca. Wiersz zmieni kolor,
		a następnie zniknie. Miejsce zostało usunięte. Aby usunąć więcej niż jedno miejsce naraz, zaznacz pole w kolumnie Wybierz obok każdego miejsca, które ma zostać usunięte, a następnie kliknij
                przycisk "Usuń wybrane" znajdujący się na górze strony.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<p style="float:right"><a href="#top">Wróć</a></p>
		<a name="merge"><p class="subheadbold">Scalanie miejsc</p></a>
		Aby dokonać scalenia nazw miejsc, które mogą być nieco inne, lecz odnosić się do tej samej lokalizacji, kliknij na "Scalanie".
                Użytkownik decyduje, czy dwa zapisy są takie same, czy też nie.</p>

		<span class="optionhead">Znajdż kandydatów do scalenia</span>
		<p>Najpierw wybierz drzewo. Nie można scalać  miejsc z różnych drzew, a więc możesz wybrać tylko jedno drzewo. Wprowadź kryteria wyszukiwania,
                które będą wspólne dla wszystkich potencjalnych duplikatów, a następnie kliknij przycisk "Kontynuuj" (na przykład, możesz wpisać <em>Salt Lake</em> aby znaleźć
		<em>Salt Lake</em> i <em>Salt Lake City</em>).</p>

		<span class="optionhead">Wybierz miejsca do scalenia</span>
		<p>Na tej karcie można będzie zobaczyć listę miejsc pasującą do kryteriów wyszukiwania. Jeśli którykolwiek z nich odnosi się do tej samej lokalizacji, zaznacz pole
                "scal te (usuń)" po lewej stronie dla każdego z nich. Każdy wybrany wiersz będzie podświetli się na czerwono. Następnie kliknij kółko w kolumnie oznaczonej "do tego (zachowaj)".
                Będzie to nazwa miejsca, która zastąpi wszystkie zaznaczone miejsca. Ten wiersz stanie się zielony. Nie ma znaczenia, czy nazwa miejsca do zachowania jest również jednym z tych
                zaznaczonych w ramach "scal te (usuń)". Będziesz mógł wybrać tylko jeden zapis w kolumnie "zachowaj", ale można wybrać dowolną liczbę duplikatów aby je z nim scalić.
                Jeśli jesteś gotowy do scalania, kliknij przycisk "Scal miejsca" na górze lub na dole ekranu. Wszystkie nazwy usuniętych miejsc (w zapisach osób i rodzin) zostaną zastąpione przez nazwę
                aktualnie wybranego. <strong>Uwaga:</strong> informacje w polach Notatki i Szerokość / długość  będzie tylko zachowane dla miejsca które pozostaje.</p>

		<p>Proszę również pamiętać, że wydajność obniża się, im więcej elementów jest wybranych do scalania. Innymi słowy, scalanie dwóch miejscach odbędzie się znacznie szybciej niż scalanie 20 miejsc.</p>
		
		<p>Aby ponownie szukać duplikatów, wystarczy wpisać nową wartość w polu "Szukaj" u góry ekranu i kliknąć przycisk "Kontynuuj".</p>
		
		<li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>
	</td>
</tr>

</table>
</body>
</html>
