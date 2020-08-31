<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問題對話頁</title>
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>
    <div id="container"></div>

    <script src="https://cdn.ckeditor.com/4.13.1/full-all/ckeditor.js"></script>
    <script>
      window.CKEDITOR = CKEDITOR;
    </script>
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
    <script src="dist/detail.min.js"></script>
  </body>
</html>