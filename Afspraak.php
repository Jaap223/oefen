<?php
require_once 'head/head.php';
require_once 'data/db.php';

class Afspraak extends database
{

    public function insertUp($update_id, $u_id, $status, $datum, $tijd, $Factuur_id)

    {

        try {

        }
    }



    public function update($updateData = null)
    {
        try {
            if ($updateData) {

                $sql = "UPDATE updates SET u_id = ?, status = ?, datum = ?, tijd = ?, factuur_id = ? WHERE update_id = ? LIMIT 1";
                $stmt = $this->connect()->prepare($sql);

                $stmt->bindParam(1, $updateData['update_id'], PDO::PARAM_INT);
                $stmt->bindParam(2, $updateData['u_id'], PDO::PARAM_INT);
                $stmt->bindParam(3, $updateData['status'], PDO::PARAM_STR);
                $stmt->bindParam(4, $updateData['datum'], PDO::PARAM_STR);
                $stmt->bindParam(5, $updateData['tijd'], PDO::PARAM_STR);
                $stmt->bindParam(6, $updateData['factuur_id'], PDO::PARAM_INT);


                $stmt->execute();
                return $stmt->rowCount();
            } else {
                $sql = "SELECT Update_id FROM updates";
                $stmt = $this->connect()->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            echo "An error occurred: " . $e->getMessage();
            return false;
        }
    }
}


$update = new Afspraak();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $updateData = [
        'Update_id' => $_POST['Update_id'],
        'u_id' => $_POST['u_id'],
        'status' => $_POST['status'],
        'datum' => $_POST['datum'],
        'tijd' => $_POST['tijd'],
        'factuur_id' => $_POST['factuur_id']
    ];

    if (!empty($updateData['Update_id'])) {
        $result = $update->update($updateData);
        echo $result > 0 ? "Update een ID " . $updateData['Update_id'] . " is geannuleerd" : "Geen veranderingen aangebracht.";
    } else {
        echo "Error om te updaten";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Afspraak Maken</title>
</head>

<body>

    <section class="formR">
        <h1>Update Form</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div>
                <label for="u_id">User ID:</label>
                <input type="number" id="u_id" name="u_id" required>
            </div>
            <div>
                <label for="status">Status:</label>
                <input type="text" id="status" name="status" required>
            </div>
            <div>
                <label for="datum">Date:</label>
                <input type="date" id="datum" name="datum" required>
            </div>
            <div>
                <label for="tijd">Time:</label>
                <input type="time" id="tijd" name="tijd" required>
            </div>
            <div>
                <label for="factuur_id">Invoice ID:</label>
                <input type="number" id="factuur_id" name="factuur_id" required>
            </div>

            <input type="hidden" name="Update_id" value="The ID you want to update">
            <div>
                <button type="submit" name="update">Submit Update</button>
            </div>
        </form>

        <?php if (isset($result)) : ?>
            <p><?php echo $result; ?></p>
        <?php endif; ?>

    </section>

</body>

</html>