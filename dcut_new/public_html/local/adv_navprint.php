<?
//echo('<font class="'.$StyleText.'">('.$title.' ');
//echo(($this->NavPageNomer-1)*$this->NavPageSize+1);
//echo(' - ');
//if($this->NavPageNomer != $this->NavPageCount)
//	echo($this->NavPageNomer * $this->NavPageSize);
//else
//	echo($this->NavRecordCount);
//echo(' '.GetMessage("nav_of").' ');
//echo($this->NavRecordCount);
//echo(")\n&nbsp;\n</font>");

echo('<div class="personalNav">');

//if($this->NavPageNomer > 1)
//	echo('<a class="tablebodylink" href="'.$sUrlPath.'?PAGEN_'.$this->NavNum.'=1'.$strNavQueryString.'#nav_start'.$add_anchor.'">'.$sBegin.'</a>&nbsp;|&nbsp;<a class="tablebodylink" href="'.$sUrlPath.'?PAGEN_'.$this->NavNum.'='.($this->NavPageNomer-1).$strNavQueryString.'#nav_start'.$add_anchor.'">'.$sPrev.'</a>');
//else
//	echo($sBegin.'&nbsp;|&nbsp;'.$sPrev);

//echo('&nbsp;|&nbsp;');

$NavRecordGroup = $nStartPage;
while($NavRecordGroup <= $nEndPage)
{
	if($NavRecordGroup == $this->NavPageNomer) 
		echo('<b>'.$NavRecordGroup.'</b>');
	else
		echo('<a class="tablebodylink" href="'.$sUrlPath.'?PAGEN_'.$this->NavNum.'='.$NavRecordGroup.$strNavQueryString.'#nav_start'.$add_anchor.'">'.$NavRecordGroup.'</a>');
	$NavRecordGroup++;
}

//echo('|&nbsp;');
//if($this->NavPageNomer < $this->NavPageCount)
//	echo ('<a class="tablebodylink" href="'.$sUrlPath.'?PAGEN_'.$this->NavNum.'='.($this->NavPageNomer+1).$strNavQueryString.'#nav_start'.$add_anchor.'">'.$sNext.'</a>&nbsp;|&nbsp;<a class="tablebodylink" href="'.$sUrlPath.'?PAGEN_'.$this->NavNum.'='.$this->NavPageCount.$strNavQueryString.'#nav_start'.$add_anchor.'">'.$sEnd.'</a>&nbsp;');
//else
//	echo ($sNext.'&nbsp;|&nbsp;'.$sEnd.'&nbsp;');

echo('</div>');
?>