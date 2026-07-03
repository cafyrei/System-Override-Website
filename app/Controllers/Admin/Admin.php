<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Pages\FeedbackModel;
use App\Models\Pages\GalleryModel;
use App\Models\Pages\PatchModel;
use CodeIgniter\HTTP\RedirectResponse;

class Admin extends BaseController
{
    /**
     * Render the Login Page UI or redirect if already authenticated
     */
    public function adminlogin(): string|RedirectResponse
    {
        if (session()->get('is_admin_logged_in')) {
            return redirect()->to(site_url('admin'));
        }

        return view('admin/auth/login-admin.php');
    }

    /**
     * Handle the Login Form Verification Post
     */
    public function authenticate(): RedirectResponse
    {
        $session = session();
        
        $identity = $this->request->getPost('identity');
        $password = $this->request->getPost('password');

        $rootAdminUser = 'admin'; 
        $rootAdminPass = 'asdasd123!'; 

        if (($identity === $rootAdminUser || $identity === 'admin@system.local') && $password === $rootAdminPass) {
            
            $session->set([
                'admin_user'          => 'Admin User',
                'admin_identity'      => $identity,
                'is_admin_logged_in'  => true
            ]);

            return redirect()->to(site_url('admin'));
        } else {
            $session->setFlashdata('error', 'Access Refused. Invalid credentials.');
            return redirect()->to(site_url('admin-login'))->withInput();
        }
    }

    /**
     * Main Core System Panel Dashboard Screen Route Handler
     */
    public function admin(): string|RedirectResponse
    {
        // Basic Security Gate check
        if (!session()->get('is_admin_logged_in')) {
            return redirect()->to(site_url('admin-login'));
        }

        $feedbackModel = new FeedbackModel();
        $galleryModel  = new GalleryModel();
        $patchesModel  = new PatchModel();

        $data = [
            'feedbacks_data' => $feedbackModel->findAll(),
            'gallery_data'   => $galleryModel->findAll(),
            'patches_data'   => $patchesModel->findAll(),
        ];

        return view('admin/index-admin', $data);
    }

    /**
     * Standard Flush & Destroy Session Logouts
     */
    public function logout(): RedirectResponse
    {
        session()->destroy();
        return redirect()->to(site_url('admin-login'));
    }

    // --- Keep your existing API data-exchange method handlers intact beneath this point ---
    
    public function mark_reviewed()
    {
        if (!session()->get('is_admin_logged_in')) return $this->response->setStatusCode(403);
        $data = $this->request->getJSON(true);
        $id = $data['id'];
        $model = new FeedbackModel();
        $model->update($id, ['status' => 'reviewed']);
        return $this->response->setJSON(['success' => true]);
    }

    public function delete_feedback()
    {
        if (!session()->get('is_admin_logged_in')) return $this->response->setStatusCode(403);
        $data = $this->request->getJSON(true);
        $id = $data['id'];
        $model = new FeedbackModel();
        $model->delete($id);
        return $this->response->setJSON(['success' => true]);
    }
}