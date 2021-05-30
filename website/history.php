<html>

<head>
    <title>Data</title>
</head>


<body>
    <?php
    include 'menu.php';
    $PPConnection = getConnection();
    if (isset($_SESSION['isAdmin'])) {
        if ($_SESSION['isAdmin'] == true) { ?>
            <table>
                <th>UserID</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Time</th>
                <?php
                $sql = "SELECT * FROM History";
                $result = $PPConnection->query($sql);
                while ($row = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?php echo $row['UserID'] ?></td>
                        <td><?php echo $row['Long'] ?></td>
                        <td><?php echo $row['Lat'] ?></td>
                        <td><?php echo $row['Time'] ?></td>


                    </tr><?php
                        }
                            ?>
            </table><?php
                } else { ?>
            <table>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Time</th><?php
                                $sql = "SELECT * FROM History WHERE UserID = '" . $_SESSION['ID'] . "'";
                                $result = $PPConnection->query($sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                    <tr>
                        <td><?php echo $row['Long'] ?></td>
                        <td><?php echo $row['Lat'] ?></td>
                        <td><?php echo $row['Time'] ?></td>
                    </tr><?php
                                }
                            ?>
            </table><?php
                }
            } ?>

</body>
</hmtl>