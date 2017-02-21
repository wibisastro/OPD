<?
/********************************************************************
*	Date		: Sunday, November 22, 2009
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: eGov Lab UI 
*	Version		: 2 -> 27-Mar-07, 23:17 

# ---- ver 2.1, 02-Apr-07, gabung head dan body ke doc
# ---- ver 2.2, 29-Apr-09, tambah mainmenu dropdown
# ---- ver 2.3, 25-Agu-09, tambah pagetitle di navpath
# ---- ver 2.4, 28-Sep-09, tambah buildsql
# ---- ver 2.5, 22-Nov-09, tambah buildcolumn
# ---- ver 2.6, 28-Jul-11, tambah parse_request
# ---- ver 2.7, 21-Sep-11, perbaikan error_message
# ---- ver 3.0, 15-Apr-14, downgrade untuk publikasi kpu
# ---- ver 3.1, 16-Jan-15, tambahkan fungsi readxml
# ---- ver 3.2, 22-Jan-15, tambahkan fungsi navpath
# ---- ver 4.1, 24-Mar-15, modifikasi fungsi sitemap
# ---- ver 4.2, 25-Mar-15, modifikasi fungsi error_message
# ---- ver 4.3, 25-Mar-15, modifikasi fungsi txt
# ---- ver 5.1, 25-Apr-15, hapus fungsi error_message_ajax, leftside, rightside, error_message_search, sortlist, set_pagerow, table_panel, filter, sort_method, menu_editdel, selectall
# ---- ver 5.2, 27-Apr-15, tambahkan fungsi api
*/

class document {
	function document() {
		global $PHP_SELF,$ses;
		$this->forbiden="This script is not for direct execution";
		if ($ses->cookies["item_perpage"]) {$this->item_perpage=$ses->cookies["item_perpage"];}
		else {$this->item_perpage=12;}
		$this->curdate = date("l")." ".date("j")." ".date("M")." ".date("y").", ".date("H:i");
		$this->querystring(getenv("QUERY_STRING"));
	}
    
	function lnk($link, $text="", $class="", $java="",$title="",$target="",$id="") {
		if ($class) {$class=" class=\"$class\"";}
		if (!$text) {$text=$link;}
		if ($target) {$target=" target=\"$target\"";}
		if ($title) {$title=" title=\"$title\"";}
		if ($id) {$id=" id=\"$id\"";}
		return "<a href=\"$link\"$class $java$title$target$id>$text</a>";
	}

	function txt($name,$style="") {
        $xml=$this->readxml("text");
        foreach ($xml->text as $text) {
            if ($text->name == $name) {
                if ($style) {
                    $result="<span class=$style>$text->text</span>";
                } elseif ($text->type != "button" && $text->type != "label") {
                    $result="<span class=\"$text->type\">$text->text</span>";
                } else {$result=$text->text;}
                break;
            } else {$result="NoText:$name";}
        }
	return $result;
	}

	function img ($src="", $alt="", $url="") {
		if ($url) {return "<img border=\"0\" src=\"$url\" alt=\"$alt\" />";}
		else {return "<img border=\"0\" src=\"images/$src\" alt=\"$alt\" />";}
	}

	function querystring($querystring) {
		if ($querystring) $qsses=explode("&", $querystring);
		for ($a=0;$a<=sizeof($qsses)-1;$a++) {$qsitem=explode("=", $qsses[$a]);$qsarray[$qsitem[0]]=$qsitem[1];}
		$a=0;
		if (is_array($qsarray)) {
			while (list($key,$val)=each($qsarray))  {
				if ($key != "page" && $key != "seq") {$qsresult[$a]=$key."=".$val;$a++;}
			}
			if (is_array($qsresult)) {$this->querystring=implode("&", $qsresult);}
		}
	}

	function content($val) {
		$index=sizeof($this->content);
		$index++;
		if (file_exists(VIWPATH."/$val")) {$this->content[$index]=VIWPATH."/$val";}
		else {$this->content[$index]=$val;}
	}

	function tab($val) {
		$index=sizeof($this->tab);
		$index++;
		$this->tab[$index]=VIWPATH."/$val";
	}

	function strip_java($data) {
		return eregi_replace("<[ \n\r]*script[^>]*>.*<[ \n\r]*/script[^>]*>","",$data);
	}

	function error_message ($message="") {
		global $gov2,$pageID,$_GET,$_POST;
		if ($gov2->error || $this->error) {
			if ($gov2->error) {
				if ($gov2->error=="NotLogin") {
                    unset($this->content);
					$this->content("gov2view.php");
				} else {
					$this->error=$gov2->error;
					$this->error_message=sprintf(strip_tags($this->txt($gov2->error)),$message);
					$this->pagetitle="Authentication Failed";
                    if ($_GET['ajax'] || $_POST['ajax']) {
                        include(VIWPATH."/general/error_privilege.php");
                        exit;
                    }
				}
			} else {
				$this->pagetitle="Invalid Execution";
				$this->error_message=sprintf(strip_tags($this->txt($this->error)),$message);
			}
		}
	}
    
    function readxml($filename) {
        if (file_exists(XMLPATH."/".$filename.".xml")) {
            $result=simplexml_load_file(XMLPATH."/".$filename.".xml");
            return $result;
        } else {
            return "Failed";
        }    
    } 
    
    function navpath($data,$menu_id) {
        static $c; global $navpath;
        $c+=0;
        if (is_array($data->children)) {
            foreach ($data->children as $child) {
                if ((INT)$child->menu_id == (INT)$menu_id) {
                    $c++;
                    $navpath[$c][caption]=$child->caption;
                    $navpath[$c][url]=$child->url;
                } elseif($child->menu) {
                    $b=$c;
                    $this->navpath($child,$menu_id);
                    if ($c>$b) {
                        $c++;
                        $navpath[$c][caption]=$child->caption;
                        $navpath[$c][url]=$child->url;
                        break;
                    }
                }
            }
        }
        if (is_array($navpath)) {arsort($navpath);}
    }
    
    function form ($action, $hidden, $onsubmit="",$name="",$target="") {
		if (!$name) {$name="theForm";}
		if ($target) {$target="target=\"$target\"";}
		$result="<form $target action=\"$action\" method=\"post\" id=\"$name\" name=\"$name\" ";
		if ($onsubmit) {$result.="onsubmit=\"return $onsubmit\"";}
		$result.=" role=\"form\">\n";
		if ($hidden) {
			while (list($key,$val)=each($hidden)) {$result.="<input type=\"hidden\" name=\"$key\" value=\"$val\" />\n";}
		}
	return $result;
	}
    
    function formatBytes($size,$accuracy=2) { 
        $units = array(' b',' Kb',' Mb',' Gb');
        foreach($units as $n=>$u) {
            $div = pow(1024,$n);
            if($size > $div) $output = number_format($size/$div,$accuracy).$u;
        }
        return $output;
    }
}
?>