<?php
$xml="<list>\n";
$php='http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
function g_c($url) {
$user = $_SERVER['HTTP_USER_AGENT'];
$ch = curl_init();
$timeout = 40;
curl_setopt($ch, CURLOPT_USERAGENT, $user);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
@ $file = curl_exec($ch);
curl_close($ch);
       return $file;
}
function g_lists(){
$php='http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$src='http://www.111ttt.com';
$m='';
$m.='<m list_src="'.$php.'?list='.$src.'/xc/" label="�ֳ�����"/>'."\n";
$m.='<m list_src="'.$php.'?list='.$src.'/myxc/" label="��ҡ����"/>'."\n";
$m.='<m list_src="'.$php.'?list='.$src.'/zw/" label="��������"/>'."\n";
$m.='<m list_src="'.$php.'?list='.$src.'/my/" label="��ҡ����"/>'."\n";
$m.='<m list_src="'.$php.'?list='.$src.'/yw/" label="Ӣ������"/>'."\n";
$m.='<m list_src="'.$php.'?list='.$src.'/jy/" label="��������"/>'."\n";
$m.='<m list_src="'.$php.'?list='.$src.'/fc/" label="�������"/>'."\n";
$m.='<m list_src="'.$php.'?list='.$src.'/zh/" label="�ۺ�����"/>'."\n";
return $m;
}
function g_page($url){
$php='http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
$m='';
$file=g_c($url);
preg_match('|<a class=\"mpage\" href=\"(.*).htm\">ĩҳ</a>|ims',$file,$u);
$x=$u[1];
if(strpos($x,'.') > 0 ){$n=explode('.',$x);
$num=$n[0]+1;
}else{$num=$x;}
for($i=1;$i<=$num;$i++){
$m.='<m list_src="'.$php.'?type='.$url .$i.'.htm" label="�� '.$i.' ҳ"/>'."\n";
}
return $m;
}
function g_f($url){
$php='http://yinyuet.sinaapp.com/code/111.php';
$m='';
$file = g_c($url);
$preg="#input type=\"checkbox\" value=\"(.*)\" name=\"t\"></td><td class=\"mName\" onclick=\"(.*)</td><td><a target=\"t\" href#iUs";
preg_match_all($preg,$file,$u);
foreach($u[2] as $id=>$v){
	ereg("<a target=\"t\" href=\"(.*)\">(.*)</a>", $v, $src);
	$src[1] =str_replace("\">","\" label=\"",$src[1]);
$src[2] =str_replace("<font color=\"ff0000\">[�Ƽ�]</font>","",$src[2]);
$src[2] =str_replace("<font color=\"ff0000"," ",$src[2]);
$sr='http://www.111ttt.com';
$m.='<m list_src="'.$php.'?id='.$sr . $src[1].'" label="'.$src[2].'"/>'."\n";
}
return $m;
}
/*function g_g($url){
*ʡ����Ԥ����ַhttp://yinyuet.sinaapp.com
}*/
if(isset ($_GET['list'])){
$xml.=g_page($_GET['list']);
}
elseif(isset ($_GET['type'])){
$n = explode('-',$_GET['type']);
$xml.=g_f($n[0],$n[1]);
}
else{
$xml.=g_lists();
}
$xml.="</list>\n";
echo $xml;
?>