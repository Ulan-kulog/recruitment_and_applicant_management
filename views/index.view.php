<?php require 'partials/head.php' ?>

<div class="z-50 min-h-screen w-full flex items-center justify-center bg-[#F7E6CA] p-4">
    <div class="w-full max-w-md p-8 rounded-lg bg-white shadow-lg">
        <div class="flex justify-center mb-8">
            <img src="/img/Logo-Name.png" alt="Avalon Logo" width="250">
        </div>
        <div class="mb-6 text-center text-[#4E3B2A] text-lg font-normal">
            Welcome to Avalon—where hospitality meets innovation.
        </div>

        <form method="POST" action="#">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="you@example.com"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                    required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#4E3B2A] focus:border-[#4E3B2A]">
                <?php if ($errors['email'] ?? '') : ?>
                    <div>
                        <span class="text-xs text-red-500"><?= $errors['email'] ?></span>
                    </div>
                <?php endif ?>
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>

                <div class="relative">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        value="<?= htmlspecialchars($_POST['password'] ?? '') ?>"
                        required
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-[#4E3B2A] focus:border-[#4E3B2A]">

                    <button
                        type="button"
                        id="togglePasswordVisibility"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-sm text-gray-500 hover:text-gray-700 focus:outline-none"
                        aria-label="Toggle password visibility">
                        Show
                    </button>
                </div>
                <?php if ($errors['password'] ?? '') : ?>
                    <div class="mt-1">
                        <span class="text-xs text-red-500"><?= $errors['password'] ?></span>
                    </div>
                <?php endif ?>
            </div>


            <div class="mb-6">
                <input type="hidden" name="login" value="true">
                <button type="submit"
                    class="w-full py-2 px-4 bg-[#594423] hover:bg-[#7e6b4c] text-white font-semibold rounded-md shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4E3B2A]">
                    Login
                </button>
            </div>
        </form>

        <div class="relative flex py-3 items-center">
            <div class="flex-grow border-t border-gray-300"></div>
            <span class="flex-shrink mx-4 text-gray-400 text-sm">OR</span>
            <div class="flex-grow border-t border-gray-300"></div>
        </div>

        <div class="flex justify-center">
            <form method="POST" action="#">
                <input type="hidden" name="google" value="true">
                <button type="submit" class="border border-gray-400 shadow-md hover:bg-gray-100 rounded-full bg-white py-2 px-3 text-gray-700 font-medium">
                    <img src="/img/google-logo-icon.jpg" alt="Google logo" width="30" height="30" class="hover:bg-gray-100">
                </button>
            </form>
        </div>
        <div>
            <p class="mt-4 text-center text-sm text-gray-600">
                Don't have an account? <a href="/register" class="text-[#594423] font-semibold">Register</a>
            </p>
        </div>
    </div>
</div>
<script src="/js/passwordBtn.js"></script>
<?php require 'partials/footer.php' ?>