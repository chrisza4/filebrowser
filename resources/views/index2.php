<html ng-app="filebrowserApp">
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
    <script src="<?php url('/assets/js/filebrowser.js') ?>"></script>
  </head>
  <body>
    <div ng-controller="fileBrowsingController">
      <label>Name:</label>
      <input type="text" ng-model="yourName" placeholder="Enter a name here">
      <hr>
      <h1>Hello [[yourName]]!</h1>
      <h1>Hello [[file]]</h1>
    </div>
  </body>
</html>