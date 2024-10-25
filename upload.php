<?php
$uploadedImages = [];
$uploadedNames = [];
$targetDirectory = "uploads/";

if (!is_dir($targetDirectory)) {
    mkdir($targetDirectory, 0755, true);
}

if (isset($_POST['upload'])) {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            echo "<script>alert('File size exceeds 2MB. Please upload a smaller file.')</script>";
        } else {
            $imageName = $_POST['image_name'];
            $imageTmpName = $_FILES['image']['tmp_name'];
            $imageFileName = basename($_FILES['image']['name']);
            $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));

            $targetFile = $targetDirectory . $imageName . '.' . $imageFileType;

            if (file_exists($targetFile)) {
                echo "<script>alert('Sorry, file already exists.')</script>";
            } else {
                if (move_uploaded_file($imageTmpName, $targetFile)) {
                    $uploadedImages[] = $targetFile;
                    $uploadedNames[] = $imageName;
                    echo "<script>alert('The file has been uploaded successfully as $targetFile.')</script>";
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.')</script>";
                }
            }
        }
    } else {
        echo "<script>alert('No file was uploaded or there was an upload error.')</script>";
    }
}

if (isset($_POST['delete'])) {
    $imageToDelete = $_POST['image_to_delete'];
    if (file_exists($imageToDelete)) {
        unlink($imageToDelete);
        echo "<script>alert('File deleted successfully.')</script>";
    } else {
        echo "<script>alert('File not found.')</script>";
    }
}

if (is_dir($targetDirectory)) {
    $uploadedImages = glob($targetDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
    $uploadedNames = array_map(function($image) {
        return pathinfo($image, PATHINFO_FILENAME);
    }, $uploadedImages);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Picture</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #c4e0e5, #f8d49f); /* Soft pastel gradient */
            padding: 40px 20px;
            text-align: center;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .container:hover {
            transform: scale(1.02);
        }

        h2 {
            margin-bottom: 20px;
            color: #4a4a4a;
        }

        .input-group {
            margin-bottom: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="file"], input[type="text"] {
            padding: 12px;
            width: 90%;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
            margin-bottom: 10px;
        }

        input[type="file"] {
            background-color: #f9f9f9;
        }

        input[type="submit"], .back-btn {
            width: 90%;
            padding: 12px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px; /* Add spacing above buttons */
        }

        input[type="submit"] {
            background-color: #6a0572; /* Deep purple */
            color: white;
        }

        input[type="submit"]:hover {
            background-color: #4b004f; /* Darker purple on hover */
        }

        .back-btn {
            background-color: #ffb74d; /* Warm yellow */
            color: white;
        }

        .back-btn:hover {
            background-color: #f9a825; /* Darker yellow on hover */
        }

        .image-preview {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .image-box {
            position: relative;
            border: 2px solid #ddd;
            border-radius: 12px;
            overflow: hidden;
            width: 180px;
            height: 180px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .image-box:hover {
            transform: scale(1.05);
        }

        .image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
        }

        .delete-button {
            position: absolute;
            top: 8px;
            right: 8px;
            background-color: #d9534f; /* Bootstrap danger color */
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            cursor: pointer;
            font-size: 14px;
            text-align: center;
            line-height: 22px;
            transition: background-color 0.3s;
        }

        .delete-button:hover {
            background-color: #c9302c; /* Darker red on hover */
        }

        .image-name {
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
            color: #6a0572; /* Deep purple */
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Upload a Picture</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div class="input-group">
            <input type="file" name="image" accept="image/*" required>
            <input type="text" name="image_name" placeholder="Enter Image Name" required>
        </div>
        <input type="submit" name="upload" value="Upload">
        <button class="back-btn" onclick="window.location.href='index.php'">BACK</button>
    </form>

    <div class="image-preview">
        <?php foreach ($uploadedImages as $index => $image): ?>
            <div class="image-box">
                <img src="<?php echo htmlspecialchars($image); ?>" alt="Uploaded Image">
                <form action="upload.php" method="post" style="display:inline;">
                    <input type="hidden" name="image_to_delete" value="<?php echo htmlspecialchars($image); ?>">
                    <button type="submit" name="delete" class="delete-button">X</button>
                </form>
                <div class="image-name"><?php echo htmlspecialchars($uploadedNames[$index]); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
