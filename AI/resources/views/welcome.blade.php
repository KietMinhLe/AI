<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhận diện đồ vật</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #4facfe, #00f2fe);
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        flex-direction: column;
    }

    h1 {
        color: white;
        margin-bottom: 20px;
        font-size: 28px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    .container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        width: 400px;
    }

    input[type="file"] {
        display: none;
    }

    .custom-file-upload {
        display: inline-block;
        padding: 10px 20px;
        cursor: pointer;
        background: #007BFF;
        color: white;
        border-radius: 5px;
        transition: 0.3s;
        font-size: 16px;
    }

    .custom-file-upload:hover {
        background: #0056b3;
    }

    #previewImage {
        display: none;
        width: 100%;
        max-height: 300px;
        margin-top: 15px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    }

    button {
        background: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 15px;
        transition: 0.3s;
    }

    button:hover {
        background: #218838;
    }

    #result {
        margin-top: 15px;
        font-size: 16px;
        color: #333;
    }
    </style>
</head>

<body>
    <h1>Nhận diện đồ vật với Laravel + Python</h1>

    <div class="container">
        <form id="uploadForm" action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="imageInput" class="custom-file-upload">Chọn ảnh</label>
            <input type="file" name="image" id="imageInput" accept="image/*">
            <img id="previewImage">
            <button type="submit">Tải lên & Nhận diện</button>
        </form>

        <p id="result"></p>
    </div>

    <script>
    document.getElementById("imageInput").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("previewImage").src = e.target.result;
                document.getElementById("previewImage").style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });
    </script>

</body>

</html>