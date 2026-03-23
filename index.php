<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Weekly Meal Plan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h1 class="text-center mb-4">Weekly Meal Plan</h1>

  <div class="mb-3">
  <label class="form-label">Date</label>
  <input type="date" id="meal_date" class="form-control">
  </div>



  <div class="row">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="mb-3">Add / Edit Meal</h3>

          <input type="hidden" id="mealId">

          <div class="mb-3">
            <label class="form-label">Day</label>
            <select id="day_name" class="form-select">
              <option value="">Select Day</option>
              <option value="Monday">Monday</option>
              <option value="Tuesday">Tuesday</option>
              <option value="Wednesday">Wednesday</option>
              <option value="Thursday">Thursday</option>
              <option value="Friday">Friday</option>
              <option value="Saturday">Saturday</option>
              <option value="Sunday">Sunday</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Breakfast</label>
            <input type="text" id="breakfast" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Lunch</label>
            <input type="text" id="lunch" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">Dinner</label>
            <input type="text" id="dinner" class="form-control">
          </div>

          <button class="btn btn-primary w-100 mb-2" onclick="saveMeal()">Save Meal</button>
          <button class="btn btn-secondary w-100" onclick="resetForm()">Clear</button>
        </div>
      </div>
    </div>

    <div class="col-md-7 mt-4 mt-md-0">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="mb-3">Meal List</h3>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="table-dark">
                <tr>
                  <th>Day</th>
                  <th>Breakfast</th>
                  <th>Lunch</th>
                  <th>Dinner</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody id="mealTableBody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function loadMeals() {
  fetch('get_meals.php')
    .then(response => response.json())
    .then(data => {
      let rows = '';
      data.forEach(meal => {
        rows += `
          <tr>
            <td>${meal.day_name}</td>
            <td>${meal.breakfast}</td>
            <td>${meal.lunch}</td>
            <td>${meal.dinner}</td>
            <td>
              <button class="btn btn-sm btn-warning me-1" onclick="editMeal(${meal.id})">Edit</button>
              <button class="btn btn-sm btn-danger" onclick="deleteMeal(${meal.id})">Delete</button>
            </td>
          </tr>
        `;
      });
      document.getElementById('mealTableBody').innerHTML = rows;
    });
}

function saveMeal() {
  const id = document.getElementById('mealId').value;
  const day_name = document.getElementById('day_name').value;
  const breakfast = document.getElementById('breakfast').value;
  const lunch = document.getElementById('lunch').value;
  const dinner = document.getElementById('dinner').value;

  if (!day_name || !breakfast || !lunch || !dinner) {
    alert('Please fill in all fields.');
    return;
  }

  const formData = new URLSearchParams();
  formData.append('id', id);
  formData.append('day_name', day_name);
  formData.append('breakfast', breakfast);
  formData.append('lunch', lunch);
  formData.append('dinner', dinner);

  const file = id ? 'update.php' : 'add.php';

  fetch(file, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: formData.toString()
  })
  .then(response => response.text())
  .then(data => {
    alert(data);
    loadMeals();
    resetForm();
  });
}

function editMeal(id) {
  fetch('get_single_meal.php?id=' + id)
    .then(response => response.json())
    .then(meal => {
      document.getElementById('mealId').value = meal.id;
      document.getElementById('day_name').value = meal.day_name;
      document.getElementById('breakfast').value = meal.breakfast;
      document.getElementById('lunch').value = meal.lunch;
      document.getElementById('dinner').value = meal.dinner;
    });
}

function deleteMeal(id) {
  if (!confirm('Are you sure you want to delete this meal?')) {
    return;
  }

  fetch('delete.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'id=' + id
  })
  .then(response => response.text())
  .then(data => {
    alert(data);
    loadMeals();
  });
}

function resetForm() {
  document.getElementById('mealId').value = '';
  document.getElementById('day_name').value = '';
  document.getElementById('breakfast').value = '';
  document.getElementById('lunch').value = '';
  document.getElementById('dinner').value = '';
}

loadMeals();
</script>

</body>
</html>