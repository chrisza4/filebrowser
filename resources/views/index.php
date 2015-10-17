<html>
<head>
  <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="<?php echo url('/assets/js/jquery.tmpl.js') ?>"></script>
  <script src="<?php echo url('/assets/js/filebrowser.js') ?>"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo url('/assets/css/fb.css') ?>" />
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.css" />
  <script>
     var baseUrl = "<?php echo url('/')?>";
  </script>
</head>
<body>
  <script type="text/html" id="templateFile">
    <div class="row row-browse row-file" data-folder="${folder}" data-level="${level}">

        <div class="file col-md-8">
          <div class="icon icon-none"></div>
          <div class="icon icon-file">
          </div>
           ${name}
        </div>
        <div class="file-info">
        <div class="date">
           ${date}
        </div>
        <div class="size">
           ${size}
        </div>
        </div>
      </div>
</script>
<script type="text/html" id="templateFolder">
    <div class="row row-browse row-folder file-collapse" data-folder="${folder}" data-level="${level}">

        <div class="file col-md-8">
          <div class="icon arrow"></div>
          <div class="icon icon-folder">
          </div>
           ${name}
        </div>
        <div class="file-info">
        <div class="date ">
           ${date}
        </div>
        <div class="size ">
           ${size}
        </div>
        </div>
      </div>
</script>
  <div id="main" class="root-tree" data-folder="\" data-level="0">
    
  </div>
</body>
</html>