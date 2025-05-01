<?php require 'partials/admin/head.php' ?>

<div class="flex min-h-screen w-full text-black">
    <div class="sidebar-overlay fixed top-0 left-0 w-full h-full bg-black opacity-50 z-40 hidden" id="sidebar-overlay"></div>
    <?php require 'partials/admin/sidebar.php' ?>

    <div class="main w-full bg-[#FFF6E8] md:ml-[320px] transition-all duration-300">
        <?php require 'partials/admin/navbar.php' ?>
        <main class="px-4 py-10 flex flex-col items-center">
            <?php if (count($errors) >= 1) : ?>
                <div role="alert" class="alert alert-error mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p>Error!</p>
                        <div>
                            <ul class="list-disc pl-5">
                                <li><?= $errors['job_title'] ?? '' ?></li>
                                <li><?= $errors['company'] ?? '' ?></li>
                                <li><?= $errors['description'] ?? '' ?></li>
                                <li><?= $errors['location'] ?? '' ?></li>
                                <li><?= $errors['salary'] ?? '' ?></li>
                                <li><?= $errors['requirements'] ?? '' ?></li>
                                <li><?= $errors['employment_type'] ?? '' ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif ?>
            <?php if ($success ?? '' == true) : ?>
                <div role="alert" class="alert alert-success mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Successfully Updated!</span>
                </div>
            <?php endif ?>
            <div class="w-full max-w-3xl p-6 rounded-lg shadow-lg bg-white border border-[#594423]">
                <p class="text-sm mb-2">Posted by <?= htmlspecialchars($job['username']) ?></p>
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-black mb-2">
                            <?= htmlspecialchars($job['job_title']) ?>
                        </h1>
                        <p class="text-sm md:text-md text-black font-medium">
                            <strong>Company:</strong> <?= htmlspecialchars($job['company']) ?>
                        </p>
                        <p class="text-xs mt-2 flex items-center text-black">
                            <i class="fas fa-map-marker-alt text-black mr-2"></i>
                            <?= htmlspecialchars($job['location']) ?>
                        </p>
                        <span class="inline-block mt-3 text-[0.6rem] md:text-xs font-semibold px-2 md:px-3 py-1 md:py-2 bg-[#594423] text-white rounded-md">
                            <?= htmlspecialchars($job['employment_type']) ?>
                        </span>
                    </div>
                    <div class="mt-4 md:mt-0 text-center flex flex-col md:flex-row items-center">
                        <button class="btn border-[#594423] rounded-lg hover:bg-[#594423] hover:text-white mx-1" onclick="my_modal_2.showModal()"><box-icon name='edit'></box-icon></button>
                        <form action="" method="post" class="text-center p-1">
                            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                            <input type="hidden" name="delete" value="true">
                            <button type="submit" class="btn border-[#594423] rounded-lg hover:bg-[#594423] hover:text-white"><box-icon name='trash'></box-icon></button>
                        </form>
                        <!-- </div> -->
                        <dialog id="my_modal_2" class="modal">
                            <div class="modal-box w-11/12 max-w-3xl bg-[#FFF6E8]">
                                <h3 class="text-lg font-bold">Edit Job details</h3>
                                <form method="dialog">
                                    <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                                </form>
                                <hr class="my-4">
                                <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4 font-normal">
                                    <div>
                                        <p>Job Title</p>
                                        <input class="input validator w-full mt-2" name="job_title" value="<?= $job['job_title'] ?>" type="text" required placeholder="Job Title" />
                                        <div class="validator-hint">Empty Job title field</div>
                                        <?php if ($errors['job_title'] ?? '') : ?>
                                            <p class="text-red-500 text-xs"><?= $errors['job_title'] ?></p>
                                        <?php endif ?>
                                    </div>
                                    <div>
                                        <p>Company</p>
                                        <input class="input validator w-full mt-2" name="company" value="<?= $job['company'] ?>" type="text" required placeholder="company" />
                                        <div class="validator-hint">Empty company field</div>
                                        <?php if ($errors['company'] ?? '') : ?>
                                            <p class="text-red-500 text-xs"><?= $errors['company'] ?></p>
                                        <?php endif ?>
                                    </div>
                                    <div class="md:col-span-2">
                                        <fieldset class="border rounded p-2">
                                            <legend class="text-sm px-2">Description</legend>
                                            <textarea class="textarea h-24 w-full" name="description" placeholder="Description..."><?= $job['description'] ?></textarea>
                                            <?php if ($errors['description'] ?? '') : ?>
                                                <p class="text-red-500 text-xs"><?= $errors['description'] ?></p>
                                            <?php endif ?>
                                        </fieldset>
                                    </div>
                                    <div>
                                        <p>Location</p>
                                        <input class="input validator w-full mt-2" name="location" value="<?= $job['location'] ?>" type="text" required placeholder="Location" />
                                        <div class="validator-hint">Empty location field</div>
                                        <?php if ($errors['location'] ?? '') : ?>
                                            <p class="text-red-500 text-xs"><?= $errors['location'] ?></p>
                                        <?php endif ?>
                                    </div>
                                    <div>
                                        <p>Salary</p>
                                        <input class="input validator w-full mt-2" name="salary" value="<?= $job['salary'] ?>" type="text" required placeholder="Salary" />
                                        <div class="validator-hint">Empty Salary field</div>
                                        <?php if ($errors['salary'] ?? '') : ?>
                                            <p class="text-red-500 text-xs"><?= $errors['salary'] ?></p>
                                        <?php endif ?>
                                    </div>
                                    <div class="md:col-span-2">
                                        <fieldset class="border rounded p-2">
                                            <legend class="text-sm px-2">Requirements</legend>
                                            <textarea class="textarea h-24 w-full" name="requirements" placeholder="Requirements..."><?= $job['requirements'] ?></textarea>
                                            <?php if ($errors['requirements'] ?? '') : ?>
                                                <p class="text-red-500 text-xs"><?= $errors['requirements'] ?></p>
                                            <?php endif ?>
                                        </fieldset>
                                    </div>
                                    <div class="md:col-span-2 flex flex-col items-center">
                                        <p class="my-2">Employment type</p>
                                        <select class="select w-full" name="employment_type" value="<?= $job['employment_type'] ?>">
                                            <option></option>
                                            <option value="full-time">full-time</option>
                                            <option value="part-time">part-time</option>
                                        </select>
                                        <?php if ($errors['employment_type'] ?? '' == true) : ?>
                                            <p class="text-red-500 text-xs"><?= $errors['employment_type'] ?></p>
                                        <?php endif ?>
                                    </div>
                                    <hr class="md:col-span-2 my-2">
                                    <div class="md:col-span-2 text-right">
                                        <input type="hidden" name="id" value="<?= $job['posting_id'] ?>">
                                        <button class="btn border-[#594423] rounded-lg hover:bg-[#594423] hover:text-white">Update</button>
                                    </div>
                                </form>
                            </div>
                            <form method="dialog" class="modal-backdrop">
                                <button>close</button>
                            </form>
                        </dialog>
                    </div>
                </div>

                <div class="mt-4 space-y-4 text-black">
                    <div>
                        <h2 class="text-lg font-semibold text-black">Job Description</h2>
                        <p class="mt-2 leading-relaxed">
                            <?= nl2br(htmlspecialchars($job['description'])) ?>
                        </p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-black">Qualifications</h2>
                        <p class="mt-2 leading-relaxed">
                            <?= nl2br(htmlspecialchars($job['requirements'])) ?>
                        </p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-black">Salary</h2>
                        <p class="mt-2 font-medium">
                            <?= htmlspecialchars($job['salary']) ?>
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="/admin/jobs" class="text-black font-medium hover:text-blue-600 hover:underline flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Back to Job Listings
                    </a>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require 'partials/admin/footer.php' ?>