<?php include("src/terms/terms-logic.php"); ?>
<?php include("src/terms/header.php"); ?>


<body>
    <div class="container mt-5">
        <div class="card p-4  border-0 content-container">
            <h2 class="mb-3 text-danger">Terms of Use & Legal Disclaimer</h2>

            <p>Reliable SMS delivery platform. Before proceeding, please read the following terms carefully:</p>

            <ul class="terms-list">

                <ul class="terms-list">
                     <li>All users must act responsibly and within the bounds of applicable laws when using this platform.</li>
                    <li>You are strictly prohibited from sending unsolicited, offensive, or unlawful messages.</li>
                    <li>Any SMS sent through your account is deemed to have been sent by you.</li>
                    <li>The developer or provider of this platform holds no liability for content sent through your usage.</li>
                    <li>You agree to indemnify and hold harmless the developer from any legal or civil claims resulting from your actions.</li>
                    <li>Please note that the stability and recognition of your Sender ID especially long term depend on the type of messages you deliver and carrier regulations. The developer is not liable for issues such as Sender ID rejection, filtering, or delivery inconsistencies.</li>
                    <li>By logging in, accessing, or interacting with this system in any form or by any means direct or indirect you fully accept these terms.</li>
                    <li>This platform is provided “as is”, without any warranties, express or implied. Any unethical use is strictly at your own risk.</li>
                </ul>

            </ul>

            <p class="text-muted mt-4">
                If you do not agree to these terms, you are not authorized to use this system.
            </p>
            <div class="d-flex gap-3 mt-4">
                <form method="POST" id="accept-form">
                    <input type="hidden" name="accept_terms" value="1">
                    <button type="button" id="accept-btn" class="btn btn-success btn-flat px-4">I Accept</button>
                </form>

                <form method="POST">
                    <input type="hidden" name="decline_terms" value="1">
                    <button type="submit" class="btn btn-danger btn-flat px-4">I Do Not Accept</button>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/terms-swal-confirm.js"></script>

</body>

</html>