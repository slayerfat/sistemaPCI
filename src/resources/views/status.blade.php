<!DOCTYPE html>
<html>
    <head>
        <title>sistemaPCI</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato', Helvetica, Arial, sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }

            .caimanize {
                font-size: 48px;
                margin-top: 32px;
                padding: 0 10%;
            }

            .caimanibiri {
                font-size: 32px;
                padding-top: 32px;
            }

            .left {
                text-align: left;
            }

            .right {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">
                    {!! trans('defaults.appName') !!}
                </div>

                <div class="caimanize">
                    <p>
                        {!! Caimaneitor::caimanais() !!}
                    </p>

                    <p class="caimanibiri left">
                        {!! Caimaneitor::locaishon() !!}
                    </p>

                    <p class="caimanibiri right">
                        {!! Date::now()->format('l j F Y H:i:s') !!}
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>
