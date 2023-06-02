<?php require_once('php/_entertainment.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>My First PHP Application</title>
<meta name="description" content="My first PHP application: user and blog comment CRUD (Create/Retrieve/Update/Delete). And other PHP tools software after it.">
<?php EchoInsideHead(); ?>
<link href="../../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(false); ?>

<div>
<h1>My First PHP Application</h1>
<p>Sep 5, 2010
<br />The first time I heard about PHP was from an <a href="../../../ar1688/index.html">AR1688</a> developer.
He told me he had written some PHP script in AR1688 web pages to calculate the total size of the pages in bytes, so the web interface would not fail silently when oversized.
Now I knew he was wrong about the PHP part, maybe he meant Javascript.
<br />Some time later, <a href="../../../res/translation.html#webhosting">Yahoo Web Hosting</a> service which hosted this website prompted me to upgrade from PHP4 to PHP5.
For the second time, I realized that PHP was in my life.
<br />Two months ago I got to know an E-Commercial startup, when I asked what development language they were using, again I had PHP in the answers.
I was so happy that I was not completely blank on the phrase, at least I had heard it twice before.
<br />With so many knowledge about PHP, when <a href="../../../pa6488/index.html">PA6488</a> camera manager software <a href="../../../pa6488/software/camman.html">CamMan</a> need user management function,
I started with PHP on our website at once. Now users can register account to test.
As PA6488 based camera is not available in market yet. Users can test the user management function by posting comments on this blog right now. Only registered user can post comment.
<br />And this is my first PHP application: user and blog comment CRUD (Create/Retrieve/Update/Delete).
<br /><img src=../photo/phpisbest.jpg alt="PHP is the best programming language in the world!" />
</p> 

<h3><?php EchoNameTag('simpletest', ACCOUNT_TOOL_EDIT); ?> User Interface</h3>
<p>Apr 10, 2017
<br /><?php echo GetSimpleTestLink(false); ?> <i>urldecode</i> function.
</p>

<h3><?php EchoNameTag('commonphrase', ACCOUNT_TOOL_PHRASE); ?></h3>
<p>Dec 26, 2017
<br /><?php EchoCommonPhraseLink(false); ?>
</p>

<h3><?php EchoNameTag('primenumber', ACCOUNT_TOOL_PRIME); ?> Tool</h3>
<p>Apr 12, 2019
<br /><?php EchoPrimeNumberLink(false); ?> tool.
<br /><img src=../photo/primenumber.jpg alt="The picture that encouraged me to write this prime nnumber tool." />
</p>

<h3><?php EchoNameTag('benfordslaw', ACCOUNT_TOOL_BENFORD); ?></h3>
<p>Nov 14, 2019
<br /><?php EchoBenfordsLawLink(false); ?>
<br /><img src=../photo/benfordslaw.jpg alt="Benford's Law equation" />
</p>

</div>

<?php _LayoutBottom(false); ?>

</body>
</html>
