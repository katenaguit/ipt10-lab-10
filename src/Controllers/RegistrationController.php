<?php 

namespace App\Controllers;

use App\Models\User;

class RegistrationController extends BaseController
{
    public function showRegisterForm() {
        return $this->render('registration-form');
    }

    public function register() {
        $errors = [];
        
        try {
            $formData = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'first_name' => $_POST['first_name'] ?? '',
                'last_name' => $_POST['last_name'] ?? '',
                'password' => $_POST['password'] ?? '',
                'confirm_password' => $_POST['confirm_password'] ?? ''
            ];
    
            $errors = $this->validateForm($formData);
    
            if (!empty($errors)) {
                return $this->render('registration-form', [
                    'errors' => $errors,
                    'username' => $formData['username'],
                    'email' => $formData['email'],
                    'first_name' => $formData['first_name'],
                    'last_name' => $formData['last_name']
                ]);
            }
    
            $user = new User();
            $saveResult = $user->save(
                $formData['username'], 
                $formData['email'], 
                $formData['first_name'], 
                $formData['last_name'], 
                $formData['password']
            );
    
            if ($saveResult > 0) {
                return $this->render('success');
            } else {
                throw new \Exception('Registration failed. Please try again.');
            }
    
        } catch (\Exception $e) {
            return $this->render('registration-form', [
                'errors' => [$e->getMessage()],
                'username' => $formData['username'],
                'email' => $formData['email'],
                'first_name' => $formData['first_name'],
                'last_name' => $formData['last_name']
            ]);
        }
    }

    private function validateForm($data) {
        $errors = [];
    
        if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['confirm_password'])) {
            $errors[] = "All required fields must be filled out.";
        }
    
        if (strlen($data['password']) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        if (!preg_match('/[0-9]/', $data['password'])) {
            $errors[] = "Password must contain at least one numeric character.";
        }

        if (!preg_match('/[a-zA-Z]/', $data['password'])) {
            $errors[] = "Password must contain at least one non-numeric character.";
        }

        if (!preg_match('/[\W]/', $data['password'])) {
            $errors[] = "Password must contain at least one special character (!@#$%^&*-+).";
        }
    
        if ($data['password'] !== $data['confirm_password']) {
            $errors[] = "Passwords do not match.";
        }
    
        return $errors;
    }
}
