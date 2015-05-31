// DOCUMENT HTML WRITER FOR TOP OF PAGE \\

var charBreadCrumb = "\u00BB";
var pageTitle;
var pageTitleA;
var pageTitleB;

var charCopyright = "\u00A9";
var copyrightDate = new Date(document.lastModified);
var copyrightYear = copyrightDate.getFullYear();

function Setup()
{
	pageTitle = document.title;
	
	var pageTitleElements = pageTitle.split(" : ");
	
	pageTitleA = pageTitleElements[0];
	pageTitleB = pageTitleElements[1];
}

function WriteOpenSection()
{
	document.write("<table align=\"center\" width=\"900\" cellpadding=\"5\"><tr><td class=\"sect\">");
}

function WriteCloseSection()
{
	document.write("</td></tr></table>");
}

function WriteSiteTitle()
{
	document.write("<center><font class=\"hdr1\">The Brothers Five</font></center>");
}

function WriteBreadCrumbs(useTitleA)
{
	document.write("<span class=\"screen_only\">");
	document.write("<center>");
	document.write("<font class=\"lnk\">" + BreadCrumbLine(useTitleA) + "</font>");
	document.write("</center>");
	document.write("</span>");
}

function WriteDocumentTitle()
{
	document.write("<center>");
	document.write("<br>");
//	document.write("<font class=\"hdr1\">" + pageTitleA + "</font>");
//	document.write("<br>");
	document.write("<font class=\"hdr3\">" + pageTitleB + "</font>");
	document.write("<br>");
	document.write("<span class=\"screen_only\">");
	document.write("<br>");
	document.write("<font class=\"lnk\">" + LinkLine("link", "<br>") + "</font>");
	document.write("</span>");
	document.write("</center>");
}

function BreadCrumbLine(useTitleA)
{
	var crumbs = LinkLine("crumb", " " + charBreadCrumb + " ");
	
	pageTitle = (useTitleA == true) ? pageTitleA : pageTitleB;
	
	crumbs = crumbs + " " + charBreadCrumb + " " + pageTitle;
	
	return crumbs;
}

function LinkLine(attributeType, delimiter)
{
	var metas = document.getElementsByTagName('meta');
	var lineText = "";
	
	for (i = 0; i < metas.length; i++)
	{
		if (metas[i].getAttribute("name") == attributeType)
		{
			crumbItems = metas[i].getAttribute("content").split("|");
			if (lineText == "")
			{
				lineText = BuildLink(crumbItems[0], crumbItems[1]);
			}
			else
			{
				lineText = lineText + "" + delimiter + "" + BuildLink(crumbItems[0], crumbItems[1]);
			}
		}
	}
	
	return lineText;
}

function BuildLink(text, link)
{
	return "<a href=\"" + link + "\">" + text + "</a>";
}

function WriteHeader()
{
	Setup();
	WriteOpenSection();
	WriteSiteTitle();
//	WriteBreadCrumbs(useTitleA);
	WriteDocumentTitle();
	WriteCloseSection();
}

function WriteFooter()
{
	document.write("<table align=\"center\" width=\"900\" cellpadding=\"5\"><tr><td class=\"sect\">");
	document.write("<center>");
	document.write("<font class=\"lnk\">" + copyrightYear.toString() + " The Brothers Five</font>");
	document.write("<span class=\"screen_only\">");
	document.write("<font class=\"lnk\"> | </font>");
	document.write("<font class=\"lnk\">Contact <a href=\"mailto:webmaster@brothersfive.ca\">Webmaster</font></a>");
	document.write("</span>");
	document.write("</center>");
	document.write("</td></tr></table>");
}
