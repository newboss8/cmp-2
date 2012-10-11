<?php

//http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshareget_urlinfoforQQ?xmlout=1&url=http://www.tudou.com/albumplay/rPLUN_vz3OY/XImkj-55GkI.html
/**
 * 本程序由 焱燚｜7huo 提供学习使用，请务必遵守协议说明。
 * 希望朋友可以加个友情链接，我灵网 www.wo0.cn ,互链请联系。
 */
include('codecs.php');
include('function.php');
$vars = array(
    'bug' => 0,
    'host' => 0,
    'cache' => 1,
    'curl' => 1,
    'base64' => 0,
    'cache_time' => 2 * 60 * 60,
    'source' => $_SERVER["QUERY_STRING"]
);
if ($vars['host'] == 1) {
  $vars['domains'] = array('wo0.cn', 'www.wo0.cn', 'haotinggequ.com', 'www.haotinggequ.com'); //白名单
}
if (!$vars['source']) {
  $vars['source'] = "help";
  _7huo_process();
}
output();
