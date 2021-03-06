<div class="register-form">
    <h2>新規登録</h2>
    <?php if (isset($error)) { ?>
    <?php foreach ($error as $e) { ?>
    <span style="color:red;"><?php eh($e); ?></span><br />
    <?php } ?>
    <?php } ?>
    <form action="<?php eh($site); ?>register/confirm" method="POST">
    <dl>
        <?php $this->tokenTag(); ?>
        <dt>アカウントID (英数字のみ 8文字以内)</dt>
        <dd><input type="text" name="username" value="<?php if (isset($username)) { eh($username); } ?>" /></dd>
        <dt>ニックネーム (全角8文字以内)</dt>
        <dd><input type="text" name="nickname" value="<?php if (isset($nickname)) { eh($nickname); } ?>" /></dd>
        <dt>メールアドレス</dt>
        <dd><input type="text" name="email" value="<?php if (isset($email)) { eh($email); } ?>" /></dd>
        <dt>パスワード (英数字のみ 6文字以上12文字以内)</dt>
        <dd><input type="password" name="password" /></dd>
        <dt>パスワード (再入力)</dt>
        <dd><input type="password" name="repassword" /></dd>
<!--
        <dt>ツイートを公開する</dt>
        <dd>
            <input type="radio" name="private_mode" value="0" <?php if (!isset($private_mode) || $private_mode === 0) { ?>checked<?php } ?>>公開する</input>
            <input type="radio" name="private_mode" value="1" <?php if (isset($private_mode) && $private_mode === 1) { ?>checked<?php } ?>>公開しない</input>
        </dd>
-->
    </dl>
    <input type="submit" value="送信" />
    </form>
</div>
