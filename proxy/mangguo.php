<?php

header("Content-type:text/xml;charset=utf-8");
define("URL", 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"]);
if (@$id = $_GET['id']) {
    mgoid($id);
}
mgoindex();

function mgoid($id) {
    $par = C('http://mlive.imgo.tv/bcEPG/GetBCPara.aspx?ChannelId=' . $id . '&ClientTypeId=1');
    $par = strtr($par, array('-' => '=', '\r\n' => '', '^' => '/'));
    $parson = base64_decode($par);
    $partten = base64_encode($parson . '&key=23388112815956771374733077204786241412');
    $partten = strtr($partten, array('=' => '-', '/' => '^'));
    parse_str($parson);
    $live = 'http://' . $ip . ':' . $port . '/live.flv?client=flash&pars=' . $partten . '&vcode=2761216233';
    H($live);
}

function mgoindex() {
    $r = array('7' => '湖南卫视', '8' => '国际频道', '15' => '金鹰卡通', '17' => '青海卫视', '9' => '湖南经视', '10' => '湖南娱乐', '16' => '快乐购物', '13' => '金鹰纪实', '23' => '天元围棋', '21' => '先锋兵羽', '18' => '快来垂钓', '24' => '四海钓鱼', '20' => '江苏靓妆', '31' => '高尔夫频道', '19' => 'CCTV高尔夫球');
    $x = '<list><m label="芒果大全">';
    foreach ($r as $k => $v) {
        $x.='<m label="' . $v . '"  src="' . URL . '?id=' . $k . '" type="2"  />';
    }
    $x.='</m></list>';
    die($x);
}

function H($a) {
    header("location:$a");
}

function P($a, $b, $c, $d = 1) {
    $e = 'preg_match' . ($c == '1' ? '_all' : '');
    $e($a, $b, $f);
    return $f[$d];
}

function J($s) {
    return json_decode($s);
}

function C($u) {
    for ($i = 0; $i < 3; $i++) {
        @$d = file_get_contents($u);
        if ($d)
            break;
    }return ($d ? $d : false);
}
