var editor_{field} = new TINY.editor.edit('editor_{field}', { 
    id: '{field}',width: 800,height: 175,cssclass: 'tinyeditor',controlclass: 'tinyeditor-control',
    rowclass: 'tinyeditor-header',dividerclass: 'tinyeditor-divider',
    controls: ['bold', 'italic', 'underline', 'strikethrough', '|','orderedlist', 'unorderedlist', '|', 
        'outdent', 'indent', '|', 'leftalign','centeralign', 'rightalign', 'blockjustify', '|', 'unformat', 
        '|', 'undo', 'redo', '|','style', 'size', '|', 'hr', 'link', 'unlink'],
    footer: false,xhtml: true,cssfile: '/assets/css/custom.css',bodyid: 'editor_{field}',
    footerclass: 'tinyeditor-footer',toggle: {text: 'source', activetext: 'wysiwyg', cssclass: 'toggle'}
});
$('#form1').on('submit',function() {
    editor_{field}.post();
});
