<?php
// models/UserModel.php
class UserModel {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE - Add new user
    public function create($username, $email, $password, $role, $first_name, $last_name, $phone, $address) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table_name . " 
                 (username, email, password, role, first_name, last_name, phone, address) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssss", $username, $email, $hashedPassword, $role, $first_name, $last_name, $phone, $address);
        
        return $stmt->execute();
    }

    // READ - Get all users
    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $result = $this->conn->query($query);
        return $result;
    }

    // READ - Get single user by ID
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // READ - Get user by username
    public function readByUsername($username) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // UPDATE - Update user
    public function update($id, $username, $email, $role, $first_name, $last_name, $phone, $address) {
        $query = "UPDATE " . $this->table_name . " 
                 SET username=?, email=?, role=?, first_name=?, last_name=?, phone=?, address=?
                 WHERE id=?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssssi", $username, $email, $role, $first_name, $last_name, $phone, $address, $id);
        
        return $stmt->execute();
    }

    // DELETE - Delete user
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        return $stmt->execute();
    }

    // Verify login credentials
    public function verifyLogin($username, $password) {
        $user = $this->readByUsername($username);
        
        if ($user && password_verify($password, $user['password']) && $user['is_active']) {
            return $user;
        }
        return false;
    }

    // Check if username exists
    public function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Check if email exists
    public function emailExists($email) {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Get users by role
    public function getUsersByRole($role) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE role = ? ORDER BY first_name";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $role);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>