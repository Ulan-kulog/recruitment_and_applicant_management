<div
    class="sidebar sidebar-collapsed fixed z-40 h-screen bg-white border-r border-[#F7E6CA] flex flex-col overflow-y-auto">
    <div
        class="h-16 border-b border-[#F7E6CA] flex items-center px-2 space-x-2">
        <!-- <h1 class="text-xl font-bold text-black bg-[#D9D9D9] p-2 rounded-xl"></h1> -->
        <div class="py-2">
            <a href="/admin/">
                <img src="/img/Logo-Name.png" alt="Avalon-logo">
            </a>
        </div>
        <!--Close Button-->
        <i
            id="close-sidebar-btn"
            class="fa-solid fa-x close-sidebar-btn transform translate-x-20 font-bold text-xl"></i>
    </div>
    <div class="side-menu px-4 py-6">
        <ul class="space-y-4">
            <!-- Dashboard Item -->
            <div class="menu-option">
                <a
                    href="/admin/"
                    class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-house text-lg pr-4"></i>
                        <span class="text-sm font-medium">Dashboard</span>
                    </div>
                </a>
            </div>

            <!-- Disbursement Item  -->
            <div class="menu-option">
                <div
                    class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer"
                    onclick="toggleDropdown('NHOES-dropdown', this)">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-wallet text-lg pr-4"></i>
                        <span class="text-sm font-medium">New Hire Onboarding and Employee Self-Service
                        </span>
                    </div>
                    <div class="arrow">
                        <i
                            class="bx bx-chevron-right text-[18px] font-semibold arrow-icon"></i>
                    </div>
                </div>
                <div
                    id="NHOES-dropdown"
                    class="menu-drop hidden flex-col w-full bg-[#F7E6CA] rounded-lg p-4 space-y-2 mt-2">
                    <ul class="space-y-1">
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Employees</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">JobRoles</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Departments</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">OnboardingTasks</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">SelfServiceRequests</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Budget Management Item  -->
            <div class="menu-option">
                <div
                    class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer"
                    onclick="toggleDropdown('pms-dropdown', this)">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-chart-pie text-lg pr-4"></i>
                        <span class="text-sm font-medium">Performance Management System</span>
                    </div>
                    <div class="arrow">
                        <i
                            class="bx bx-chevron-right text-[18px] font-semibold arrow-icon"></i>
                    </div>
                </div>
                <div
                    id="pms-dropdown"
                    class="menu-drop hidden flex-col w-full bg-[#F7E6CA] rounded-lg p-4 space-y-2 mt-2">
                    <ul class="space-y-1">
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">PerformanceReviews</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">KPIs</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Goals</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Feedback</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Appraisals</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Collection Item  -->
            <div class="menu-option">
                <div
                    class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer"
                    onclick="toggleDropdown('ram-dropdown', this)">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-folder-open text-lg pr-4"></i>
                        <span class="text-sm font-medium">Recruitment and Applicant Management</span>
                    </div>
                    <div class="arrow">
                        <i
                            class="bx bx-chevron-right text-[18px] font-semibold arrow-icon"></i>
                    </div>
                </div>
                <div
                    id="ram-dropdown"
                    class="menu-drop hidden flex-col w-full bg-[#F7E6CA] rounded-lg p-4 space-y-2 mt-2">
                    <ul class="space-y-1">
                        <li>
                            <a
                                href="/admin/applicants"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">
                                applicants</a>
                        </li>
                        <li>
                            <a
                                href="/admin/users"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">User Accounts</a>
                        </li>
                        <li>
                            <a
                                href="/admin/job-offers"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">
                                Job offers</a>
                        </li>
                        <li>
                            <a
                                href="/admin/interview_schedules"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">
                                interviewschedules</a>
                        </li>
                        <li>
                            <a
                                href="/admin/jobs"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">jobpostings</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- General Ledger Item  -->
            <div class="menu-option">
                <div
                    class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer"
                    onclick="toggleDropdown('general-ledger-dropdown', this)">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-money-bills text-lg pr-4"></i>
                        <span class="text-sm font-medium">Social Recognition</span>
                    </div>
                    <div class="arrow">
                        <i
                            class="bx bx-chevron-right text-[18px] font-semibold arrow-icon"></i>
                    </div>
                </div>
                <div
                    id="general-ledger-dropdown"
                    class="menu-drop hidden flex-col w-full bg-[#F7E6CA] rounded-lg p-4 space-y-2 mt-2">
                    <ul class="space-y-1">
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">EmployeeRecognition</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Account Payable/Receiver Item  -->
            <div class="menu-option">
                <div
                    class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer"
                    onclick="toggleDropdown('competency-dropdown', this)">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-file-invoice-dollar text-lg pr-4"></i>
                        <span class="text-sm font-medium">Competency Management</span>
                    </div>
                    <div class="arrow">
                        <i
                            class="bx bx-chevron-right text-[18px] font-semibold arrow-icon"></i>
                    </div>
                </div>
                <div
                    id="competency-dropdown"
                    class="menu-drop hidden flex-col w-full bg-[#F7E6CA] rounded-lg p-4 space-y-2 mt-2">
                    <ul class="space-y-1">
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Competencies</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">EmployeeCompetencies</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="menu-option">
                <div
                    class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer"
                    onclick="toggleDropdown('succession-dropdown', this)">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-file-invoice-dollar text-lg pr-4"></i>
                        <span class="text-sm font-medium">Succession Planning</span>
                    </div>
                    <div class="arrow">
                        <i
                            class="bx bx-chevron-right text-[18px] font-semibold arrow-icon"></i>
                    </div>
                </div>
                <div
                    id="succession-dropdown"
                    class="menu-drop hidden flex-col w-full bg-[#F7E6CA] rounded-lg p-4 space-y-2 mt-2">
                    <ul class="space-y-1">
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">SuccessionPlans</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">KeyPositions</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">PotentialSuccessors</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="menu-option">
                <div
                    class="menu-name flex justify-between items-center space-x-3 hover:bg-[#F7E6CA] px-4 py-3 rounded-lg transition duration-300 ease-in-out cursor-pointer"
                    onclick="toggleDropdown('ltm-dropdown', this)">
                    <div class="flex items-center space-x-2">
                        <i class="fa-solid fa-file-invoice-dollar text-lg pr-4"></i>
                        <span class="text-sm font-medium">Learning and Training Management</span>
                    </div>
                    <div class="arrow">
                        <i
                            class="bx bx-chevron-right text-[18px] font-semibold arrow-icon"></i>
                    </div>
                </div>
                <div
                    id="ltm-dropdown"
                    class="menu-drop hidden flex-col w-full bg-[#F7E6CA] rounded-lg p-4 space-y-2 mt-2">
                    <ul class="space-y-1">
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">TrainingPrograms</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Enrollments</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Trainers</a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="text-sm text-gray-800 hover:text-blue-600 hover:ms-2 duration-300 ease-out pr-5 py-2">Assessments</a>
                        </li>
                    </ul>
                </div>
            </div>
        </ul>
    </div>
</div>