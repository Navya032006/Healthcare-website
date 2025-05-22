document.addEventListener('DOMContentLoaded', function() {
  const doctorData = [
    {
      id: 1,
      name: "Dr. Anil Sharma",
      image: "anil.png",
      specialty: "Cardiology",
      hospital: "City Heart Hospital",
      position: "Head of Cardiology",
      experience: "15+ Years Exp.",
      description: "Specializes in interventional cardiology with expertise in angioplasty and stent procedures. Trained at prestigious institutes worldwide.",
      badges: ["Heart Surgery", "Angioplasty"],
      rating: 4.8,
      availability: "Available Today"
    },
    {
      id: 2,
      name: "Dr. Priya Mehta",
      image: "priya.png",
      specialty: "Cardiology",
      hospital: "City Heart Hospital",
      position: "Senior Cardiologist",
      experience: "12+ Years Exp.",
      description: "Expert in non-invasive cardiac diagnostics and cardiac rehabilitation. Known for her patient-centered approach to heart health.",
      badges: ["Echocardiography", "Cardiac Rehab"],
      rating: 5.0,
      availability: "Available Today"
    },
    {
      id: 3,
      name: "Dr. Rahul Kapoor",
      image: "rahul.png",
      specialty: "Vascular Surgery",
      hospital: "City Heart Hospital",
      position: "Vascular Surgeon",
      experience: "8+ Years Exp.",
      description: "Specializes in minimally invasive vascular procedures. Pioneering advanced techniques for treating complex vascular conditions.",
      badges: ["Vascular Surgery", "Endovascular"],
      rating: 4.6,
      availability: "Tomorrow"
    },
    
    {
      id: 4,
      name: "Dr. Vikram Singh",
      image: "vikram.png",
      specialty: "Neurology",
      hospital: "Greenlife Multi-Specialty",
      position: "Chief Neurologist",
      experience: "18+ Years Exp.",
      description: "Renowned neurologist specializing in movement disorders and neurodegenerative diseases. International speaker and researcher.",
      badges: ["Parkinson's", "Alzheimer's"],
      rating: 4.9,
      availability: "Available Today"
    },
    {
      id: 5,
      name: "Dr. Meera Patel",
      image: "meera.png",
      specialty: "Orthopedics",
      hospital: "Greenlife Multi-Specialty",
      position: "Orthopedic Surgeon",
      experience: "10+ Years Exp.",
      description: "Expert in joint replacement surgeries and sports injuries. Combines traditional techniques with cutting-edge medical technology.",
      badges: ["Joint Replacement", "Sports Medicine"],
      rating: 4.7,
      availability: "Next Week"
    },
    {
      id: 6,
      name: "Dr. Sanjay Gupta",
      image: "sanjay.png",
      specialty: "General Medicine",
      hospital: "Greenlife Multi-Specialty",
      position: "Internal Medicine",
      experience: "14+ Years Exp.",
      description: "Holistic approach to patient care with expertise in preventive medicine and chronic disease management. Emphasizes patient education.",
      badges: ["Preventive Care", "Diabetes"],
      rating: 5.0,
      availability: "Available Today"
    },
    
    {
      id: 7,
      name: "Dr. Sunita Reddy",
      image: "suni.png",
      specialty: "Oncology",
      hospital: "Hope Cancer Institute",
      position: "Medical Oncologist",
      experience: "20+ Years Exp.",
      description: "Leading oncologist specializing in personalized cancer treatments and immunotherapy. Pioneer in novel cancer treatment approaches.",
      badges: ["Medical Oncology", "Immunotherapy"],
      rating: 4.9,
      availability: "Available Today"
    },
    {
      id: 8,
      name: "Dr. Amit Desai",
      image: "amith.png",
      specialty: "Radiation Oncology",
      hospital: "Hope Cancer Institute",
      position: "Head of Radiation Oncology",
      experience: "16+ Years Exp.",
      description: "Specialist in precision radiation therapy techniques. Focuses on minimizing side effects while maximizing cancer treatment effectiveness.",
      badges: ["IMRT", "Proton Therapy"],
      rating: 4.7,
      availability: "Next Week"
    },
    {
      id: 9,
      name: "Dr. Leela Krishnan",
      image: "leela.png",
      specialty: "Surgical Oncology",
      hospital: "Hope Cancer Institute",
      position: "Surgical Oncologist",
      experience: "12+ Years Exp.",
      description: "Expertise in minimally invasive cancer surgeries. Specializes in breast, colorectal and gastrointestinal cancer surgical interventions.",
      badges: ["Minimally Invasive", "Robotic Surgery"],
      rating: 4.8,
      availability: "Available Today"
    },
    
    {
      id: 10,
      name: "Dr. Rajesh Kumar",
      image: "rajesh.png",
      specialty: "Spine Surgery",
      hospital: "Joint & Spine Care Center",
      position: "Director, Spine Surgery",
      experience: "22+ Years Exp.",
      description: "Internationally acclaimed spine surgeon with expertise in complex spinal deformities and minimally invasive spine procedures.",
      badges: ["Scoliosis", "Disc Replacement"],
      rating: 4.9,
      availability: "Next Week"
    },
    {
      id: 11,
      name: "Dr. Neha Singh",
      image: "neha.png",
      specialty: "Rheumatology",
      hospital: "Joint & Spine Care Center",
      position: "Senior Rheumatologist",
      experience: "14+ Years Exp.",
      description: "Specialized in autoimmune and inflammatory conditions affecting joints. Known for her comprehensive approach to arthritis management.",
      badges: ["Rheumatoid Arthritis", "Lupus"],
      rating: 4.8,
      availability: "Available Today"
    },
    {
      id: 12,
      name: "Dr. Suresh Patel",
      image: "suresh.png",
      specialty: "Sports Medicine",
      hospital: "Joint & Spine Care Center",
      position: "Head of Sports Medicine",
      experience: "17+ Years Exp.",
      description: "Sports medicine specialist with experience treating elite athletes. Expert in non-surgical treatments and rehabilitation protocols.",
      badges: ["Joint Preservation", "Regenerative Medicine"],
      rating: 4.7,
      availability: "Tomorrow"
    },
    
    {
      id: 13,
      name: "Dr. Ananya Mukherjee",
      image: "ananya.png",
      specialty: "Emergency Medicine",
      hospital: "Metro General Hospital",
      position: "ER Director",
      experience: "12+ Years Exp.",
      description: "Highly skilled emergency physician with extensive experience in trauma care and critical emergency interventions.",
      badges: ["Trauma", "Critical Care"],
      rating: 4.8,
      availability: "Available Today"
    },
    {
      id: 14,
      name: "Dr. Harish Verma",
      image: "harish.png",
      specialty: "Internal Medicine",
      hospital: "Metro General Hospital",
      position: "Chief of Medicine",
      experience: "25+ Years Exp.",
      description: "Renowned internist with expertise in complex medical cases and multisystem disorders. Focuses on evidence-based comprehensive care.",
      badges: ["Complex Care", "Geriatrics"],
      rating: 4.9,
      availability: "Next Week"
    },
    {
      id: 15,
      name: "Dr. Fatima Ahmed",
      image: "fathima.png",
      specialty: "Pulmonology",
      hospital: "Metro General Hospital",
      position: "Pulmonary Specialist",
      experience: "16+ Years Exp.",
      description: "Expert in respiratory disorders with special interest in sleep medicine and interventional pulmonology procedures.",
      badges: ["Asthma", "Sleep Apnea"],
      rating: 4.7,
      availability: "Tomorrow"
    },
    
    {
      id: 16,
      name: "Dr. Ravi Menon",
      image: "ravi.png",
      specialty: "Pediatrics",
      hospital: "Sunshine Children's Hospital",
      position: "Chief Pediatrician",
      experience: "20+ Years Exp.",
      description: "Experienced pediatrician specializing in developmental pediatrics and childhood chronic conditions management.",
      badges: ["Development", "Chronic Care"],
      rating: 4.9,
      availability: "Available Today"
    },
    {
      id: 17,
      name: "Dr. Kavita Sharma",
      image: "kavita.png",
      specialty: "Pediatric Surgery",
      hospital: "Sunshine Children's Hospital",
      position: "Head of Pediatric Surgery",
      experience: "18+ Years Exp.",
      description: "Pediatric surgeon with expertise in minimally invasive techniques and neonatal surgeries. Known for her gentle approach with children.",
      badges: ["Neonatal Surgery", "Laparoscopic"],
      rating: 4.8,
      availability: "Tomorrow"
    },
    {
      id: 18,
      name: "Dr. Siddharth Mehta",
      image: "sid.png",
      specialty: "Pediatric Neurology",
      hospital: "Sunshine Children's Hospital",
      position: "Pediatric Neurologist",
      experience: "15+ Years Exp.",
      description: "Specialist in childhood neurological disorders including epilepsy, developmental delays, and neuromuscular conditions.",
      badges: ["Epilepsy", "Developmental"],
      rating: 4.7,
      availability: "Next Week"
    }
  ];
  
  function groupDoctorsByHospital(doctors) {
    const hospitals = {};
    
    doctors.forEach(doctor => {
      if (!hospitals[doctor.hospital]) {
        hospitals[doctor.hospital] = [];
      }
      hospitals[doctor.hospital].push(doctor);
    });
    
    return hospitals;
  }
  
  function generateDoctorCarousels() {
    const doctorsByHospital = groupDoctorsByHospital(doctorData);
    const container = document.querySelector('.container.mb-5');
    
    const existingSections = container.querySelectorAll('.section-heading, .row:not(:first-child)');
    existingSections.forEach(section => section.remove());
    
    Object.keys(doctorsByHospital).forEach((hospital, index) => {
      const hospitalDoctors = doctorsByHospital[hospital];
      
      const heading = document.createElement('h3');
      heading.className = 'section-heading mb-4 mt-5';
      heading.textContent = hospital;
      container.appendChild(heading);
      
      const carouselWrapper = document.createElement('div');
      carouselWrapper.innerHTML = `
        <div id="doctorCarousel${index}" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner"></div>
          <button class="carousel-control-prev" type="button" data-bs-target="#doctorCarousel${index}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#doctorCarousel${index}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      `;
      container.appendChild(carouselWrapper);
      
      const carouselInner = carouselWrapper.querySelector('.carousel-inner');
      
      const doctorGroups = [];
      for (let i = 0; i < hospitalDoctors.length; i += 3) {
        doctorGroups.push(hospitalDoctors.slice(i, i + 3));
      }
      
      doctorGroups.forEach((group, groupIndex) => {
        const carouselItem = document.createElement('div');
        carouselItem.className = `carousel-item ${groupIndex === 0 ? 'active' : ''}`;
        
        const row = document.createElement('div');
        row.className = 'row';
        
        group.forEach(doctor => {
          const doctorCard = createDoctorCard(doctor);
          row.appendChild(doctorCard);
        });
        
        carouselItem.appendChild(row);
        carouselInner.appendChild(carouselItem);
      });
    });
  }
  
  function createDoctorCard(doctor) {
    const col = document.createElement('div');
    col.className = 'col-md-4';
    
    col.innerHTML = `
      <div class="doctor-card" data-doctor-id="${doctor.id}">
        <div class="doctor-image">
          <img src="${doctor.image}" alt="${doctor.name}">
          <div class="hospital-tag">${doctor.hospital}</div>
          <div class="experience-tag">${doctor.experience}</div>
        </div>
        <div class="doctor-content">
          <div class="doctor-specialty">${doctor.specialty}</div>
          <h4 class="doctor-name">${doctor.name}</h4>
          <div class="doctor-hospital">
            <i class="fas fa-hospital-alt me-2 text-primary"></i>${doctor.position}
          </div>
          <p class="doctor-description">
            ${doctor.description}
          </p>
          <div class="doctor-badges mb-3">
            <span class="badge-specialty">${doctor.badges[0]}</span>
            <span class="badge-specialty">${doctor.badges[1]}</span>
          </div>
          <div class="doctor-meta">
            <div class="doctor-rating">
              ${generateStarRating(doctor.rating)}
              <span class="ms-2 text-dark">${doctor.rating}</span>
            </div>
            <div class="doctor-availability">
              <i class="far fa-calendar-check me-1"></i> ${doctor.availability}
            </div>
          </div>
          <a href="appointment.html" class="btn appointment-btn mt-3" data-doctor-id="${doctor.id}">Book Appointment</a>
        </div>
      </div>
    `;
    
    const doctorCardElement = col.querySelector('.doctor-card');
    doctorCardElement.addEventListener('click', function(event) {
      if (!event.target.classList.contains('appointment-btn')) {
        showDoctorDetails(doctor.name);
      }
    });

    const bookButton = col.querySelector('.appointment-btn');
    bookButton.addEventListener('click', function(event) {
      event.preventDefault();
      event.stopPropagation();
      window.location.href = `appointment.html?doctor=${encodeURIComponent(doctor.name)}&id=${doctor.id}`;
    });
    
    return col;
  }
  
  function generateStarRating(rating) {
    const fullStars = Math.floor(rating);
    const halfStar = rating % 1 >= 0.5;
    const emptyStars = 5 - fullStars - (halfStar ? 1 : 0);
    
    let starsHTML = '';
    
    for (let i = 0; i < fullStars; i++) {
      starsHTML += '<i class="fas fa-star"></i>';
    }
    
    if (halfStar) {
      starsHTML += '<i class="fas fa-star-half-alt"></i>';
    }
    
    for (let i = 0; i < emptyStars; i++) {
      starsHTML += '<i class="far fa-star"></i>';
    }
    
    return starsHTML;
  }

  const doctorSearch = document.querySelector('.search-input');
  const specialtyFilter = document.getElementById('specialty');
  const hospitalFilter = document.getElementById('hospital');
  const locationFilter = document.getElementById('location');
  const availabilityFilter = document.getElementById('availability');
  const filterButton = document.querySelector('.btn-primary');

  if (filterButton) {
    filterButton.addEventListener('click', filterDoctors);
  }

  if (doctorSearch) {
    doctorSearch.addEventListener('keyup', function(e) {
      if (e.key === 'Enter') {
        filterDoctors();
      }
    });
  }

  function filterDoctors() {
    const searchTerm = doctorSearch.value.toLowerCase();
    const specialty = specialtyFilter.value;
    const hospital = hospitalFilter.value;
    const location = locationFilter.value;
    const availability = availabilityFilter.value;
    
    const filteredDoctors = doctorData.filter(doctor => {
      const matchesSearch = searchTerm === '' || 
        doctor.name.toLowerCase().includes(searchTerm) || 
        doctor.specialty.toLowerCase().includes(searchTerm) || 
        doctor.hospital.toLowerCase().includes(searchTerm);
      
      const matchesSpecialty = specialty === 'All Specialties' || doctor.specialty === specialty;
      const matchesHospital = hospital === 'All Hospitals' || doctor.hospital === hospital;
      const matchesLocation = location === 'All Locations';
      
      const matchesAvailability = availability === 'Any Day' || 
        (availability === 'Today' && doctor.availability.includes('Today')) ||
        (availability === 'Tomorrow' && doctor.availability.includes('Tomorrow')) ||
        (availability === 'This Week' && !doctor.availability.includes('Next Week')) ||
        (availability === 'Next Week' && doctor.availability.includes('Next Week'));
      
      return matchesSearch && matchesSpecialty && matchesHospital && matchesLocation && matchesAvailability;
    });
    
    const doctorsByHospital = groupDoctorsByHospital(filteredDoctors);
    updateDoctorDisplay(doctorsByHospital);
    
    const container = document.querySelector('.container.mb-5');
    const noResultsMsg = container.querySelector('.no-results-message');
    
    if (Object.keys(doctorsByHospital).length === 0) {
      if (!noResultsMsg) {
        const message = document.createElement('div');
        message.className = 'no-results-message text-center my-5';
        message.innerHTML = '<h4>No doctors match your search criteria</h4><p>Please try different search criteria</p>';
        container.appendChild(message);
      }
    } else if (noResultsMsg) {
      noResultsMsg.remove();
    }
  }
  
  function updateDoctorDisplay(doctorsByHospital) {
    const container = document.querySelector('.container.mb-5');
    
    const existingSections = container.querySelectorAll('.section-heading, .row:not(:first-child), .carousel');
    existingSections.forEach(section => section.remove());
    
    Object.keys(doctorsByHospital).forEach((hospital, index) => {
      const hospitalDoctors = doctorsByHospital[hospital];
      
      const heading = document.createElement('h3');
      heading.className = 'section-heading mb-4 mt-5';
      heading.textContent = hospital;
      container.appendChild(heading);
      
      const carouselWrapper = document.createElement('div');
      carouselWrapper.innerHTML = `
        <div id="doctorCarousel${index}" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner"></div>
          <button class="carousel-control-prev" type="button" data-bs-target="#doctorCarousel${index}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#doctorCarousel${index}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      `;
      container.appendChild(carouselWrapper);
      
      const carouselInner = carouselWrapper.querySelector('.carousel-inner');
      
      const doctorGroups = [];
      for (let i = 0; i < hospitalDoctors.length; i += 3) {
        doctorGroups.push(hospitalDoctors.slice(i, i + 3));
      }
      
      doctorGroups.forEach((group, groupIndex) => {
        const carouselItem = document.createElement('div');
        carouselItem.className = `carousel-item ${groupIndex === 0 ? 'active' : ''}`;
        
        const row = document.createElement('div');
        row.className = 'row';
        
        group.forEach(doctor => {
          const doctorCard = createDoctorCard(doctor);
          row.appendChild(doctorCard);
        });
        
        carouselItem.appendChild(row);
        carouselInner.appendChild(carouselItem);
      });
      
      new bootstrap.Carousel(carouselWrapper.querySelector('.carousel'));
    });
  }
  
  const hospitalPills = document.querySelectorAll('.hospital-pill');
  hospitalPills.forEach(pill => {
    pill.addEventListener('click', function() {
      hospitalPills.forEach(p => p.classList.remove('active'));
      
      this.classList.add('active');
      
      const hospital = this.textContent;
      
      if (hospitalFilter) {
        hospitalFilter.value = hospital === 'All Hospitals' ? 'All Hospitals' : hospital;
      }
      
      filterDoctors();
    });
  });
  
  function showDoctorDetails(doctorName) {
    const doctor = doctorData.find(d => d.name === doctorName);
    
    if (!doctor) {
      console.error('Doctor not found:', doctorName);
      return;
    }
    
    const modalHTML = `
      <div class="modal fade" id="doctorDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="doctorModalTitle">${doctor.name}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="doctorModalBody">
              <div class="row">
                <div class="col-md-4">
                  <img src="${doctor.image}" class="img-fluid rounded" alt="${doctor.name}">
                </div>
                <div class="col-md-8">
                  <h4>${doctor.name}</h4>
                  <p class="text-primary fw-bold">${doctor.specialty}</p>
                  <p><i class="fas fa-hospital me-2 text-primary"></i>${doctor.hospital} - ${doctor.position}</p>
                  <div class="mb-3">
                    ${doctor.badges.map(badge => `<span class="badge-specialty">${badge}</span>`).join(' ')}
                  </div>
                  <div class="mb-3">
                    <div class="doctor-rating">
                      ${generateStarRating(doctor.rating)}
                      <span class="ms-2 text-dark">${doctor.rating}</span>
                    </div>
                  </div>
                  <p>${doctor.description}</p>
                  <p><strong>Experience:</strong> ${doctor.experience}</p>
                  <p><strong>Availability:</strong> ${doctor.availability}</p>
                  <a href="appointment.html?doctor=${encodeURIComponent(doctor.name)}&id=${doctor.id}" 
                     class="btn btn-primary mt-3">Book Appointment</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
    
    let doctorModal = document.getElementById('doctorDetailsModal');
    
    if (doctorModal) {
      document.body.removeChild(doctorModal);
    }
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    doctorModal = document.getElementById('doctorDetailsModal');
    
    const bsModal = new bootstrap.Modal(doctorModal);
    bsModal.show();
  }
  
  generateDoctorCarousels();
});