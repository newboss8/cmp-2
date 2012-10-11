<?php

function _7huo_codec_info() {
  $codecs = array();

  $codecs['youku'] = array(
      'name' => 'YouKu',
      'sample_url' => 'http://v.youku.com/v_show/id_XMjM2MDYxMzY0=.html',
      'regexp' => '/v\.youku\.com\/v_show\/id_([\S]+)\.html/i',
  );
  $codecs['youku_list'] = array(
      'name' => 'YouKu list',
      'sample_url' => 'http://www.youku.com/playlist_show/id_2198_ascending_1_page_1.html',
      'regexp' => '/youku\.com\/playlist_show\/id_([\S]+)+/i',
  );
  $codecs['tudou'] = array(
      'name' => 'tudou',
      'sample_url' => 'http://www.tudou.com/programs/view/rwQ4CNxNbQ0/',
      'regexp' => '/tudou.*\/programs\/view\/([a-zA-Z0-9\-_=]+)[\/]*/i',
  );
  $codecs['xiu_56'] = array(
      'name' => '56xiu',
      'sample_url' => '',
      'regexp' => '/56\/xiu\/(\d*)[\/]*(\d*)/i',
  );
  $codecs['bg'] = array(
      'name' => 'bg',
      'sample_url' => '',
      'regexp' => '/bg\/rd/i',
  );
  $codecs['help'] = array(
      'name' => 'help',
      'sample_url' => 'help',
      'regexp' => '/help/i',
  );
  return $codecs;
}

function _7huo_xiu_56() {
  global $vars;
  $vars['source'] = 'http://xiu.56.com/api/liveListv3.php?gtype=' . $vars['codec']['matches'][1] . '&Type=' . $vars['codec']['matches'][2];
  $str = file_data($vars['source']);
  $vars['ar'] = json_decode($str, true);
  $vars['ar'] = $vars['ar']['roomArray'];
  $z = '';
  foreach ($vars['ar'] as $k => $v) {
    $n = sprintf("%02d", $k + 1);
    $z .= '<m type="2" src="' . $vars['ar'][$k]['token'] . '"  rtmp="rtmp://play.xiu.v-56.com/vshow" label="' . $n . '. ' . $vars['ar'][$k]['nickname'] . '" />' . "\n";
  }
  $vars['xml'] = '<list>' . "\n" . $z . '</list>';
}

function _7huo_tudou() {
  global $vars;
  $vars['source'] = 'http://www.tudou.com/programs/view/' . $vars['codec']['matches'][1];
  $str = file_data($vars['source']);
  $vars['preg0'] = '/iid.*?([0-9]+)/';
  preg_match($vars['preg0'], $str, $vars['ar0']);
  $vars['src0'] = $vars['ar0'][1];
  $vars['src'] = "http://v2.tudou.com/v2/cdn?id=" . $vars['src0'];
}

function _7huo_youku() {
  global $vars;
  $vars['src'] = 'https://7huo.googlecode.com/svn/trunk/cmp/cmpn.swf';
}

function _7huo_help() {
  global $vars;
  $vars['txt'] = _7huo_instructions();
}

function _7huo_bg() {
  global $vars;

  $page = array(
      //随机背景，每行一个。
      //'/cmp/plugins/bigbg.swf',
      //'/cmp/logo.png',
      'http://news.xinhuanet.com/game/2005-02/06/xinsrc_40202020615514219632450.jpg',
      'http://www.qqtn.com/up/2010-6/201061018247.jpg',
      'http://news.xinhuanet.com/game/2005-02/06/xinsrc_422020206155100021334453.jpg',
      'http://news.xinhuanet.com/game/2005-02/06/xinsrc_012020206155375021374459.jpg',
      'http://news.xinhuanet.com/game/2004-12/01/xinsrc_5521201011441096530544.jpg',
      'http://op.manmankan.com/UploadFiles_9531/201008/20100826105657449.jpg',
  );
  $key = array_rand($page, 1);
  $vars['src'] = $page[$key];
}