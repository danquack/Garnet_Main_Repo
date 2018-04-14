<?php
/**
 * Class: ${NAME}
 * Date: 4/13/2018
 * Description:
 */
function createHash($txt, $salt){
    return hash('sha256', $txt.$salt);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo createHash($_POST['text'], $_POST['salt']);
    return createHash($_POST['text'], $_POST['salt']);

}
?>
<!-- HTML -->
<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

    <body>
    <label for="txt">Hashing Example</label></br>
    <input type="text" id="txt" name="txt" autocomplete="off" placeholder="Enter text"/>

    <button onclick="createHash()" id="btn"> Generate Hash </button>

    </body>
</html>

<!--- JS --->
<script type="text/javascript">
function createHash() {
    var value2 = $('#txt').val();
    alert(value2);

    $.ajax({
        method: "POST",
        url: "ex04.php",
        data: {
            text: $('#txt').val(),
            salt: getSalt();
        }
    }).done(function (data) {
        alert(data);
    });
}

function getSalt() {
    $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'";:?.>,<!@#$%^&*()-_=+|';
    $randStringLen = 64;

    $randString = "";
    for ($i = 0; $i < $randStringLen; $i++) {
        $randString = $charset[mt_rand(0, strlen($charset) - 1)];
    }

    return $randString;
}
</script>