<?php
	echo "var branchids = new Array();\n";
	echo "branchids['none'] = new Array(\"\");\n";
	echo "var branchnames = new Array();\n";
	echo "branchnames['none'] = new Array(\"$admtext[nobranch]\");\n";
	$swapbranches = "swapBranches();\n";
	$dispid = "";
	$dispname = "";
	
	$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
	$treeresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
	while( $treerow = mysql_fetch_assoc( $treeresult ) ) {
		$nexttree = $treerow[gedcom];
		$dispid .= "branchids['$nexttree'] = new Array(\"\"";
		$dispname .= "branchnames['$nexttree'] = new Array(\"$admtext[nobranch]\"";

		$query = "SELECT branch, gedcom, description FROM $branches_table WHERE gedcom = \"$nexttree\" ORDER BY description";
		$branchresult = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
		
		while( $branch = mysql_fetch_assoc( $branchresult ) ) {
			$dispid .= ",\"$branch[branch]\"";
			$dispname .= ",\"" . addslashes(trim($branch[description])) . "\"";
		}
		mysql_free_result( $branchresult );
		$dispid .= ");\n";
		$dispname .= ");\n";
	}
	mysql_free_result( $treeresult );
	echo $dispid;
	echo $dispname;
?>
function swapBranches() {
	var tree=getTree();
	var len = 0;
	document.form1.branch.options.length = 0;
	if($('branchlist'))
		$('branchlist').innerHTML = '';

	if(navigator.appName == "Netscape") {
		var isselected;
		for( var i = 0; i < branchids[tree].length; i++ ) {
			if( !i ) 
				document.form1.branch.options[len] = new Option(branchnames[tree][i],branchids[tree][i],false,true);
			else
				document.form1.branch.options[len] = new Option(branchnames[tree][i],branchids[tree][i],false,false);
			len = len + 1;
		}
	}
	else {
		for( var i = 0; i < branchids[tree].length; i++ ) {
			var newElem = document.createElement("OPTION");
			len = len + 1;
			newElem.text = branchnames[tree][i];
			newElem.value = branchids[tree][i];
			if( !i ) newElem.selected = true;
			document.form1.branch.options.add(newElem);
		}
	}
}