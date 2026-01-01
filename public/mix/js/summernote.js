window.addEventListener('load', function () {
    $('#summernote').summernote({
        height: 300,
        disableDragAndDrop: true,
        toolbar: [
            ['style', ['style']],
            ['text', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['misc', ['undo', 'redo', 'codeview']]
        ],
        styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5']
    });
})