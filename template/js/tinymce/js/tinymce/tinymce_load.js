/**
 * File : tinymce_load.js
 *
 * Crées par Joudrier Kevin
 *
 * permet de configurer l'editeur
 **/

tinymce.init({
		selector: "textarea",
		plugins: [
       				"addImage advlist autolink lists link charmap print preview hr anchor pagebreak",
        				"searchreplace wordcount visualblocks visualchars code fullscreen",
        				"insertdatetime media nonbreaking save table contextmenu directionality",
       				"emoticons template paste textcolor colorpicker textpattern"
    		],
    	height : 500,
		toolbar1 : "fontselect fontsizeselect | bold italic underline strikethrough subscript superscript backcolor forecolor | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent",
		toolbar2 : "addImage",
		paste_auto_cleanup_on_paste : true,
		paste_remove_style : true,
		paste_remove_style_if_webkit : true,
		paste_strip_class_attributes : "all",
		entity_encoding : "raw",
		nonbreaking_force_tab : true,
});

