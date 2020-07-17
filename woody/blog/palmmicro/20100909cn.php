<?php require_once('php/_palmmicro.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>忘记密码?</title>
<meta name="description" content="Palmmicro AR1688和PA1688密码相关问题. 虽然这篇网络日志部分来说是被某个寻找AR1688密码的客户所激发, 我的主要目的还是想宣传注册我们的网站帐号并发表网络日志评论.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(); ?>

<div>
<h1>忘记密码?</h1>
<p>2010年9月9日
<br />在<a href="../../../ar1688/indexcn.html">AR1688</a>的登录网页界面上会询问密码. 我们在AR1688设备的安全性上其实很随意, 原始密码无非是12345678或者完全空白. 万一用户忘记了密码, 可以按照以下步骤找回来:
</p>
<ol>
  <li><a href="../../../ar1688/softwarecn.html">下载</a>一份AR1688软件API.</li>
  <li>把下载文件解压缩到c:\sdcc.</li>
  <li>进入命令行下c:\sdcc\bin.</li>
  <li>执行命令: "getopt xxx.xxx.xxx.xxx".</li>
  <li>修改options.txt文件中"admin_pin"(保存密码位置)的部分.</li>
  <li>执行命令: "setopt xxx.xxx.xxx.xxx".</li>
</ol>
<p>getopt.bat和setopt.bat批处理文件中都调用tftp.exe, 要确认Windows系统中安装了它. 
<br /><a href="../../../pa1688/indexcn.html">PA1688</a>的网页界面用到了2个密码. 用普通密码登录后, 跟运营商有关的设置是看不到的. 用户必须用"超级"密码登录才能看到全部界面.
2个密码都可以用<a href="../../../pa1688/software/palmtoolcn.html">PalmTool</a>.exe更改:
</p>
<ol>
  <li>设置好"片上IP地址"后点击PalmTool的"话机设置"直接连接设备. 如果可以连接上, 就可以在设置对话框中直接修改.</li>
  <li>当"调试级别"选项是关闭的时候, PalmTool连不上设备, 用户会得到如"Can not connect to Palm1"这样的提示.</li>
  <li>然而在<a href="../pa6488/20090927cn.php">安全模式</a>下调试级别设置总是打开的. 用户可以在按下*号键的同时加电起动2次, 此时设备的IP地址会是缺省的192.168.1.100(MAC地址缺省是00-09-45-00-00-00).
      再次使用PalmTool连接修改即可.</li>
</ol>
<p>忘记了我们网站登录密码? 访问密码<a href="../../../account/remindercn.php">提醒</a>页面即可. 新的密码会发送到注册电子邮箱.  
<br />为什么不简单的送回原来的密码, 而是要新产生一个呢? 因为我们并没有保存用户密码, 保存在数据库中用户密码项的数据是根据密码产生的MD5加密串, 理论上这个加密是不可逆的, 就是说不能从加密串再反过来得到原始串. 
<br />最后我要承认, 虽然这篇网络日志部分来说是被某个寻找AR1688密码的客户所激发, 我的主要目的还是想宣传新写的<a href="../entertainment/20100905cn.php">PHP</a>软件: 注册我们的网站帐号并发表网络日志评论.
这也是为什么它被放到了<a href="20080326cn.php">Palmmicro</a>的分类中. 
</p>
</div>

<?php _LayoutBottom(); ?>

</body>
</html>
