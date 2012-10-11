<?php

header("Content-type:text/xml;charset=utf-8");
error_reporting(0);
define("URL", 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"]);
parse_str($_SERVER['QUERY_STRING']);
if ($key) {
    cctv_key($key);
}
if ($name && $date) {
    cctv_date($name, $date);
}
if ($channel && $playtime) {
    cctv_play($channel, $playtime);
}
defaultXml();

function cctv_play($channel, $playtime) {
    $t = explode('-', $playtime);
    $vdn = 'http://vdn.apps.cntv.cn/api/liveback.do?channel=' . $channel . '&starttime=' . $t[0] . '&endtime=' . $t[1] . '&from=web';
    $vx = json_decode(getStr($vdn))->video->chapters;
    $x = '';
    $du = 0;
    $by = 0;
    $byt = 16101;
    foreach ($vx as $v) {
        $dur = $v->duration;
        $by+=$byt;
        $du+=$dur;
        $x.='<u bytes="' . $byt . '" duration="' . $dur . '" src="' . $v->url . '?start={start_seconds}" />';
    }
    $x.='</m> ';
    $x = '<m starttype="0" label="" type="mp4" bytes="' . $by . '" duration="' . $du . '" bg_video="" lrc="">' . $x;
    echo $x;
    exit;
}

function cctv_date($name, $date) {
    $xmlUrl = 'http://ipad.cntv.cn/nettv/2011jiemudan/xmldata/' . $date . '/' . $name . '.xml';
    $sim = simplexml_load_string(getStr($xmlUrl))->programsback->program;
    $name = $sim->Attributes()->url;
    $name = end(explode('=', $name));
    $x = '<list>';
    $today = date("Y/m/d");
    $hour = strtotime(date("H:i"));
    if ($date == $today) {
        $bool = true;
    }


    foreach ($sim as $si) {
        $atr = $si->Attributes();
        if ($bool) {
            if (strtotime($atr->showTime) > $hour) {
                break;
            }
        }
        $x.='<m label="' . $atr->title . '-' . $atr->showTime . '" type="merge"  src="' . URL . '?channel=' . $name . '&amp;playtime=' . $atr->starttime . '-' . $atr->endtime . '" />';
    }

    $x.='</list>';
    echo $x;
    exit;
}

function cctv_key($key) {
    $Y = date("Y");
    $m = date("m");
    $d = date("d");
    $list = "<list>\n";
    $mon = 7; //设置每个节目显示天数 最大为30天，最小为2
    if ($d >= $mon) {
        for ($i = $d + 0; $i > $d - $mon; $i--) {
            $k = hh($i);
            $riqi = "$Y/$m/$k";
            $list .= "<m   label=\"$riqi\" list_src=\"" . URL . "?name=$key&amp;date=$riqi\" />\n";
        }
    } else {
        for ($i = $d + 0; $i > 0; $i--) {
            $k = hh($i);
            $riqi = "$Y/$m/$k";
            $list .= "<m label=\"$riqi\" list_src=\"" . URL . "?name=$key&amp;date=$riqi\" />\n";
        }
        $j = hh($m - 1);
        $lm = "$Y-$j-$d";
        $days = date('t', strtotime("$lm")); //获取上个月天数
        for ($i = $days; $i > $days + $d - $mon; $i--) {
            $k = hh($i);
            $riqi = "$Y/$j/$k";
            $list .= "<m  label=\"$riqi\" list_src=\"" . URL . "?name=$key&amp;date=$riqi\" />\n";
        }
    }
    header("Content-type: text/xml; charset=utf-8");
    echo $list . "</list>";
    exit;
}

function getStr($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    @ $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function hh($hour) {
    return str_pad($hour, 2, "0", STR_PAD_LEFT);
}

function defaultXml() {
    $array = array(
        'cctv1' => 'CCTV-1综合频道',
        'cctv2' => 'CCTV-2财政频道',
        'cctv3' => 'CCTV-3综艺频道',
        'cctv4' => 'CCTV-4中文国际',
        'cctv5' => 'CCTV-5体育频道',
        'cctv6' => 'CCTV-6电影频道',
        'cctv7' => 'CCTV-7军事农业',
        'cctv8' => 'CCTV-8影剧频道',
        'cctv9d' => 'CCTV-纪录',
        'cctv10' => 'CCTV-10科教频道',
        'cctv11' => 'CCTV-11戏曲频道',
        'cctv12' => 'CCTV-12社会与法',
        'cctvgaoqing' => 'CCTV-HD高清频道',
        'cctvchildren' => 'CCTV-14少儿频道',
        'cctvmusic' => 'CCTV-15音乐频道',
        'cctv9' => 'CCTV-NEWS',
        'cctv13' => 'CCTV-新闻',
        'cctvf' => 'CCTV-法语',
        'cctvarabic' => 'CCTV-阿拉伯语',
        'russian' => 'CCTV-俄语',
        'cctve' => 'CCTV-西语',
        'btv1' => '北京卫视',
        'shanghai' => '东方卫视',
        'tianjin' => '天津卫视',
        'chongqing' => '重庆卫视',
        'sichuan' => '四川卫视',
        'hunan' => '湖南卫视',
        'guangdong' => '广东卫视',
        'hebei' => '河北卫视',
        'shanxi1' => '山西卫视',
        'liaoning' => '辽宁卫视',
        'jilin' => '吉林卫视',
        'zhejiang' => '浙江卫视',
        'anhui' => '安徽卫视',
        'dongnan' => '东南卫视',
        'jiangxi' => '江西卫视',
        'shandong' => '山东卫视',
        'henan' => '河南卫视',
        'hubei' => '湖北卫视',
        'luyou' => '旅游卫视',
        'yunnan' => '云南卫视',
        'shanxi2' => '陕西卫视',
        'gansu' => '甘肃卫视',
        'qinghai' => '青海卫视',
        'guangxi' => '广西卫视',
        'ningxia' => '宁夏卫视',
        'guizhou' => '贵州卫视',
        'heilongjiang' => '黑龙江卫视',
        'neimenggu' => '内蒙古卫视',
        'xinjiang' => '新疆卫视'
    );
    $x = "<list>\n";
    foreach ($array as $k => $v) {
        $x .= "<m list_src=\"" . URL . "?key=$k\" label=\"$v\"/>\n";
    }
    $x .= '</list>';
    echo $x;
}

?>