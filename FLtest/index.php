
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- JQuery -->
    <script src="./asset/js/jquery.min.js"></script>
    <script src="./asset/js/popper.min.js"></script>

    <!-- Bootstarp 4 -->
    <script src="./asset/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./asset/css/bootstrap.min.css">

    <!-- Styles -->
    <link href="./asset/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--Favicon-->
    <!--    <link rel="shortcut icon" href="{{ URL::asset('/img/favicon.ico') }}" type="image/x-icon"/>-->

    <title>Проверка на самозанятость</title>
</head>
<body>

<div class="container">
    <div class="row justify-content-center mt-3 p-3">
        <h1 class="text-center mt-3">Проверка на самозанятость по ИНН</h1>
    </div>

    <div class="row">
        <div class="col">

            <div class="vb-rounded-nmh p-3 my-2 d-flex justify-content-center">
                <div class="align-self-center">
                    <div class="row justify-content-center">
                        <h4 class="text-center"> Введите ваш ИНН:</h4>
                    </div>
                    <div class="row justify-content-center p-3">
                        <div class="col-sm-12 col-lg-10">

                            <div class="form-group row justify-content-center">
                                <input type="text" class="form-control text-center" id="inn" value="">

                                <div id="msg" class="row d-none mt-3">
                                    <div class="col">
                                        <div class="alert alert-success">
                                            <h3 class="text-center" id="res_msg"></h3>
                                        </div>
                                    </div>
                                </div>

                                <div id="err" class="row d-none mt-3">
                                    <div class="col">
                                        <div class="alert alert-danger">
                                            <h3 class="text-center" id="err_msg"></h3>
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                    <div class="row justify-content-around">
                        <div class="col text-center">
                            <button class="btn btn-outline-success btn-mw" id="submit">Отправить</button>
                        </div>
                        <div class="col text-center">
                            <button class="btn btn-outline-danger btn-mw" id="clear">Очистить</button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


<!-- Scripts -->
<script src="./asset/js/app.js" defer></script>

</body>
</html>
