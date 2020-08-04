/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
	var loc = window.location;
    var pathName = loc.pathname.split('cpanel/');
	var url  = pathName[0]
CKEDITOR.editorConfig = function( config ) {
	config.filebrowserBrowseUrl = url + 'cpanel/kcfinder/browse.php?type=files';
   	config.filebrowserImageBrowseUrl = url + 'cpanel/kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = url + 'cpanel/kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = url + 'cpanel/kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = url + 'cpanel/kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = url + 'cpanel/kcfinder/upload.php?type=flash';

	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';

};
