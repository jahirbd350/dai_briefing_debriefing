<?php
class Login
{
    protected $link;

    public function __construct()
    {
        $this->link = mysqli_connect('localhost', 'root', '', 'dai_briefing');
    }

    public function userRegistration($data)
    {
        if ($data['user_password'] != $data['cf_user_password']) {
            $message = "Password and Confirm Password Does not Match!!";
            return $message;
        } else {
            $sql = "SELECT * FROM new_users WHERE bd_no='$data[bd_no]'";
            if (mysqli_query($this->link, $sql)) {
                $queryResult = mysqli_query($this->link, $sql);
                $userInfo = mysqli_fetch_assoc($queryResult);
                if ($userInfo['bd_no'] == $data['bd_no']) {
                    $message = "User Svc No already used!";
                    return $message;
                } else {
                    $sql = "INSERT INTO users(user_name,bd_no,password)
                          VALUES ('$data[full_name]','$data[bd_no]','$data[user_password]')";
                    if (mysqli_query($this->link, $sql)) {
                        $message = "User Registration success. Please Login.";
                        $_SESSION['message'] = $message;
                        //return $message;
                        header('Location: index.php');
                    } else {
                        die('User Registration Query Error : ' . mysqli_error($this->link));
                    }
                }
            } else {
                die('User Check Error : ' . mysqli_error($this->link));
            }
        }
    }

    public function userResetPassword($data)
    {
        $sql = "SELECT * FROM new_users WHERE bd_no='$_SESSION[bd_no]'";
        $queryResult = mysqli_query($this->link, $sql);

        if (mysqli_num_rows($queryResult)>0) {
            $sql = "UPDATE new_users SET
            password='$data[user_password]'
            WHERE bd_no='$_SESSION[bd_no]'";
            if (mysqli_query($this->link, $sql)) {
                $_SESSION['message'] = "Password changed Successfully! <br> Pl login again with new password.";
                $this->adminLogout();
                header('Location: ../index.php');
            } else {
                die('Password Reset Error : ' . mysqli_error($this->link));
            }
        } else {
            $message = "User Svc No not found.<br> Please contact Dte AI(3050,01769993050) if you are not a registered!";
            return $message;
        }
    }

    public function passwordResetRequest()
    {
        $bd_no = $_POST['bd_no'];
        $date_of_birth = $_POST['date_of_birth'];
        $sql = "SELECT * FROM new_users WHERE bd_no='$bd_no'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($queryResult) > 0) {
                $userInfo = mysqli_fetch_assoc($queryResult);

                if ($date_of_birth==$userInfo['date_of_birth']){
                    $sql = "UPDATE new_users
                            SET
                            pass_reset_request='requested'
                            WHERE bd_no='$_POST[bd_no]'";

                    if (mysqli_multi_query($this->link, $sql)) {
                        $message = "Your Password Reset Request sent Successfully!<br>Pl contact svc ext-3050 or mob-01769993050 (if necessary).";
                    } else {
                        die('passwordResetRequest Query Problem : ' . mysqli_error($this->link));
                    }

                }else{
                    $message = "Your date of birth is not correct!<br> Please enter correct date of birth.";
                }
            }
            else{
                $message = "You are not registered! <br> Please contact with(3050 or 01769993050)";
            }
        }
        else {
            die('passwordResetRequest query Problem : ' . mysqli_error($this->link));
        }
        return $message;
    }

    public function adminLoginCheck($data)
    {
        $bd_no = $data['bd_no'];
        $password = $data['user_password'];
        $date_of_birth = $data['date_of_birth'];
        $sql = "SELECT * FROM new_users WHERE bd_no='$bd_no'";
        if (mysqli_query($this->link, $sql)) {
            $queryResult = mysqli_query($this->link, $sql);
            if (mysqli_num_rows($queryResult) > 0) {
                $userInfo = mysqli_fetch_assoc($queryResult);

                if ($date_of_birth==$userInfo['date_of_birth']){
                    if ($password == $userInfo['password']) {
                        session_start();
                        $_SESSION['user_id'] = $userInfo['id'];
                        $_SESSION['bd_no'] = $userInfo['bd_no'];
                        $_SESSION['rank'] = $userInfo['rank'];
                        $_SESSION['name'] = $userInfo['name'];
                        $_SESSION['br_trade'] = $userInfo['br_trade'];
                        $_SESSION['user_role'] = $userInfo['user_role'];
                        $_SESSION['type_of_visit'] = $userInfo['type_of_visit'];
                        $_SESSION['user_active'] = $userInfo['user_active'];
                        if ($userInfo['group_id'] != NULL){
                            $groupId = $userInfo['group_id'];
                        }else{
                            $groupId = mt_rand(000, 999);
                        }
                        $_SESSION['groupId'] = $groupId;
                        header('location: index.php');
                    }
                    else {
                        $message = "Password is not correct!<br> Please reset your password.";
                    }
                }else{
                    $message = "Your date of birth is not correct!<br> Please enter correct date of birth.";
                }
            }
            else{
                $message = "You are not registered! <br> Please contact with Dte AI(3050 or 01769993050)";
            }
        }
        else {
            die('Login Query Problem : ' . mysqli_error($this->link));
        }
        return $message;
    }

    public function adminLogout()
    {
        session_destroy();
        /*unset($_SESSION['user_id']);
        unset($_SESSION['bd_no']);
        unset($_SESSION['user_role']);
        unset($_SESSION['type_of_visit']);
        unset($_SESSION['user_active']);
        unset($_SESSION['visitId']);
        unset($_SESSION['visiting_country']);
        unset($_SESSION['groupId']);*/
        header('location: ../index.php');
        $message = "Logged out successfully.";
        return $message;
    }
}