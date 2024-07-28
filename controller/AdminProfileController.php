<?php
class AdminProfileController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST['uname'])) {
                $this->updateUsername();
            } elseif (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
                $this->updatePassword();
            }
        }
    }

    private function updateUsername() {
        $newUsername = mysqli_real_escape_string($this->model->conn, $_POST['uname']);
        $id = $_SESSION['id'];
        $uname = $this->model->getAdminUsername($id); // Fetch the username

        if ($this->model->updateUsername($id, $newUsername)) {
            echo "Username updated successfully!";
            echo '<script>
                    setTimeout(function(){
                        window.location.href = "AdminProfileView.php";
                    }, 2000); // Redirect after 2 seconds
                  </script>';
            exit();
        } else {
            // Handle the case where the update was not successful
            echo "Failed to update username.";
        }
        
    }

    private function updatePassword() {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        if ($newPassword !== $confirmPassword) {
            echo "New password and confirm password do not match.";
        } else {
            $id = $_SESSION['id'];
            $adminInfo = $this->model->getAdminInfo($id);

            if ($adminInfo) {
                $currentPasswordDb = $adminInfo['password'];
            
                if ($currentPassword === $currentPasswordDb) {
                    if ($this->model->updatePassword($id, $newPassword)) {
                        echo "Password updated successfully.";
                        echo '<script>
                                setTimeout(function(){
                                    window.location.href = "AdminProfileView.php";
                                }, 2000); // Redirect after 2 seconds
                              </script>';
                        exit();
                    } else {
                        echo "Error updating password.";
                    }
                } else {
                    echo "Current password is incorrect.";
                }
            } else {
                echo "Error fetching admin information.";
            }
            
        }
    }

    public function displayAdminProfile() {
        $id = $_SESSION['id'];
        $adminInfo = $this->model->getAdminInfo($id);

        if ($adminInfo) {
            $uname = $adminInfo['uname'];
            echo "<h2>Admin Profile</h2>";
            echo "<p>Unique UserID: $id</p>";
        } else {
            echo "Error fetching admin information.";
        }
    }

    public function displayUsernameForm() {
        $id = $_SESSION['id'];
        $uname = $this->model->getAdminUsername($id); // Fetch the username
        echo "<div id='uname-update'>";
        echo "<h2>Update Your Username</h2>";
        echo "<form action='AdminProfileView.php' method='post'>";
        echo "<label for='uname'>New Username:</label>";
        echo "<input type='text' name='uname' value='$uname'>";
        echo "<br><input type='submit' value='Change uname'>";
        echo "</form></div>";
    }

    public function displayPasswordForm() {
        echo "<div id='password-update'>";
        echo "<h2>Update Password</h2>";
        echo "<form method='post' action='AdminProfileView.php'>";
        echo "<label for='current_password'>Current Password:</label>";
        echo "<input type='password' name='current_password' required><br><br>";
        echo "<label for='new_password'>New Password:</label>";
        echo "<input type='password' name='new_password' required><br><br>";
        echo "<label for='confirm_password'>Confirm New Password:</label>";
        echo "<input type='password' name='confirm_password' required><br><br>";
        echo "<input type='submit' name='submit' value='Confirm'>";
        echo "</form></div>";    }

    // Add more methods for handling other actions and displaying other views as needed
}
?>
