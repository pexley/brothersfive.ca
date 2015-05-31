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
	<title>Help: Events</title>
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
			<a href="citations_help.php" class="lightlink">&laquo; Pomoc: Cytaty</a> &nbsp; | &nbsp;
			<a href="more_help.php" class="lightlink">Pomoc: Więcej &raquo;</a>
		</p>
		<span class="largeheader">Pomoc: Wydarzenia</span>
		<p class="smaller menu">
			<a href="#what" class="lightlink">Wydarzenia standardowe a niestandardowe</a> &nbsp; | &nbsp;
			<a href="#add" class="lightlink">Dodaj nowe</a> &nbsp; | &nbsp;
			<a href="#edit" class="lightlink">Edycja istniejących</a> &nbsp; | &nbsp;
			<a href="#del" class="lightlink">Usuń</a> &nbsp; | &nbsp;
			<a href="#citations" class="lightlink">Cytaty</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="what"><p class="subheadbold">Wydarzenia standardowe a niestandardowe</p></a>
		Większość wspólnych wydarzeń takich jak narodziny, śmierć, małżeństwo i kilka innych, jest zawarta na głównych stronach osób, rodzin, źródeł i repozytoriów.
		Te wydarzenia są przechowywane w odpowiednich tabelach bazy danych. Dokumentacja TNG odnosi się do tych wydarzeń jako "standardowe".
		Wszystkie inne wydarzenia są  "niestandardowe" i są zarządzane w sekcji <strong>Inne wydarzenia</strong> na kartach osób, rodzin, źródeł i repozytoriów.
		Te wydarzenia są przechowywane w oddzielnym tabelach wydarzeń. Pomoc ta odnosi się do kwestii zarządzania tymi <em>niestandardowymi</em> wydarzeniami.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="add"><p class="subheadbold">Dodawanie wydarzeń</p></a>

		<p>Aby dodać nowe wydarzenie, kliknij na "Dodaj nowe" w sekcji Inne wydarzenia, a następnie wypełnij formularz. Jeśli istnieją już jakieś wydarzenia,
                będą one wyświetlane w tabeli w sekcji Inne wydarzenia. Dla wyjaśnienia na temat dostępnych pól, patrz rozdział poniżej.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="edit"><p class="subheadbold">Edycja wydarzeń</p></a>

		<p>Aby edytować istniejące wydarzenie, należy kliknąć na ikonkę Edycja obok tego wydarzenia w sekcji Inne wydarzenia (aby edytować dane w "standardowym" wydarzeniu takim jak na
                przykład narodziny lub zgon, zmień po prostu tekst).</p>

		<p>Podczas dodawania lub edycji notatki dostępne są następujące pola:</p>

		<span class="optionhead">Rodzaj wydarzenia</span>
		<p>Wybierz rodzaj wydarzenia (nie można zmienić rodzaju wydarzenia dla istniejącego wydarzenia). Jeśli potrzebnego rodzaju wydarzenia nie ma w polu wyboru, przejdź najpierw do
                Administracja / Niestandardowe rodzaje wydarzeń i ustaw rodzaj wydarzenia, a następnie powrócić na tę kartę, aby je wybrać.</p>

        <span class="optionhead">Data wydarzenia</span>
		<p>Rzeczywista lub zbliżona data związana z wydarzeniem.</p>

        <span class="optionhead">Miejsce wydarzenia</span>
		<p>Miejsce, gdzie nastąpiło wydarzenie. Podaj nazwę miejsca lub kliknij ikonkę "Znajdź" (lupka), aby zlokalizować wprowadzone wcześniej miejsce.</p>

        <span class="optionhead">Szczegóły</span>
		<p>Wszelkie dodatkowe wyjaśnienia w przypadku, jeśli jest to konieczne. Jeśli nie ma miejsca lub daty związanych z wydarzeniem, pole "szczegóły"  powinno zawierać informacje dotyczące tych brakujących danych.</p>

        <span class="optionhead">Więcej</span><br />
		<p>Więcej rzadziej używanych informacji można dodać do każdego wydarzenia klikając na napis "Więcej" lub strzałkę obok niego. W ten sposób pojawią dodatkowe pola. Pola te możesz ukryć przez ponowne kliknięcie
                na napis lub strzałkę. Ukrywanie pól nie usuwa zapisanych informacji. Te dodatkowe pola to:</p>

        <p><span class="optionhead">Wiek</span>: Wiek osoby w czasie wydarzenia.</p>

        <p><span class="optionhead">Urząd</span>: Kompetentny i / lub odpowiedzialny w momencie wydarzenia organ lub instytucja.</p>

        <p><span class="optionhead">Przyczyna</span>: Przyczyna zdarzenia (najczęściej używane ze śmiercią).</p>

        <p><span class="optionhead">Adres 1/Adres 2/Miasto/Województwo/Kod pocztowy/Kraj/Telefon/E-mail/Strona Web</span>: Adres oraz inne informacje kontaktowe związane z wydarzeniem..</p>

        <span class="optionhead">Wymagane pola:</span>
		<p>Musisz wybrać rodzaj wydarzenia i wpisać coś w co najmniej jednym z następujących pól: <strong>data wydarzenia</strong>, <strong>miejsce wydarzenia</strong>,
		lub <strong>szczególy</strong>. Wszystkie inne informacje są opcjonalne.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="del"><p class="subheadbold">Usuwanie wydarzeń</p></a>

		<p>Aby usunąć istniejące wydarzenie, należy kliknąć na ikonkę Usuń obok tego wydarzenia w sekcji Inne wydarzenia. Wydarzenie zostanie usunięte, niezależnie od tego, czy strona zostanie zapisana.</p>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="citations"><p class="subheadbold">Cytaty</p>
		<p>Aby dodać lub edytować cytat ze źródła do wydarzenia musisz najpierw zapisać wydarzenie, a następnie kliknąć na ikonkę obok zapisu tego wydarzenia na liście wydarzeń. Aby uzyskać więcej informacji na ten temat cytatów, zobacz <a href="citations_help.php">Pomoc: Cytaty</a>.</p>
                <li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>

	</td>
</tr>

</table>
</body>
</html>
