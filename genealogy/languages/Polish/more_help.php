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
			<a href="events_help.php" class="lightlink">&laquo; Pomoc: Wydarzenia</a> &nbsp; | &nbsp;
			<a href="media_help.php" class="lightlink">Pomoc: Media &raquo;</a>
		</p>
		<span class="largeheader">Pomoc: Więcej</span>
		<p class="smaller menu">
			<a href="#more" class="lightlink">Więcej informacji</a>
		</p>
	</td>
</tr>
<tr class="databack">
	<td class="tngshadow">

		<a name="more"><p class="subheadbold">Więcej informacji</p></a>
		<p>To okienko pozwala na wprowadzenie dodatkowych informacji związanych ze standardowymi rodzajami wydarzeń TNG. Kiedy jedno lub więcej z tych pól jest wypełnione, ikonka "Więcej" (znak plus)
                będzie miała zieloną kropkę w rogu. Pola w okienku "Więcej informacji" obejmują:</p>

        <p><span class="optionhead">Wiek</span>: Wiek osoby w czasie wydarzenia.</p>

        <p><span class="optionhead">Urząd</span>: Kompetentny i / lub odpowiedzialny w momencie wydarzenia organ lub instytucja.</p>

        <p><span class="optionhead">Przyczyna</span>: Przyczyna zdarzenia (najczęściej używane ze śmiercią).</p>

        <p><span class="optionhead">Adres 1/Adres 2/Miasto/Województwo/Kod pocztowy/Kraj/Telefon/E-mail/Strona Web</span>: Adres oraz inne informacje kontaktowe związane z wydarzeniem..</p>

        <p><span class="optionhead">Wymagane pola:</span>
		<p>Żadna z tych informacji nie jest wymagana.</p>
	<li><p>Uwagi dotyczące polskiego tłumaczenia: <a href="mailto:januszkielak@gmail.com">januszkielak@gmail.com</a>. Prosimy zgłaszać ewentualne błędy lub niejasności.</p></li>	
	</td>
</tr>

</table>
</body>
</html>
