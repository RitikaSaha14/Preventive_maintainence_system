<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);
    
    if ($stmt->execute()) {
        echo "<script>alert('Signup Successful!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup | Create Account</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #6c63ff;
            --secondary: #ff6584;
            --accent: #42b6ff;
            --dark: #1a1a2e;
            --light: #f1f5f9;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            overflow-x: hidden;
            color: white;
        }
        
        .signup-container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform-style: preserve-3d;
            perspective: 1000px;
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
        }
        
        .signup-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        
        .signup-header {
            background: linear-gradient(45deg, var(--primary), var(--accent));
            padding: 1.5rem;
            color: white;
            text-align: center;
            margin: -2rem -2rem 2rem -2rem;
        }
        
        .signup-title {
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: -0.5px;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.2);
            font-weight: 600;
            color: white;
            backdrop-filter: blur(5px);
        }
        
        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .input-field:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, 0.3);
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            color: white;
        }
        
        .signup-btn {
            background: linear-gradient(45deg, var(--primary), var(--accent));
            background-size: 200% 200%;
            transition: all 0.5s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
            border: none;
            color: white;
        }
        
        .signup-btn:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }
        
        .signup-btn:active {
            transform: translateY(0);
        }
        
        .signup-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: all 0.5s ease;
        }
        
        .signup-btn:hover::after {
            left: 100%;
        }
        
        .form-label {
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            display: block;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        .role-select {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }
        
        .login-link {
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-align: center;
            display: block;
            margin-top: 1.5rem;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        
        .login-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }
        
        .login-link a:hover {
            text-decoration: underline;
            text-shadow: 0 0 8px rgba(66, 182, 255, 0.5);
        }
        
        /* Particle background effect */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: float-particle linear infinite;
        }
        
        @keyframes float-particle {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <!-- Background particles -->
    <div class="particles" id="particles-js"></div>
    
    <div class="signup-container p-8 w-full max-w-md">
        <div class="signup-header">
            <h1 class="signup-title">CREATE ACCOUNT</h1>
        </div>
        
        <form method="POST" class="space-y-5">
            <div>
                <label class="form-label">FULL NAME</label>
                <input type="text" name="name" placeholder="Enter your full name" 
                    class="w-full px-4 py-3 rounded-lg input-field focus:outline-none" required>
            </div>

            <div>
                <label class="form-label">EMAIL</label>
                <input type="email" name="email" placeholder="Enter your email" 
                    class="w-full px-4 py-3 rounded-lg input-field focus:outline-none" required>
            </div>

            <div>
                <label class="form-label">PASSWORD</label>
                <input type="password" name="password" placeholder="Create a password" 
                    class="w-full px-4 py-3 rounded-lg input-field focus:outline-none" required>
            </div>

            <div>
                <label class="form-label">ROLE</label>
                <select name="role" class="w-full px-4 py-3 rounded-lg input-field focus:outline-none role-select">
                    <option value="user">User</option>
                    <option value="technician">Technician</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="w-full py-3 rounded-lg signup-btn mt-6">
                SIGN UP NOW
            </button>
        </form>

        <p class="login-link">
            Already have an account? <a href="index.php">Login here</a>
        </p>
    </div>

    <script>
        // Create floating particles
        document.addEventListener('DOMContentLoaded', function() {
            const particlesContainer = document.getElementById('particles-js');
            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random properties
                const size = Math.random() * 5 + 2;
                const posX = Math.random() * 100;
                const delay = Math.random() * 5;
                const duration = Math.random() * 20 + 10;
                
                particle.style.width = ${size}px;
                particle.style.height = ${size}px;
                particle.style.left = ${posX}%;
                particle.style.bottom = -10px;
                particle.style.animationDelay = ${delay}s;
                particle.style.animationDuration = ${duration}s;
                
                particlesContainer.appendChild(particle);
            }
        });
    </script>
</body>
</html>