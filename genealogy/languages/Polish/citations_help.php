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
	<title>Help: Citations</title>
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
			<a href="notes_help.php" class="lightlink">&laquo; Pomoc: Notatki</a> &nbsp; | &nbsp;
			<a href="events_help.php" class="lightlink">Pomoc: Wydarzenia &raquo;</a>
		</p>
		<span class="largeheader">Pomoc: Cytaty</span>
		<p class="smaller menu">
			<a href="#what" class="lightlink">Co to jest cytat?</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Dodaj/Edycja/Usuń</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="what"><p class="subheadbold">Co to są cytaty?</p></a>

		<p><strong>Cytat</strong> jest odniesieniem do zapisu źródła, dokonanym z zamiarem udowodnienia prawdziwości niektórych informacji. Źródło zawiera
                zwykle ogólne dane, gdzie została znaleziona informacja (np. księga lub spis ludności), cytat natomiast zawiera zwylke więcej szczegółowych
                informacji (np. na której stronie). To samo źródło może być cytowane w treści dokumentu wiele razy dla różnych osób, rodzin, notatek i wydarzeń.</p>


	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="add"><p class="subheadbold">Dodawanie/Edycja/Usuwanie cytatów</p></a>

		<p>Aby dodać, edytować lub usuwać cytaty, należy kliknąć na ikonkę na górze ekranu lub obok wybranego pola (jeśli istnieją już jakieś cytaty,
                ikonka będzie oznaczona zieloną kropką). Po kliknięciu ikonki, pojawi się małe okienko (popup), w którym zobaczysz wszystkie istniejące dla wybranego źródła, wydarzenia cytaty.</p>

		<p>Aby dodać nowy cytat, kliknij na "Dodaj nowe" i wypełnić formularz. </p>

		<p>Aby edytować lub usunąć istniejące cytaty, kliknij na odpowiednią ikonkę obok tego cytatu.</p>

		<p>Podczas dodawania lub edycji cytatów dostępne są następujące pola:</p>

		<span class="optionhead">Źródło</span>
		<p>Wybierz istniejące źródło do cytowania. Jeśli źródło, które chcemy cytować nie pojawia się na liście źródeł, to znaczy że
                albo nie zostało jeszcze utworzone albo istnieje w innym drzewie. Najpierw przejdź do Administracja / Źródła i utwórz źródło
                dla właściwego drzewa, a następnie wrócić do listy cytatów i wybierz źródło.</p>
		
        <!--<span class="optionhead">Opis</span>
		<p>Jeśli Twój program genealogiczny nie przydziela numerów ID swoim źródłom, cytaty będą miały swój opis. Nie zobaczysz pola do opisu nowych cytatów.</p>-->

		<span class="optionhead">Strona</span>
		<p>Podaj stronę z wybranego źródła odnoszącą się do tego wydarzenia (opcjonalne).</p>
		
		<span class="optionhead">Wiarygodność</span>
		<p>Wybierz cyfrę (0-3) wskazującą, jak wiarygodne jest źródło (opcjonalnie). Wyższe cyfry oznaczają większą wiarygodność.</p>
		
		<span class="optionhead">Data cytatu</span>
		<p>Data związana z tym cytatem (opcjonalne).</p>
		
		<span class="optionhead">Faktyczny tekst</span>
		<p>Krótki fragment z materiału źródłowego (opcjonalne).</p>

		<span class="optionhead">Notatki</span>
		<p>Wszelkie uwagi pomocnicze dotyczące tego źródła (opcjonalne).</p><br>
		<li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>

	</td>
</tr>

</table>
</body>
</html>
