<div class="menu">
<form action="<?php eh($site); ?>search/" method="GET">
<input type="text" name="keyword" value="" />
<input type="submit" value="検索" />
&nbsp;&nbsp;&nbsp;<a href="<?php eh($site); ?>logout/">ログアウト</a>
</form>
</div>
<?php if (!$mypage) { ?>
<a href="<?php eh($site); ?>home/">マイページへ</a>&nbsp;&nbsp;
<?php if (isset($error)) { ?>
<?php } else if (!$isFollow) { ?>
<a href="<?php eh($site); ?>follow/?user=<?php eh($owner["username"]); ?>">フォローする</a><br />
<?php } else { ?>
フォロー中<br />
<?php } ?>
<?php } ?>
<h2><?php eh($owner["nickname"]); ?>さんのページ</h2>
<script type="text/javascript">
<!--
    function showTweetRest() {
        var textLength = document.tweetform.tweet.value.length;
        document.getElementById('tweetrest').innerHTML = 120 - textLength;
    }
//-->
</script>
<?php if ($mypage) { ?>
<div class="tweet">
<?php eh($user["nickname"]); ?>さん&nbsp;いまどうしてる？<br />
<form name="tweetform" action="<?php eh($site); ?>home/tweet/" method="POST">
  <?php $this->tokenTag(); ?>
  <textarea name="tweet" rows="4" cols="40" onkeydown="showTweetRest();"></textarea><br />
  残り<span id="tweetrest">120</span>文字 <input type="submit" value"つぶやく" />
</form>
</div>
<?php } ?>
<?php if (isset($error)) { ?>
<?php foreach ($error as $e) { ?>
<span style="color:red;"><?php eh($e); ?></span><br />
<?php } ?>
<?php } ?>
<div class="timeline">
<?php if (isset($timeline)) { ?>
<table>
<?php foreach ($timeline as $tweet) { ?>
<tr>
<td><?php eh($tweet{"User"}["nickname"]); ?></td>
</tr>
<tr>
<td><?php eh($tweet["text"]); ?>&nbsp;&nbsp;&nbsp;<?php eh($tweet["created"]); ?></td>
</tr>
<?php } ?>
</table>
<?php } ?>
</div>
<br />
<div class="follow" style="float:left;margin-right:30px;">
<h3>フォローしている</h3>
<?php if (isset($follow) && $follow) { ?>
<?php foreach ($follow as $f) { ?>
<a href="<?php eh($site) ?>home/?user=<?php eh($f["User"]["username"]); ?>"><?php eh($f["User"]["username"]); ?></a>&nbsp;<?php eh($f["User"]["nickname"]); ?><br />
<?php } ?>
<?php } ?>
</div>
<div class="follower" style="float:left;">
<h3>フォローされている</h3>
<?php if (isset($follower) && $follower) { ?>
<?php foreach ($follower as $f) { ?>
<a href="<?php eh($site) ?>home/?user=<?php eh($f["User"]["username"]); ?>"><?php eh($f["User"]["username"]); ?></a>&nbsp;<?php eh($f["User"]["nickname"]); ?><br />
<?php } ?>
<?php } ?>
</div>
