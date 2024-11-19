let currentEditIndex = null;
    const form = document.getElementById('crudForm');
    const dataList = document.getElementById('dataList');
    const birthdateInput = document.getElementById('birthdate');
    const ageInput = document.getElementById('age');

    // Array to hold data
    let data = [];

    // Calculate age based on birthdate
    function calculateAge(birthdate) {
      const today = new Date();
      const birthDate = new Date(birthdate);
      let age = today.getFullYear() - birthDate.getFullYear();
      const monthDiff = today.getMonth() - birthDate.getMonth();
      if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
        age--;
      }
      return age;
    }

    // Update age field when birthdate is inputted
    birthdateInput.addEventListener('input', () => {
      if (birthdateInput.value) {
        ageInput.value = calculateAge(birthdateInput.value);
      } else {
        ageInput.value = '';
      }
    });

    // Handle form submission
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const fullname = document.getElementById('fullname').value;
      const gender = document.getElementById('gender').value;
      const birthdate = document.getElementById('birthdate').value;
      const age = document.getElementById('age').value;
      const occupation = document.getElementById('occupation').value;

      if (currentEditIndex === null) {
        data.push({ fullname, gender, birthdate, age, occupation });
      } else {
        data[currentEditIndex] = { fullname, gender, birthdate, age, occupation };
        currentEditIndex = null;
      }

      form.reset();
      ageInput.value = '';
      renderList();
    });

    // Render person list as cards (smaller size)
    function renderList() {
      dataList.innerHTML = '';
      data.forEach((item, index) => {
        const card = document.createElement('div');
        card.className = 'col-12 col-sm-6 col-md-4 mb-3';
        card.innerHTML = `
          <div class="card" style="max-width: auto;">
            <div class="card-body p-2">
              <h5 class="card-title text-truncate" style="font-size: 20px;">${item.fullname}</h5>
              <p class="card-text" style="font-size: 0.875rem;"><strong>Gender:</strong> ${item.gender}</p>
              <p class="card-text" style="font-size: 0.875rem;"><strong>Birthdate:</strong> ${item.birthdate}</p>
              <p class="card-text" style="font-size: 0.875rem;"><strong>Age:</strong> ${item.age}</p>
              <p class="card-text" style="font-size: 0.875rem;"><strong>Occupation:</strong> ${item.occupation}</p>
              <button class="btn btn-primary btn-sm" onclick="editRow(${index})" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
              <button class="btn btn-danger btn-sm" onclick="deleteRow(${index})">Delete</button>
            </div>
          </div>
        `;
        dataList.appendChild(card);
      });
    }

    // Edit modal
    function editRow(index) {
      currentEditIndex = index;
      const item = data[index];
      document.getElementById('modalFullName').value = item.fullname;
      document.getElementById('modalGender').value = item.gender;
      document.getElementById('modalBirthdate').value = item.birthdate;
      document.getElementById('modalAge').value = item.age;
      document.getElementById('modalOccupation').value = item.occupation;
    }

    document.getElementById('editForm').addEventListener('submit', (e) => {
      e.preventDefault();

      const fullname = document.getElementById('modalFullName').value;
      const gender = document.getElementById('modalGender').value;
      const birthdate = document.getElementById('modalBirthdate').value;
      const age = calculateAge(birthdate);
      const occupation = document.getElementById('modalOccupation').value;

      data[currentEditIndex] = { fullname, gender, birthdate, age, occupation };
      renderList();

      const modal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
      modal.hide();
    });

    // Delete row
    function deleteRow(index) {
      data.splice(index, 1);
      renderList();
    }