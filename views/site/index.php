<?php

/** @var yii\web\View $this */

$this->title = 'Сервис коротких ссылок';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Сервис сокращения ссылок</h1>

        <p class="lead">Вы можете получить короткую ссылку для любого, работающего http(https) адреса.</p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-6">
                <h2>Введите адрес сайта:</h2>
                <form action="/send-url" method="post" id="form">
                    <label for="basic-url">Скопируйте ссылку на сайт</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="basic-url" name="url" aria-describedby="basic-addon3" placeholder="https://mysite.ru" required>
                    </div>
                    <div class="input-group mb-3">
                        <input type="submit" value="Получить ссылку" name="submit_url" id="submit_url"/>
                    </div>
                </form>
            </div>
            <div class="col-lg-6">
                <h2>Здесь появится короткая ссылка:</h2>

                <p class="text-center" id="short_url"></p>
            </div>
        </div>

    </div>
</div>
