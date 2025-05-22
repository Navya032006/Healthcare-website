document.addEventListener('DOMContentLoaded', function() {
    
    const menuToggle = document.getElementById('menuToggle');
    const navbarMenu = document.getElementById('navbarMenu');
    
    if (menuToggle && navbarMenu) {
        menuToggle.addEventListener('click', function() {
            navbarMenu.classList.toggle('active');
        });
    }
    
    const filterForm = document.getElementById('filterForm');
    const hospitalsContainer = document.getElementById('hospitalsContainer');
    
    if (filterForm) {
        filterForm.addEventListener('submit', function(event) {
            event.preventDefault();
            
            const formData = new FormData(filterForm);
            
            hospitalsContainer.innerHTML = '<div class="loading">Loading results...</div>';
            
            fetch('filter.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    if (data.hospitals.length > 0) {
                        let hospitalsHTML = '';
                        
                        data.hospitals.forEach(hospital => {
                            let ratingHTML = '';
                            for (let i = 1; i <= 5; i++) {
                                if (i <= hospital.rating) {
                                    ratingHTML += '<i class="fas fa-star text-warning"></i>';
                                } else if (i - 0.5 <= hospital.rating) {
                                    ratingHTML += '<i class="fas fa-star-half-alt text-warning"></i>';
                                } else {
                                    ratingHTML += '<i class="far fa-star text-warning"></i>';
                                }
                            }
                           
                            let specialtiesHTML = '';
                            hospital.specialties.forEach(specialty => {
                                specialtiesHTML += `<span class="badge">${specialty}</span>`;
                            });
                            
                            hospitalsHTML += `
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="${hospital.image_url}" class="card-img-top" alt="${hospital.name}" />
                                        <div class="card-body">
                                            <h5 class="card-title">${hospital.name}</h5>
                                            <div class="mb-2">
                                                ${specialtiesHTML}
                                            </div>
                                            <p class="card-text">${hospital.description}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                                    <span class="ms-1">${hospital.location}</span>
                                                </div>
                                                <div>
                                                    ${ratingHTML}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <a href="hospital_details.php?id=${hospital.id}" class="btn btn-primary w-100">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        
                        hospitalsContainer.innerHTML = hospitalsHTML;
                    } else {
                        hospitalsContainer.innerHTML = `
                            <div class="col-12">
                                <div class="alert alert-info">No hospitals found matching your criteria. Please try different filters.</div>
                            </div>
                        `;
                    }
                } else {
                    hospitalsContainer.innerHTML = `
                        <div class="col-12">
                            <div class="alert alert-danger">An error occurred while fetching results. Please try again.</div>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hospitalsContainer.innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger">An error occurred while fetching results. Please try again.</div>
                    </div>
                `;
            });
        });
    }
});
