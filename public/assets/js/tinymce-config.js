// Configuração do TinyMCE em português
tinymce.init({
    selector: '#clausulas',
    language: 'pt_BR',
    language_url: 'https://cdn.tiny.cloud/1/no-api-key/tinymce/6/langs/pt_BR.js',
    height: 400,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
    branding: false,
    promotion: false,
    browser_spellcheck: true,
    contextmenu: false,
    setup: function(editor) {
        editor.on('change', function() {
            editor.save();
        });
    },
    // Configurações específicas para contratos
    style_formats: [
        {title: 'Título da Cláusula', format: 'h3'},
        {title: 'Subcláusula', format: 'h4'},
        {title: 'Texto Normal', format: 'p'},
        {title: 'Texto Destacado', inline: 'span', classes: 'highlighted'}
    ],
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tiny.cloud/css/codepen.min.css'
    ]
});
