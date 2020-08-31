<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入頁</title>
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      html, body {
        height: 100%;
      }
      body {
        display: flex;
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }
      .form-signin {
        width: 100%;
        max-width: 330px;
        margin: auto;
      }
      .form-registe {
        display: flex;
        justify-content: flex-end;
      }
      .form-signin .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
      }
      .form-signin .form-control:focus {
        z-index: 2;
      }
      .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
      }
      .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
      }
    </style>
  </head>
  <body>
    <div id="container" class="container"></div>

    <script>
      if('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
          navigator
            .serviceWorker
            .register('/service-worker.js')
            .then((reg) => {
              console.log('Service worker registered.', reg);
            });
        });
      }
    </script>
    <script src="dist/login.min.js"></script>
  </body>
</html>