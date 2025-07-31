<?php
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($email, $password, $fullName, $role = 'student') {
        $stmt = $this->pdo->prepare("INSERT INTO users 
            (email, password, full_name, role) 
            VALUES (?, ?, ?, ?)");
        return $stmt->execute([$email, $password, $fullName, $role]);
    }

    public function getUserById($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }

    public function getUserByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function updateUser($userId, $data) {
        $sql = "UPDATE users SET ";
        $params = [];
        foreach ($data as $key => $value) {
            $sql .= "$key = ?, ";
            $params[] = $value;
        }
        $sql = rtrim($sql, ', ') . " WHERE id = ?";
        $params[] = $userId;
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteUser($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$userId]);
    }

    public function getAllTeachers() {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE role = 'teacher'");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalUsers() {
    $stmt = $this->pdo->query("SELECT COUNT(*) FROM users");
    return $stmt->fetchColumn();
}
public function updateProfilePicture($userId, $path) {
    $stmt = $this->pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
    return $stmt->execute([$path, $userId]);
}
public function getProfilePicture($userId) {
    $stmt = $this->pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['profile_picture'] : null;
}

}
?>