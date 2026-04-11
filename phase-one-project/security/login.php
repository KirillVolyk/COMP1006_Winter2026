<?php
session_start();

// this file handles proper pathing
require_once dirname(__DIR__) . '/config.php';

require_once INCLUDES . 'connect.php';
require_once INCLUDES . 'header.php';

// Already logged in? Skip to tasks.
if (isset($_SESSION['user_id'])) {
    header("Location: " . URL_ROOT . "/crud/tasks.php");
    exit;
}

// ── reCAPTCHA credentials (uncomment when going live) ────
// define('RECAPTCHA_SITE_KEY',   '6Le2mbEsAAAAABNjVNH2udfYeQxnnqFC-LucdpRe');
// define('RECAPTCHA_SECRET_KEY', '6Le2mbEsAAAAANG_RTqurPQrtZYoEGR_PfpdpvXG');

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
    $password        = $_POST['password'] ?? '';

    if ($usernameOrEmail === '' || $password === '') {
        $error = "Username/email and password are required.";
    } else {

        // ── reCAPTCHA verification (commented out for testing) ──
        // $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
        // $verifyData = http_build_query([
        //     'secret'   => RECAPTCHA_SECRET_KEY,
        //     'response' => $recaptchaResponse,
        //     'remoteip' => $_SERVER['REMOTE_ADDR'],
        // ]);
        // $opts    = ['http' => ['method' => 'POST', 'content' => $verifyData,
        //                        'header' => "Content-Type: application/x-www-form-urlencoded\r\n"]];
        // $context = stream_context_create($opts);
        // $result  = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        // $json    = json_decode($result, true);
        //
        // if (empty($json['success'])) {
        //     $error = "Please complete the reCAPTCHA.";
        // } else {

            $sql = "SELECT id, username, email, password
                    FROM users
                    WHERE username = :login OR email = :login
                    LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':login', $usernameOrEmail);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_regenerate_id(true);

                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];

                header("Location: " . URL_ROOT . "/crud/tasks.php");
                exit;
            } else {
                $error = "Invalid credentials. Please try again.";
            }

        // } // recaptcha commented out

    }
}
?>

<!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->

<main class="container mt-4">
    <h2>Login</h2>

    <?php if ($error !== ""): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-3">
        <label for="username_or_email" class="form-label">Username or Email</label>
        <input
            type="text"
            id="username_or_email"
            name="username_or_email"
            class="form-control mb-3"
            required
        >

        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-4"
            required
        >

        <!-- <div class="g-recaptcha mb-4" data-sitekey="<?= defined('RECAPTCHA_SITE_KEY') ? RECAPTCHA_SITE_KEY : '' ?>"></div> -->

        <button type="submit" class="btn btn-primary">Login</button>
        <a href="register.php" class="btn btn-secondary">Create Account</a>
    </form>
</main>

<?php require_once INCLUDES . 'footer.php'; ?>