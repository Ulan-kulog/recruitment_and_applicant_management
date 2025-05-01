<?php require 'partials/head.php' ?>
<?php require 'partials/navbar.php' ?>
<?php if ($success == true) : ?>
    <div role="alert" class="alert alert-success">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <p>Application Submitted!</p>
        <a href="/application" class="hover:underline font-bold">Go to applications tab</a>
    </div>
<?php endif ?>
<div class="my-5">
    <a href="/home" class="text-blue-500 hover:text-blue-600 hover:underline mx-5 flex items-center"><box-icon name='left-arrow-alt'></box-icon>Back to jobpostings</a>
</div>
<main class="max-w-7xl mx-auto my-6 p-6 flex-grow bg-[#FFF6E8] rounded-lg shadow-lg">
    <h2 class="text-3xl font-semibold text-[#594423] mb-6 text-center">Job Application Form</h2>
    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[#4E3B2A] text-md text-md">First Name</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($user_info['first_name'] ?? '') ?>" placeholder="Juan"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring focus:ring-[#594423] focus:outline-none" readonly required>
                <?php if ($errors['first_name'] ?? '') : ?>
                    <p class="w-full max-w-md text-red-500">
                        <?= $errors['first_name'] ?>
                    </p>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-[#4E3B2A] text-md">Last Name</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($user_info['last_name'] ?? '') ?>" placeholder="Dela Cruz"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring focus:ring-[#594423] focus:outline-none" readonly required>
                <?php if ($errors['last_name'] ?? '') : ?>
                    <p class=" w-full max-w-md text-red-500">
                        <?= $errors['last_name'] ?>
                    </p>
                <?php endif ?>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[#4E3B2A] text-md">Contact Number</label>
                <input type="tel" name="contact_number" value="<?= htmlspecialchars($_POST['contact_number'] ?? '') ?>" placeholder="09123456789"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring focus:ring-[#594423] focus:outline-none" required>
                <?php if ($errors['contact_number'] ?? '') : ?>
                    <p class="w-full max-w-md text-red-500">
                        <?= $errors['contact_number'] ?>
                    </p>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-[#4E3B2A] text-md">Age</label>
                <input type="number" name="age" value="<?= htmlspecialchars($_POST['age'] ?? '') ?>" placeholder="25"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring focus:ring-[#594423] focus:outline-none" id="age" required>
                <p class="w-full max-w-md text-red-500 text-xs hidden" id="ageError">age must be 18 and above</p>
                <?php if ($errors['age'] ?? '') : ?>
                    <p class="w-full max-w-md text-red-500 text-xs">
                        <?= $errors['age'] ?>
                    </p>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-[#4E3B2A] text-md">Date of Birth</label>
                <input type="date" name="date_of_birth" value="<?= htmlspecialchars($_POST['date_of_birth'] ?? '') ?>"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring focus:ring-[#594423] focus:outline-none" required>
                <?php if ($errors['date_of_birth'] ?? '') : ?>
                    <p class="w-full max-w-md text-red-500">
                        <?= $errors['date_of_birth'] ?>
                    </p>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-[#4E3B2A] text-md">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user_info['email']) ?>" placeholder="juanDelaCruz@gmail.com"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring focus:ring-[#594423] focus:outline-none" readonly>
                <?php if ($errors['email'] ?? '') : ?>
                    <p class="w-full max-w-md text-red-500">
                        <?= $errors['email'] ?>
                    </p>
                <?php endif ?>
            </div>
        </div>

        <div>
            <label class="block text-[#4E3B2A] text-md w-full">Address</label>
            <input type="text" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '')  ?>" placeholder="1234 Main St, City, Province"
                class="w-full px-4 py-2 mt-2 border border-gray-300 rounded-lg focus:ring focus:ring-[#594423] focus:outline-none" required>
            <?php if ($errors['address'] ?? '') : ?>
                <p class="w-full max-w-md text-red-500">
                    <?= $errors['address'] ?>
                </p>
            <?php endif ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-[#4E3B2A] text-md">Resume (PDF/DOCX)</label>
                <input type="file" name="resume" accept=".pdf,.doc,.docx"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg bg-white" required>
                <?php if ($errors['resume'] ?? '') : ?>
                    <div class="text-red-500 text-sm">
                        <?= $errors['resume'] ?>
                    </div>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-[#4E3B2A] text-md">Philhealth (PDF/DOCX)</label>
                <input type="file" name="philhealth" accept=".pdf,.doc,.docx"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg bg-white" required>
                <?php if ($errors['philhealth'] ?? '') : ?>
                    <div class="text-red-500 text-sm">
                        <?= $errors['philhealth'] ?>
                    </div>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-[#4E3B2A] text-md">SSS (PDF/DOCX)</label>
                <input type="file" name="sss" accept=".pdf,.doc,.docx"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg bg-white" required>
                <?php if ($errors['sss'] ?? '') : ?>
                    <div class="text-red-500 text-sm">
                        <?= $errors['sss'] ?>
                    </div>
                <?php endif ?>
            </div>

            <div>
                <label class="block text-[#4E3B2A] text-md">Pag-ibig (PDF/DOCX)</label>
                <input type="file" name="pagibig" accept=".pdf,.doc,.docx"
                    class="w-full max-w-md px-4 py-2 mt-2 border border-gray-300 rounded-lg bg-white" required>
                <?php if ($errors['pagibig'] ?? '') : ?>
                    <div class="text-red-500 text-sm">
                        <?= $errors['pagibig'] ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <div class="flex justify-center ">
            <button type="button"
                class="btn hover:bg-[#594423] hover:text-white border border-[#594423] px-6 py-3 rounded-lg text-md font-semibold text-[#594423]" id="submitBtn">
                Submit Application
            </button>
        </div>
    </form>
</main>

<script>
    $('#submitBtn').on('click', function() {
        let isValid = true;
        $('input[required]').each(function() {
            if ($(this).val() === '') {
                isValid = false;
                $(this).addClass('border-red-500');
            } else {
                $(this).removeClass('border-red-500');
            }
        });
        if ($('#age').val() < 18) {
            isValid = false;
            $('#age').removeClass('hidden');
            $('#age').addClass('border-red-500');
            $('#ageError').removeClass('hidden');
        } else {
            $('#age').removeClass('border-red-500');
        }
        if (isValid) {
            swal.fire({
                title: 'Application Submitted!',
                text: 'Your application has been submitted successfully.',
                icon: 'success',
                confirmButton: 'false',
            })
            $('form').submit();
        } else {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Please fill in all required fields.",
            });
        }
    });
</script>
<?php require 'partials/footer.php' ?>