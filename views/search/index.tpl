<div class="menu">
<form action="<?php eh($site); ?>search/" method="GET">
<input type="text" name="keyword" value="" />
<input type="submit" value="検索" />
</form>
<a href="<?php eh($site); ?>home/">マイページへ</a>&nbsp;&nbsp;<a href="<?php eh($site); ?>logout/">ログアウト</a>
</div>
<?php if (isset($error)) { ?>
<?php foreach ($error as $e) { ?>
<span style="color:red;"><?php eh($e); ?></span><br />
<?php } ?>
<?php } ?>

<br />

<h2>「<?php eh($keyword); ?>」の検索検索結果</h2>

<div class="searchusers">
<h3>ユーザー</h3>
<?php if (isset($users) && $user) { ?>
<table>
<?php foreach ($users as $user) { ?>
<tr>
<td><a href="<?php eh($site); ?>home/?user=<?php eh($user["username"]); ?>"><?php eh($user["username"]); ?></a>&nbsp;&nbsp;&nbsp;<?php eh($user["nickname"]); ?></td>
</tr>
<?php } ?>
</table>
<?php } else { ?>
見つかりませんでした
<?php } ?>
</div>

<div class="searchtweet">
<h3>ツイート</h3>
<?php if (isset($tweets) && $tweets) { ?>
<table>
<?php foreach ($tweets as $tweet) { ?>
<tr>
<td><a href="<?php eh($site); ?>home/?user=<?php eh($tweet["User"]["username"]); ?>"><?php eh($tweet["User"]["username"]); ?></a>&nbsp;&nbsp;&nbsp;<?php eh($tweet["text"]); ?>&nbsp;&nbsp;&nbsp;<?php eh($tweet["created"]); ?></td>
</tr>
<?php } ?>
</table>
<?php } else { ?>
見つかりませんでした
<?php } ?>
</div>
