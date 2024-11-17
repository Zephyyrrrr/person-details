<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_person'])) {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $age = $_POST['age'];
    $occupation = $_POST['occupation'];

    $sql = "INSERT INTO persons (full_name, gender, birth_date, age, occupation) VALUES ('$full_name', '$gender', '$birth_date', '$age', '$occupation')";
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    }
}

//delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM persons WHERE id=$id");
}

$result = $conn->query("SELECT * FROM persons");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Person Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5 my-5 shadow p-3 mb-5 bg-body-tertiary rounded">
    <h2 class="text-center">Person Details</h2>
    <form method="POST" class="mb-4">
        <div class="form-group">
            <label>FULL NAME:</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>GENDER:</label>
            <select name="gender" class="form-control" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>BIRTH DATE:</label>
            <input type="date" name="birth_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>AGE:</label>
            <input type="number" name="age" class="form-control" required>
        </div>
        <div class="form-group">
            <label>OCCUPATION:</label>
            <input type="text" name="occupation" class="form-control" required>
        </div>
        <button type="submit" name="add_person" class="btn btn-primary">Add Person</button>
    </form>
</div>
    <div class= "container my-5 shadow p-3 mb-5 bg-body-tertiary rounded">
    <h3 class= "text-center">List of Persons</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Birth Date</th>
            <th>Age</th>
            <th>Occupation</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['full_name'] ?></td>
                <td><?= $row['gender'] ?></td>
                <td><?= $row['birth_date'] ?></td>
                <td><?= $row['age'] ?></td>
                <td><?= $row['occupation'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>