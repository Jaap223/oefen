<?php

require_once 'head/head.php';
require_once 'data/db.php';


// deze functie is om een bestaande afspraak te koppelen aan een gebruiker : 

class Afspraak extends database
{
    public function insertUp($update_id, $status, $datum, $tijd, $factuur_id)
    {
        try {
            $sql = "INSERT INTO updates (update_id, status, datum, tijd, factuur_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->connect()->prepare($sql);

            $stmt->bindParam(1, $update_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $status, PDO::PARAM_STR);
            $stmt->bindParam(3, $datum, PDO::PARAM_STR);
            $stmt->bindParam(4, $tijd, PDO::PARAM_STR);
            $stmt->bindParam(5, $factuur_id, PDO::PARAM_INT);

            $stmt->execute();
            $rowCount = $stmt->rowCount();

            return $rowCount;
            header("Location: Index.php");
            exit();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function showUpdates()
    {
        try {
            $sql = "SELECT * FROM updates";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();

            if ($stmt->errorCode() !== '00000') {
                throw new Exception("Error: " . implode(", ", $stmt->errorInfo()));
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error executing query: " . $e->getMessage());
            return [];
        }
    }




    public function deleteUp($update_id)
    {
        try {
            $sql = "DELETE FROM updates WHERE update_id = :update_id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":update_id", $update_id);
            $stmt->execute();

            return $stmt->rowCount();

        } catch (Exception $e) {

            error_log("Error deleting query: " . $e->getMessage());
            return 0;
        }
    }

}

$insertInstance = new Afspraak();
$insertResult = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['insertUp'])) {
    $insertData = [
        'u_id' => $_POST['u_id'],
        'status' => $_POST['status'],
        'datum' => $_POST['datum'],
        'tijd' => $_POST['tijd'],
        'factuur_id' => $_POST['factuur_id']
    ];

    $insertResult = $insertInstance->insertUp($insertData['u_id'], $insertData['status'], $insertData['datum'], $insertData['tijd'], $insertData['factuur_id']);
    echo $insertResult > 0 ? "Insertion successful" : "Error inserting data";
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteUpdate'])) { 

    $delete_id = $_POST['delete_id'];
    $deleteResult = $insertInstance->deleteUp($delete_id);

    echo $deleteResult > 0 ? "Deletion successful" : "error";

}



?>

<section class="formR">
    <h1>Insert Update</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <table>
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
            <button type="submit" name="insertUp">Insert Update</button>
        </div>
    </form>

    <?php if (isset($insertResult)) : ?>
        <p><?php echo $insertResult; ?></p>
    <?php endif; ?>

    <br>
    <h2>Afspraken</h2>

    
</section>
<table>
    <thead>
        <tr>
            <th>Status</th>
            <th>Date</th>
            <th>Time</th>
            <th>Invoice ID</th>
            <th>Action</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody class="tab2">
            <?php
            $showUpdatesResult = $insertInstance->showUpdates();
            foreach ($showUpdatesResult as $row) {
                echo "<tr>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['datum'] . "</td>";
                echo "<td>" . $row['tijd'] . "</td>";
                echo "<td>" . $row['factuur_id'] . "</td>";
                echo "<td>
                    <form method='post' action='" . $_SERVER['PHP_SELF'] . "'>
                        <input type='hidden' name='delete_id' value='" . $row['update_id'] . "'>
                        <button type='submit' name='deleteUpdate'>Delete</button>
                    </form>
                </td>";
                echo "</tr>";
            }

            echo "<tr>";
            echo "<td colspan='5'></td>";
            echo "<td>
                    <form method='post' action='Afspraak.php'>
                        <button type='submit'>Update</button>
                    </form>
                </td>";
            echo "</tr>";
            ?>
        </tbody>
</table>
</section>