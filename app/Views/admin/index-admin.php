<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Game Admin Master Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('css/admin/gallery.css') ?>" />
</head>

<body class="bg-gray-50 font-sans text-gray-900">

    <div class="flex h-screen overflow-hidden">

        <aside class="w-72 bg-slate-900 text-white flex flex-col shadow-xl">
            <div class="p-6 text-2xl font-black tracking-tighter border-b border-slate-800 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-500 rounded-lg"></div>
                OVERRIDE <span class="text-xs font-normal text-slate-400">ADMIN</span>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <button onclick="showSection('dashboard')" class="nav-link w-full flex items-center space-x-3 py-3 px-4 rounded-lg bg-slate-800 text-white">
                    <i class="fas fa-chart-line w-5"></i> <span>Dashboard</span>
                </button>
                <button onclick="showSection('patches')" class="nav-link w-full flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-code-branch w-5"></i> <span>Manage Patches</span>
                </button>
                <button onclick="showSection('gallery')" class="nav-link w-full flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-images w-5"></i> <span>Gallery Uploads</span>
                </button>
                <button onclick="showSection('feedback')" class="nav-link w-full flex items-center space-x-3 py-3 px-4 rounded-lg hover:bg-slate-800 transition">
                    <i class="fas fa-comment-dots w-5"></i> <span>User Feedback</span>
                </button>
            </nav>

            <div class="p-6 bg-slate-950 border-t border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-600 border-2 border-green-500"></div>
                    <div>
                        <p class="text-sm font-bold">Admin User</p>
                        <p class="text-xs text-gray-500">System Online</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">

            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8">
                <h1 id="page-title" class="text-xl font-bold text-gray-800">Dashboard Overview</h1>
                <div class="flex items-center gap-4">
                    <button class="text-gray-500 hover:text-blue-600 transition"><i class="fas fa-bell"></i></button>
                    <button class="bg-red-50 text-red-600 px-4 py-1.5 rounded-md text-sm font-medium hover:bg-red-100 transition">Logout</button>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                <div class="max-w-5xl mx-auto">
                    <section id="dashboard" class="admin-section space-y-6">
                        <div class="flex flex-col lg:flex-row gap-6">
                            <div class="flex-1 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                </div>

                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                                    <div class="p-4 border-b font-bold">Recent System Events</div>
                                    <table class="w-full text-sm text-left">
                                        <tr class="border-b bg-gray-50/50">
                                            <th class="p-3">User</th>
                                            <th class="p-3">Action</th>
                                            <th class="p-3">Time</th>
                                        </tr>
                                        <tr class="border-b">
                                            <td class="p-3 font-medium">Allen</td>
                                            <td class="p-3">Uploaded Patch v1.0.5</td>
                                            <td class="p-3 text-gray-500">2 mins ago</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="w-full lg:w-72 space-y-6">
                                <div class="bg-slate-900 text-white p-6 rounded-xl shadow-lg">
                                    <h3 class="text-xs uppercase tracking-widest text-slate-400 font-bold mb-4">System Status</h3>
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                        <span class="text-sm">Database Online</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                        <span class="text-sm">Vercel Build: Success</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="patches" class="admin-section hidden space-y-6">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                            <h2 class="text-lg font-bold mb-4 flex items-center gap-2"><i class="fas fa-upload text-blue-500"></i> New Patch Release</h2>
                            <form class="grid grid-cols-2 gap-4">
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-semibold mb-1">Patch Version (e.g. v1.0.5)</label>
                                    <input type="text" class="w-full border-gray-300 border p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="v1.0.0" />
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-semibold mb-1">Patch File (.zip, .exe)</label>
                                    <input type="file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-semibold mb-1">Release Notes</label>
                                    <textarea rows="4" class="w-full border-gray-300 border p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="What changed in this update?"></textarea>
                                </div>
                                <button class="bg-blue-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-blue-700 w-fit transition">Publish Patch</button>
                            </form>
                        </div>
                    </section>

                    <section id="gallery" class="admin-section hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold">Gallery Management</h2>
                            <div class="text-sm text-gray-500">
                                Total Images: <span class="font-bold"><?= is_array($gallery_data) ? count($gallery_data) : 0 ?></span>
                            </div>
                        </div>

                        <div class="flex gap-6 h-[calc(100vh-250px)]">

                            <div class="w-1/3 overflow-y-auto space-y-3 pr-2 custom-scrollbar">
                                <?php if (!empty($gallery_data)) : ?>
                                    <?php foreach ($gallery_data as $img) : ?>
                                        <div class="gallery-item bg-white p-3 rounded-lg border border-gray-200 cursor-pointer hover:border-blue-500 transition shadow-sm group"
                                            onclick="showGalleryDetail(event, <?= htmlspecialchars(json_encode($img)) ?>)">

                                            <div class="flex gap-3">
                                                <img src="<?= base_url($img['image_path']) ?>" class="w-16 h-16 rounded object-cover border border-gray-100" alt="">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-bold truncate text-gray-800"><?= esc($img['gallery_title']) ?></p>
                                                    <p class="text-xs text-gray-500 truncate"><?= esc($img['gallery_description']) ?></p>
                                                    <span class="text-[10px] text-blue-500 font-bold uppercase mt-1 block">View Details</span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="text-center py-10 text-gray-400 text-sm italic">No images uploaded.</div>
                                <?php endif; ?>
                            </div>

                            <div class="flex-1 bg-white rounded-xl border border-gray-200 flex flex-col shadow-sm h-[70vh] overflow-hidden">
                                <div class="p-8 overflow-y-auto h-full">
                                    <div class="flex justify-between items-start mb-6">
                                        <div>
                                            <h3 id="gallery-form-title" class="text-2xl font-black mb-2">Add New Image</h3>
                                            <p class="text-gray-500 text-sm">Upload a new screenshot or edit an existing one.</p>
                                        </div>
                                        <div id="gallery-actions" class="hidden flex gap-2 relative z-50 pointer-events-auto">
                                            <button onclick="resetForm()" class="bg-blue-50 text-blue-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-blue-100 transition">
                                                New
                                            </button>
                                            <button onclick="deleteGalleryItem()" class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-100 transition">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                    <form action="<?= site_url('admin/gallery/upload') ?>" method="POST" enctype="multipart/form-data" id="galleryForm">
                                        <input type="hidden" name="gallery_id" id="edit-id">

                                        <div class="grid grid-cols-1 gap-6">
                                            <div id="uploadArea" class="relative border-2 border-dashed border-gray-300 rounded-xl p-10 flex flex-col items-center justify-center text-gray-500 hover:border-blue-400 transition cursor-pointer">
                                                <i class="fas fa-cloud-upload-alt text-4xl mb-3"></i>
                                                <p class="font-medium text-sm">Click to upload or drag image</p>
                                                <input type="file" name="image" id="fileInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*">
                                            </div>

                                            <div id="previewArea" class="hidden flex flex-col  h-[250px]">

                                                <div class="w-full h-64 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                                    <img id="imagePreview" class="w-full h-full object-cover">
                                                </div>

                                                <div class="p-4 border-t text-sm">
                                                    <p id="fileName"></p>
                                                    <p id="fileSize" class="text-gray-500"></p>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 mb-1">Title</label>
                                                <input type="text" name="caption" id="form-title" class="w-full border-gray-300 border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Epic Screenshot...">
                                            </div>

                                            <div>
                                                <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                                                <textarea name="description" id="form-desc" rows="4" class="w-full border-gray-300 border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Notes about this image..."></textarea>
                                            </div>

                                            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-lg hover:bg-blue-700 transition flex items-center justify-center gap-2">
                                                <i class="fas fa-save"></i> <span id="submit-btn-text">Save to Gallery</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="feedback" class="admin-section hidden">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold">Player Inbox</h2>
                            <select id="feedback-filter" class="border rounded-lg px-4 py-2 text-sm bg-white shadow-sm">
                                <option value="all">All Feedback</option>
                                <option value="bug_report">Bug Reports</option>
                                <option value="suggestion">Suggestions</option>
                            </select>
                        </div>

                        <div class="flex gap-6 h-[calc(100vh-250px)]">
                            <div class="w-1/3 overflow-y-auto space-y-3 pr-2 custom-scrollbar">
                                <?php foreach ($feedbacks_data as $item) : ?>

                                    <div
                                        class="feedback-item bg-white p-4 rounded-lg border border-gray-200 cursor-pointer hover:border-blue-500 transition shadow-sm"
                                        data-id="<?= esc($item['feedback_id']) ?>"
                                        data-username="<?= esc($item['username']) ?>"
                                        data-comment="<?= esc($item['comment']) ?>"
                                        data-email="<?= esc($item['email']) ?>"
                                        data-type="<?= esc($item['feedback_type']) ?>"
                                        data-time="<?= time_ago($item['created_at']) ?>"
                                        data-text="<?= esc($item['comment']) ?>"
                                        data-status="<?= esc($item['status']) ?>">

                                        <div class="flex justify-between text-xs text-gray-500 mb-1">
                                            <span><?= $item['username'] ?></span>
                                            <span class="<?= $item['status'] === 'reviewed' ? 'text-green-600' : 'text-gray-500' ?>">
                                                <?= $item['status'] === 'reviewed' ? 'reviewed' : time_ago($item['created_at']) ?>
                                            </span>
                                        </div>
                                        <p class="text-sm font-bold truncate"><?= $item['comment'] ?></p>
                                        <span class="text-[10px] uppercase font-black tracking-tighter <?= $item['feedback_type'] === 'bug_report' ? 'text-red-500' : 'text-amber-500' ?>">
                                            <?= $item['feedback_type'] ?>
                                        </span>
                                    </div>

                                <?php endforeach; ?>
                            </div>

                            <div class="flex-1 bg-white rounded-xl border border-gray-200 flex flex-col shadow-sm">
                                <div class="p-8 flex-1">

                                    <div class="flex justify-between items-start mb-6">
                                        <div>
                                            <h3 id="fb-title" class="text-2xl font-black mb-2">Feedback Detail</h3>

                                            <p id="fb-user" class="text-gray-500 mb-1"></p>
                                            <p id="fb-email" class="text-gray-400 text-sm"></p>
                                        </div>

                                        <div class="flex gap-2">
                                            <button id="mark-reviewed"
                                                disabled
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-bold opacity-50 cursor-not-allowed">
                                                Mark as Reviewed
                                            </button>

                                            <button id="delete-feedback"
                                                disabled
                                                class="bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm font-bold opacity-50 cursor-not-allowed">
                                                Delete
                                            </button>
                                        </div>
                                    </div>

                                    <div id="fb-comment"
                                        class="bg-gray-50 p-6 rounded-xl italic text-gray-700 leading-relaxed border border-gray-100">
                                        Select an item from the left to read the full player comment and technical details.
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>

    <script>
        window.markReviewedUrl = '<?= site_url("admin/feedback/mark_reviewed") ?>';
        window.deleteFeedbackUrl = '<?= site_url("admin/feedback/delete_feedback") ?>';
        window.baseUrl = "<?= base_url() ?>";
        window.deleteGalleryUrl = "<?= site_url('admin/gallery/delete') ?>";
    </script>
    <script src="<?= base_url('js/admin/feedback.js') ?>"></script>
    <script src="<?= base_url('js/admin/gallery.js') ?>"></script>

    <!-- Animations -->
    <script src="<?= base_url('js/admin/animations/ui-animation.js') ?>"></script>
</body>

</html>