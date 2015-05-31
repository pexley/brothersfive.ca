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
	<title>Help: Collections</title>
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
			<a href="media_help.php" class="lightlink">&laquo; Pomoc: Media</a> &nbsp; | &nbsp;
			<a href="albums_help.php" class="lightlink">Pomoc: Albumy &raquo;</a>
		</p>
		<span class="largeheader">Pomoc: Kolekcje</span>
		<p class="smaller menu">
			<a href="#what" class="lightlink">Co to jest kolekcja?</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Dodaj/Eytuj/Usuń</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="what"><p class="subheadbold">Co to są kolekcje?</p></a>

		<p><strong>Kolekcja</strong> w TNG odnosi się do rodzaju mediów. Standardowymi kolekcjami w TNG są  zdjęcia, dokumenty, nagrobki, historie,
                filmy i nagrania. TNG pozwala jednak również na tworzenie własnych kolekcji. Kolekcja nie jest ograniczona do jednego rodzaju plików.
                Na przykład zdjęcia w formacie jpg mogą być częścią każdej kolekcji, nie tylko zdjęć lub dokumentów. Kolekcja zdjęć nie musi zawierać wyłącznie plików graficznych.</p>


	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="add"><p class="subheadbold">Dodawanie kolekcji</p></a>

		<p>Aby dodać nową kolekcję, kliknij na przycisk "Dodaj kolekcję" tam gdzie jest on widoczny (na przykład w dziale Media na kartach Szukaj i Dodaj nowe).
                Kiedy pojawi się okienko popup, wypełnij formularz. Do dyspozycji są następujące pola:</p>

		<span class="optionhead">ID kolekcji</span>
		<p>ID kolekcji to bardzo krótki ciąg znaków. Nie powinno zawierać spacji ani znaków, które nie są alfanumeryczne. Idealnie było by to 10 znaków lub mniej.
                Na przykład, jeśli tworzysz kolekcję dla tematów wojskowych, możesz podać "wojsko" jako jej ID . Ta wartość nie będzie wyświetlana więc to, jak ją nazwiesz
                nie jest ważne tak długo, jak długo jest ona niepowtarzalna.</p>

		<span class="optionhead">Wyświetlany tytuł</span>
		<p>Nazwa ta będzie wyświetlana na liście kolekcji i gdy będą pokazywane elementy tej kolekcji. Wyświetlany tytuł może być nieco dłuższy niż ID kolekcji, ale powinien
                on być nadal stosunkowo krótki. Korzystając z tego samego przykładu możesz wpisać "Zdjęcia z wojska" jako nazwę dla tej kolekcji . Możesz wybraną nazwę używać we
                wszystkich językach. Jeśli korzystasz na Twojej stronie z wielu języków, i chcesz by wyświetlany tytuł został przetłumaczony w tych językach, musisz do utworzyć wpis w
                pliku "cust_text.php" w folderze każdego języka. W kluczu wiadomości $text należy wpisać ID, a wartość jest wyświetlanym tytułem. Dla tego przykładu Twój wpis będzie wyglądać następująco:</p>

		<pre>$text['wojsko'] = "Zdjęcia z wojska";</pre>

		<p>Musisz powielić plik cust_text.php dla każdego języka, tłumacząc tylko nazwę "Zdjęcia z wojska". Ani klucz ani ID ( "wojsko") nie może być tłumaczone.</p>

		<span class="optionhead">Nazwa folderu</span>
		<p>Nazwa fizycznego folderu lub katalogu na Twojej stronie internetowej, w którym będą przechowywane elementy tej kolekcji. Powinna być stosunkowo krótka, bez spacji i składać się wyłącznie ze
                znaków alfanumerycznych (np. "wojsko"). Po wprowadzeniu wartości, możesz kliknąć na przycisk "Twórz folder". Powinien pojawić się komunikat informujący, czy tworzenie było udane, czy nie.
                Jeśli serwer nie pozwala na tę operację, będziesz musiał skorzystać z programu FTP lub menedżera plików online w celu utworzenia folderu. Powinien on zostać utworzony w tym samym folderze
                nadrzędnym jak "zdjęcia", "dokumenty", "historie" i inne foldery kolekcji. Upewnij się, że jego rzeczywista nazwa odpowiada dokładnie nazwie wpisanej tutaj  ( "Wojsko" to nie to samo co "wojsko").</p>

		<span class="optionhead">Plik ikony</span>
		<p>Musisz utworzyć własną ikonę, lub użyć jednego z już istniejących i podać nazwę pliku ikony. Plik ikony powinien znajdować się w folderze głównym TNG, wraz z innymi standardowymi ikonami mediów (np. "tng_photo.gif" lub "tng_doc.gif").</p>

		<span class="optionhead">Kolejność wyświetlania</span>
		<p>Wpisz tutaj liczbę aby wskazać kolejność, w jakiej będą wyświetlane w menu publicznym niestandardowe  typy kolekcji. Jako pierwsze pojawiają się najniższe numery.</p>

		<span class="optionhead">Takie same ustawienia jak</span>
		<p>Być może zauważyliście, że karty  Dodaj nowe i Edycja zmieniają się nieco w zależności od wybranej kolekcji. Pole "Takie same ustawienia jak " pozwala na wskazanie rodzaju standardowej kolekcji, który w odniesieniu do układu tych kart
                powinna najbardziej przypominać Twoja nowa kolekcja.</p>

		<p class="subheadbold">Edycja/Usuwanie kolekcji</p></a>

		<p>Aby edytować istniejące niestandardowe kolekcje (standardowe nie mogą być edytowane, chyba że w Ustawieniach głównych), zaznacz kolekcję na liście i kliknij przycisk Edycja. Pola wypełnij w sposób opisany powyżej.</p>

		<p>Aby usunąć istniejącą kolekcję niestandardową wybierz ją z listy i kliknij przycisk Usuń. Ani fizyczny folder kolekcji utworzony na serwerze, ani żaden z jego elementów nie powinny zostać usunięte.</p>
		<li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>

	</td>
</tr>

</table>
</body>
</html>
