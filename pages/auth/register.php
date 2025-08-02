<?php
// Initialize required variables if accessed directly
if (!isset($auth)) {
    require_once __DIR__ . '/../../config/config.php';
    require_once __DIR__ . '/../../config/supabase_client.php';
    require_once __DIR__ . '/../../includes/auth.php';
    
    $supabase = new SupabaseClient();
    $auth = new Auth();
}

$page_title = 'Register';
$page_description = 'Create a new Sue & Mon account';

// Check if user is already logged in
if ($auth->isLoggedIn()) {
    header('Location: ' . url());
    exit;
}

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error_message'] = 'Please fill in all fields.';
    } elseif ($password !== $confirm_password) {
        $_SESSION['error_message'] = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $_SESSION['error_message'] = 'Password must be at least 6 characters long.';
    } else {
        try {
            // Check if user already exists
            $existing_users = $supabase->select('users', '*', ['email' => $email]);
            
            if (!empty($existing_users)) {
                $_SESSION['error_message'] = 'An account with this email already exists.';
            } else {
                // Create new user
                $user_data = [
                    'name' => $name,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => 'user',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $result = $supabase->insert('users', $user_data);
                
                if ($result) {
                    $_SESSION['flash_message'] = 'Account created successfully! Please log in.';
                    header('Location: ' . url('auth/login'));
                    exit;
                } else {
                    $_SESSION['error_message'] = 'Registration failed. Please try again.';
                }
            }
        } catch (Exception $e) {
            $_SESSION['error_message'] = 'Registration failed. Please try again.';
        }
    }
}
?>

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <div class="bg-gradient-to-r from-green-600 to-green-800 p-3 rounded-lg shadow-lg">
                <img src="<?php echo asset('logo.svg'); ?>" alt="<?php echo SITE_NAME; ?> Logo" class="w-8 h-8 object-contain">
            </div>
        </div>
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
            Create your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Or
            <a href="<?php echo url('auth/login'); ?>" class="font-medium text-green-600 hover:text-green-500">
                sign in to your existing account
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" method="POST">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Full Name
                    </label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" autocomplete="name" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <div class="mt-1">
                        <input id="confirm_password" name="confirm_password" type="password" autocomplete="new-password" required
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        I agree to the
                        <a href="#" class="text-green-600 hover:text-green-500">Terms of Service</a>
                        and
                        <a href="#" class="text-green-600 hover:text-green-500">Privacy Policy</a>
                    </label>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Create Account
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300" />
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div>
                        <a href="#"
                           class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fab fa-google text-red-500"></i>
                            <span class="ml-2">Google</span>
                        </a>
                    </div>

                    <div>
                        <a href="#"
                           class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <i class="fab fa-facebook text-blue-600"></i>
                            <span class="ml-2">Facebook</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 