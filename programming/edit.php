<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM persons WHERE id=$id");
    $person = $result->fetch_assoc();
}

// Handle the form submission for updating a person
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_person'])) {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $birth_date = $_POST['birth_date'];
    $age = $_POST['age'];
    $occupation = $_POST['occupation'];

    $sql = "UPDATE persons SET full_name='$full_name', gender='$gender', birth_date='$birth_date', age='$age', occupation='$occupation' WHERE id=$id";
    $conn->query($sql);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Person</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5 my-5 shadow p-3 mb-5 bg-body-tertiary rounded">
    <h2>Edit Person</h2>
    <form method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?= $person['full_name'] ?>" required>
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male" <?= $person['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $person['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $person['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Birth Date</label>
            <input type="date" name="birth_date" class="form-control" value="<?= $person['birth_date'] ?>" required>
        </div>
        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" class="form-control" value="<?= $person['age'] ?>" required>
        </div>
        <div class="form-group">
            <label>Occupation</label>
            <input type="text" name="occupation" class="form-control" value="<?= $person['occupation'] ?>" required>
        </div>
        <button type="submit" name="update_person" class="btn btn-primary">Update Person</button>
    </form>
</div>
</body>
</html>