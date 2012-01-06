<div class="login-form">
    <h2>ログイン</h2>
    <?php if (isset($error)) { ?>
    <?php foreach ($error as $e) { ?>
    <span style="color:red;"><?php eh($e); ?></span><br />
    <?php } ?>
    <?php } ?>
    <form action="<?php eh($site); ?>login/" method="POST">
    <?php $this->tokenTag(); ?>
    <dl>
        <dt>アカウントID</dt>
        <dd><input type="text" name="username" /></dd>
        <dt>パスワード</dt>
        <dd><input type="password" name="password" /></dd>
    </dl>
    <input type="submit" value="送信" />
    </form>
</div>
<a href="<?php eh($site); ?>register/">新登録はコチラ</a><br />
