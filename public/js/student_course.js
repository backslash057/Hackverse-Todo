const coursesList = document.getElementById('courses-list');

async function loadCourses() {
    const response = await fetch("/api/courses");
    const result = await response.json();
    
    if (result.success && result.courses) {
        coursesList.innerHTML = result.courses.map(course => `
            <div class="course-item">
                <h4>${course.title} (${course.code})</h4>
                <p>${course.description}</p>
                <button onclick="joinCourse(${course.id})">Join</button>
            </div>
        `).join('');
    } else {
        coursesList.innerHTML = '<p>No courses found.</p>';
    }
}

async function loadJoinedCourses() {
    const response = await fetch("/api/courses?joined=1");
    const result = await response.json();
    
    if (result.success && result.courses) {
        coursesList.innerHTML = result.courses.map(course => `
            <div class="course-item">
                <h4>${course.title} (${course.code})</h4>
                <p>${course.description}</p>
                <button onclick="quitCourse(${course.id})">Quit</button>
            </div>
        `).join('');
    } else {
        coursesList.innerHTML = '<p>No courses found.</p>';
    }
}

async function joinCourse(id) {
    const response = await fetch("/api/courses", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({course_id: id })
    });
    const result = await response.json();

    if (result.success) {
        alert(result.message);
        loadCourses();
    } else {
        alert(result.message || 'Failed to join course');
    }
}


async function quitCourse(id) {
    const response = await fetch("/api/courses", {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({course_id: id })
    });
    const result = await response.json();

    if (result.success) {
        alert(result.message);
        loadCourses();
    } else {
        alert(result.message || 'Failed to join course');
    }
}

