<?php
include("../subroot.php");
include($subroot . "config.php");
include("adminlib.php");
$textpart = "index";
include("../getlang.php");
include("../$mylanguage/admintext.php");
tng_db_connect($database_host,$database_name,$database_username,$database_password) or exit;
include("checklogin.php");
include("../version.php");
include($subroot . "importconfig.php");

if( !$allow_add || !$allow_add || !$allow_edit || $assignedbranch ) {
	$message = "$admtext[norights]";
	header( "Location: login.php?message=" . urlencode($message) );
	exit;
}

if( $assignedtree )
	$wherestr = "WHERE gedcom = \"$assignedtree\"";
else
	$wherestr = "";
$query = "SELECT gedcom, treename FROM $trees_table $wherestr ORDER BY treename";
$result = mysql_query($query) or die ("$admtext[cannotexecutequery]: $query");
$numtrees = mysql_num_rows($result);


$treenum = 0;
$trees = array();
$treename = array();
while( $treerow = mysql_fetch_assoc($result) ) {
	$trees[$treenum] = $treerow[gedcom];
	$treename[$treenum] = $treerow[treename];
	$treenum++;
}
mysql_free_result($result);

$helplang = findhelp("data_help.php");

$flags[tabs] = $tngconfig[tabs];
tng_adminheader( $admtext[datamaint], $flags );
?>
<script type="text/javascript" src="mediautils.js"></script>
<script type="text/javascript">
var tnglitbox;
function checkFile(form)
{
	var rval = true;
	if( form.remotefile.value.length == 0 && form.database.value.length == 0 ) {
		alert( "<?php echo $admtext['selectimportfile']; ?>" );
		rval = false;
	}
	else if( form.tree1.options[form.tree1.selectedIndex].value == "" && !form.eventsonly.checked) {
		alert( "<?php echo $admtext['selectdesttree']; ?>" );
		rval = false;
	}
	return rval;
}

function toggleAppenddiv(flag) {
	if(flag)
		new Effect.Appear('appenddiv',{duration:.2});
	else
		new Effect.Fade('appenddiv',{duration:.2});
}

function toggleNorecalcdiv(flag) {
	if(flag)
   		new Effect.Appear('norecalcdiv',{duration:.2});
	else
   		new Effect.Fade('norecalcdiv',{duration:.2});
}

function toggleSections(flag) {
	new Effect.toggle('desttree','appear',{duration:.4});
	new Effect.toggle('replace','appear',{duration:.4});
	new Effect.toggle('ioptions','appear',{duration:.4});
	document.form1.action = flag ? 'gedimport_eventtypes.php' :  document.form1.action = 'gedimport.php';
	if(flag) document.form1.allevents.checked = "";
}

function validateTreeForm(form) {
	if( form.gedcom.value.length == 0 ) {
		alert('<?php echo $admtext['entertreeid']; ?>');
		rval = false;
	}
	else if( !alphaNumericCheck(form.gedcom.value) ) {
		alert("<?php echo $admtext['alphanum']; ?>");
	}
	else if( form.treename.value.length == 0 ) {
		alert("<?php echo $admtext['entertreename']; ?>");
	}
	else {
		var params = Form.serialize(form);
		new Ajax.Request('addtree.php',{
			parameters:params,
			onSuccess:function(req){
				if(req.responseText == "1") {
					tnglitbox.remove();
					var treeselect = document.form1.tree1;
					var i = treeselect.options.length;
					if(navigator.appName == "Netscape") {
						treeselect.options[i] = new Option(form.treename.value,form.gedcom.value,false,false)
					}
					else if( navigator.appName == "Microsoft Internet Explorer") {
						treeselect.add(document.createElement("OPTION"));
						treeselect.options[i].text=form.treename.value;
						treeselect.options[i].value=form.gedcom.value;
					}
					treeselect.selectedIndex = i;
				}
				else
					$('treemsg').innerHTML = req.responseText;
			}
		});
	}
	return false;
}	

function alphaNumericCheck(string){
	var regex=/^[0-9A-Za-z_-]+$/; //^[a-zA-z]+$/
	return regex.test(string);
}

var branches = new Array();
var branchcounts = new Array();
<?php
$treectr = 0;
for( $i=0; $i<$treenum; $i++ ) {
	$treeref = $trees[$i] ? $trees[$i] : "none";
	echo "branchcounts['$treeref']=-1;\n";
	$treectr++;
}
?>
function getBranches(treeselect) {
	if(treeselect.selectedIndex) {
		var tree = treeselect.options[treeselect.selectedIndex].value
		var treeidx = tree ? tree : 'none';
	
		if(branchcounts[treeidx] == -1) {
			var params = "tree="+tree;
			new Ajax.Request('branchoptions.php',{
				parameters:params,
				onSuccess:function(req){
					branchcounts[treeidx] = req.responseText == "0" ? 0 : 1; 
					if(branchcounts[treeidx]) {
						branches[treeidx] = req.responseText;
					}
					showBranches(treeidx);
				}
			});
		}
		else
			showBranches(treeidx);
	}
	else
		new Effect.Fade('destbranch',{duration:.2});
}

function showBranches(treeidx) {
	if(branchcounts[treeidx] == 1) {
		$('branch1div').innerHTML = '<select name="branch1" id="branch1">' + branches[treeidx] + '</select>';
		new Effect.Appear('destbranch',{duration:.2});
	}
	else {
		new Effect.Fade('destbranch',{duration:.2});
	}
}
</script>
</head>

<body background="../background.gif">

<?php
	$datatabs[0] = array(1,"dataimport.php",$admtext[import],"import");
	$datatabs[1] = array($allow_ged,"export.php",$admtext[export],"export");
	$datatabs[2] = array(1,"secondmenu.php",$admtext[secondarymaint],"second");
	$innermenu = "<a href=\"javascript:newwindow=window.open('../$helplang/data_help.php', 'newwindow', 'height=500,width=700,resizable=yes,scrollbars=yes'); newwindow.focus();\" class=\"lightlink\">$admtext[help]</a>";
	$menu = doMenu($datatabs,"import",$innermenu);
	echo displayHeadline("$admtext[datamaint] &gt;&gt; $admtext[gedimport]","data_icon.gif",$menu,$message);
?>

<form action="gedimport.php" name="form1" style="margin:0px;" method="post" ENCTYPE="multipart/form-data" onsubmit="return checkFile(this);">
<table width="100%" border="0" cellpadding="10" cellspacing="2" class="lightback">
<tr class="databack">
<td class="tngshadow">
	<div class="normal">
	<em><?php echo $admtext['addreplacedata']; ?></em><br/><br/>

	<p class="subhead"><strong><?php echo $admtext['importgedcom']; ?>:</strong></p>
	<table border="0" cellpadding="1" class="normal">
		<tr>
			<td>&nbsp;&nbsp;<?php echo $admtext['fromyourcomputer']; ?>: </td><td><input type="file" name="remotefile" size="50"></td>
		</tr>
		<tr>
			<td>&nbsp;&nbsp;<strong><?php echo $admtext['text_or']; ?></strong> &nbsp;<?php echo $admtext['onwebserver']; ?>: </td>
			<td><input type="text" name="database" id="database" size="50"><input type="hidden" id="database_org" value=""><input type="hidden" id="database_last" value=""> <input type="button" value="<?php echo "$admtext[select]..."; ?>" name="gedselect" onclick="javascript:FilePicker('database','gedcom');"></td>
		</tr>
		<tr>
			<td colspan="2"><br/>
				<input type="checkbox" name="allevents" value="yes" onclick="if(document.form1.allevents.checked && document.form1.eventsonly.checked) {document.form1.eventsonly.checked ='';toggleSections(false)}" /> <?php echo $admtext['allevents']; ?>&nbsp;&nbsp;
				<input type="checkbox" name="eventsonly" value="yes" onclick="toggleSections(this.checked);" /> <?php echo $admtext['eventsonly']; ?>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow" id="desttree">
	<p class="subhead"><strong><?php echo $admtext['selectexisting']; ?>:</strong></p>
	<table border="0" cellpadding="1" class="normal">
		<tr id="desttree2">
			<td>&nbsp;&nbsp;<?php echo $admtext['desttree']; ?>:</td>
			<td>
				<select name="tree1" id="tree1" onchange="getBranches(this);">
<?php
if($numtrees != 1) echo "	<option value=\"\"></option>\n";
$treectr = 0;
for( $i=0; $i<$treenum; $i++ ) {
	echo "	<option value=\"$trees[$treectr]\"";
	if( $newtree && $newtree == $trees[$treectr] ) echo " selected";
	echo ">$treename[$treectr]</option>\n";
	$treectr++;
}
?>
				</select>
<?php
	if( !$assignedtree ) {
?>
				&nbsp; <input type="button" name="newtree" value="<?php echo $admtext[addnewtree]; ?>" onclick="tnglitbox = new LITBox('newtree.php?beforeimport=yes',{width:600,height:510});">
<?php
	}
?>
			</td>
		</tr>
		<tr id="destbranch" style="display:none">
			<td>&nbsp;&nbsp;<?php echo $admtext['destbranch']; ?>:</td>
			<td>
				<div id="branch1div">
				<select name="branch1" id="branch1">
				</select>
				</div>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr class="databack">
<td class="tngshadow">
	<table border="0" cellpadding="1" class="normal">
		<tr id="replace">
			<td colspan="2">
				<p class="subhead"><strong><?php echo $admtext['replace']; ?>:</strong></p>
				<input type="radio" name="del" value="yes"<?php if($tngimpcfg['defimpopt'] == 1) echo " checked=\"checked\""; ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(0);"> <?php echo $admtext['allcurrentdata']; ?> &nbsp;
				<input type="radio" name="del" value="match"<?php if(!$tngimpcfg['defimpopt']) echo " checked=\"checked\""; ?> onclick="toggleNorecalcdiv(1); toggleAppenddiv(0);"> <?php echo $admtext['matchingonly']; ?> &nbsp;
				<input type="radio" name="del" value="no"<?php if($tngimpcfg['defimpopt'] == 2) echo " checked=\"checked\""; ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(0);"> <?php echo $admtext['donotreplace']; ?> &nbsp;
				<input type="radio" name="del" value="append"<?php if($tngimpcfg['defimpopt'] == 3) echo " checked=\"checked\""; ?> onclick="document.form1.norecalc.checked = false; toggleNorecalcdiv(0); toggleAppenddiv(1);"> <?php echo $admtext['appendall']; ?><br /><br />
				<span style="font-size:11px;"><em><?php echo $admtext['imphints']; ?></em></span>
			</td>
		</tr>
		<tr id="ioptions">
			<td valign="top">
				<br/>
				<div><input type="checkbox" name="ucaselast" value="1"> <?php echo $admtext['ucaselast']; ?></div>
				<div id="norecalcdiv" style="display:none">
					<input type="checkbox" name="norecalc" value="1"> <?php echo $admtext['norecalc']; ?><br>
					<input type="checkbox" name="neweronly" value="1"> <?php echo $admtext['neweronly']; ?><br>
				</div>
				<div><input type="checkbox" name="importmedia" value="1"> <?php echo $admtext['importmedia']; ?></div>
				<div><input type="checkbox" name="importlatlong" value="1"> <?php echo $admtext['importlatlong']; ?></div>
			</td>
			<td valign="top">
				<br/>
					<div id="appenddiv" style="display:none;">
					<input type="radio" name="offsetchoice" value="auto" checked> <?php echo $admtext['autooffset']; ?>&nbsp;<br/>
					<input type="radio" name="offsetchoice" value="user"> <?php echo $admtext['useroffset']; ?>&nbsp;<input type="text" name="useroffset" size="10" maxlength="9">
					</div>
			</td>
		</tr>
	</table><br/>
	<input type="submit" name="submit" value="<?php echo $admtext['importdata']; ?>">
	</div>
</td>
</tr>
</table>
</form>
<?php echo "<div align=\"right\"><span class=\"normal\">$tng_title, v.$tng_version</span></div>"; ?>
</body>
</html>
