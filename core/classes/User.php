<?php 
    class User {
        protected $pdo;

        function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function checkInput($var) {
            $var = htmlspecialchars($var);
            $var = trim($var);
            $var = stripcslashes($var);
            return $var;
        }

        public function login($email, $password) {
            $stmt = $this->pdo->prepare("SELECT `user_id` FROM `users` WHERE `email` = :email AND `password` = :passwords");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":passwords", $password, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_OBJ);
            $count = $stmt->rowCount();
            //return $user;

           if($count > 0) {
                //return $count;
                $_SESSION['user_id'] = $user->user_id;
                header('Location: home.php');
            } else {
                return false;
            }
        }

        public function userData($user_id) {
            $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `user_id` = :users_id");
            $stmt->bindParam(":users_id", $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function logout() {
            $_SESSION = array();
            session_destroy();
            header('Location: '.BASE_URL.'index.php');
        }

        public function checkEmail($email) {
            $stmt = $this->pdo->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();
            if($count > 0) {
                return true;
            } else {
                return false;
            }
        }

        
        public function uploadImage($file) {
            $filename = basename($file['name']);
            $fileTmp = $file['tmp_name'];
            $fileSize = $file['size'];
            $error = $file['error'];

            $ext = explode('.', $filename);
            $ext = strtolower(end($ext));
            $allowed_ext = array('jpg', 'png', 'jpeg', 'gif');

            if(in_array($ext, $allowed_ext) === true) {
                if($error === 0) {
                    if($fileSize <= 409272152) {
                        $fileRoot = 'users/'. $filename;
                        move_uploaded_file($fileTmp, $fileRoot);
                        return $fileRoot;
                    } else {
                        $_GLOBAL['imageError'] = "Image size too big";
                    }
                }
            } else {
                $_GLOBAL['imageError'] = "Image extension is not Allowed";
            }
        }

        public function search($search) {
            $stmt = $this->pdo->prepare("SELECT `user_id`, `username`, `screenName`, `profileImage`, `profileCover` FROM `users` WHERE `username` LIKE ? OR `screenName` LIKE ?");
            $stmt->bindValue(1, $search.'%', PDO::PARAM_STR);
            $stmt->bindValue(2, $search.'%', PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function register($email, $screenName, $password) {
            $stmt = $this->pdo->prepare("INSERT INTO `users` (`email`, `password`, `screenName`, `profileImage`, `profileCover`) VALUES(:email, :passwords, :screenName, 'assets/images/defaultprofileimage.png', 'assets/images/defaultCoverImage.png')");
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->bindParam(":passwords", $password, PDO::PARAM_STR);
            $stmt->bindParam(":screenName", $screenName, PDO::PARAM_STR);

            $stmt->execute();

            $user_id = $this->pdo->lastInsertId();
            $_SESSION['user_id'] = $user_id;
        }

        public function create($table, $fields = array()) {
            // remove the , from the key values in the fields(i.e the values input into databse)
            $columns = implode(',', array_keys($fields));
            $values = ':'.implode(', :', array_keys($fields));
            $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
            if($stmt = $this->pdo->prepare($sql)) {
                foreach($fields as $key => $data) {
                    $stmt->bindValue(`:`.$key, $data);
                }
                $stmt->execute();
                return $this->pdo->lastInsertId();
            }
        }

        public function update($table, $user_id, $fields = array()) {
            $columns = '';
            $i = 1;

            foreach($fields as $name => $value) {
                $columns .= "`{$name}` = :{$name}";
                if($i < count($fields)) {
                    $columns .= ', ';
                }
                $i++;
            }
            $sql = "UPDATE {$table} SET {$columns} WHERE `user_id` = {$user_id}";
            if($stmt = $this->pdo->prepare($sql)) {
                foreach($fields as $key => $value) {
                    $stmt->bindValue(':'.$key, $value);
                }
                //var_dump($sql);
                $stmt -> execute();
            }
        }

        public function checkUsername($username) {
            $stmt = $this->pdo->prepare("SELECT `username` FROM `users` WHERE `username` = :username");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();
            if($count > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function userIdByUsername($username) {
            $stmt = $this->pdo->prepare("SELECT `user_id` FROM `users` WHERE `username` = :username");
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $stmt->execute();
            //to fetch current user_id
            $user = $stmt->fetch(PDO::FETCH_OBJ);
            return $user->user_id;
        }

        public function loggedIn() {
            return (isset($_SESSION['user_id'])) ? true : false;
        }
    }
?>
