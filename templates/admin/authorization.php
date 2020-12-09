<main class="page-authorization">
  <h1 class="h h--1">Авторизация</h1>
    <?php if(!empty($params['authError'])) :?>
        <span class="auth-error">Неправильное имя пользователя или пароль</span>
    <?php endif; ?>
  <form class="custom-form" action="" method="post">
    <input type="email" class="custom-form__input" required name="login">
    <input type="password" class="custom-form__input" required name="password">
    <button class="button" type="submit">Войти в личный кабинет</button>
  </form>
</main>