<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Game Admin Master Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/output.css') ?>" />
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

                <section id="dashboard" class="admin-section space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-gray-500 text-sm font-medium">Total Patches</p>
                            <p class="text-3xl font-bold">24</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-gray-500 text-sm font-medium">Gallery Items</p>
                            <p class="text-3xl font-bold">142</p>
                        </div>
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <p class="text-gray-500 text-sm font-medium">Unread Feedback</p>
                            <p class="text-3xl font-bold text-blue-600">12</p>
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

                <section id="gallery" class="admin-section hidden space-y-6">
                    <form action="<?= site_url('admin/gallery/upload') ?>"
                        method="POST"
                        enctype="multipart/form-data"
                        class="bg-white p-6 rounded-xl shadow-sm border border-gray-200"
                        id="galleryForm">

                        <h2 class="text-lg font-bold mb-4">Add Gallery Image</h2>

                        <!-- Upload Area (Initial State) -->
                        <div id="uploadArea" class="relative border-2 border-dashed border-gray-300 rounded-xl p-10 flex flex-col items-center justify-center text-gray-500 hover:border-blue-400 transition cursor-pointer mb-4 block w-full">
                            <i class="fas fa-cloud-upload-alt text-4xl mb-3"></i>
                            <p class="font-medium">Click or drag images to upload</p>
                            <p class="text-xs">PNG, JPG or WebP (Max 10MB)</p>

                            <input type="file"
                                name="image"
                                id="fileInput"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                accept="image/*"
                                multiple>
                        </div>

                        <!-- Preview Area (Hidden Initially) -->
                        <div id="previewArea" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                            <div class="flex items-center text-green-800 mb-3">
                                <i class="fas fa-check-circle text-xl mr-2"></i>
                                <span class="font-semibold">✅ Images selected successfully!</span>
                            </div>
                            <div id="imagePreviews" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3"></div>
                            <button type="button" id="changeImages" class="w-1/4 bg-[#63C1F8] text-white font-bold py-3 px-6 mt-6 rounded-lg hover:bg-[#0379A0] transition duration-200 flex items-center justify-center">
                                <i class="fas fa-edit mr-1"></i>Change Images
                            </button>
                        </div>

                        <!-- Form Fields (Caption & Notes) -->
                        <div class="mt-6">
                            <label class="block text-sm font-semibold mb-1 text-gray-700">Image Caption</label>
                            <input type="text"
                                name="caption"
                                class="w-full border-gray-300 border p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="Epic Boss Fight Screenshot..." />
                        </div>

                        <div class="mt-4">
                            <label class="block text-sm font-semibold mb-1 text-gray-700">Release Notes</label>
                            <textarea name="description"
                                rows="4"
                                class="w-full border-gray-300 border p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                placeholder="What changed in this update?"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-[#14C1FA] text-white font-bold py-3 px-6 mt-6 rounded-lg hover:bg-[#0379A0] transition duration-200 flex items-center justify-center">
                            <i class="fas fa-save mr-2"></i>
                            Save to Gallery
                        </button>
                    </form>
                </section>

                <section id="feedback" class="admin-section hidden space-y-4">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold">Recent Player Suggestions</h2>
                        <select class="border rounded-md px-3 py-1 text-sm outline-none">
                            <option>Newest First</option>
                            <option>Oldest First</option>
                            <option>Bug Reports</option>
                        </select>
                    </div>

                    <div class="bg-white p-4 rounded-lg border-l-4 border-amber-400 shadow-sm flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-gray-800">DragonSlayer99</span>
                                <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-500">2 hours ago</span>
                            </div>
                            <p class="text-gray-600">"The new fire mage class feels slightly underpowered in PvP. Can we look at the mana costs?"</p>
                            <div class="mt-3 flex gap-2">
                                <button class="text-xs font-bold text-blue-600 hover:underline">Mark as Reviewed</button>
                                <button class="text-xs font-bold text-red-600 hover:underline">Delete</button>
                            </div>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-700 px-2 py-1 rounded">Suggestion</span>
                    </div>

                    <div class="bg-white p-4 rounded-lg border-l-4 border-red-500 shadow-sm flex justify-between items-start">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-bold text-gray-800">NoobMaster69</span>
                                <span class="text-xs bg-gray-100 px-2 py-0.5 rounded text-gray-500">Yesterday</span>
                            </div>
                            <p class="text-gray-600">"Game crashes when I try to enter the 'Forgotten Forest' zone on MacOS."</p>
                            <div class="mt-3 flex gap-2">
                                <button class="text-xs font-bold text-blue-600 hover:underline">Mark as Fixed</button>
                                <button class="text-xs font-bold text-red-600 hover:underline">Delete</button>
                            </div>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider bg-red-100 text-red-700 px-2 py-1 rounded">Bug Report</span>
                    </div>
                </section>

            </main>
        </div>
    </div>

    <script>
        // File Upload Verification & Preview
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const uploadArea = document.getElementById('uploadArea');
            const previewArea = document.getElementById('previewArea');
            const imagePreviews = document.getElementById('imagePreviews');
            const changeImagesBtn = document.getElementById('changeImages');

            // File selection handler
            fileInput.addEventListener('change', handleFiles);

            // Drag & Drop handlers
            uploadArea.addEventListener('dragover', handleDragOver);
            uploadArea.addEventListener('dragleave', handleDragLeave);
            uploadArea.addEventListener('drop', handleDrop);

            // Change images button
            changeImagesBtn?.addEventListener('click', resetUploadArea);

            function handleFiles(e) {
                const files = e.target.files;
                if (files.length > 0) {
                    showPreview(files);
                }
            }

            function handleDragOver(e) {
                e.preventDefault();
                uploadArea.classList.add('bg-blue-50', 'border-blue-400', 'ring-2', 'ring-blue-200');
            }

            function handleDragLeave(e) {
                e.preventDefault();
                uploadArea.classList.remove('bg-blue-50', 'border-blue-400', 'ring-2', 'ring-blue-200');
            }

            function handleDrop(e) {
                e.preventDefault();
                uploadArea.classList.remove('bg-blue-50', 'border-blue-400', 'ring-2', 'ring-blue-200');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    const dataTransfer = new DataTransfer();
                    Array.from(files).forEach(file => {
                        if (file.type.startsWith('image/')) {
                            dataTransfer.items.add(file);
                        }
                    });
                    fileInput.files = dataTransfer.files;
                    showPreview(files);
                }
            }

            function showPreview(files) {
                // Hide upload area, show preview
                uploadArea.classList.add('hidden');
                previewArea.classList.remove('hidden');

                // Clear previous previews
                imagePreviews.innerHTML = '';

                // Generate previews
                Array.from(files).slice(0, 8).forEach((file, index) => { // Limit to 8 images
                    if (file.type.startsWith('image/') && file.size <= 10 * 1024 * 1024) { // 10MB limit
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = createPreviewHTML(e.target.result, file.name, file.size);
                            imagePreviews.insertAdjacentHTML('beforeend', preview);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            function createPreviewHTML(imageSrc, fileName, fileSize) {
                return `
            <div class="group relative bg-gray-100 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                <img src="${imageSrc}" 
                     class="w-full h-24 md:h-28 object-cover" 
                     alt="${fileName}">
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all"></div>
                <div class="absolute top-1 right-1 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                    ${formatFileSize(fileSize)}
                </div>
                <p class="text-xs text-gray-600 mt-1 truncate px-1">${fileName}</p>
            </div>
        `;
            }

            function resetUploadArea() {
                fileInput.value = '';
                previewArea.classList.add('hidden');
                uploadArea.classList.remove('hidden');
                imagePreviews.innerHTML = '';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
            }
        });


        function showSection(sectionId) {

            document.querySelectorAll('.admin-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Show the selected one
            document.getElementById(sectionId).classList.remove('hidden');

            const titles = {
                'dashboard': 'Dashboard Overview',
                'patches': 'Manage Game Patches',
                'gallery': 'Gallery & Media Management',
                'feedback': 'Player Feedback & Suggestions'
            };
            document.getElementById('page-title').innerText = titles[sectionId];

            // Update Sidebar Styles
            document.querySelectorAll('.nav-link').forEach(link => {
                link.classList.remove('bg-slate-800', 'text-white');
                link.classList.add('hover:bg-slate-800', 'transition');
            });
            event.currentTarget.classList.add('bg-slate-800', 'text-white');
        }
    </script>

</body>

</html>