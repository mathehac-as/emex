<div class="auth_login_cont">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Добавление пользователя</h3>
        </div>
        <div class="panel-body">
            <?php if(isset($errors)):?>
                <?php foreach ($errors as $val):?>
                <div class="alert alert-danger alert-min"><?=$val?></div>
                <?php endforeach;?>
            <?php endif;?>
            <form method="post">
                <select name="role" class="form-control input-sm-min" placeholder="Роль">
                    <option value="login">Пользователь</option>
                    <option value="admin">Администратор</option>
                </select>
                <input type="text" name="username" class="form-control input-sm-min" placeholder="Логин">
                <input type="text" name="email" class="form-control input-sm-min" placeholder="Email">
                <input type="password" name="password" class="form-control input-sm-min" placeholder="Пароль">
                <input type="password" name="password_confirm" class="form-control input-sm-min" placeholder="Повтор пароля">
                <input type="submit" value="Войти" name="enter" class="btn btn-primary btn-xs" />
            </form>
        </div>
    </div>
</div>
