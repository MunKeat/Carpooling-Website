<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $HTML_title?></title>
  <!--Foundation-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/css/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/css/foundation.min.css">
  <!--Check if loaded-->
  <script>
  if(!window.Foundation) {
      document.write(unescape('%3Clink rel="stylesheet" href="./foundation/css/normalize.css"%3E'));
      document.write(unescape('%3Clink rel="stylesheet" href="./foundation/css/foundation.min.css"%3E'));
  }
  </script>
  <!--jQuery-->
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script>
  /*
  if() {
  // TODO
  }
  */
  </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <!--Check if loaded-->
  <script>
  if (!window.jQuery) {
    // TODO
  }
  if (!window.jQuery.ui) {
    // TODO
  }
  </script>
</head>
<body>
