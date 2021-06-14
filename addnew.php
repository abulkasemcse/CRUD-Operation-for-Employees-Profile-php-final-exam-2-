<?php
//error_reporting(~E_NOTICE);
require_once 'PDO_Config.php';

if (isset($_POST['btnsave'])) {
    $username = $_POST['user_name'];
    $userjob = $_POST['user_job'];
    // $userEmail = $_POST['user_email']
    //===========================================//
    $imgFile = $_FILES['user_img']['name'];
    $tmp_dir = $_FILES['user_img']['tmp_name'];
    $imgSize = $_FILES['user_img']['size'];
    //===========================================//

    if (empty($username)) {
        $errorMSG = "Please enter username";
    } else if (empty($userjob)) {
        $errorMSG = "Please enter employees job";
    } elseif (empty($imgFile)) {
        $errorMSG = "Please select employees image";
    }
    //===========================================//
    else {
        $upload_dir = 'user_images/'; //upload directory
        $imgExt = strtolower(pathinfo($imgFile, PATHINFO_EXTENSION));
        $valid_extention = array('jpeg', 'jpg', 'png', 'gif');
        $userpic = rand(1000, 100000000) . "." . $imgExt;


        if (in_array($imgExt, $valid_extention)) {
            if ($imgSize < 5 * 1024 * 1024) {
                move_uploaded_file($tmp_dir, $upload_dir . $userpic);
            } else {
                $errorMSG = "Sorry, your file is too large";
            }
        } else {
            $errorMSG = "Sorry, only jpeg, jpg, png, gif files are allowed";
        }
    }
    //===========================================//

    if (!isset($errorMSG)) {
        $stmt = $DB_CON->prepare("INSERT INTO tbl_users(userName,userProfession,userPic) VALUES (:uname,:ujob,:upic)");

        $stmt->bindParam(':uname', $username);
        $stmt->bindParam(':ujob', $userjob);
        $stmt->bindParam(':upic', $userpic);

        if ($stmt->execute()) {
            $successMSG = "New Record Inserted Successfully";
            header('refresh:5; index.php');
        } else {
            $errorMSG = "Error while inserting...";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <div>
        <div>
            <h1>Add New Employee</h1><a href="index.php"><br><b>View All Employee</b></a>
        </div>
        <?php
        error_reporting(~E_NOTICE);
        if (isset($errorMSG)) {
        ?>
            <div>
                <span></span><b><?= $errorMSG; ?></b>
            </div>
        <?php
        } else if (isset($successMSG)) {
        ?>
            <div>
                <b><span></span><?= $successMSG; ?></b>
            </div>
        <?php
            header("location:index.php");
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">

            <table>
                <tr>
                    <td>
                        <label for="">Username</label>
                    </td>
                    <td>
                        <input type="text" name="user_name" value="<?= $username; ?>">
                    </td>
                </tr>

                <!-- <tr>
					<td>
						<label>Email</label>
					</td>
					<td>
						<input type="email" name="user_email" value="< ?php echo $userEmail; ?>">
					</td>
				</tr> -->

                <tr>
                    <td>
                        <label for="">Profession</label>
                    </td>
                    <td>
                        <input type="text" name="user_job" value="<?= $userjob; ?>">
                    </td>
                </tr>
                <!--==================================================-->
                <tr>
                    <td>
                        <label for="">Profile Image</label>
                    </td>
                    <td>
                        <input type="file" name="user_img" accept="image/*">
                    </td>
                </tr>
                <!--==================================================-->

                <tr>
                    <td colspan="2">
                        <button type="submit" name="btnsave">
                            <span></span>&nbsp;save
                        </button>
                    </td>
                </tr>
            </table>

        </form>

    </div>

</body>

</html>