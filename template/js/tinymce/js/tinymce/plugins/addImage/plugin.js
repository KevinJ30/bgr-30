tinymce.PluginManager.add('addImage', function(editor, url){
    // permet d'ouvrire une iframe contenant la page d'ajout de l'image
    editor.addButton('addImage', {
        text : 'Insérer une image',
        icon: false,
        onclick: function(){
            // Ouverture de la frame
            editor.windowManager.open({
                title : 'Ajouter une image',
                body: [
                    {type: 'textbox', name: 'title', label: 'Title'}
                ],
                onsubmit: function(e){
                    // Insertion du contenu dans la page
                   
                }
            });
        }
    });
});