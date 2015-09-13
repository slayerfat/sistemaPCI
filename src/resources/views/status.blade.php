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
                    {!! Caimaneitor::caimanais() !!}
                </div>
            </div>
        </div>
    </body>
</html>
