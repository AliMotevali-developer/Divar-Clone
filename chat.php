<?php
require_once "database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_user = $_SESSION['user_id'];
$contact_id = filter_var($_GET['to'] ?? '', FILTER_SANITIZE_NUMBER_INT);

if (empty($contact_id)) {
    $contact_id = ($current_user == 1) ? 2 : 1; 
}

if ($current_user == $contact_id) {
    die('<div style="padding:50px; text-align:center;" dir="rtl">شما نمی‌توانید با خودتان چت کنید!</div>');
}

?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>چت دیوار</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/divar.css">
    <style>
        body { background-color: #f8f9fa; }
        .chat-container { max-width: 600px; margin: 0 auto; height: 100vh; display: flex; flex-direction: column; background: #fff; border-left: 1px solid #eee; border-right: 1px solid #eee; }
        .chat-header { background: #fff; padding: 15px; border-bottom: 1px solid #eee; box-shadow: 0 2px 5px rgba(0,0,0,0.02); z-index: 10; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 20px 15px 90px 15px; display: flex; flex-direction: column; gap: 10px; }
        .chat-input-box { background: #fff; padding: 10px 15px; border-top: 1px solid #eee; position: fixed; bottom: 55px; width: 100%; max-width: 598px; z-index: 10; }
        @media (min-width: 768px) { .chat-input-box { bottom: 0; } } 
        
        .msg-bubble { max-width: 75%; padding: 10px 15px; border-radius: 15px; font-size: 0.95rem; line-height: 1.5; word-wrap: break-word; }
        .msg-mine { background-color: #f0faff; color: #333; align-self: flex-start; border-radius: 15px 15px 0 15px; border: 1px solid #e0f2fe; }
        .msg-yours { background-color: #f5f5f5; color: #333; align-self: flex-end; border-radius: 15px 15px 15px 0; border: 1px solid #e5e5e5; }
        
        .send-btn { background: transparent; border: none; color: #a62626; font-size: 1.2rem; cursor: pointer; transition: 0.2s; }
        .send-btn:disabled { color: #ccc; cursor: not-allowed; }
    </style>
</head>
<body>

<div class="chat-container">
    <div class="chat-header d-flex align-items-center">
        <a href="index.php" class="text-dark text-decoration-none me-3"><i class="fas fa-arrow-right"></i></a>
        <h6 class="m-0 fw-bold">چت با کاربر (شناسه: <?= $contact_id ?>)</h6>
    </div>

    <div class="chat-messages" id="all_chat">
        <?php
        try {
            $stmt = $pdo->prepare("SELECT * FROM chat2 WHERE (from_user_id = ? AND to_user_id = ?) OR (from_user_id = ? AND to_user_id = ?) ORDER BY Id ASC");
            $stmt->execute([$current_user, $contact_id, $contact_id, $current_user]);
            $messages = $stmt->fetchAll();

            foreach ($messages as $row) {
                $pm = htmlspecialchars($row["text1"], ENT_QUOTES, "UTF-8");
                $is_mine = ($row["from_user_id"] == $current_user);
                
                if ($is_mine) {
                    echo '<div class="msg-bubble msg-mine">' . $pm . '</div>';
                } else {
                    echo '<div class="msg-bubble msg-yours">' . $pm . '</div>';
                }
            }
        } catch (PDOException $e) {
            echo "<p class='text-center text-muted'>خطا در بارگذاری پیام‌ها.</p>";
        }
        ?>
    </div>

    <div class="chat-input-box d-flex align-items-center gap-2">
        <input type="text" id="inptchat" class="form-control rounded-pill bg-light border-0 px-3" placeholder="متنی بنویسید..." autocomplete="off">
        <button id="chat_icon" class="send-btn" disabled onclick="send()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<?php include "down_btns.php"; ?>

<script>
const chatBox = document.getElementById("all_chat");
const inputField = document.getElementById("inptchat");
const sendBtn = document.getElementById("chat_icon");
const toUser = <?= $contact_id ?>;

window.scrollTo(0, document.body.scrollHeight);
chatBox.scrollTop = chatBox.scrollHeight;

inputField.addEventListener("input", function() {
    sendBtn.disabled = this.value.trim().length === 0;
});

inputField.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        send();
    }
});

async function send() {
    let text = inputField.value.trim();
    if (text.length === 0) return;

    inputField.value = "";
    sendBtn.disabled = true;

    let formData = new FormData();
    formData.append("chat_text", text);
    formData.append("to_user", toUser);

    try {
        let response = await fetch("ajax.php", {
            method: "POST",
            body: formData
        });
        
        let result = await response.text();
        if (result && result !== "error") {
            chatBox.innerHTML += `<div class="msg-bubble msg-mine">${result}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    } catch (error) {
        console.error("خطا در ارسال پیام");
    }
}

setInterval(async function() {
    try {
        let response = await fetch(`daryaft.php?contact_id=${toUser}`);
        let newMsg = await response.text();
        
        if (newMsg.trim().length > 0) {
            chatBox.innerHTML += `<div class="msg-bubble msg-yours">${newMsg}</div>`;
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    } catch (error) {
        console.error("خطا در دریافت پیام");
    }
}, 1000);
</script>

</body>
</html>