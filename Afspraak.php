<?php
require_once 'head/head.php';
require_once 'data/db.php';

class Afspraak extends Database
{
    public function update($updateData = null)
    {
        try {
            if ($updateData) {
                $sql = "UPDATE updates SET u_id = ?, status = ?, datum = ?, tijd = ?, factuur_id = ? WHERE update_id = ?";
                $stmt = $this->connect()->prepare($sql);

                $stmt->bindParam(1, $updateData['u_id'], PDO::PARAM_INT);
                $stmt->bindParam(2, $updateData['status'], PDO::PARAM_STR);
                $stmt->bindParam(3, $updateData['datum'], PDO::PARAM_STR);
                $stmt->bindParam(4, $updateData['tijd'], PDO::PARAM_STR);
                $stmt->bindParam(5, $updateData['factuur_id'], PDO::PARAM_INT);
                $stmt->bindParam(6, $updateData['update_id'], PDO::PARAM_INT);
                $stmt->execute();

                return $stmt->rowCount();

            } else {
                $sql = "SELECT update_id, u_id, status, datum, tijd, factuur_id FROM updates";
                $stmt = $this->connect()->query($sql);
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            return $e->getMessage(); 
        }
    }
}

// $user_name = $_SESSION['naam'];
// $conn = new PDO("mysql:host;dbname=oefen", "root", "");
// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// $sql ="SELECT * FROM gebruiker WHERE naam = :naam";
// $stmt = $conn->prepare($sql);

// $stmt->bindParam("naam", $naam);
// $stmt->execute();


// $result = $stmt->fetch(PDO::FETCH_ASSOC);

// if ($result[''] != '') {
//     header("Location: Index.php");
//     exit();
// }TEMBO


$updateInstance = new Afspraak();
$updateResult = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    if(isset($_POST['update_id']) && !empty($_POST['update_id'])) {
        $updateData['update_id'] = $_POST['update_id']; 
        $updateData['u_id'] =$_POST['u_id'];
        $updateData['status'] = $_POST['status'];
        $updateData['datum'] = $_POST['tijd'];
        $updateData['factuur_id'] = $_POST['factuur_id'];


        $updateResult = $updateInstance->update($updateData);
        echo $updateResult > 0 ? "Update with ID " . $updateData['update_id'] . " has been successful" : "No changes made.";
    } else {
        echo "error";
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
    <title>Update Form</title>
</head>

<body>

<section class="formR">
    <h1>Update Form</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
            <tr>
                <td>
                    <label for="update_id">Update ID:</label>
                </td>
                <td>
                    <input type="number" id="update_id" name="update_id" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="u_id">User ID:</label>
                </td>
                <td>
                    <input type="number" id="u_id" name="u_id" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="status">Status:</label>
                </td>
                <td>
                    <input type="text" id="status" name="status" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="datum">Date:</label>
                </td>
                <td>
                    <input type="date" id="datum" name="datum" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="tijd">Time:</label>
                </td>
                <td>
                    <input type="time" id="tijd" name="tijd" required>
                </td>
            </tr>
            <tr>
                <td>
                    <label for="factuur_id">Invoice ID:</label>
                </td>
                <td>
                    <input type="number" id="factuur_id" name="factuur_id" required>
                </td>
            </tr>
        </table>

        <div>
            <button type="submit" name="update">Submit Update</button>
        </div>
    </form>
    <?php if (isset($updateResult)) : ?>
        <p><?php echo $updateResult; ?></p>
    <?php endif; ?>
</section>

</body>

</html>
