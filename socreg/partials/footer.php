 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <script>
     function toggleDropdown(dropdownId, element) {
         const dropdown = document.getElementById(dropdownId);
         const icon = element.querySelector('.arrow-icon');
         const allDropdowns = document.querySelectorAll('.menu-drop');
         const allIcons = document.querySelectorAll('.arrow-icon');

         // Close all other dropdowns
         allDropdowns.forEach(d => {
             if (d.id !== dropdownId && !d.classList.contains('hidden')) {
                 d.classList.add('hidden');
             }
         });

         // Reset all other icons
         allIcons.forEach(i => {
             if (i !== icon) {
                 i.classList.remove('bx-chevron-down');
                 i.classList.add('bx-chevron-right');
             }
         });

         // Toggle current dropdown
         dropdown.classList.toggle('hidden');
         icon.classList.toggle('bx-chevron-right');
         icon.classList.toggle('bx-chevron-down');
     }


     // Mobile menu toggle
     const menuToggle = document.getElementById('menu-toggle');
     const sidebar = document.querySelector('.sidebar');
     const overlay = document.getElementById('sidebar-overlay');


     function toggleSidebar() {
         if (window.innerWidth <= 968) {
             // Mobile view toggle
             sidebar.classList.toggle('mobile-active');
             overlay.classList.toggle('active');
             document.body.classList.toggle('overflow-hidden');
         } else {
             // Desktop view toggle
             if (sidebar.classList.contains('sidebar-expanded')) {
                 sidebar.classList.remove('sidebar-expanded');
                 sidebar.classList.add('sidebar-collapsed');
                 document.querySelector('.main').style.marginLeft = '100px';
             } else {
                 sidebar.classList.remove('sidebar-collapsed');
                 sidebar.classList.add('sidebar-expanded');
                 document.querySelector('.main').style.marginLeft = '320px';
             }
         }
     }

     document.addEventListener('DOMContentLoaded', function() {
         menuToggle.addEventListener('click', toggleSidebar);
         overlay.addEventListener('click', toggleSidebar);
     });

     // Auto-expand the Social Recognition dropdown if on an awards/recognition page
     document.addEventListener('DOMContentLoaded', function() {
         const currentPage = window.location.search;
         if (currentPage.includes('page=awards')) {
             const currentPage = window.location.search;
             if (currentPage.includes('page=awards') ||
                 currentPage.includes('page=recognitions') ||
                 currentPage.includes('page=categories')) {

                 const recognitionDropdown = document.getElementById('recognition-dropdown');
                 const recognitionIcon = document.querySelector('[onclick="toggleDropdown(\'recognition-dropdown\', this)"] .arrow-icon');

                 if (recognitionDropdown && recognitionIcon) {
                     recognitionDropdown.classList.remove('hidden');
                     recognitionIcon.classList.remove('bx-chevron-right');
                     recognitionIcon.classList.add('bx-chevron-down');
                 }
             }
         }
     });
 </script>
 </body>

 </html>