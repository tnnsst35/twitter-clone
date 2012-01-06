<div class="register-confirm">
    <h2>新規登録</h2>
    <form action="<?php eh($site); ?>register/execute" method="POST">
    <?php $this->tokenTag(); ?>
    <input type="hidden" name="username"     value="<?php eh($username); ?>"     />
    <input type="hidden" name="nickname"     value="<?php eh($nickname); ?>"     />
    <input type="hidden" name="email"        value="<?php eh($email); ?>"        />
    <input type="hidden" name="password"     value="<?php eh($password) ?>"      />
    <input type="hidden" name="private_mode" value="<?php eh($private_mode); ?>" />
    <dl>
        <dt>アカウントID (英数字のみ 8文字以内)</dt>
        <dd><?php eh($username); ?></dd>
        <dt>ニックネーム (全角8文字以内)</dt>
        <dd><?php eh($nickname); ?></dd>
        <dt>メールアドレス</dt>
        <dd><?php eh($email); ?></dd>
<!--
        <dt>ツイートを公開する</dt>
        <dd><?php if ($private_mode === 0) { eh("公開する"); } else { eh("公開しない"); } ?></dd>
-->
    </dl>
    <input type="submit" value="送信" />
    </form>
</div>
