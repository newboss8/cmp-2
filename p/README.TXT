本程序由 焱燚｜7huo 提供学习使用，请务必遵守协议说明。
希望朋友可以加个友情链接，我灵网 www.wo0.cn ,互链请联系。


什么是P程序：
－－－－
P程序及CMP预处理程序（代理），通过处理外部数据，输出CMP支持的数据格式。

调用方式：
－－－－
P/参数0/参数1/参数2[/参数N……]
P/网址
如：
p/?tudou/view/1_MjwWdvOck.tudou
p/?http://www.tudou.com/programs/view/1_MjwWdvOck

服务器配置：
－－－－
  开启php组件curl（打开php.ini搜索curl删除前面的分号，如是windos主机要把php_curl.dll复制到C:\Windows\System32，重启）

单项调用：
－－－－
  参数0：来源网站英文名称
  参数1：ID（标识符）
  参数2：特殊（标识符）
  参数N：如需要可以添加
  
  为方便大家使用提供转换工具http://wo0.cn/cmp/p_list

  *列表配置（list.xml）：

  *说明：
  type必需填写（1>MP3音频 2>FLV/MP4视频 3>WMP类型 4>flash）。
  例2采用跳板与本地调用相结合方法。
  名称后加2为跳板，节省本地服务器资源，但可能被屏蔽。

全局调用：
－－－－
  *配置文件（config.xml）：
  曲目匹配：src_handler = "p/?src/{label}/{type}"
  歌词匹配：lrc_handler = "p/?lrc/{label}/{type}"
  随机背景：backgrounds = "p/?bg/rand"
  背景匹配：backgrounds = "p/?bg/{label}/{type}"

  *列表配置（list.xml）设置：
  <m type="1" label="标签" />

  *说明：
  type必需填写（1>MP3音频 2>FLV/MP4视频 3>WMP类型 4>flash）。

特别说明：
－－－－
  调用优先级：src->bak-config（全局调用参数）
  Apache内rewrite开启方法:http://wo0.cn/?q=apache%E5%86%85rewrite%E5%BC%80%E5%90%AF
  如不支持rewrite调用网址改为：p?q=参数1/参数2/参数3 （即把p/替换成p?q=）
  不支持56、




扩展示例：
－－－－
比如我们想得到http://127.0.0.1/cmp/help/app_readme.htm
下面是一个完整的代码
  
  case '7huo'://本地测试示例，你可以把这里改成你自己的采集。
    $url = "http://127.0.0.1/cmp/help/".$id;//来路url，就是要采集的网址
    $src =get_data($url,'/<td>(.*)<\/td>/');//正则匹配，从网页内取得所要内容
    $src = "http://127.0.0.1/cmp/".$src;//组合提取网址，后处理部分，如果上一步已经得到完全地址可删除本行。
    echo $url ;//输出文本
  break;

正则部分：
    打开http://127.0.0.1/cmp/help/app_readme.htm找到我们要的地址在<td>music/test.mp3</td>
  正则就写成/<td>(.*)<\/td>/  (.*)就是我们要的网址了，正则的写法请google正则。