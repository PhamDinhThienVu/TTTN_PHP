<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CKEditor Example</title>
  <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
</head>
<body>
<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
  <h2>CKEditor Example</h2>

  <textarea name="editor1" id="editor1"></textarea>

  <script>
    ClassicEditor
      .create(document.querySelector('#editor1'))
      .catch(error => {
        console.error(error);
      });
  </script>

</body>
</html>
