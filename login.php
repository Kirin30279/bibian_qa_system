<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入頁</title>
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>
    <div id="container"></div>

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