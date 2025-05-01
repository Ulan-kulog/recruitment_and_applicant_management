<div class="shadow-sm sticky top-0 z-50">
    <nav class="bg-white h-16 w-full border-b border-[#F7E6CA] flex justify-between items-center px-6 py-4">
        <div class="left-nav flex items-center space-x-4 max-w-96 w-full">
            <button
                aria-label="Toggle menu"
                class="menu-btn text-[#4E3B2A] focus:outline-none hover:bg-[#F7E6CA] hover:rounded-full">
                <i class="fa-solid fa-bars text-[#594423] text-xl w-11 py-2"></i>
            </button>

            <div class="relative w-full flex pr-2">
                <!-- <input
                    type="text"
                    class="bg-[#FFF6E8] h-10 rounded-lg grow w-full pl-10 pr-4 focus:ring-2 focus:ring-[#F7E6CA] focus:outline-none"
                    placeholder="Search something..."
                    aria-label="Search input" />
                <i
                    class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-[#4E3B2A]"></i> -->
                <?= $heading ?>
            </div>
        </div>

        <!-- <div>
        <i
            class="fa-regular fa-user bg-[#594423] text-white px-4 py-2 rounded-lg cursor-pointer text-lg lg:hidden"
            aria-label="User profile"></i>
    </div> -->

        <!-- Right Navigation Section -->
        <div class="right-nav items-center lg:flex md:flex sm:flex space-x-4">
            <!-- User Dropdown -->
            <!-- Notification Icon (Moved to the right) -->
            <button aria-label="Notifications" class="text-[#4E3B2A] focus:outline-none pl-6 relative">
                <i class="fa-regular fa-bell text-xl"></i>
                <span class="absolute top-0.5 right-0 block w-2.5 h-2.5 bg-[#594423] rounded-full"></span>
            </button>

            <div class="relative">
                <button id="userDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                    <i class="fa-regular fa-user bg-[#594423] text-white px-4 py-2 rounded-lg text-lg" aria-label="User profile"></i>
                    <span class="text-[#4E3B2A] md:hidden sm:hidden font-semibold font-serif text-sm">
                        <?= $_SESSION['username'] . ' ' . strtoupper($_SESSION['username']) ?>
                    </span>
                </button>

                <!-- Dropdown menu -->
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

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>