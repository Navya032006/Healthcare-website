document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    const urlParams = new URLSearchParams(window.location.search);
    const redirected = urlParams.get('redirected');
    const redirectUrl = urlParams.get('redirect');
    
    if (redirected === 'true') {
        showAlert('Please login to book an appointment', 'warning');
    }
    
    fetch('check_auth.php')
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                if (redirectUrl) {
                    window.location.href = decodeURIComponent(redirectUrl);
                } else {
                    window.location.href = 'login.html';
                }
            }
        })
        .catch(error => {
            console.error('Error checking auth status:', error);
        });
    
    
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
       
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        
        if (!email || !password) {
            showAlert('Please fill in all fields.', 'danger');
            return;
        }
     
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showAlert('Please enter a valid email address.', 'danger');
            return;
        }
    
        const formData = {
            email: email,
            password: password
        };
      
        fetch('login_process.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert(data.message, 'success');
               
                localStorage.setItem('user', JSON.stringify(data.user));
                
                if (window.notificationSystem) {
                    window.notificationSystem.init(data.user.id);
                }
               
                setTimeout(() => {
                    if (redirectUrl) {
                        window.location.href = decodeURIComponent(redirectUrl);
                    } else {
                        window.location.href = 'home.html';
                    }
                }, 1500);
            } else {
                showAlert(data.message, 'danger');
            }
        })
        .catch(error => {
            showAlert('An error occurred. Please try again.', 'danger');
            console.error('Error:', error);
        });
    });
   
    function showAlert(message, type) {
        const alertContainer = document.getElementById('alert-container');
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3`;
        alert.role = 'alert';
        alert.style.zIndex = '1050';
        alert.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        alertContainer.innerHTML = '';
        
        alertContainer.appendChild(alert);
       
        setTimeout(() => {
            try {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            } catch (error) {
                alert.remove();
            }
        }, 5000);
    }
 
    document.querySelector('.btn-google').addEventListener('click', function() {
        showAlert('Google login integration will be implemented soon.', 'info');
    });
    
    document.querySelector('.btn-facebook').addEventListener('click', function() {
        showAlert('Facebook login integration will be implemented soon.', 'info');
    });
   
    document.querySelector('.forgot-password a').addEventListener('click', function(e) {
        e.preventDefault();
        showAlert('Password reset functionality will be implemented soon.', 'info');
    });
});
