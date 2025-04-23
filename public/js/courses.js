const addCourseBtn = document.getElementById('add-course-btn');
const modal = document.getElementById('add-course-modal');
const closeModal = document.getElementById('close-modal');
const submitCourse = document.getElementById('submit-course');
const coursesList = document.getElementById('courses-list');


addCourseBtn.addEventListener('click', () => {
    modal.style.display = 'flex';
});


closeModal.addEventListener('click', () => {
    modal.style.display = 'none';
});


submitCourse.addEventListener('click', async () => {
    const code = document.getElementById('course-code').value;
    const title = document.getElementById('course-title').value;
    const description = document.getElementById('course-description').value;

    if (!code || !title || !description) {
        alert('Please fill all fields');
        return;
    }

    const response = await fetch("/api/courses", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ code, title, description })
    });

    const result = await response.json();

    if (result.success) {
        alert('Course added successfully!');
        modal.style.display = 'none';
        loadCourses();
    } else {
        alert(result.message || 'Failed to add course');
    }
});


async function loadCourses() {
    const response = await fetch("/api/courses");
    const result = await response.json();
    
    if (result.success && result.courses) {
        coursesList.innerHTML = result.courses.map(course => `
            <div class="course-item">
                <h4>${course.title} (${course.code})</h4>
                <p>${course.description}</p>
                <button onclick="editCourse(${course.id}, '${course.code}', '${course.title}', '${course.description}')">Edit</button>
                <button onclick="deleteCourse(${course.id})">Delete</button>
            </div>
        `).join('');
    } else {
        coursesList.innerHTML = '<p>No courses found.</p>';
    }
}


function editCourse(id, code, title, description) {
    const newTitle = prompt('Edit title:', title);
    const newDescription = prompt('Edit description:', description);

    if (newTitle !== null && newDescription !== null) {
        updateCourse(id, code, newTitle, newDescription);
    }
}


async function updateCourse(id, code, title, description) {
    const response = await fetch("/api/courses", {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id, code, title, description })
    });
    const result = await response.json();

    if (result.success) {
        alert('Course updated');
        loadCourses();
    } else {
        alert(result.message || 'Failed to update');
    }
}

async function deleteCourse(id) {
    if (!confirm('Are you sure you want to delete this course?')) return;
    console.log(id)
    const response = await fetch("/api/courses", {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({id: id })
    });
    const result = await response.json();

    if (result.success) {
        alert('Course deleted');
        loadCourses();
    } else {
        alert(result.message || 'Failed to delete');
    }
}


window.addEventListener('DOMContentLoaded', loadCourses);
