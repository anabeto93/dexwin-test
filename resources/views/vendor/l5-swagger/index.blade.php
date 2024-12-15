<!DOCTYPE html>
<html>
  <head>
    <title>{{ config('l5-swagger.documentations.'.config('l5-swagger.default').'.api.title') }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: 'Montserrat', sans-serif;
      }
      redoc {
        display: block;
      }
    </style>
  </head>
  <body>
    <div id="redoc"></div>
    <script src="https://cdn.redoc.ly/redoc/latest/bundles/redoc.standalone.js"></script>
    <script>
      Redoc.init(
        '{!! url($urlToDocs) !!}',
        {
          theme: {
            colors: {
              primary: {
                main: '#1976D2'
              }
            },
            typography: {
              fontFamily: '"Montserrat", sans-serif',
              fontSize: '16px',
              lineHeight: '1.5em',
              headings: {
                fontFamily: '"Montserrat", sans-serif',
                fontWeight: '600'
              }
            }
          }
        },
        document.getElementById('redoc')
      );
    </script>
  </body>
</html>
