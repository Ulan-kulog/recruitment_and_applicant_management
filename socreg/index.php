<?php
function sanitize_page($page)
{
    return preg_replace('/[^a-zA-Z0-9_-]/', '', $page);
}
require 'socreg/config.php';
require 'partials/admin/head.php';
?>

<div class="flex min-h-screen w-full">
    <!-- Overlay -->
    <!-- <div class="sidebar-overlay" id="sidebar-overlay"></div> -->

    <!-- Sidebar -->
    <?php require 'partials/admin/sidebar.php' ?>

    <!-- Main Content -->
    <div class="main w-full md:ml-[320px] bg-[#FFF6E8]">
        <!-- Navbar -->
        <!-- <nav class="h-16 w-full bg-white border-b border-[#F7E6CA] flex justify-between items-center px-6">
            <div class="flex items-center space-x-4">
                <button id="menu-toggle" class="text-[#4E3B2A] hover:bg-[#F7E6CA] p-2 rounded-lg">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
                <div class="relative">
                    <input type="text"
                        placeholder="  Search..."
                        class="w-64 bg-[#FFF6E8] rounded-lg px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-[#F7E6CA]">
                    <i class="fa-solid fa-search absolute left-2 top-1/2 -translate-y-1/2 text-[#4E3B2A]"></i>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button class="relative">
                    <i class="fa-regular fa-bell text-xl text-[#4E3B2A]"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 rounded-full w-2 h-2"></span>
                </button>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-[#4E3B2A] rounded-lg flex items-center justify-center">
                        <i class="fa-regular fa-user text-white"></i>
                    </div>
                    <div class="hidden md:block">
                        <h3 class="text-sm font-medium text-[#4E3B2A]">John Doe</h3>
                        <p class="text-xs text-[#594423]">Administrator</p>
                    </div>
                </div>
            </div>
        </nav> -->
        <?php require 'partials/admin/navbar.php' ?>

        <!-- Page Content -->
        <div class="p-6">
            <?php
            // Determine which page to include based on the query parameter
            if (isset($_GET['page'])) {
                $page = sanitize_page($_GET['page']);
                switch ($page) {
                    case 'awards':
                        include 'awards.php';
                        break;
                    case 'recognitions':
                        include 'recognitions.php';
                        break;
                    case 'categories':
                        include 'categories.php';
                        break;
                    case 'dashboard':
                        echo '<h1 class="text-2xl font-bold text-[#4E3B2A] mb-6">Dashboard</h1>';
                        echo '<div class="bg-white rounded-lg p-6 shadow-sm border border-[#F7E6CA]">';
                        echo '<p>Welcome to the HR Management System Dashboard.</p>';
                        echo '</div>';
                        break;
                    default:
                        echo '<h1 class="text-2xl font-bold text-[#4E3B2A] mb-6">Page Not Found</h1>';
                        echo '<div class="bg-white rounded-lg p-6 shadow-sm border border-[#F7E6CA]">';
                        echo '<p>The requested page could not be found.</p>';
                        echo '</div>';
                }
            } else {
                echo '<h1 class="text-2xl font-bold text-[#4E3B2A] mb-6">Dashboard</h1>';
                echo '<div class="bg-white rounded-lg p-6 shadow-sm border border-[#F7E6CA]">';
                echo '<p>Welcome to the HR Management System Dashboard.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleDropdown(dropdownId, element) {
        const dropdown = document.getElementById(dropdownId);
        const icon = element.querySelector('.arrow-icon');
        const allDropdowns = document.querySelectorAll('.menu-drop');
        const allIcons = document.querySelectorAll('.arrow-icon');
        allDropdowns.forEach(d => {
            if (d.id !== dropdownId && !d.classList.contains('hidden')) {
                d.classList.add('hidden');
            }
        });
        allIcons.forEach(i => {
            if (i !== icon) {
                i.classList.remove('bx-chevron-down');
                i.classList.add('bx-chevron-right');
            }
        });
        dropdown.classList.toggle('hidden');
        icon.classList.toggle('bx-chevron-right');
        icon.classList.toggle('bx-chevron-down');
    }
    const menuToggle = document.getElementById('menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    // function toggleSidebar() {
    //     if (window.innerWidth <= 968) {
    //         sidebar.classList.toggle('mobile-active');
    //         overlay.classList.toggle('active');
    //         document.body.classList.toggle('overflow-hidden');
    //     } else {
    //         if (sidebar.classList.contains('sidebar-expanded')) {
    //             sidebar.classList.remove('sidebar-expanded');
    //             sidebar.classList.add('sidebar-collapsed');
    //             document.querySelector('.main').style.marginLeft = '100px';
    //         } else {
    //             sidebar.classList.remove('sidebar-collapsed');
    //             sidebar.classList.add('sidebar-expanded');
    //             document.querySelector('.main').style.marginLeft = '320px';
    //         }
    //     }
    // }
    // document.addEventListener('DOMContentLoaded', function() {
    //     menuToggle.addEventListener('click', toggleSidebar);
    //     overlay.addEventListener('click', toggleSidebar);
    // });
    // document.addEventListener('DOMContentLoaded', function() {
    //     const currentPage = window.location.search;
    //     if (currentPage.includes('page=awards')) {
    //         const currentPage = window.location.search;
    //         if (currentPage.includes('page=awards') ||
    //             currentPage.includes('page=recognitions') ||
    //             currentPage.includes('page=categories')) {

    //             const recognitionDropdown = document.getElementById('recognition-dropdown');
    //             const recognitionIcon = document.querySelector('[onclick="toggleDropdown(\'recognition-dropdown\', this)"] .arrow-icon');

    //             if (recognitionDropdown && recognitionIcon) {
    //                 recognitionDropdown.classList.remove('hidden');
    //                 recognitionIcon.classList.remove('bx-chevron-right');
    //                 recognitionIcon.classList.add('bx-chevron-down');
    //             }
    //         }
    //     }
    // });
</script>
<?php require 'partials/admin/footer.php' ?>