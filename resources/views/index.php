<html ng-app="app">
  <head>
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="<?php echo url('/assets/js/angular.js') ?>"></script>
    <script src="<?php echo url('/assets/js/filebrowser.js') ?>"></script>
    <link href="<?php echo url('/assets/css/fb.css') ?>" />
  </head>
  <body>
    <div ng-controller="fileBrowsingController as controller">
      <ul ng-repeat="file in controller.files">
      </ul>
      <button ng-click="controller.click()">asdf</button>
    </div>
  </body>
</html>