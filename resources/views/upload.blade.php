<!-- resources/views/upload.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>PDF File Upload</title>
</head>
<body>
    <h1>Upload PDF File</h1>
    <form action="/upload-pdf" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="pdf_file">
        <button type="submit">Upload PDF</button>
    </form>

    <div id="response-message"></div>

    <!-- Include Axios from a CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- Include the JavaScript file -->
    <script src="{{ asset('js/upload.js') }}"></script>
</body>
</html>
