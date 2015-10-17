// var myapp = angular.module('app', []);
  
// myapp.controller('fileBrowsingController', function() {
//     var appScope = this;
//     appScope.file = "File browser kub";
//     appScope.click = function() {
//       alert(appScope.yourName);
//     }
//   }).config(['$interpolateProvider', function ($interpolateProvider) {
//     $interpolateProvider.startSymbol('[[');
//     $interpolateProvider.endSymbol(']]');
//   }]);

$(document).ready(function() {
	var eachPadding = 20;
	var loadFile = function(targetDiv) {
		var folder = $(targetDiv).attr('data-folder');
		var currentLevel = parseInt($(targetDiv).attr('data-level')) + 1;
		$(targetDiv).addClass('loading');
		$(targetDiv).removeClass('file-collapse').addClass('file-expand');
		$.get(baseUrl + '/browse', { "folder": folder}, function(response) {
			for (var k in response) {
				var data = response[k];
				data.level = currentLevel;
				var divToInsert;
				if (data.type == "1") {
					data.folder = folder + data.name + "\\";
					divToInsert = $.tmpl($('#templateFolder'), data);
				}
				else {
					data.folder = folder + data.name;
					divToInsert = $.tmpl($('#templateFile'), data);
				}
				divToInsert.css('padding-left', currentLevel * eachPadding);
				divToInsert.insertAfter($(targetDiv));
			}
			$(targetDiv).removeClass('loading');

		});
	}
	loadFile('#main');
	$(document).on('click', '.row-browse', function() {
		var thisRow = $(this);
		if (thisRow.hasClass('row-folder')) {
			if ($(thisRow).hasClass('file-collapse'))
				loadFile(thisRow);
			else {
				// Remove child 
				var allNextElement = $(thisRow).nextAll();
				var thisLevel = parseInt($(thisRow).attr('data-level'));
				var nextLevel = thisLevel + 1;
				for (var i=0;i<allNextElement.length;i++) {
					var thisElement = $(allNextElement[i]);
					if (parseInt(thisElement.attr('data-level')) == thisLevel)
						break;
					thisElement.remove();
				}
				$(this).removeClass('file-expand').addClass('file-collapse');
			}
		}
		else {
			window.open(baseUrl + '/download?file=' + thisRow.attr('data-folder'));
		}
	});
});