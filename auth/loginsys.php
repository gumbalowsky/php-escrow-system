<?PHP
session_start();
$login = $_POST['nicknamelogin'];
$_SESSION['nickname'] = $login;
header("Location: ../");
?>