<?php
$config = require 'config.php';
$db = new Database($config['database']);
$notifications = $db->query('SELECT * FROM notifications WHERE `for` = :for', [
    ':for' => 'admin'
])->fetchAll();
?>
<div class="shadow-sm sticky top-0 z-50">
    <nav class="bg-white h-16 w-full border-b border-[#F7E6CA] flex justify-between items-center px-6 py-4">
        <div class="left-nav flex items-center space-x-4 max-w-96 w-full">
            <button
                aria-label="Toggle menu"
                class="menu-btn text-[#4E3B2A] focus:outline-none hover:bg-[#F7E6CA] hover:rounded-full">
                <i class="fa-solid fa-bars text-[#594423] text-xl w-11 py-2"></i>
            </button>

            <div class="relative w-full flex pr-2">
                <?= $heading ?>
            </div>
        </div>
        <div class="right-nav items-center lg:flex md:flex sm:flex space-x-4">
            <button aria-label="Notifications" class="text-[#4E3B2A] focus:outline-none pl-6 relative">


            </button>
            <div class="dropdown dropdown-center">
                <div tabindex="0" role="button" class="">
                    <i class="fa-regular fa-bell text-xl"></i>
                    <span class="absolute top-0.5 right-0 block w-2.5 h-2.5 bg-[#594423] rounded-full"></span>
                </div>
                <ul tabindex="0" class="dropdown-content border border-[#594423] menu bg-base-100 rounded-box z-1 w-52 p-2 me-4 mt-4 shadow-sm">
                    <h3 class="py-2.5 px-3 bg-gray-300 rounded-md mb-2">Notifications</h3>
                    <hr>
                    <?php foreach ($notifications as $notification) : ?>
                        <li><a><?= $notification['title'] ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="relative">
                <button id="userDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                    <i class="fa-regular fa-user bg-[#594423] text-white px-4 py-2 rounded-lg text-lg" aria-label="User profile"></i>
                    <span class="text-[#4E3B2A] md:hidden sm:hidden font-semibold font-serif text-sm">
                        <?= $_SESSION['username'] . ' ' . strtoupper($_SESSION['username']) ?>
                    </span>
                </button>

                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                    <div class="py-1">
                        <div class="border-b border-gray-200">
                            <span class="block px-4 py-2 text-sm text-gray-700"><?= strtoupper($_SESSION['username']) ?></span>
                            <span class="block px-4 py-2 text-sm text-gray-500">Administrator</span>
                        </div>
                        <div class="flex items-center justify-center px-4 py-2 text-sm text-gray-800 hover:bg-gray-100">
                            <box-icon name='log-out'></box-icon>
                            <a href="/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Log Out
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.getElementById('userDropdownButton');
        const dropdown = document.getElementById('userDropdown');

        dropdownButton.addEventListener('click', function() {
            dropdown.classList.toggle('hidden');
        });

        window.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>