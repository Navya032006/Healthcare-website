document.addEventListener('DOMContentLoaded', function() {
    checkAuth();

    let selectedSpecialty = '';
    let selectedDoctor = '';
    let selectedTime = '';
    window.nextStep = function(currentStep) {
     
        if (!validateStep(currentStep)) {
            return;
        }
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.add('completed');
        
        document.getElementById(`step${currentStep}`).classList.remove('active');
        
        document.getElementById(`step${currentStep + 1}`).classList.add('active');
        
        document.querySelector(`.step[data-step="${currentStep + 1}"]`).classList.add('active');
        
        if (currentStep === 4) {
            updateSummary();
        }
        
        if (currentStep === 4) {
            submitAppointment();
        }
        
        document.querySelector('.appointment-form-container').scrollIntoView({
            behavior: 'smooth'
        });
    };

    window.prevStep = function(currentStep) {
        
        document.getElementById(`step${currentStep}`).classList.remove('active');
        
        document.getElementById(`step${currentStep - 1}`).classList.add('active');
        
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${currentStep - 1}"]`).classList.add('active');
        
        document.querySelector('.appointment-form-container').scrollIntoView({
            behavior: 'smooth'
        });
    };

    window.selectSpecialty = function(element) {
        document.querySelectorAll('.specialty-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        element.classList.add('selected');
        
        selectedSpecialty = element.getAttribute('data-specialty');
        
        updateDoctorsBySpecialty(selectedSpecialty);
    };
    window.selectDoctor = function(element) {
        
        document.querySelectorAll('.doctor-card').forEach(card => {
            card.classList.remove('selected');
        });
        
        element.classList.add('selected');
        
        selectedDoctor = element.getAttribute('data-doctor');
    };

    window.selectTimeSlot = function(element) {
        
        document.querySelectorAll('.time-slot').forEach(slot => {
            slot.classList.remove('selected');
        });
        
        element.classList.add('selected');
        selectedTime = element.getAttribute('data-time');
    };

    window.printAppointment = function() {
        window.print();
    };
    function updateDoctorsBySpecialty(specialty) {
        document.querySelectorAll('.doctor-specialty').forEach(el => {
            el.textContent = specialty;
        });
    }
    function validateStep(step) {
        switch(step) {
            case 1:
                const patientForm = document.getElementById('patientForm');
                return validateForm(patientForm);
            case 2:
                if (!selectedSpecialty) {
                    showAlert('Please select a medical specialty', 'warning');
                    return false;
                }
                return true;
            case 3:
                if (!selectedDoctor) {
                    showAlert('Please select a doctor', 'warning');
                    return false;
                }
                return true;
            case 4:
                const appointmentDate = document.getElementById('appointmentDate').value;
                if (!appointmentDate) {
                    showAlert('Please select an appointment date', 'warning');
                    return false;
                }
                if (!selectedTime) {
                    showAlert('Please select an appointment time', 'warning');
                    return false;
                }
                return true;
            default:
                return true;
        }
    }
    function validateForm(form) {
        const requiredFields = form.querySelectorAll('[required]');
        let valid = true;
        
        requiredFields.forEach(field => {
            if (!field.value) {
                field.classList.add('is-invalid');
                valid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!valid) {
            showAlert('Please fill in all required fields', 'warning');
        }
        
        return valid;
    }
    function updateSummary() {
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const appointmentDate = document.getElementById('appointmentDate').value;

        const formattedDate = new Date(appointmentDate).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        
        document.getElementById('summaryName').textContent = firstName + ' ' + lastName;
        document.getElementById('summaryDoctor').textContent = selectedDoctor;
        document.getElementById('summarySpecialty').textContent = selectedSpecialty;
        document.getElementById('summaryDate').textContent = formattedDate;
        document.getElementById('summaryTime').textContent = selectedTime;
        document.getElementById('summaryEmail').textContent = email;
    }

    function submitAppointment() {
        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        const email = document.getElementById('email').value;
        const phone = document.getElementById('phone').value;
        const dob = document.getElementById('dob').value;
        const gender = document.getElementById('gender').value;
        const address = document.getElementById('address').value;
        const city = document.getElementById('city').value;
        const state = document.getElementById('state').value;
        const zip = document.getElementById('zip').value;
        const appointmentDate = document.getElementById('appointmentDate').value;
        const notes = document.getElementById('appointmentNotes').value;
        
        const appointmentData = {
            first_name: firstName,
            last_name: lastName,
            email: email,
            phone: phone,
            dob: dob,
            gender: gender,
            address: address,
            city: city,
            state: state,
            zip: zip,
            specialty: selectedSpecialty,
            doctor: selectedDoctor,
            appointment_date: appointmentDate,
            appointment_time: selectedTime,
            notes: notes
        };
        
        fetch('save_appointment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(appointmentData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert('Appointment booked successfully!', 'success');
            } else {
                showAlert('Error: ' + data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('An error occurred while booking your appointment', 'danger');
        });
    }

    function showAlert(message, type) {
        const alertContainer = document.createElement('div');
        alertContainer.className = `alert-container position-fixed top-0 start-50 translate-middle-x mt-5 z-index-1000`;
        
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        alertContainer.appendChild(alertDiv);
        document.body.appendChild(alertContainer);
        
        setTimeout(() => {
            alertDiv.classList.remove('show');
            setTimeout(() => {
                if (alertContainer.parentNode) {
                    document.body.removeChild(alertContainer);
                }
            }, 150);
        }, 5000);
    }
    function checkAuth() {
        fetch('check_auth.php')
            .then(response => response.json())
            .then(data => {
                if (!data.loggedIn) {
                    const currentPage = encodeURIComponent(window.location.href);
                    window.location.href = `login.html?redirected=true&redirect=${currentPage}`;
                }
            })
            .catch(error => {
                console.error('Error checking authentication:', error);
                showAlert('An error occurred while checking authentication status', 'danger');
            });
    }
});

