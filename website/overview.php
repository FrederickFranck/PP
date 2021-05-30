<html>

<head>
    <title>Data</title>
</head>

<body>
    <?php
    include 'menu.php';
    $userDBconnection = getConnectionUserDB();
    if (isset($_SESSION['isAdmin'])) {
        if ($_SESSION['isAdmin'] == true) { ?>
            <table>
                <th>First name</th>
                <th>Last name</th>
                <th>E-mail</th>
                <th>UserID</th><?php
                                $sql = "SELECT * FROM Users";
                                $result = $userDBconnection->query($sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                    <tr>
                        <td><?php echo $row['Firstname'] ?></td>
                        <td><?php echo $row['Lastname'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['ID'] ?></td>
                    </tr><?php
                                }
                            ?>
            </table><?php
                } else { ?>
            <table>
                <th>First name</th>
                <th>Last name</th>
                <th>E-mail</th>
                <th>UserID</th><?php
                                $sql = "SELECT * FROM Users WHERE ID = '" . $_SESSION['ID'] . "'";
                                $result = $userDBconnection->query($sql);
                                while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                    <tr>
                        <td><?php echo $row['Firstname'] ?></td>
                        <td><?php echo $row['Lastname'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['ID'] ?></td>
                    </tr><?php
                                }
                            ?>
            </table><?php
                }
            } ?>

</body>
</hmtl>