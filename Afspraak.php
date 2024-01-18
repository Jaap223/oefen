<?php
require_once 'head/head.php';
require_once 'data/db.php';

class Afspraak extends Database
{

    //Update functie om waardes uit de database mee te kunnen updaten
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


    public function fetchAll($sql)
    {
        try {
            $sql = "SELECT * FROM updates";
            $stmt = $this->connect()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }


    public function delete($update_id)
    {
        try {
            $sql  = "DELETE FROM updates WHERE update_id = :update_id LIMIT 1";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(':update_id', $update_id, PDO::PARAM_INT); // Fix here
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            return $rowCount;
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
    if (isset($_POST['update_id']) && !empty($_POST['update_id'])) {
        $updateData['update_id'] = $_POST['update_id'];
        $updateData['u_id'] = $_POST['u_id'];
        $updateData['status'] = $_POST['status'];
        $updateData['datum'] = $_POST['tijd'];
        $updateData['factuur_id'] = $_POST['factuur_id'];


        $updateResult = $updateInstance->update($updateData);
        echo $updateResult > 0 ? "Update with ID " . $updateData['update_id'] . " has been successful" : "No changes made.";
    } else {
        echo "error";
    }
}


//Logica om een afspraak te verwijderen
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $delete = new Afspraak();
        $delete->delete($_POST['update_id']);
        $deleteMessage = 'Auto verwijderd!';
    }
}












?>



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


<table class="tab2">
    <h2>Afspraken</h2>
    <tr>
        <th>Update ID</th>
        <th>User ID</th>
        <th>Status</th>
        <th>Date</th>
        <th>Time</th>
        <th>Action</th>
    </tr>
    <?php
    $afspraakData = $updateInstance->fetchAll("SELECT * FROM updates");
    foreach ($afspraakData as $afspraak) {
        echo "<tr>";
        echo "<td>{$afspraak['update_id']}</td>";
        echo "<td>{$afspraak['u_id']}</td>";
        echo "<td>{$afspraak['status']}</td>";
        echo "<td>{$afspraak['datum']}</td>";
        echo "<td>{$afspraak['tijd']}</td>";
        echo "<td>
                <form method='post' action='{$_SERVER['PHP_SELF']}'>
                    <input type='hidden' name='update_id' value='{$afspraak['update_id']}'>
                    <input type='hidden' name='action' value='delete'>
                    <button type='submit'>Delete</button>
                </form>
              </td>";
        echo "</tr>";
    }
    ?>
</table>


</body>

</html>