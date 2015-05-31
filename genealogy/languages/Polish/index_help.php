<?php
include("../subroot.php");
include($subroot . "config.php");
include("../version.php");
echo $tngconfig['doctype'] ? $tngconfig['doctype'] . "\n\n" : "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \n\"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n\n";
echo "<!-- $tng_title, v.$tng_version ($tng_date), Written by Darrin Lythgoe, $tng_copyright -->\n";
?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>Help: Administration</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2" />
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
			<a href="backuprestore_help.php" class="lightlink">&laquo; Pomoc: Narzędzia</a> &nbsp; | &nbsp;
			<a href="people_help.php" class="lightlink">Pomoc: Osoby &raquo;</a>
		</p>
		<span class="largeheader">Pomoc: Pierwsze kroki</span>
		<p class="smaller menu">
			<a href="#gettingstarted" class="lightlink">Pierwsze kroki</a> &nbsp; | &nbsp;
			<a href="#notes" class="lightlink">Notatki</a> &nbsp; | &nbsp;
			<a href="#otherresources" class="lightlink">Inne dane</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">
		<a name="gettingstarted"><p class="subheadbold">Pierwsze kroki:</p></a>
		<p>Nie wiesz co zrobić najpierw? Oto podstawowe informacje:</p>
		<ol>
				<li><p><strong>Postępuj zgodnie z instrukcjami instalacji w pliku <a href="../readme.html" target="_blank">readme.html</a> albo <a href="http://kielakowie.pl/tng/readme620-700.html" target="blank">readme.html po polsku</a>.
                                </strong> Wszystkich podstawowych konfiguracji
					można dokonać bezpośrednio z tej strony, tutaj możesz również wprowadzić wszystkie potrzebne wartości w dziale <strong>Ustawienia i konfiguracja</strong> w menu Admina</p></li>
				<li><p><strong>Utwórz co najmniej jedno drzewo.</strong> Jeśli masz jeden samodzielny plik GEDCOM, potrzebujesz tylko jedno drzewo.</p></li>
				<li><p><strong>Utwórz co najmniej jednego użytkownika.</strong> Pierwszy użytkownik musi być Administratorem (musi on mieć wszystkie uprawnienia i nie może być związany z żadnym drzewem).</p></li>
				<li><p><strong>Importuj Twoje dane, lub rozpocznij wpisywanie ręczne</strong>. Jeśli wpisujesz jeden zapis na raz, nie ma znaczenia, od czego zaczynasz.
                                        Najlepiej jest zaczynać od osób, a następnie łączyć je w rodziny. Później dodawać dzieci i w ten sposób budować drzewo. </p></li>
				<li><p><strong>Wejdź na Procesy drugorzędne</strong> (pod Import / Export) i wybierz tam opcje, które uważasz za konieczne (aby uzyskać więcej informacji zobacz "Pomoc").</p></li>
				<li><p><strong>Media.</strong> Gdy dane zostały wpisane lub importowane, możesz zacząć tworzyć łącza do zdjęć, historii i innych mediów. Miłej zabawy!</p></li>
				<li><p><strong>Inne.</strong> Jeśli będziesz chciał zajrzeć do innych sekcji w menu administratora, na każdej stronie możesz znaleźć dodatkową pomoc.</p></li>
		</ol>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="notes"><p class="subheadbold">Uwagi:</p></a>
		<ol>
				<li><p>Jeśli zauważysz brak jakichś opcji w menu Administratora, znaczy to prawdopodobnie, że nie jesteś zalogowany z pełnymi uprawnieniami, albo masz uprawnienia tylko do określonego drzewa.
                                Aby dokonać zmian uprawnień użytkownika, musisz się wylogować i zalogować ponownie jako </p></li>
				<li><p>Link do "Strony publicznej" w menu Administratora po lewej stronie, otwiera okno Twojej przeglądarki w polu obok. Pozwala to na swobodną nawigację na Twojej stronie z możliwością natychmiastowego
                                powrotu do sekcji Administratora. </p></li>
		</ol>

	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="otherresources"><p class="subheadbold">Przydatne adresy i linki:</p></a>
		<ol>
			<li><p>Updates mailing list: <a href="mailto:tngusers@lythgoes.net">tngusers@lythgoes.net</a>. To subscribe, send a message to
				<a href="mailto:tngusers-subscribe@lythgoes.net">tngusers-subscribe@lythgoes.net</a>. This list is used exclusively to inform users of
				software updates and related issues. </p></li>
			<li><p>Users mailing list: <a href="mailto:tngusers2@lythgoes.net">tngusers2@lythgoes.net</a>. To subscribe, send a message to
				  <a href="mailto:tngusers2-subscribe@lythgoes.net">tngusers2-subscribe@lythgoes.net</a>. This list may be used for all discussion among TNG users. </p></li>
			<li><p>Forum użytkowników: <a href="http://tngforum.us" target="_blank">http://tngforum.us</a>.</p></li>
			<li><p>PHP Reference: <a href="http://www.php.net" target="_blank">http://www.php.net</a>.</p></li>
			<li><p>MySQL Reference: <a href="http://www.mysql.com" target="_blank">http://www.mysql.com</a>.</p></li>
			<li><p>HTML Reference: <a href="http://www.htmlhelp.com" target="_blank">http://www.htmlhelp.com</a>.</p></li>
			<li><p>Bezpośredni kontakt z autorem: <a href="mailto:darrin@lythgoes.net">darrin@lythgoes.net</a>.</p></li>
			<li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>
                        </ol>
	</td>
</tr>

</table>
</body>
</html>
