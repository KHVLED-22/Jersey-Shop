<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form To Email Using JavaScript</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <form onsubmit="sendEmail(); reset(); return false;">
            <h3>GET IN TOUCH</h3>
            <input type="text" id="name" placeholder="Your Name" required>
            <input type="email" id="email" placeholder="Email id" required>
            <input type="text" id="phone" placeholder="Phone no." required>
            <textarea id="message" rows="4" placeholder="How can we help you?"></textarea>
            <button type=" submit">Send</button>
        </form>
    </div>
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script>
        function sendEmail() {
    fetch('temp.html')
        .then(response => response.text())
        .then(htmlContent => {
            Email.send({
                SecureToken: "610aee9a-f09f-42db-8996-6963cf012e48",
                To: "jmal.khaled@enis.tn",
                From: "smaoui.imem@enis.tn",
                Subject: "Mail de confirmation de commande",
                Body: htmlContent
            }).then(
                message => alert(message)
            );
        })
        .catch(error => console.error(error));
}
    </script>
</body>

</html>